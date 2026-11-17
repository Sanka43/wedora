<?php

use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Planning\Models\ChecklistTemplate;
use App\Domains\Platform\Models\SubscriptionPlan;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Couple\PartnerCollaborationController;
use App\Http\Controllers\Couple\WeddingInvitationController;
use App\Http\Controllers\Couple\WeddingOnboardingController;
use App\Http\Controllers\Couple\WorkspaceDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Public Landing Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $categories = collect();
    $plans = collect();
    $templates = collect();

    if (Schema::hasTable('vendor_categories')) {
        $categories = VendorCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    if (Schema::hasTable('subscription_plans')) {
        $plans = SubscriptionPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    if (Schema::hasTable('checklist_templates')) {
        $templates = ChecklistTemplate::withCount('items')
            ->where('is_active', true)
            ->get();
    }

    return view('welcome', compact('categories', 'plans', 'templates'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Wedding Invitation Landing & Acceptance Routes
|--------------------------------------------------------------------------
*/
Route::get('/invitations/{token}', [WeddingInvitationController::class, 'show'])->name('invitations.show');
Route::post('/invitations/{token}/accept', [WeddingInvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invitations/{token}/decline', [WeddingInvitationController::class, 'decline'])->name('invitations.decline');

/*
|--------------------------------------------------------------------------
| Couple Wedding Workspace Routes (Multi-Tenant Scoped)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'wedding.context'])->prefix('workspace')->name('workspace.')->group(function () {
    // Wedding Onboarding Wizard
    Route::get('/onboarding', [WeddingOnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding', [WeddingOnboardingController::class, 'store'])->name('onboarding.store');

    // Main Workspace Dashboard
    Route::get('/', [WorkspaceDashboardController::class, 'index'])->name('dashboard');

    // Partner Collaboration & Team Management
    Route::get('/collaborators', [PartnerCollaborationController::class, 'index'])->name('collaborators.index');
    Route::post('/collaborators/invite', [PartnerCollaborationController::class, 'invite'])->name('collaborators.invite');
    Route::post('/collaborators/invitations/{uuid}/revoke', [PartnerCollaborationController::class, 'revoke'])->name('collaborators.revoke');
    Route::delete('/collaborators/members/{id}', [PartnerCollaborationController::class, 'removeMember'])->name('collaborators.remove');
    Route::put('/collaborators/members/{id}/permissions', [PartnerCollaborationController::class, 'updatePermissions'])->name('collaborators.permissions');
    Route::post('/switch/{uuid}', [PartnerCollaborationController::class, 'switchWedding'])->name('switch');
});
