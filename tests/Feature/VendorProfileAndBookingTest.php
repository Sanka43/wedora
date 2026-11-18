<?php

namespace Tests\Feature;

use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Favorite;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Database\Seeders\VendorCategorySeeder;
use Database\Seeders\VendorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class VendorProfileAndBookingTest extends TestCase
{
    use RefreshDatabase;

    protected Vendor $vendor;
    protected User $coupleUser;
    protected Wedding $wedding;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(VendorCategorySeeder::class);
        $this->seed(VendorSeeder::class);

        $this->vendor = Vendor::where('slug', 'dhanushka-senanayake')->firstOrFail();

        // Create a logged-in couple and their wedding workspace
        $this->coupleUser = User::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Kavindu & Thisari',
            'email' => 'kavindu@wedora.lk',
            'password' => Hash::make('password'),
            'phone' => '+94771234567',
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
            'email_verified_at' => now(),
        ]);

        $this->wedding = Wedding::create([
            'uuid' => (string) Str::uuid(),
            'owner_id' => $this->coupleUser->id,
            'title' => 'Kavindu & Thisari Nuptials',
            'partner1_name' => 'Kavindu Perera',
            'partner2_name' => 'Thisari Silva',
            'wedding_date' => now()->addDays(142)->toDateString(),
            'wedding_type' => WeddingType::Traditional,
            'district' => 'Colombo',
            'estimated_guest_count' => 350,
            'total_budget' => 4000000.00,
            'currency' => 'LKR',
            'status' => WeddingStatus::Planning,
        ]);

        WeddingMember::create([
            'wedding_id' => $this->wedding->id,
            'user_id' => $this->coupleUser->id,
            'role' => WeddingMemberRole::Owner,
            'invitation_status' => InvitationStatus::Accepted,
            'joined_at' => now(),
            'permissions' => ['*'],
        ]);
    }

    public function test_vendor_profile_page_renders_successfully(): void
    {
        $response = $this->get(route('vendors.show', 'dhanushka-senanayake'));

        $response->assertStatus(200);
        $response->assertSee('Dhanushka Senanayake');
        $response->assertSee('Fine Art Photography &amp; Cinema', false);
        $response->assertSee('4.95');
        $response->assertSee('The Poruwa Heritage Collection');
        $response->assertSee('The Royal Sovereign Experience');
        $response->assertSee('Grand Heirloom Master');
        $response->assertSee('280,000');
        $response->assertSee('460,000');
        $response->assertSee('680,000');
        $response->assertSee('Nekath Readiness Guarantee');
        $response->assertSee('Request Customized Quotation (RFQ)');
        $response->assertSee('Shenali &amp; Raveen Wickremasinghe', false);
    }

    public function test_authenticated_couple_can_submit_rfq_for_vendor(): void
    {
        $royalPackage = $this->vendor->packages()->where('name', 'like', '%Royal%')->first();

        $payload = [
            'package_id' => $royalPackage?->id,
            'event_date' => now()->addMonths(6)->toDateString(),
            'ceremony_style' => 'Traditional Poruwa + Western Reception',
            'venue_location' => 'Colombo • Cinnamon Grand (Oak Room)',
            'guest_count' => 350,
            'services' => ['Stills Photography', '4K Cinematography', '4K Drone Aerial'],
            'couple_message' => 'We have an auspicious Poruwa Nekath at 09:42 AM. Looking for elite coverage.',
        ];

        $response = $this->actingAs($this->coupleUser)
            ->post(route('vendors.rfq.store', $this->vendor->slug), $payload);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('quotations', [
            'wedding_id' => $this->wedding->id,
            'vendor_id' => $this->vendor->id,
            'package_id' => $royalPackage?->id,
            'requested_by_user_id' => $this->coupleUser->id,
            'status' => QuotationStatus::Pending->value,
            'currency' => 'LKR',
            'total_amount' => $royalPackage?->price ?? 460000.00,
        ]);
    }

    public function test_unauthenticated_guest_can_submit_rfq_via_ajax(): void
    {
        $payload = [
            'event_date' => now()->addMonths(8)->toDateString(),
            'ceremony_style' => 'Destination Coastal Wedding (Bentota / Galle)',
            'venue_location' => 'Galle Fort Hotel',
            'guest_count' => 150,
            'services' => ['Stills Photography', '4K Cinematography'],
            'couple_message' => 'Please provide custom quotation for destination nuptials.',
            'guest_name' => 'Dilshan & Chamari',
            'guest_email' => 'dilshan.nuptials@example.com',
            'guest_phone' => '+94778899001',
        ];

        $response = $this->postJson(route('vendors.rfq.store', $this->vendor->slug), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('quotations', [
            'vendor_id' => $this->vendor->id,
            'venue_location' => 'Galle Fort Hotel',
            'guest_count' => 150,
        ]);
    }

    public function test_rfq_submission_validates_required_fields(): void
    {
        $response = $this->actingAs($this->coupleUser)
            ->post(route('vendors.rfq.store', $this->vendor->slug), [
                // missing event_date and couple_message
                'guest_count' => 200,
            ]);

        $response->assertSessionHasErrors(['event_date', 'couple_message']);
    }

    public function test_couple_can_toggle_shortlist_favorite_status(): void
    {
        // 1. Add to shortlist
        $response = $this->actingAs($this->coupleUser)
            ->postJson(route('vendors.favorite.toggle', $this->vendor->slug));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_favorited' => true,
        ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->coupleUser->id,
            'vendor_id' => $this->vendor->id,
        ]);

        // 2. Remove from shortlist
        $response2 = $this->actingAs($this->coupleUser)
            ->postJson(route('vendors.favorite.toggle', $this->vendor->slug));

        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'is_favorited' => false,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->coupleUser->id,
            'vendor_id' => $this->vendor->id,
        ]);
    }

    public function test_couple_can_schedule_video_consultation(): void
    {
        $payload = [
            'consultation_date' => now()->addDays(3)->toDateString(),
            'preferred_time' => '06:00 PM - 06:15 PM',
            'contact_phone' => '+94 77 123 4567',
            'consultation_notes' => 'Discuss Poruwa Ashtaka Nekath timing',
        ];

        $response = $this->actingAs($this->coupleUser)
            ->postJson(route('vendors.consultation.schedule', $this->vendor->slug), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }
}
