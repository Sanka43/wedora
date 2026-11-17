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

        // Check if redirect intended or parameter is provided
        if ($redirect = $request->input('redirect')) {
            return redirect($redirect);
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
            return redirect()->route('home')
                ->with('success', __("Welcome back, :name! Vendor portal preview.", ['name' => $user->name]));
        }

        return redirect()->intended(route('home'));
    }
}
