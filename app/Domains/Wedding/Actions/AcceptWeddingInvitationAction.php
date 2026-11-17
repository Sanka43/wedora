<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingInvitation;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AcceptWeddingInvitationAction
{
    /**
     * Accept a pending wedding invitation.
     *
     * @param string $token
     * @param User $user
     * @return Wedding
     * @throws ValidationException
     */
    public function execute(string $token, User $user): Wedding
    {
        $invitation = WeddingInvitation::with('wedding')
            ->where('token', $token)
            ->first();

        if (!$invitation) {
            throw ValidationException::withMessages([
                'invitation' => [__('The invitation link is invalid or has expired.')],
            ]);
        }

        if ($invitation->status !== InvitationStatus::Pending) {
            throw ValidationException::withMessages([
                'invitation' => [__('This invitation has already been ' . $invitation->status->label() . '.')],
            ]);
        }

        if ($invitation->expires_at->isPast()) {
            $invitation->update(['status' => InvitationStatus::Expired]);
            throw ValidationException::withMessages([
                'invitation' => [__('This invitation has expired. Please request a new invitation.')],
            ]);
        }

        return DB::transaction(function () use ($invitation, $user) {
            $wedding = $invitation->wedding;

            // Retrieve staged permissions from session if present
            $permissionsKey = "invite_permissions_{$invitation->token}";
            $permissions = session($permissionsKey, ['all' => ($invitation->role === WeddingMemberRole::Partner)]);

            // Update or create membership
            WeddingMember::updateOrCreate(
                [
                    'wedding_id' => $wedding->id,
                    'user_id' => $user->id,
                ],
                [
                    'role' => $invitation->role,
                    'invitation_status' => InvitationStatus::Accepted,
                    'permissions' => $permissions,
                    'joined_at' => now(),
                ]
            );

            // Mark invitation as accepted
            $invitation->update([
                'status' => InvitationStatus::Accepted,
            ]);

            // Update user's profile partner name if accepted as partner
            if ($invitation->role === WeddingMemberRole::Partner) {
                $userProfile = $user->profile;
                if ($userProfile && empty($userProfile->partner_name)) {
                    $otherPartner = ($wedding->partner1_name === $user->name)
                        ? $wedding->partner2_name
                        : $wedding->partner1_name;

                    $userProfile->update(['partner_name' => $otherPartner]);
                }
            }

            // Set active wedding in session
            session(['active_wedding_uuid' => $wedding->uuid]);
            session()->forget($permissionsKey);

            return $wedding;
        });
    }
}
