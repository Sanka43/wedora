<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Identity\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password link request form.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link email.
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request): RedirectResponse
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Str::random(60);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            // In production, send Mailable. For local/development logging:
            logger()->info("Password reset token generated for {$email}: {$token}");
        }

        return back()->with('status', __('If your email exists in our system, a password reset link has been dispatched.'));
    }

    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Reset user password.
     */
    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->input('email'))
            ->first();

        if (!$record || !Hash::check($request->input('token'), $record->token)) {
            return back()->withErrors(['email' => __('This password reset token is invalid or expired.')]);
        }

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
            DB::table('password_reset_tokens')->where('email', $request->input('email'))->delete();
        }

        return redirect()->route('login')
            ->with('status', __('Your password has been reset! Please sign in with your new password.'));
    }
}
