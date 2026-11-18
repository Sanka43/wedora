<?php

namespace App\Http\Middleware;

use App\Domains\Identity\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request and ensure user has one of the required roles.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRoleValue = $user->role instanceof UserRole ? $user->role->value : (string) $user->role;

        // Check if user has one of the allowed roles
        if (!in_array($userRoleValue, $roles, true)) {
            // If request expects JSON
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Forbidden: Unauthorized role access.'], 403);
            }

            // Redirect user to their own role dashboard with notice
            $redirectRoute = match ($userRoleValue) {
                UserRole::SuperAdmin->value => 'admin.dashboard',
                UserRole::Vendor->value => 'vendor.dashboard',
                UserRole::Planner->value => 'planner.dashboard',
                UserRole::Couple->value => 'workspace.dashboard',
                default => 'home',
            };

            return redirect()->route($redirectRoute)
                ->with('error', __('You do not have permission to access that section. Redirected to your authorized dashboard.'));
        }

        return $next($request);
    }
}
