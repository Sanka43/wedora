<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Validation\ValidationException;

class UpdateWeddingMemberPermissionsAction
{
    /**
     * Update permissions for a collaborator in a wedding workspace.
     *
     * @param Wedding $wedding
     * @param int $memberId
     * @param array<string, bool> $permissions
     * @param User $performedBy
     * @return WeddingMember
     * @throws ValidationException
     */
    public function execute(Wedding $wedding, int $memberId, array $permissions, User $performedBy): WeddingMember
    {
        $member = WeddingMember::where('wedding_id', $wedding->id)
            ->where('id', $memberId)
            ->firstOrFail();

        // Guard: Only owner or partner can update permissions
        $actorMember = WeddingMember::where('wedding_id', $wedding->id)
            ->where('user_id', $performedBy->id)
            ->first();

        if (!$actorMember || !in_array($actorMember->role, [WeddingMemberRole::Owner, WeddingMemberRole::Partner])) {
            throw ValidationException::withMessages([
                'permissions' => [__('You do not have permission to modify member permissions.')],
            ]);
        }

        $member->update([
            'permissions' => $permissions,
        ]);

        return $member;
    }
}
