<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingInvitation;
use Illuminate\Validation\ValidationException;

class RevokeWeddingInvitationAction
{
    /**
     * Revoke a pending wedding invitation.
     *
     * @param Wedding $wedding
     * @param string $uuid
     * @return WeddingInvitation
     * @throws ValidationException
     */
    public function execute(Wedding $wedding, string $uuid): WeddingInvitation
    {
        $invitation = WeddingInvitation::where('wedding_id', $wedding->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        if ($invitation->status !== InvitationStatus::Pending) {
            throw ValidationException::withMessages([
                'invitation' => [__('Only pending invitations can be revoked.')],
            ]);
        }

        $invitation->update(['status' => InvitationStatus::Revoked]);

        return $invitation;
    }
}
