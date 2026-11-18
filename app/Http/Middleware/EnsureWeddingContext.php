<?php

namespace App\Http\Middleware;

use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class EnsureWeddingContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $manager = app(CurrentWeddingManager::class);
        $wedding = null;

        // 1. Check route parameter {wedding:uuid}
        $routeWedding = $request->route('wedding');
        if ($routeWedding instanceof Wedding) {
            $wedding = $routeWedding;
        } elseif (is_string($routeWedding)) {
            $wedding = Wedding::where('uuid', $routeWedding)->first();
        }

        // 2. Check session active_wedding_uuid
        if (!$wedding && session()->has('active_wedding_uuid')) {
            $wedding = Wedding::where('uuid', session('active_wedding_uuid'))->first();
        }

        // 3. Fallback to user's first accepted wedding
        if (!$wedding) {
            $membership = WeddingMember::with('wedding')
                ->where('user_id', $user->id)
                ->where('invitation_status', InvitationStatus::Accepted)
                ->first();

            $wedding = $membership?->wedding;
        }

        // If wedding found, verify authorization & set context
        if ($wedding) {
            $isMember = $user->isSuperAdmin() || $user->isPlanner() || WeddingMember::where('wedding_id', $wedding->id)
                ->where('user_id', $user->id)
                ->where('invitation_status', InvitationStatus::Accepted)
                ->exists();

            if (!$isMember) {
                // If not authorized for this specific wedding, find their valid one
                $validMembership = WeddingMember::with('wedding')
                    ->where('user_id', $user->id)
                    ->where('invitation_status', InvitationStatus::Accepted)
                    ->first();

                if ($validMembership) {
                    $wedding = $validMembership->wedding;
                } else {
                    $wedding = null;
                }
            }
        }

        if ($wedding) {
            $manager->set($wedding);
            session(['active_wedding_uuid' => $wedding->uuid]);
            View::share('currentWedding', $wedding);
        } else {
            // If couple user has no wedding workspace yet, force them to onboarding
            if ($user->isCouple() && !$request->routeIs('workspace.onboarding*') && !$request->routeIs('logout')) {
                return redirect()->route('workspace.onboarding')
                    ->with('info', __('Please setup your wedding details to start planning.'));
            }

            // If non-couple user accesses workspace without an active wedding context
            if (!$user->isCouple() && !$request->routeIs('logout')) {
                if ($user->isVendor()) {
                    return redirect()->route('vendor.dashboard')
                        ->with('info', __('Manage your listings and client inquiries in the Vendor Portal.'));
                }
                if ($user->isSuperAdmin()) {
                    return redirect()->route('admin.dashboard')
                        ->with('info', __('Wedora platform administration and metrics.'));
                }
                if ($user->isPlanner()) {
                    return redirect()->route('planner.dashboard')
                        ->with('info', __('Manage assigned client weddings in the Planner Portal.'));
                }
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
