<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Identity\Actions\AuthenticateUserAction;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Models\WeddingMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm(Request $request): View
    {
        $redirectUrl = $request->query('redirect');
        return view('auth.login', compact('redirectUrl'));
    }

    /**
     * Handle login authentication.
     */
    public function login(LoginRequest $request, AuthenticateUserAction $action): RedirectResponse
    {
        $user = $action->execute(
            $request->input('email'),
            $request->input('password'),
            $request->boolean('remember')
        );

        // Check if a safe internal redirect parameter is provided
        if ($redirect = $request->input('redirect')) {
            if (is_string($redirect) && str_starts_with($redirect, '/') && !str_starts_with($redirect, '//') && !str_contains($redirect, '\\')) {
                return redirect($redirect);
            }
        }

        // Role-based routing
        if ($user->role === UserRole::Couple) {
            $hasWedding = WeddingMember::where('user_id', $user->id)
                ->where('invitation_status', InvitationStatus::Accepted)
                ->exists();

            if ($hasWedding) {
                return redirect()->route('workspace.dashboard')
                    ->with('success', __("Welcome back, :name!", ['name' => $user->name]));
            }

            return redirect()->route('workspace.onboarding');
        }

        if ($user->role === UserRole::Vendor) {
            return redirect()->route('vendor.dashboard')
                ->with('success', __("Welcome back, :name! Access your vendor leads and bookings.", ['name' => $user->name]));
        }

        if ($user->role === UserRole::SuperAdmin) {
            return redirect()->route('admin.dashboard')
                ->with('success', __("Welcome to Wedora Control Center, :name!", ['name' => $user->name]));
        }

        if ($user->role === UserRole::Planner) {
            return redirect()->route('planner.dashboard')
                ->with('success', __("Welcome back, :name! Access your client weddings portfolio.", ['name' => $user->name]));
        }

        return redirect()->intended(route('home'));
    }
}
