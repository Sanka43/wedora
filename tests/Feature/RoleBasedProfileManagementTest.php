<?php

namespace Tests\Feature;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\VendorCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test vendor profile displays atelier management fields.
     */
    public function test_vendor_profile_screen_renders_atelier_fields(): void
    {
        $vendorUser = User::where('role', UserRole::Vendor)->first();
        $this->assertNotNull($vendorUser);

        $response = $this->actingAs($vendorUser)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Atelier Brand &amp; Marketplace Details', false);
        $response->assertSee('Business / Brand Name', false);
        $response->assertSee('Operating District', false);
        $response->assertSee('Base Starting Price', false);
        $response->assertSee('Atelier Narrative &amp; Artistic Philosophy', false);
        $response->assertSee('Atelier Studio', false);
        $response->assertDontSee('Partner / Spouse Name');
    }

    /**
     * Test vendor can update business details and directory listing.
     */
    public function test_vendor_can_update_atelier_profile(): void
    {
        $vendorUser = User::where('role', UserRole::Vendor)->first();
        $this->assertNotNull($vendorUser);

        $category = VendorCategory::first();
        $this->assertNotNull($category);

        $payload = [
            'name' => 'Dhanushka S. Lead Photographer',
            'email' => 'dhanushka.updated@wedora.lk',
            'phone' => '+94771122334',
            'business_name' => 'Dhanushka Senanayake Haute Matrimonial Arts',
            'category_id' => $category->id,
            'description' => 'Master Sri Lankan matrimonial fine art cinema and royal Kandyan Poruwa coverage with Sony Cine line cameras.',
            'district' => 'Kandy',
            'address' => 'No. 88, Peradeniya Road, Kandy',
            'vendor_phone' => '+94779998888',
            'vendor_email' => 'atelier@dhanushkahaute.lk',
            'starting_price' => 380000.00,
            'website' => 'https://www.dhanushkahaute.lk',
            'instagram_handle' => '@dhanushka_haute',
            'facebook_url' => 'https://facebook.com/dhanushkahaute',
            'avatar_url' => 'https://example.com/dhanushka-avatar.jpg',
            'preferred_locale' => 'en',
        ];

        $response = $this->actingAs($vendorUser)->put('/profile', $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // Verify users table
        $this->assertDatabaseHas('users', [
            'id' => $vendorUser->id,
            'name' => 'Dhanushka S. Lead Photographer',
            'email' => 'dhanushka.updated@wedora.lk',
            'phone' => '+94771122334',
        ]);

        // Verify vendors table
        $this->assertDatabaseHas('vendors', [
            'user_id' => $vendorUser->id,
            'business_name' => 'Dhanushka Senanayake Haute Matrimonial Arts',
            'category_id' => $category->id,
            'district' => 'Kandy',
            'address' => 'No. 88, Peradeniya Road, Kandy',
            'phone' => '+94779998888',
            'email' => 'atelier@dhanushkahaute.lk',
            'starting_price' => 380000.00,
        ]);
    }

    /**
     * Test planner profile displays studio & cultural specialization fields.
     */
    public function test_planner_profile_screen_renders_planner_fields(): void
    {
        $plannerUser = User::where('role', UserRole::Planner)->first();
        $this->assertNotNull($plannerUser);

        $response = $this->actingAs($plannerUser)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Lead Planner Credentials');
        $response->assertSee('Agency Practice &amp; Professional Background', false);
        $response->assertSee('Ceremonial Expertise &amp; Coverage', false);
        $response->assertSee('Traditional Poruwa Ceremonies');
        $response->assertSee('Kandyan Royal Nuptials');
        $response->assertSee('Operating Geographic Districts', false);
        $response->assertSee('Planner Concierge Studio');
        $response->assertDontSee('Partner / Spouse Name');
    }

    /**
     * Test planner can update agency credentials and specializations.
     */
    public function test_planner_can_update_agency_profile(): void
    {
        $plannerUser = User::where('role', UserRole::Planner)->first();
        $this->assertNotNull($plannerUser);

        $payload = [
            'name' => 'Ananya Wickremasinghe, Senior Consultant',
            'email' => 'ananya.planner@wedora.lk',
            'phone' => '+94775554433',
            'company_name' => 'Ananya Luxury Nuptial Curators',
            'designation' => 'Principal Matrimonial Architect',
            'experience_years' => 12,
            'address' => 'Independence Avenue, Colombo 07',
            'bio' => 'Over a decade orchestrating high-profile Poruwa and ballroom nuptials across Sri Lanka with meticulous Nekath timing accuracy.',
            'specializations' => [
                'Traditional Poruwa Ceremonies',
                'Kandyan Royal Nuptials',
                'Luxury Ballroom & Gala Receptions',
            ],
            'operating_districts' => ['Colombo', 'Kandy', 'Galle', 'Nuwara Eliya'],
            'website' => 'https://www.ananyaweddings.lk',
            'instagram_handle' => '@ananya_luxury_weddings',
            'facebook_url' => 'https://facebook.com/ananyaweddingslk',
            'avatar_url' => 'https://example.com/ananya.jpg',
            'preferred_locale' => 'en',
        ];

        $response = $this->actingAs($plannerUser)->put('/profile', $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // Verify users table
        $this->assertDatabaseHas('users', [
            'id' => $plannerUser->id,
            'name' => 'Ananya Wickremasinghe, Senior Consultant',
            'email' => 'ananya.planner@wedora.lk',
        ]);

        // Verify user_profiles table
        $plannerProfile = $plannerUser->fresh()->profile;
        $this->assertNotNull($plannerProfile);
        $this->assertEquals('Ananya Luxury Nuptial Curators', $plannerProfile->company_name);
        $this->assertEquals('Principal Matrimonial Architect', $plannerProfile->designation);
        $this->assertEquals(12, $plannerProfile->experience_years);
        $this->assertContains('Traditional Poruwa Ceremonies', $plannerProfile->specializations);
        $this->assertContains('Colombo', $plannerProfile->operating_districts);
    }

    /**
     * Test couple profile renders partner information and workspace link.
     */
    public function test_couple_profile_screen_renders_couple_fields(): void
    {
        $coupleUser = User::where('role', UserRole::Couple)->first();
        $this->assertNotNull($coupleUser);

        $response = $this->actingAs($coupleUser)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Nuptial Co-Planning Identity');
        $response->assertSee('Partner / Spouse Name', false);
        $response->assertSee('Notification &amp; Alert Preferences', false);
        $response->assertDontSee('Base Starting Price');
        $response->assertDontSee('Ceremonial Expertise &amp; Coverage', false);
    }

    /**
     * Test couple can update partner and language preference.
     */
    public function test_couple_can_update_partner_details(): void
    {
        $coupleUser = User::where('role', UserRole::Couple)->first();
        $this->assertNotNull($coupleUser);

        $payload = [
            'name' => 'Kasun Perera',
            'email' => 'kasun.nuptials@wedora.lk',
            'phone' => '+94772233445',
            'partner_name' => 'Dilani Jayawardena',
            'preferred_locale' => 'si',
            'avatar_url' => 'https://example.com/couple-avatar.jpg',
            'notification_preferences' => [
                'email_quotes' => '1',
                'sms_nekath' => '1',
            ],
        ];

        $response = $this->actingAs($coupleUser)->put('/profile', $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $coupleUser->id,
            'partner_name' => 'Dilani Jayawardena',
            'preferred_locale' => 'si',
        ]);
    }

    /**
     * Test super admin profile renders cleanly.
     */
    public function test_super_admin_profile_renders(): void
    {
        $adminUser = User::where('role', UserRole::SuperAdmin)->first();
        $this->assertNotNull($adminUser);

        $response = $this->actingAs($adminUser)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Super Administrator Access');
        $response->assertSee('Control Center');
    }

    /**
     * Test role-based validation failures.
     */
    public function test_vendor_validation_requires_business_name_and_category(): void
    {
        $vendorUser = User::where('role', UserRole::Vendor)->first();
        $this->assertNotNull($vendorUser);

        $response = $this->actingAs($vendorUser)->put('/profile', [
            'name' => 'Vendor Test',
            'email' => 'vendor.test@wedora.lk',
            // Missing business_name, category_id, description, district, address
        ]);

        $response->assertSessionHasErrors(['business_name', 'category_id', 'description', 'district', 'address']);
    }
}
