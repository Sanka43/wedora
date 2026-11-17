<?php

namespace App\Http\Controllers\Couple;

use App\Domains\Wedding\Actions\AcceptWeddingInvitationAction;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Models\WeddingInvitation;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WeddingInvitationController extends Controller
{
    /**
     * Show invitation landing page.
     */
    public function show(string $token): View
    {
        $invitation = WeddingInvitation::with(['wedding', 'invitedBy'])
            ->where('token', $token)
            ->firstOrFail();

        $isExpired = $invitation->expires_at->isPast();
        $isPending = $invitation->status === InvitationStatus::Pending && !$isExpired;
        $currentUser = Auth::user();

        return view('couple.invitations.show', [
            'invitation' => $invitation,
            'wedding' => $invitation->wedding,
            'inviter' => $invitation->invitedBy,
            'isPending' => $isPending,
            'isExpired' => $isExpired,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * Accept wedding invitation.
     */
    public function accept(
        Request $request,
        string $token,
        AcceptWeddingInvitationAction $action
    ): RedirectResponse {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login', ['redirect' => route('invitations.show', ['token' => $token])])
                ->with('info', __('Please sign in to accept this invitation.'));
        }

        $wedding = $action->execute($token, $user);

        return redirect()->route('workspace.dashboard')
            ->with('success', __("✨ You have officially joined :wedding as :role! Start planning together.", [
                'wedding' => $wedding->title,
                'role' => $user->name,
            ]));
    }

    /**
     * Decline wedding invitation.
     */
    public function decline(Request $request, string $token): RedirectResponse
    {
        $invitation = WeddingInvitation::where('token', $token)->firstOrFail();

        if ($invitation->status === InvitationStatus::Pending) {
            $invitation->update(['status' => InvitationStatus::Declined]);
        }

        return redirect()->route('home')
            ->with('info', __('You have declined the wedding planning invitation.'));
    }
}
