<?php

namespace App\Domains\Identity\Actions;

use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateUserAction
{
    /**
     * Authenticate user credentials and establish session.
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return User
     * @throws ValidationException
     */
    public function execute(string $email, string $password, bool $remember = false): User
    {
        $user = User::where('email', strtolower(trim($email)))->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('These credentials do not match our records.')],
            ]);
        }

        if ($user->status !== UserStatus::Active) {
            throw ValidationException::withMessages([
                'email' => [__('Your account has been deactivated or suspended. Please contact support.')],
            ]);
        }

        Auth::login($user, $remember);
        request()->session()->regenerate();

        return $user;
    }
}
