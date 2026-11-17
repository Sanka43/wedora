<?php

namespace Database\Seeders;

use App\Domains\Planning\Enums\ChecklistWeddingType;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Models\ChecklistTemplate;
use App\Domains\Planning\Models\ChecklistTemplateItem;
use Illuminate\Database\Seeder;

class ChecklistTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Traditional Sri Lankan Poruwa Wedding
        $traditional = ChecklistTemplate::firstOrCreate(
            ['name' => 'Traditional Sri Lankan Poruwa Wedding Timeline'],
            [
                'wedding_type' => ChecklistWeddingType::Traditional,
                'description' => 'Comprehensive planning milestones tailored for authentic Sri Lankan Buddhist and cultural Poruwa ceremonies.',
                'is_active' => true,
            ]
        );

        $traditionalItems = [
            [
                'category_name' => 'Astrology & Nekath',
                'title' => 'Consult Astrologer for Auspicious Times (Nekath)',
                'description' => 'Obtain Nekath for Poruwa entry, tying of nuptial knot (Pethi Kandum), exchange of rings, and departure.',
                'suggested_due_offset_days' => -365,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 1,
            ],
            [
                'category_name' => 'Venue & Catering',
                'title' => 'Book Wedding Reception Hall & Catering Banquet',
                'description' => 'Finalize hotel or banquet venue capable of accommodating Poruwa structure and guest count.',
                'suggested_due_offset_days' => -300,
                'priority' => TaskPriority::High,
                'sort_order' => 2,
            ],
            [
                'category_name' => 'Photography',
                'title' => 'Book Candid Photographer & Drone Cinematographer',
                'description' => 'Secure wedding day coverage and plan the Sri Lankan pre-shoot location.',
                'suggested_due_offset_days' => -240,
                'priority' => TaskPriority::High,
                'sort_order' => 3,
            ],
            [
                'category_name' => 'Attire & Dressing',
                'title' => 'Book Kandyan Bridal Beautician & Mul Anduma Tailor',
                'description' => 'Reserve bridal dressing artist for authentic Kandyan Osariya, Nalalpata, and 7 jewelry necklaces.',
                'suggested_due_offset_days' => -210,
                'priority' => TaskPriority::High,
                'sort_order' => 4,
            ],
            [
                'category_name' => 'Poruwa & Cultural',
                'title' => 'Select Poruwa Master (Ashtaka) & Jayamangala Gatha Troupe',
                'description' => 'Arrange experienced Ashtaka chanter, Jayamangala Gatha singers, and traditional Ves drummers.',
                'suggested_due_offset_days' => -180,
                'priority' => TaskPriority::High,
                'sort_order' => 5,
            ],
            [
                'category_name' => 'Decor & Florals',
                'title' => 'Finalize Poruwa Stage, Settee Backdrop & Oil Lamp Decor',
                'description' => 'Confirm traditional coconut flower (Pol Mal), betel leaves (Bulath Hurulu), and Brass Oil Lamp decorations.',
                'suggested_due_offset_days' => -120,
                'priority' => TaskPriority::Medium,
                'sort_order' => 6,
            ],
            [
                'category_name' => 'Stationery & Invitations',
                'title' => 'Print and Hand-Deliver Wedding Invitations (Bulath Athin Deema)',
                'description' => 'Print invitations, assemble cake boxes, and conduct traditional visits with betel leaves to close elders.',
                'suggested_due_offset_days' => -60,
                'priority' => TaskPriority::High,
                'sort_order' => 7,
            ],
            [
                'category_name' => 'Poruwa Ceremony Items',
                'title' => 'Gather Poruwa Ritual Items (Piri Pirivara)',
                'description' => 'Prepare white pirith noola, gold coin, betel sheaves, clay pot & coconut for breaking (Pol Geseema).',
                'suggested_due_offset_days' => -14,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 8,
            ],
            [
                'category_name' => 'Final Rehearsals',
                'title' => 'Synchronize Exact Nekath Schedule with Venue and Master of Ceremonies',
                'description' => 'Ensure hotel food service and Poruwa coordinator are aligned to the minute of auspicious times.',
                'suggested_due_offset_days' => -3,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 9,
            ],
            [
                'category_name' => 'Wedding Day',
                'title' => 'Poruwa Ceremony & Marriage Registration',
                'description' => 'Step onto the Poruwa right foot first at exact Nekath time, recite vows, light brass oil lamp, and register marriage.',
                'suggested_due_offset_days' => 0,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 10,
            ],
        ];

        foreach ($traditionalItems as $item) {
            ChecklistTemplateItem::firstOrCreate(
                [
                    'checklist_template_id' => $traditional->id,
                    'title' => $item['title'],
                ],
                $item
            );
        }

        // 2. Western / Church Wedding
        $western = ChecklistTemplate::firstOrCreate(
            ['name' => 'Western / Church Wedding Timeline'],
            [
                'wedding_type' => ChecklistWeddingType::Western,
                'description' => 'Classic church ceremony and reception planning timeline with modern milestone milestones.',
                'is_active' => true,
            ]
        );

        $westernItems = [
            [
                'category_name' => 'Ceremony Venue',
                'title' => 'Reserve Church and Consult Officiant / Priest',
                'description' => 'Book church date, fulfill pre-marital counseling requirements, and review ceremony guidelines.',
                'suggested_due_offset_days' => -365,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 1,
            ],
            [
                'category_name' => 'Reception',
                'title' => 'Book Reception Ballroom & Catering Menu Tasting',
                'description' => 'Reserve cocktail lawn and banquet hall, select 4-course menu or international buffet.',
                'suggested_due_offset_days' => -300,
                'priority' => TaskPriority::High,
                'sort_order' => 2,
            ],
            [
                'category_name' => 'Photography',
                'title' => 'Hire Wedding Photographer & Videographer',
                'description' => 'Finalize bridal party portraits, candid coverage, and highlight teaser film.',
                'suggested_due_offset_days' => -240,
                'priority' => TaskPriority::High,
                'sort_order' => 3,
            ],
            [
                'category_name' => 'Attire',
                'title' => 'Select Bridal Gown, Veil, and Tuxedos',
                'description' => 'Custom gown fittings, order bridesmaids dresses, and fit groom & groomsmen suits.',
                'suggested_due_offset_days' => -180,
                'priority' => TaskPriority::High,
                'sort_order' => 4,
            ],
            [
                'category_name' => 'Entertainment',
                'title' => 'Book Wedding Band, DJ & Master of Ceremonies',
                'description' => 'Select first dance song, bridal entrance anthem, and party playlist.',
                'suggested_due_offset_days' => -120,
                'priority' => TaskPriority::Medium,
                'sort_order' => 5,
            ],
            [
                'category_name' => 'RSVP & Seating',
                'title' => 'Send Formal Invitations & Finalize Seating Chart',
                'description' => 'Track RSVPs via digital portal and organize table arrangements.',
                'suggested_due_offset_days' => -45,
                'priority' => TaskPriority::High,
                'sort_order' => 6,
            ],
            [
                'category_name' => 'Rehearsal',
                'title' => 'Conduct Church Rehearsal & Dinner',
                'description' => 'Walkthrough procession, readings, vows, and exchange of rings with wedding party.',
                'suggested_due_offset_days' => -1,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 7,
            ],
            [
                'category_name' => 'Wedding Day',
                'title' => 'Church Ceremony, Nuptial Blessing & Reception Gala',
                'description' => 'Exchange rings and vows, sign registry, first dance, cake cutting, and celebratory send-off.',
                'suggested_due_offset_days' => 0,
                'priority' => TaskPriority::Urgent,
                'sort_order' => 8,
            ],
        ];

        foreach ($westernItems as $item) {
            ChecklistTemplateItem::firstOrCreate(
                [
                    'checklist_template_id' => $western->id,
                    'title' => $item['title'],
                ],
                $item
            );
        }
    }
}
