<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Validation\ValidationException;

class RemoveWeddingMemberAction
{
    /**
     * Remove a member or collaborator from a wedding workspace.
     *
     * @param Wedding $wedding
     * @param int $memberId
     * @param User $performedBy
     * @return void
     * @throws ValidationException
     */
    public function execute(Wedding $wedding, int $memberId, User $performedBy): void
    {
        $member = WeddingMember::where('wedding_id', $wedding->id)
            ->where('id', $memberId)
            ->firstOrFail();

        // Guard: Cannot remove the workspace owner
        if ($member->role === WeddingMemberRole::Owner) {
            throw ValidationException::withMessages([
                'member' => [__('The workspace owner cannot be removed from the wedding.')],
            ]);
        }

        // Guard: Only owner or partner can remove members
        $actorMember = WeddingMember::where('wedding_id', $wedding->id)
            ->where('user_id', $performedBy->id)
            ->first();

        if (!$actorMember || !in_array($actorMember->role, [WeddingMemberRole::Owner, WeddingMemberRole::Partner])) {
            throw ValidationException::withMessages([
                'member' => [__('You do not have permission to remove members from this wedding.')],
            ]);
        }

        $member->delete();
    }
}
