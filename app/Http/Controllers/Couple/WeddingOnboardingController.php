<?php

namespace App\Http\Controllers\Couple;

use App\Domains\Wedding\Actions\CreateWeddingWorkspaceAction;
use App\Domains\Wedding\Enums\WeddingType;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WeddingOnboardingController extends Controller
{
    /**
     * Show wedding creation onboarding form.
     */
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();

        // If user already owns a wedding, redirect straight to dashboard
        if ($user->ownedWeddings()->exists()) {
            return redirect()->route('workspace.dashboard');
        }

        $districts = [
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya',
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Kilinochchi', 'Mannar',
            'Vavuniya', 'Mullaitivu', 'Batticaloa', 'Ampara', 'Trincomalee',
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla',
            'Monaragala', 'Ratnapura', 'Kegalle'
        ];

        return view('couple.onboarding', [
            'user' => $user,
            'districts' => $districts,
            'weddingTypes' => WeddingType::cases(),
        ]);
    }

    /**
     * Store wedding workspace and initiate planning tasks.
     */
    public function store(Request $request, CreateWeddingWorkspaceAction $action): RedirectResponse
    {
        $validated = $request->validate([
            'partner1_name' => ['required', 'string', 'max:255'],
            'partner2_name' => ['required', 'string', 'max:255'],
            'wedding_date' => ['required', 'date', 'after:today'],
            'wedding_type' => ['required', Rule::enum(WeddingType::class)],
            'district' => ['required', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'estimated_guest_count' => ['required', 'integer', 'min:1', 'max:5000'],
            'total_budget' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'style_theme' => ['nullable', 'string', 'max:100'],
        ]);

        $user = Auth::user();
        $wedding = $action->execute($user, $validated);

        // Update profile partner name if not set
        $partnerName = ($validated['partner1_name'] === $user->name)
            ? $validated['partner2_name']
            : $validated['partner1_name'];

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['partner_name' => $partnerName]
        );

        return redirect()->route('workspace.dashboard')
            ->with('success', __("✨ Congratulations! Your wedding workspace for :title has been created.", ['title' => $wedding->title]));
    }
}
