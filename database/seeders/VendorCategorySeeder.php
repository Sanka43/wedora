<?php

namespace Database\Seeders;

use App\Domains\Marketplace\Models\VendorCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VendorCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Venues & Reception Halls',
                'slug' => 'venues-reception-halls',
                'description' => 'Luxury hotels, outdoor banquet lawns, heritage villas, and beachside wedding venues across Sri Lanka.',
                'icon_url' => 'icons/venue.svg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Photography & Videography',
                'slug' => 'photography-videography',
                'description' => 'Candid wedding photographers, pre-shoot specialists, drone cinematographers, and heirloom storytellers.',
                'icon_url' => 'icons/camera.svg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Bridal Dressing, Hair & Makeup',
                'slug' => 'bridal-dressing-makeup',
                'description' => 'Kandyan Osariya drapers, Western bridal beauticians, groom dressing, and mehendi artists.',
                'icon_url' => 'icons/sparkles.svg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Poruwa & Cultural Ceremonies',
                'slug' => 'poruwa-cultural-ceremonies',
                'description' => 'Traditional wooden carved Poruwas, Ashtaka chanting masters, Jayamangala Gatha singers, and Kandyan Ves drummers.',
                'icon_url' => 'icons/sun.svg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Floral & Event Decoration',
                'slug' => 'floral-event-decor',
                'description' => 'Fresh tropical florals, entrance arches, settee backdrops, fairy lighting, and luxury table centerpieces.',
                'icon_url' => 'icons/flower.svg',
                'sort_order' => 5,
            ],
            [
                'name' => 'Wedding Attire & Fine Jewelry',
                'slug' => 'wedding-attire-jewelry',
                'description' => 'Custom Kandyan Mul Anduma, bespoke tuxedos, bridal sarees, and traditional 7-necklace bridal jewelry sets.',
                'icon_url' => 'icons/shirt.svg',
                'sort_order' => 6,
            ],
            [
                'name' => 'Catering & Wedding Cakes',
                'slug' => 'catering-wedding-cakes',
                'description' => 'Authentic Sri Lankan buffets, Western sit-down banquets, tiered wedding structure cakes, and sweet cake structures.',
                'icon_url' => 'icons/cake.svg',
                'sort_order' => 7,
            ],
            [
                'name' => 'Music, Bands & DJs',
                'slug' => 'music-bands-dj',
                'description' => 'Live wedding bands, acoustic ensembles, club DJs, sound reinforcement, and intelligent lighting setups.',
                'icon_url' => 'icons/music.svg',
                'sort_order' => 8,
            ],
            [
                'name' => 'Stationery, Invitations & Cake Boxes',
                'slug' => 'stationery-invitations-cake-boxes',
                'description' => 'Letterpress wedding invitations, custom cake boxes, wax seals, digital RSVP stationery, and guest favors.',
                'icon_url' => 'icons/mail.svg',
                'sort_order' => 9,
            ],
            [
                'name' => 'Wedding Cars & Transport',
                'slug' => 'wedding-cars-transport',
                'description' => 'Classic vintage wedding cars, luxury limousines, modern convertibles, and guest shuttle coaches.',
                'icon_url' => 'icons/car.svg',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $cat) {
            VendorCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, [
                    'uuid' => (string) Str::uuid(),
                    'is_active' => true,
                ])
            );
        }
    }
}
