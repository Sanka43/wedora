<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Identity\Actions\RegisterUserAction;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Wedding\Actions\AcceptWeddingInvitationAction;
use App\Domains\Wedding\Models\WeddingInvitation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show registration form.
     */
    public function showRegistrationForm(Request $request): View
    {
        $categories = VendorCategory::where('is_active', true)->orderBy('sort_order')->get();
        $inviteToken = $request->query('invite');
        $invitation = null;

        if ($inviteToken) {
            $invitation = WeddingInvitation::with('wedding')
                ->where('token', $inviteToken)
                ->first();
        }

        $districts = [
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya',
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Kilinochchi', 'Mannar',
            'Vavuniya', 'Mullaitivu', 'Batticaloa', 'Ampara', 'Trincomalee',
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla',
            'Monaragala', 'Ratnapura', 'Kegalle'
        ];

        return view('auth.register', compact('categories', 'districts', 'invitation', 'inviteToken'));
    }

    /**
     * Handle registration submission.
     */
    public function register(
        RegisterRequest $request,
        RegisterUserAction $registerAction,
        AcceptWeddingInvitationAction $acceptInviteAction
    ): RedirectResponse {
        $user = $registerAction->execute($request->validated());

        Auth::login($user);
        $request->session()->regenerate();

        // Check if user came via wedding invitation link
        $inviteToken = $request->input('invite_token');
        if ($inviteToken) {
            try {
                $wedding = $acceptInviteAction->execute($inviteToken, $user);
                return redirect()->route('workspace.dashboard')
                    ->with('success', __("Welcome to Wedora! You have successfully joined :wedding.", ['wedding' => $wedding->title]));
            } catch (\Throwable $e) {
                // Ignore invite acceptance errors during register, continue flow
            }
        }

        // Determine destination based on role
        if ($user->role === UserRole::Couple) {
            return redirect()->route('workspace.onboarding')
                ->with('success', __('Welcome to Wedora! Let\'s set up your wedding planning workspace.'));
        }

        if ($user->role === UserRole::Vendor) {
            return redirect()->route('home')
                ->with('success', __('Vendor account created successfully! Our team will review your profile shortly.'));
        }

        return redirect()->route('home');
    }
}
