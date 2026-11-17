<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function show(): View
    {
        $user = Auth::user()->load('profile');
        return view('auth.profile', compact('user'));
    }

    /**
     * Update user profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'phone' => $validated['phone'] ?? null,
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'partner_name' => $validated['partner_name'] ?? null,
                'preferred_locale' => $validated['preferred_locale'] ?? 'en',
                'avatar_url' => $validated['avatar_url'] ?? null,
            ]
        );

        return back()->with('success', __('Your profile has been updated successfully.'));
    }
}
