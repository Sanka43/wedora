<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingInvitation;
use App\Domains\Wedding\Models\WeddingMember;
use App\Mail\WeddingInvitationMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SendWeddingInvitationAction
{
    /**
     * Send an invitation to a partner or collaborator.
     *
     * @param Wedding $wedding
     * @param User $invitedBy
     * @param string $email
     * @param WeddingMemberRole|string $role
     * @param array<string, mixed>|null $permissions
     * @return WeddingInvitation
     * @throws ValidationException
     */
    public function execute(
        Wedding $wedding,
        User $invitedBy,
        string $email,
        WeddingMemberRole|string $role = WeddingMemberRole::Partner,
        ?array $permissions = null
    ): WeddingInvitation {
        $email = strtolower(trim($email));

        $roleEnum = $role instanceof WeddingMemberRole ? $role : WeddingMemberRole::from($role);

        // Check if an existing user with this email is already a member
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $isAlreadyMember = WeddingMember::where('wedding_id', $wedding->id)
                ->where('user_id', $existingUser->id)
                ->where('invitation_status', InvitationStatus::Accepted)
                ->exists();

            if ($isAlreadyMember) {
                throw ValidationException::withMessages([
                    'email' => [__('This user is already an active member of this wedding workspace.')],
                ]);
            }
        }

        // Revoke any previous pending invitation for this email on this wedding
        WeddingInvitation::where('wedding_id', $wedding->id)
            ->where('email', $email)
            ->where('status', InvitationStatus::Pending)
            ->update(['status' => InvitationStatus::Revoked]);

        // Generate new invitation token
        $invitation = WeddingInvitation::create([
            'wedding_id' => $wedding->id,
            'invited_by_user_id' => $invitedBy->id,
            'email' => $email,
            'role' => $roleEnum,
            'token' => Str::random(64),
            'status' => InvitationStatus::Pending,
            'expires_at' => now()->addDays(14),
        ]);

        // If specific permissions are passed for a collaborator, we can stage them or apply them on accept
        if ($permissions) {
            session(["invite_permissions_{$invitation->token}" => $permissions]);
        }

        // Send Email
        try {
            Mail::to($email)->send(new WeddingInvitationMailable($invitation));
        } catch (\Throwable $e) {
            // Mail logging failure should not halt the invitation in local dev
            report($e);
        }

        return $invitation;
    }
}
