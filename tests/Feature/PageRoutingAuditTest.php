<?php

namespace Tests\Feature;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PageRoutingAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test public routes render with unified top navbar.
     */
    public function test_public_routes_render_with_top_navbar(): void
    {
        $publicRoutes = [
            '/',
            '/login',
            '/register',
            '/forgot-password',
            '/vendor/dashboard',
        ];

        foreach ($publicRoutes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $response->assertSee('Wedora Brand Logo');
            $response->assertSee('Marketplace &amp; Vendors', false);
            $response->assertSee('Planning Workspace');
            $response->assertSee('Nekath &amp; Timeline', false);
            $response->assertSee('Budget &amp; Expenses', false);
            $response->assertSee('RSVP &amp; Guests', false);
        }
    }

    /**
     * Test authenticated home page renders without errors for all roles.
     */
    public function test_authenticated_home_page_renders_for_all_roles(): void
    {
        $roles = [UserRole::Couple, UserRole::Vendor, UserRole::Planner, UserRole::SuperAdmin];

        foreach ($roles as $role) {
            $user = User::where('role', $role)->first();
            $this->assertNotNull($user);

            $response = $this->actingAs($user)->get('/');
            $response->assertStatus(200);
            $response->assertSee('Wedora Brand Logo');
            $response->assertDontSee('Undefined variable');
        }
    }

    /**
     * Test vendor profile page renders with top navbar.
     */
    public function test_vendor_profile_page_renders_with_top_navbar(): void
    {
        $vendor = Vendor::first();
        if ($vendor) {
            $response = $this->get('/vendors/' . $vendor->slug);
            $response->assertStatus(200);
            $response->assertSee('Wedora Brand Logo');
            $response->assertSee('Marketplace &amp; Vendors', false);
            $response->assertSee('Planning Workspace');
        }
    }

    /**
     * Test convenience redirects.
     */
    public function test_convenience_routing_redirects(): void
    {
        $this->get('/admin')->assertRedirect('/admin/dashboard');
        $this->get('/vendor')->assertRedirect('/vendor/dashboard');
        $this->get('/planner')->assertRedirect('/planner/dashboard');
        $this->get('/onboarding')->assertRedirect('/workspace/onboarding');
        $this->get('/marketplace')->assertRedirect('/#marketplace-anchor');
    }

    /**
     * Test couple user workspace pages have top navbar and user profile info.
     */
    public function test_couple_workspace_pages_render_with_top_navbar(): void
    {
        $coupleUser = User::where('role', UserRole::Couple)->first();
        $this->assertNotNull($coupleUser);

        $response = $this->actingAs($coupleUser)->get('/workspace');
        $response->assertStatus(200);
        $response->assertSee('Wedora Brand Logo');
        $response->assertSee('My Workspace');
        $response->assertSee(Str::limit($coupleUser->name, 14));

        $collaboratorsResponse = $this->actingAs($coupleUser)->get('/workspace/collaborators');
        $collaboratorsResponse->assertStatus(200);
        $collaboratorsResponse->assertSee('Wedora Brand Logo');
        $collaboratorsResponse->assertSee('My Workspace');

        $profileResponse = $this->actingAs($coupleUser)->get('/profile');
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('Wedora Brand Logo');
        $profileResponse->assertSee('Account & Partner Profile', false);
    }

    /**
     * Test super admin dashboard renders with top navbar.
     */
    public function test_super_admin_dashboard_renders_with_top_navbar(): void
    {
        $adminUser = User::where('role', UserRole::SuperAdmin)->first();
        $this->assertNotNull($adminUser);

        $response = $this->actingAs($adminUser)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Wedora Brand Logo');
        $response->assertSee('Control Center');
        $response->assertSee(Str::limit($adminUser->name, 14));
    }

    /**
     * Test planner studio dashboard renders with top navbar.
     */
    public function test_planner_dashboard_renders_with_top_navbar(): void
    {
        $plannerUser = User::where('role', UserRole::Planner)->first();
        $this->assertNotNull($plannerUser);

        $response = $this->actingAs($plannerUser)->get('/planner/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Wedora Brand Logo');
        $response->assertSee('Planner Studio');
        $response->assertSee(Str::limit($plannerUser->name, 14));
    }

    /**
     * Test vendor portal dashboard renders with top navbar.
     */
    public function test_vendor_dashboard_renders_with_top_navbar(): void
    {
        $vendorUser = User::where('role', UserRole::Vendor)->first();
        $this->assertNotNull($vendorUser);

        $response = $this->actingAs($vendorUser)->get('/vendor/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Wedora Brand Logo');
        $response->assertSee('Vendor Portal');
        $response->assertSee(Str::limit($vendorUser->name, 14));
    }
}
