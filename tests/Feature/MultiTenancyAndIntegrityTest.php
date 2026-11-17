<?php

namespace Tests\Feature;

use App\Domains\Booking\Actions\ConvertQuotationToBookingAction;
use App\Domains\Booking\Enums\BookingStatus;
use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Budget\Actions\AllocateBudgetCategoriesAction;
use App\Domains\Budget\Models\Budget;
use App\Domains\Budget\Models\Expense;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Enums\TaskStatus;
use App\Domains\Planning\Models\Task;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenancyAndIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected User $user1;
    protected User $user2;
    protected Wedding $wedding1;
    protected Wedding $wedding2;
    protected CurrentWeddingManager $weddingManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->weddingManager = app(CurrentWeddingManager::class);
        $this->weddingManager->clear();

        $this->user1 = User::create([
            'name' => 'Kasun Perera',
            'email' => 'kasun@test.lk',
            'password' => 'secret123',
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $this->user2 = User::create([
            'name' => 'Nimal Silva',
            'email' => 'nimal@test.lk',
            'password' => 'secret123',
            'role' => UserRole::Couple,
            'status' => UserStatus::Active,
        ]);

        $this->wedding1 = Wedding::create([
            'owner_id' => $this->user1->id,
            'title' => 'Kasun & Dilani Wedding',
            'partner1_name' => 'Kasun',
            'partner2_name' => 'Dilani',
            'wedding_date' => now()->addMonths(6)->toDateString(),
            'wedding_type' => WeddingType::Traditional,
            'district' => 'Colombo',
            'estimated_guest_count' => 250,
            'total_budget' => 3000000.00,
            'currency' => 'LKR',
            'status' => WeddingStatus::Planning,
        ]);

        $this->wedding2 = Wedding::create([
            'owner_id' => $this->user2->id,
            'title' => 'Nimal & Ruwani Wedding',
            'partner1_name' => 'Nimal',
            'partner2_name' => 'Ruwani',
            'wedding_date' => now()->addMonths(8)->toDateString(),
            'wedding_type' => WeddingType::Western,
            'district' => 'Kandy',
            'estimated_guest_count' => 150,
            'total_budget' => 2000000.00,
            'currency' => 'LKR',
            'status' => WeddingStatus::Planning,
        ]);
    }

    public function test_uuids_are_auto_generated_on_model_creation(): void
    {
        $this->assertNotEmpty($this->user1->uuid);
        $this->assertNotEmpty($this->wedding1->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $this->wedding1->uuid
        );
    }

    public function test_wedding_scope_automatically_scopes_queries_and_assigns_wedding_id(): void
    {
        // 1. Set context to Wedding 1
        $this->weddingManager->set($this->wedding1);

        // 2. Create task without explicitly passing wedding_id
        $task1 = Task::create([
            'title' => 'Book Poruwa Ashtaka Master',
            'priority' => TaskPriority::High,
            'status' => TaskStatus::Pending,
        ]);

        $this->assertEquals($this->wedding1->id, $task1->wedding_id);

        // 3. Switch context to Wedding 2
        $this->weddingManager->set($this->wedding2);

        $task2 = Task::create([
            'title' => 'Reserve Church Venue in Kandy',
            'priority' => TaskPriority::Urgent,
            'status' => TaskStatus::Pending,
        ]);

        $this->assertEquals($this->wedding2->id, $task2->wedding_id);

        // 4. Assert Wedding 2 only sees its own tasks
        $wedding2Tasks = Task::all();
        $this->assertCount(1, $wedding2Tasks);
        $this->assertEquals('Reserve Church Venue in Kandy', $wedding2Tasks->first()->title);

        // 5. Switch back to Wedding 1
        $this->weddingManager->set($this->wedding1);
        $wedding1Tasks = Task::all();
        $this->assertCount(1, $wedding1Tasks);
        $this->assertEquals('Book Poruwa Ashtaka Master', $wedding1Tasks->first()->title);

        // 6. Clear wedding context - now all tasks are visible
        $this->weddingManager->clear();
        $this->assertCount(2, Task::all());
    }

    public function test_on_delete_restrict_blocks_deleting_budget_with_recorded_expenses(): void
    {
        $budget = Budget::create([
            'wedding_id' => $this->wedding1->id,
            'category_name' => 'Reception Catering',
            'planned_amount' => 1200000.00,
        ]);

        Expense::create([
            'wedding_id' => $this->wedding1->id,
            'budget_id' => $budget->id,
            'title' => 'Advance Deposit for Cinnamon Grand',
            'amount' => 300000.00,
            'expense_date' => now()->toDateString(),
        ]);

        // Attempting to delete the Budget while Expenses exist must be blocked by database foreign key constraint
        $this->expectException(QueryException::class);
        $budget->delete();
    }

    public function test_allocate_budget_categories_action_allocates_budget_percentages(): void
    {
        $action = new AllocateBudgetCategoriesAction();
        $categories = $action->execute($this->wedding1);

        $this->assertCount(8, $categories);

        // 45% of 3,000,000 = 1,350,000
        $catering = $categories->firstWhere('category_name', 'Reception Venue & Catering');
        $this->assertNotNull($catering);
        $this->assertEquals('1350000.00', $catering->planned_amount);

        // Sum of all planned categories must equal total budget
        $totalPlanned = $categories->sum('planned_amount');
        $this->assertEquals(3000000.00, $totalPlanned);
    }

    public function test_convert_quotation_to_booking_action_creates_booking_and_updates_quotation(): void
    {
        $vendorUser = User::create([
            'name' => 'Studio 3000',
            'email' => 'studio3000@test.lk',
            'password' => 'secret',
            'role' => UserRole::Vendor,
            'status' => UserStatus::Active,
        ]);

        $category = VendorCategory::create([
            'name' => 'Photography',
            'slug' => 'photography',
        ]);

        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'category_id' => $category->id,
            'business_name' => 'Studio 3000 Photography',
            'slug' => 'studio-3000',
            'description' => 'Top Sri Lankan wedding photographer',
            'district' => 'Colombo',
            'address' => 'Galle Road, Colombo 03',
            'phone' => '+94112345678',
            'email' => 'info@studio3000.lk',
            'starting_price' => 250000.00,
        ]);

        $quotation = Quotation::create([
            'wedding_id' => $this->wedding1->id,
            'vendor_id' => $vendor->id,
            'requested_by_user_id' => $this->user1->id,
            'event_date' => $this->wedding1->wedding_date,
            'couple_message' => 'Please provide quote for full day photography',
            'total_amount' => 450000.00,
            'status' => QuotationStatus::Pending,
        ]);

        $action = new ConvertQuotationToBookingAction();
        $booking = $action->execute($quotation, 150000.00, 'Advance paid via Commercial Bank transfer');

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals(BookingStatus::Confirmed, $booking->status);
        $this->assertEquals('450000.00', $booking->total_amount);
        $this->assertEquals('150000.00', $booking->advance_amount);
        $this->assertEquals('300000.00', $booking->balance_amount);
        $this->assertEquals('Advance paid via Commercial Bank transfer', $booking->notes);

        // Verify quotation status transitioned to Accepted
        $quotation->refresh();
        $this->assertEquals(QuotationStatus::Accepted, $quotation->status);
        $this->assertNotNull($quotation->accepted_at);
    }
}
