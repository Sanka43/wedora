<?php

namespace App\Domains\Budget\Actions;

use App\Domains\Budget\Models\Budget;
use App\Domains\Wedding\Models\Wedding;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AllocateBudgetCategoriesAction
{
    /**
     * Default Sri Lankan wedding budget allocation percentage distribution.
     */
    protected array $defaultAllocations = [
        ['category' => 'Reception Venue & Catering', 'pct' => 45.0, 'notes' => 'Hall booking, guest plates, beverages & welcome drinks'],
        ['category' => 'Photography & Cinematography', 'pct' => 15.0, 'notes' => 'Full day wedding coverage, pre-shoot & wedding albums'],
        ['category' => 'Bridal Dressing, Attire & Jewelry', 'pct' => 12.0, 'notes' => 'Osariya, Mul Anduma, 7-necklace jewelry & accessories'],
        ['category' => 'Floral & Settee Decor', 'pct' => 10.0, 'notes' => 'Settee backdrop, Poruwa decor, centerpieces & entrance arch'],
        ['category' => 'Poruwa, Ashtaka & Drummers', 'pct' => 8.0, 'notes' => 'Poruwa construction, master of ceremonies, Ves dancers & blessings'],
        ['category' => 'Music, Live Band & DJ', 'pct' => 5.0, 'notes' => 'Band, acoustic sounds, DJ & lighting production'],
        ['category' => 'Stationery & Cake Boxes', 'pct' => 3.0, 'notes' => 'Bulath Hurulu invitations, wedding cake structures & favor boxes'],
        ['category' => 'Contingency & Miscellaneous', 'pct' => 2.0, 'notes' => 'Emergency funds, tips & last minute transport needs'],
    ];

    /**
     * Allocate budget categories for a given wedding based on total budget.
     *
     * @return Collection<int, Budget>
     */
    public function execute(Wedding $wedding, ?array $customAllocations = null): Collection
    {
        $allocations = $customAllocations ?? $this->defaultAllocations;
        $totalBudget = (float) $wedding->total_budget;

        return DB::transaction(function () use ($wedding, $allocations, $totalBudget) {
            $created = collect();
            $sort = 1;

            foreach ($allocations as $alloc) {
                $pct = (float) $alloc['pct'];
                $plannedAmount = round(($totalBudget * ($pct / 100)), 2);

                $budget = Budget::create([
                    'wedding_id' => $wedding->id,
                    'category_name' => $alloc['category'],
                    'planned_amount' => $plannedAmount,
                    'notes' => $alloc['notes'] ?? null,
                    'sort_order' => $sort++,
                ]);

                $created->push($budget);
            }

            return $created;
        });
    }
}
