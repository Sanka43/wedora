<?php

namespace App\Http\Controllers\Couple;

use App\Domains\Wedding\Actions\RevokeWeddingInvitationAction;
use App\Domains\Wedding\Actions\RemoveWeddingMemberAction;
use App\Domains\Wedding\Actions\SendWeddingInvitationAction;
use App\Domains\Wedding\Actions\UpdateWeddingMemberPermissionsAction;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PartnerCollaborationController extends Controller
{
    /**
     * List members and pending invitations for partner collaboration.
     */
    public function index(CurrentWeddingManager $manager): View
    {
        $wedding = $manager->get();
        $user = Auth::user();

        $wedding->load([
            'members.user.profile',
            'invitations' => fn($q) => $q->orderByDesc('created_at'),
            'invitations.invitedBy',
        ]);

        $currentMembership = $wedding->members->firstWhere('user_id', $user->id);
        $canManage = in_array($currentMembership?->role, [WeddingMemberRole::Owner, WeddingMemberRole::Partner]);

        // All weddings user belongs to (for workspace switcher)
        $userWeddings = $user->weddings()->wherePivot('invitation_status', InvitationStatus::Accepted)->get();

        return view('couple.collaborators.index', [
            'wedding' => $wedding,
            'user' => $user,
            'members' => $wedding->members,
            'invitations' => $wedding->invitations,
            'currentMembership' => $currentMembership,
            'canManage' => $canManage,
            'userWeddings' => $userWeddings,
        ]);
    }

    /**
     * Send invitation to partner or collaborator.
     */
    public function invite(
        Request $request,
        CurrentWeddingManager $manager,
        SendWeddingInvitationAction $action
    ): RedirectResponse {
        $wedding = $manager->get();
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', Rule::in(['partner', 'collaborator'])],
            'permissions' => ['nullable', 'array'],
        ]);

        $invitation = $action->execute(
            $wedding,
            $user,
            $validated['email'],
            WeddingMemberRole::from($validated['role']),
            $validated['permissions'] ?? null
        );

        $inviteUrl = route('invitations.show', ['token' => $invitation->token]);

        return back()->with('success', __("✨ Invitation sent to :email!", ['email' => $validated['email']]))
            ->with('invite_url', $inviteUrl);
    }

    /**
     * Revoke a pending invitation.
     */
    public function revoke(
        Request $request,
        string $uuid,
        CurrentWeddingManager $manager,
        RevokeWeddingInvitationAction $action
    ): RedirectResponse {
        $wedding = $manager->get();
        $action->execute($wedding, $uuid);

        return back()->with('info', __('The invitation has been successfully revoked.'));
    }

    /**
     * Remove a member from the workspace.
     */
    public function removeMember(
        Request $request,
        int $id,
        CurrentWeddingManager $manager,
        RemoveWeddingMemberAction $action
    ): RedirectResponse {
        $wedding = $manager->get();
        $action->execute($wedding, $id, Auth::user());

        return back()->with('info', __('The member has been removed from this wedding workspace.'));
    }

    /**
     * Update permissions for a collaborator.
     */
    public function updatePermissions(
        Request $request,
        int $id,
        CurrentWeddingManager $manager,
        UpdateWeddingMemberPermissionsAction $action
    ): RedirectResponse {
        $wedding = $manager->get();
        $permissions = $request->input('permissions', []);

        $action->execute($wedding, $id, $permissions, Auth::user());

        return back()->with('success', __('Collaborator permissions updated.'));
    }

    /**
     * Switch active wedding workspace.
     */
    public function switchWedding(Request $request, string $uuid): RedirectResponse
    {
        $user = Auth::user();
        $wedding = Wedding::where('uuid', $uuid)->firstOrFail();

        $isMember = WeddingMember::where('wedding_id', $wedding->id)
            ->where('user_id', $user->id)
            ->where('invitation_status', InvitationStatus::Accepted)
            ->exists();

        if (!$isMember && !$user->isSuperAdmin() && !$user->isPlanner()) {
            abort(403, __('You are not a member of this wedding workspace.'));
        }

        session(['active_wedding_uuid' => $wedding->uuid]);

        return redirect()->route('workspace.dashboard')
            ->with('success', __("Switched to workspace: :title", ['title' => $wedding->title]));
    }
}
