<?php

namespace Tests\Feature;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_redirects_to_admin_dashboard_and_can_render_page(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@wedora.lk',
            'password' => bcrypt('Wedora@2026'),
            'role' => UserRole::SuperAdmin,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@wedora.lk',
            'password' => 'Wedora@2026',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));

        $portalResponse = $this->actingAs($admin)->get(route('admin.dashboard'));
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('Wedora Super Admin Control Center');
        $portalResponse->assertSee('Artisan Vendor Directory');
    }

    public function test_vendor_redirects_to_vendor_dashboard_and_can_render_page(): void
    {
        $vendorUser = User::create([
            'name' => 'Dhanushka Vendor',
            'email' => 'dhanushka@wedora.lk',
            'password' => bcrypt('password'),
            'role' => UserRole::Vendor,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'dhanushka@wedora.lk',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($vendorUser);
        $response->assertRedirect(route('vendor.dashboard'));

        $portalResponse = $this->actingAs($vendorUser)->get(route('vendor.dashboard'));
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('Inbound RFQ Leads');
        $portalResponse->assertSee('Service Packages');
    }

    public function test_planner_redirects_to_planner_dashboard_and_can_render_page(): void
    {
        $plannerUser = User::create([
            'name' => 'Ananya Planner',
            'email' => 'planner@wedora.lk',
            'password' => bcrypt('password'),
            'role' => UserRole::Planner,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'planner@wedora.lk',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($plannerUser);
        $response->assertRedirect(route('planner.dashboard'));

        $portalResponse = $this->actingAs($plannerUser)->get(route('planner.dashboard'));
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('Professional Planner Concierge');
        $portalResponse->assertSee('Auspicious Timings');
    }

    public function test_couple_redirects_to_workspace_dashboard_when_wedding_exists(): void
    {
        $couple = User::create([
            'name' => 'Dilani Couple',
            'email' => 'dilani@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $wedding = Wedding::create([
            'owner_id' => $couple->id,
            'title' => 'Dilani & Kasun Wedding',
            'partner1_name' => 'Dilani',
            'partner2_name' => 'Kasun',
            'wedding_date' => now()->addMonths(4)->toDateString(),
            'wedding_type' => WeddingType::Traditional,
            'district' => 'Kandy',
            'status' => WeddingStatus::Planning,
        ]);

        WeddingMember::create([
            'wedding_id' => $wedding->id,
            'user_id' => $couple->id,
            'role' => WeddingMemberRole::Owner,
            'invitation_status' => InvitationStatus::Accepted,
            'joined_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'dilani@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($couple);
        $response->assertRedirect(route('workspace.dashboard'));
    }

    public function test_unauthorized_roles_cannot_access_admin_portal(): void
    {
        $vendorUser = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor_unauth@wedora.lk',
            'password' => bcrypt('password'),
            'role' => UserRole::Vendor,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($vendorUser)->get(route('admin.dashboard'));
        $response->assertRedirect(route('vendor.dashboard'));
    }

    public function test_vendor_accessing_workspace_redirects_to_vendor_dashboard_without_crash(): void
    {
        $vendorUser = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor_safe@wedora.lk',
            'password' => bcrypt('password'),
            'role' => UserRole::Vendor,
            'status' => UserStatus::Active,
        ]);

        $response = $this->actingAs($vendorUser)->get('/workspace');
        $response->assertRedirect(route('vendor.dashboard'));
    }

    public function test_external_open_redirect_is_blocked_on_login(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin_redirect@wedora.lk',
            'password' => bcrypt('Wedora@2026'),
            'role' => UserRole::SuperAdmin,
            'status' => UserStatus::Active,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin_redirect@wedora.lk',
            'password' => 'Wedora@2026',
            'redirect' => 'https://evil.com',
        ]);

        $this->assertNotEquals('https://evil.com', $response->headers->get('Location'));
        $response->assertRedirect(route('admin.dashboard'));
    }
}
