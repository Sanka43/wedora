<?php

namespace Tests\Feature;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Actions\CreateWeddingWorkspaceAction;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingInvitation;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PartnerCollaborationTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Wedding $wedding;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Kasun Perera',
            'email' => 'kasun@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $createAction = app(CreateWeddingWorkspaceAction::class);
        $this->wedding = $createAction->execute($this->owner, [
            'partner1_name' => 'Kasun',
            'partner2_name' => 'Amaya',
            'wedding_date' => '2026-12-15',
            'wedding_type' => 'traditional',
            'district' => 'Colombo',
            'estimated_guest_count' => 200,
            'total_budget' => 3000000,
        ]);
    }

    public function test_couple_can_access_workspace_dashboard(): void
    {
        $response = $this->actingAs($this->owner)->get(route('workspace.dashboard'));

        $response->assertStatus(200);
        $response->assertSee("Kasun & Amaya's Wedding");
        $response->assertSee('Colombo');
    }

    public function test_owner_can_invite_partner_via_email(): void
    {
        $response = $this->actingAs($this->owner)->post(route('workspace.collaborators.invite'), [
            'email' => 'amaya@example.com',
            'role' => 'partner',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('wedding_invitations', [
            'wedding_id' => $this->wedding->id,
            'email' => 'amaya@example.com',
            'role' => 'partner',
            'status' => 'pending',
        ]);

        $invitation = WeddingInvitation::where('email', 'amaya@example.com')->first();
        $this->assertEquals(64, strlen($invitation->token));
    }

    public function test_recipient_can_view_invitation_landing_page(): void
    {
        $invitation = WeddingInvitation::create([
            'wedding_id' => $this->wedding->id,
            'invited_by_user_id' => $this->owner->id,
            'email' => 'amaya@example.com',
            'role' => WeddingMemberRole::Partner,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->addDays(14),
        ]);

        $response = $this->get(route('invitations.show', ['token' => $invitation->token]));

        $response->assertStatus(200);
        $response->assertSee("Kasun & Amaya's Wedding");
        $response->assertSee('Kasun');
    }

    public function test_authenticated_recipient_can_accept_invitation_and_join_workspace(): void
    {
        $partnerUser = User::create([
            'name' => 'Amaya Senanayake',
            'email' => 'amaya@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $invitation = WeddingInvitation::create([
            'wedding_id' => $this->wedding->id,
            'invited_by_user_id' => $this->owner->id,
            'email' => 'amaya@example.com',
            'role' => WeddingMemberRole::Partner,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->addDays(14),
        ]);

        $response = $this->actingAs($partnerUser)->post(route('invitations.accept', ['token' => $invitation->token]));

        $response->assertRedirect(route('workspace.dashboard'));

        $this->assertDatabaseHas('wedding_members', [
            'wedding_id' => $this->wedding->id,
            'user_id' => $partnerUser->id,
            'role' => 'partner',
            'invitation_status' => 'accepted',
        ]);

        $this->assertDatabaseHas('wedding_invitations', [
            'id' => $invitation->id,
            'status' => 'accepted',
        ]);
    }

    public function test_new_user_can_register_using_invite_token_and_auto_join(): void
    {
        $invitation = WeddingInvitation::create([
            'wedding_id' => $this->wedding->id,
            'invited_by_user_id' => $this->owner->id,
            'email' => 'nimal@example.com',
            'role' => WeddingMemberRole::Collaborator,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->addDays(14),
        ]);

        $response = $this->post('/register', [
            'name' => 'Nimal Jayawardena',
            'email' => 'nimal@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'couple',
            'invite_token' => $invitation->token,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('workspace.dashboard'));

        $nimal = User::where('email', 'nimal@example.com')->first();

        $this->assertDatabaseHas('wedding_members', [
            'wedding_id' => $this->wedding->id,
            'user_id' => $nimal->id,
            'role' => 'collaborator',
            'invitation_status' => 'accepted',
        ]);
    }

    public function test_owner_can_revoke_pending_invitation(): void
    {
        $invitation = WeddingInvitation::create([
            'wedding_id' => $this->wedding->id,
            'invited_by_user_id' => $this->owner->id,
            'email' => 'amaya@example.com',
            'role' => WeddingMemberRole::Partner,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->addDays(14),
        ]);

        $response = $this->actingAs($this->owner)->post(route('workspace.collaborators.revoke', ['uuid' => $invitation->uuid]));

        $response->assertRedirect();
        $response->assertSessionHas('info');

        $this->assertDatabaseHas('wedding_invitations', [
            'id' => $invitation->id,
            'status' => 'revoked',
        ]);
    }

    public function test_owner_can_remove_collaborator_from_wedding(): void
    {
        $collaborator = User::create([
            'name' => 'Rohan Helper',
            'email' => 'rohan@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $member = WeddingMember::create([
            'wedding_id' => $this->wedding->id,
            'user_id' => $collaborator->id,
            'role' => WeddingMemberRole::Collaborator,
            'invitation_status' => InvitationStatus::Accepted,
            'joined_at' => now(),
        ]);

        $response = $this->actingAs($this->owner)->delete(route('workspace.collaborators.remove', ['id' => $member->id]));

        $response->assertRedirect();
        $response->assertSessionHas('info');

        $this->assertDatabaseMissing('wedding_members', [
            'id' => $member->id,
        ]);
    }

    public function test_owner_cannot_be_removed_from_wedding(): void
    {
        $ownerMember = WeddingMember::where('wedding_id', $this->wedding->id)
            ->where('user_id', $this->owner->id)
            ->first();

        $response = $this->actingAs($this->owner)->delete(route('workspace.collaborators.remove', ['id' => $ownerMember->id]));

        $response->assertSessionHasErrors('member');

        $this->assertDatabaseHas('wedding_members', [
            'id' => $ownerMember->id,
        ]);
    }

    public function test_couple_can_submit_onboarding_and_create_workspace(): void
    {
        $freshUser = User::create([
            'name' => 'Mahesh Bandara',
            'email' => 'mahesh@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($freshUser)->post(route('workspace.onboarding.store'), [
            'partner1_name' => 'Mahesh',
            'partner2_name' => 'Dilini',
            'wedding_date' => '2026-11-20',
            'wedding_type' => 'traditional',
            'district' => 'Kandy',
            'location' => 'Earl\'s Regency',
            'estimated_guest_count' => 300,
            'total_budget' => 4500000,
        ]);

        $response->assertRedirect(route('workspace.dashboard'));

        $this->assertDatabaseHas('weddings', [
            'owner_id' => $freshUser->id,
            'partner1_name' => 'Mahesh',
            'partner2_name' => 'Dilini',
            'district' => 'Kandy',
        ]);

        $wedding = Wedding::where('owner_id', $freshUser->id)->first();
        $this->assertDatabaseHas('wedding_members', [
            'wedding_id' => $wedding->id,
            'user_id' => $freshUser->id,
            'role' => 'owner',
            'invitation_status' => 'accepted',
        ]);
    }

    public function test_user_can_switch_between_multiple_weddings(): void
    {
        // Create second wedding where owner is also a member
        $otherWedding = Wedding::create([
            'owner_id' => $this->owner->id,
            'title' => 'Sister Wedding Support',
            'partner1_name' => 'Ruwan',
            'partner2_name' => 'Nadeesha',
            'wedding_date' => '2027-01-10',
            'wedding_type' => WeddingType::Western,
            'district' => 'Galle',
            'estimated_guest_count' => 150,
            'total_budget' => 2000000,
            'currency' => 'LKR',
        ]);

        WeddingMember::create([
            'wedding_id' => $otherWedding->id,
            'user_id' => $this->owner->id,
            'role' => WeddingMemberRole::Collaborator,
            'invitation_status' => InvitationStatus::Accepted,
            'joined_at' => now(),
        ]);

        $response = $this->actingAs($this->owner)->post(route('workspace.switch', ['uuid' => $otherWedding->uuid]));

        $response->assertRedirect(route('workspace.dashboard'));
        $this->assertEquals($otherWedding->uuid, session('active_wedding_uuid'));
    }

    public function test_expired_invitation_cannot_be_accepted(): void
    {
        $partnerUser = User::create([
            'name' => 'Amaya Senanayake',
            'email' => 'amaya@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $invitation = WeddingInvitation::create([
            'wedding_id' => $this->wedding->id,
            'invited_by_user_id' => $this->owner->id,
            'email' => 'amaya@example.com',
            'role' => WeddingMemberRole::Partner,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->subDay(), // Expired yesterday
        ]);

        $response = $this->actingAs($partnerUser)->post(route('invitations.accept', ['token' => $invitation->token]));

        $response->assertSessionHasErrors('invitation');

        $this->assertDatabaseMissing('wedding_members', [
            'wedding_id' => $this->wedding->id,
            'user_id' => $partnerUser->id,
        ]);
    }
}
