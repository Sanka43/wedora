<?php

namespace App\Domains\Wedding\Policies;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;

class WeddingPolicy
{
    /**
     * Determine whether the user can view the wedding workspace.
     */
    public function view(User $user, Wedding $wedding): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return WeddingMember::where('wedding_id', $wedding->id)
            ->where('user_id', $user->id)
            ->where('invitation_status', InvitationStatus::Accepted)
            ->exists();
    }

    /**
     * Determine whether the user can update wedding details.
     */
    public function update(User $user, Wedding $wedding): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return WeddingMember::where('wedding_id', $wedding->id)
            ->where('user_id', $user->id)
            ->where('invitation_status', InvitationStatus::Accepted)
            ->whereIn('role', [WeddingMemberRole::Owner, WeddingMemberRole::Partner])
            ->exists();
    }

    /**
     * Determine whether the user can delete the wedding workspace.
     */
    public function delete(User $user, Wedding $wedding): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $wedding->owner_id === $user->id;
    }

    /**
     * Determine whether the user can invite collaborators or partners.
     */
    public function invite(User $user, Wedding $wedding): bool
    {
        return $this->update($user, $wedding);
    }

    /**
     * Determine whether the user can manage collaborators.
     */
    public function manageCollaborators(User $user, Wedding $wedding): bool
    {
        return $this->update($user, $wedding);
    }
}
