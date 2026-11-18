<?php

namespace Database\Seeders;

use App\Domains\Booking\Enums\BookingStatus;
use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Enums\ReviewStatus;
use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Booking\Models\Review;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Enums\MediaType;
use App\Domains\Marketplace\Enums\VerificationStatus;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Marketplace\Models\VendorMedia;
use App\Domains\Marketplace\Models\VendorPackage;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categories lookup
        $photoCat = VendorCategory::firstOrCreate(
            ['slug' => 'photography-videography'],
            [
                'name' => 'Photography & Videography',
                'description' => 'Elite wedding photography, cinema, and aerial drone masters in Sri Lanka.',
                'icon_url' => 'icons/camera.svg',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $venueCat = VendorCategory::firstOrCreate(
            ['slug' => 'venues-reception-halls'],
            [
                'name' => 'Venues & Reception Halls',
                'description' => 'Luxury hotels, outdoor banquet lawns, heritage villas, and beachside wedding venues.',
                'icon_url' => 'icons/venue.svg',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $bridalCat = VendorCategory::firstOrCreate(
            ['slug' => 'bridal-dressing-makeup'],
            [
                'name' => 'Bridal Dressing, Hair & Makeup',
                'description' => 'Kandyan Osariya drapers, Western bridal beauticians, groom dressing, and mehendi artists.',
                'icon_url' => 'icons/sparkles.svg',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        $poruwaCat = VendorCategory::firstOrCreate(
            ['slug' => 'poruwa-cultural-ceremonies'],
            [
                'name' => 'Poruwa & Cultural Ceremonies',
                'description' => 'Traditional wooden carved Poruwas, Ashtaka chanting masters, Jayamangala Gatha singers, and Kandyan drummers.',
                'icon_url' => 'icons/sun.svg',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        $floralCat = VendorCategory::firstOrCreate(
            ['slug' => 'floral-event-decor'],
            [
                'name' => 'Floral & Event Decoration',
                'description' => 'Fresh tropical florals, entrance arches, settee backdrops, fairy lighting, and luxury table centerpieces.',
                'icon_url' => 'icons/flower.svg',
                'sort_order' => 5,
                'is_active' => true,
            ]
        );

        // 2. Dhanushka Senanayake
        $vendorUser1 = User::firstOrCreate(
            ['email' => 'dhanushka@wedora.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Dhanushka Senanayake',
                'password' => Hash::make('password'),
                'phone' => '+94772345678',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $dhanushka = Vendor::firstOrCreate(
            ['slug' => 'dhanushka-senanayake'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $vendorUser1->id,
                'category_id' => $photoCat->id,
                'business_name' => 'Dhanushka Senanayake Fine Art & Cinema',
                'description' => 'A Sri Lankan wedding is not merely a party—it is a celestial alignment, a lineage gathering, and a tapestry of sacred rites. We operate as silent observers, capturing raw tenderness, authentic laughter, and grand architectural grandeur across historic estates and coastal shores.',
                'district' => 'Colombo',
                'address' => 'Colombo 07, Western Province',
                'phone' => '+94 11 782 9900',
                'email' => 'artisan@dhanushkasenanayake.com',
                'website' => 'https://dhanushkasenanayake.com',
                'instagram_handle' => 'dhanushka_fineart',
                'facebook_url' => 'https://facebook.com/dhanushkacinema',
                'starting_price' => 280000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 4.95,
                'reviews_count' => 240,
            ]
        );

        // Seed Dhanushka's 3 packages
        $dhanushkaPackages = [
            [
                'name' => 'The Poruwa Heritage Collection',
                'description' => 'Essential full-ceremony coverage focused on the solemnity of your morning Poruwa rites.',
                'price' => 280000.00,
                'duration_hours' => 6.0,
                'features' => ['2 Senior Photographers', '1 Master Cinematographer', '40-Page Flushmount Album', '3-5 Min 4K Teaser Film'],
                'sort_order' => 1,
            ],
            [
                'name' => 'The Royal Sovereign Experience',
                'description' => 'Complete coverage for both Wedding and Homecoming ceremonies including editorial pre-shoot.',
                'price' => 460000.00,
                'duration_hours' => 12.0,
                'features' => ['3 Lead Photographers', '2 Cinema Directors', '4K Aerial Drone Coverage', '2 Italian Leather Albums', 'Galle / Kandy Pre-Shoot'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Grand Heirloom Master',
                'description' => 'Unrestricted 3-day coverage including Sangeet, Nuptials, Reception, and same-day premiere.',
                'price' => 680000.00,
                'duration_hours' => 24.0,
                'features' => ['Multi-Day Full Studio Crew', 'Same-Day Reception Edit Video', '3 Fine Art Flush Albums', 'Full RAW Video Footage Hard Drive'],
                'sort_order' => 3,
            ],
        ];

        foreach ($dhanushkaPackages as $pkgData) {
            VendorPackage::firstOrCreate(
                ['vendor_id' => $dhanushka->id, 'name' => $pkgData['name']],
                [
                    'uuid' => (string) Str::uuid(),
                    'description' => $pkgData['description'],
                    'price' => $pkgData['price'],
                    'currency' => 'LKR',
                    'duration_hours' => $pkgData['duration_hours'],
                    'features' => $pkgData['features'],
                    'is_active' => true,
                    'sort_order' => $pkgData['sort_order'],
                ]
            );
        }

        // Seed Dhanushka's Media
        $mediaItems = [
            [
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDNqsCB0yjT21Rcr7gaR2phbZK4M-1JvtQnhDtIoP1hQCjk-GuYZ7WofEfFQ5c1JBnNtmwL5hA7ursRJBAzjEXlm0YZAo2_FlkWlXrljQuwhAsaoz3RJaT5JVu5CBdK4CL7xawOipyQt4o6pVxoCt6wiIA4FoRheEv18gadwX_Lauhy0fyPHCCPi6A8ANCrPG3OOe4gTQAmaHcu2vqo5kanQ6ALFximZO4R-gHA9TH-',
                'media_type' => MediaType::Image,
                'caption' => 'Candid editorial portrait of a joyful Sri Lankan couple during Poruwa ceremony',
                'is_cover' => true,
                'sort_order' => 1,
            ],
            [
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCVjheqc1ty7w6BhPZa4MH5HSI9dxXzNPQMl6Y8rILb5nqFjZiJn1tC57VSfaM_xX9RpPKd_Cd4-Ckuoe_eYnUTtcVXrN88hKTOM6L_HlZIjUAMbfjl7HrhqK5d0xG9gNtbXfQM4hS7ri5qaBZZvPSkEhYK_Z1oZV4RZhzgqUONfyqLCFJvFWWoz6bDSa_XgxQhATDKERdupspGSahrzftFPwQlIM07Lxw1vw0QPROR',
                'media_type' => MediaType::Image,
                'caption' => 'Rituals & Nuool',
                'is_cover' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($mediaItems as $mediaData) {
            VendorMedia::firstOrCreate(
                ['vendor_id' => $dhanushka->id, 'sort_order' => $mediaData['sort_order']],
                [
                    'uuid' => (string) Str::uuid(),
                    'file_path' => $mediaData['file_path'],
                    'media_type' => $mediaData['media_type'],
                    'caption' => $mediaData['caption'],
                    'is_cover' => $mediaData['is_cover'],
                ]
            );
        }

        // 3. Shangri-La Colombo Grand Ballroom
        $shangriLaUser = User::firstOrCreate(
            ['email' => 'events.colombo@shangri-la.com'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Shangri-La Banquet Director',
                'password' => Hash::make('password'),
                'phone' => '+94117888288',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $shangriLa = Vendor::firstOrCreate(
            ['slug' => 'shangri-la-colombo'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $shangriLaUser->id,
                'category_id' => $venueCat->id,
                'business_name' => 'Shangri-La Colombo Grand Ballroom',
                'description' => 'Pillar-less banquet sanctuary overlooking Galle Face Green and the Indian Ocean with dedicated bridal salons, curated Ceylon and International culinary menus, and personalized banquet butler service.',
                'district' => 'Colombo',
                'address' => '1 Galle Face, Colombo 02, Western Province',
                'phone' => '+94 11 788 8288',
                'email' => 'events.colombo@shangri-la.com',
                'website' => 'https://shangri-la.com/colombo',
                'instagram_handle' => 'shangrilacolombo',
                'starting_price' => 850000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 5.00,
                'reviews_count' => 184,
            ]
        );

        VendorPackage::firstOrCreate(
            ['vendor_id' => $shangriLa->id, 'name' => 'Shangri-La Grand Nuptials Banquet'],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Comprehensive ballroom hire with bespoke five-course banquet dinner and complementary executive bridal ocean suite.',
                'price' => 850000.00,
                'currency' => 'LKR',
                'duration_hours' => 8.0,
                'features' => ['Pillar-less Grand Ballroom', 'Dedicated Bridal Dressing Suite', 'Complimentary Champagne Toast', 'Full Audio-Visual Rigging'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        VendorMedia::firstOrCreate(
            ['vendor_id' => $shangriLa->id, 'sort_order' => 1],
            [
                'uuid' => (string) Str::uuid(),
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCmJ6sX6uqukygxYx8D509G4qdlGY2a7M4Gz1npj6BPM2UN-AkI80MMRGH7DauRP02ZBa4hVuvChP1TNHQyoi3R7zQzo44BR-cg50LzARVBA44fiJrxH-0FoOJIItwXBpvMmMt90R8bVW9DZtLThP9sJDit-x37q2YV8d6Sb5T3Ptp8Ik2k4T6LRvX-MqRhuPOzWYTt1T0w5mXh5-dntVfBqtdBVZqBWs8M_HcaJ8lL',
                'media_type' => MediaType::Image,
                'caption' => 'Opulent grand wedding ballroom at Shangri-La Colombo',
                'is_cover' => true,
            ]
        );

        // 4. Malka Bridal Atelier
        $malkaUser = User::firstOrCreate(
            ['email' => 'malka@bridalatelier.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Malka Wijesinghe',
                'password' => Hash::make('password'),
                'phone' => '+94773456789',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $malka = Vendor::firstOrCreate(
            ['slug' => 'malka-bridal-atelier'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $malkaUser->id,
                'category_id' => $bridalCat->id,
                'business_name' => 'Malka Bridal Atelier (Kandyan & Western)',
                'description' => 'Master bridal stylist specializing in royal Kandyan Osariya pleating, genuine antique 22K gold jewelry curation, hair artistry, and evening bridal western transformations.',
                'district' => 'Kandy',
                'address' => 'Peradeniya Road, Kandy & Colombo 07 Studio',
                'phone' => '+94 81 223 4567',
                'email' => 'atelier@malkabridal.lk',
                'website' => 'https://malkabridal.lk',
                'instagram_handle' => 'malka_bridal',
                'starting_price' => 180000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 4.90,
                'reviews_count' => 160,
            ]
        );

        VendorPackage::firstOrCreate(
            ['vendor_id' => $malka->id, 'name' => 'Royal Kandyan Osariya & Jewelry Suite'],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Full bridal dressing with authentic heirloom Agasti Mala and Nalalpata pin-placement.',
                'price' => 180000.00,
                'currency' => 'LKR',
                'duration_hours' => 5.0,
                'features' => ['Royal Osariya Pleating', '22K Gilded Jewelry Set', 'Mother of Bride Styling', 'Hair & Airbrush Makeup'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        VendorMedia::firstOrCreate(
            ['vendor_id' => $malka->id, 'sort_order' => 1],
            [
                'uuid' => (string) Str::uuid(),
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC6nBUoYHGWcOH-Ms4P-tHB9wY4ooFc_dzFK524Jv6zQ4fPp33y_L2IYuwOlkAehPICapiEHPww6i-XUOfl0L80chXY1LUXfnM7MmEAY8WvABWmiEMqbnYWmnqczEm_GIpWA8bqeqlCeHWREKZJ4Dz_2NaaSRac_l5MStNMe1UpjQleubtip4wz9ZGjsSO12p2Xmp5GWawbX774IK4ROwpyxOil1k5CyN1YOsc9I48P',
                'media_type' => MediaType::Image,
                'caption' => 'Hand-sewn real gold bullion embroidery on Kandyan Osariya saree',
                'is_cover' => true,
            ]
        );

        // 5. Lassana Flora Poruwa Concepts
        $floraUser = User::firstOrCreate(
            ['email' => 'weddings@lassanaflora.com'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Dr. Lasantha Malavige',
                'password' => Hash::make('password'),
                'phone' => '+94112345678',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $flora = Vendor::firstOrCreate(
            ['slug' => 'lassana-flora-poruwa'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $floraUser->id,
                'category_id' => $floralCat->id,
                'business_name' => 'Lassana Flora Poruwa Concepts',
                'description' => 'Architectural wedding Poruwa structures carved with traditional lotus and swan motifs, exotic fresh floral styling, and ceremonial floral lighting.',
                'district' => 'Colombo',
                'address' => 'Wijerama Mawatha, Colombo 07',
                'phone' => '+94 11 234 5678',
                'email' => 'weddings@lassanaflora.com',
                'website' => 'https://lassanaflora.com',
                'instagram_handle' => 'lassanaflora',
                'starting_price' => 320000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 4.88,
                'reviews_count' => 210,
            ]
        );

        VendorPackage::firstOrCreate(
            ['vendor_id' => $flora->id, 'name' => 'Regal Heritage Poruwa & Floral Pavilion'],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Handcrafted carved timber Poruwa adorned with 10,000 fresh white lotus buds and fragrant jasmine chandeliers.',
                'price' => 320000.00,
                'currency' => 'LKR',
                'duration_hours' => 10.0,
                'features' => ['Handcarved Timber Poruwa', 'Fresh White Lotus & Jasmine Decor', 'Head Table Centerpieces', 'Entrance Floral Archway'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        VendorMedia::firstOrCreate(
            ['vendor_id' => $flora->id, 'sort_order' => 1],
            [
                'uuid' => (string) Str::uuid(),
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_Qa1TV4GRM08rC95X9ja7aUKnQGa2usfTOHOhLoyzk0x4277WOxNiZHtuxI7YNEAXu5V-PiIPIFs1JbKLuOC2xHw588KPITUNzDvxEcmE7BECSzD-qFJYZo88hAkGPicCBMvo2UuHFhYmwXklTrdqtlAB3jyjG68FVGVieFc5h4SS7kolLX3vXX2Y7Gn0X2XTmdsfKkw3J7EvTeRLFw-A8ntzxYvuIn3Ht31wVpUJ',
                'media_type' => MediaType::Image,
                'caption' => 'Architectural wedding Poruwa carved with traditional lotus and swan motifs',
                'is_cover' => true,
            ]
        );

        // 6. Cinnamon Lakeside Grand Ballroom
        $lakesideUser = User::firstOrCreate(
            ['email' => 'events.lakeside@cinnamonhotels.com'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Cinnamon Lakeside Banquet Team',
                'password' => Hash::make('password'),
                'phone' => '+94112491000',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $lakeside = Vendor::firstOrCreate(
            ['slug' => 'cinnamon-lakeside'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $lakesideUser->id,
                'category_id' => $venueCat->id,
                'business_name' => 'Cinnamon Lakeside Grand Ballroom',
                'description' => 'Tranquil lakeside sanctuary with expansive manicured gardens overlooking Beira Lake, perfect for regal Poruwa ceremonies and enchanting homecoming celebrations.',
                'district' => 'Colombo',
                'address' => '115 Sir Chittampalam A. Gardiner Mawatha, Colombo 02',
                'phone' => '+94 11 249 1000',
                'email' => 'events.lakeside@cinnamonhotels.com',
                'website' => 'https://cinnamonhotels.com',
                'instagram_handle' => 'cinnamonlakeside',
                'starting_price' => 720000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 4.92,
                'reviews_count' => 195,
            ]
        );

        VendorPackage::firstOrCreate(
            ['vendor_id' => $lakeside->id, 'name' => 'King’s Court Lakeside Ballroom Package'],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Lavish ballroom hire with custom buffet curation and complimentary lakefront bridal photo-shoot access.',
                'price' => 720000.00,
                'currency' => 'LKR',
                'duration_hours' => 7.0,
                'features' => ['King’s Court Ballroom Hire', 'Gourmet Ceylon & Western Buffet', 'Dedicated Event Coordinator', 'Executive Lake Suite Night'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        VendorMedia::firstOrCreate(
            ['vendor_id' => $lakeside->id, 'sort_order' => 1],
            [
                'uuid' => (string) Str::uuid(),
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_9jG03Q2Gq5g5ZgZk-xJ2Q3n8x8Y7v8c7b8A9s8d7f6g5h4j3k2l1m0n9p8o7i6u5y4t3r2e1w0q9a8s7d6f5g4h3j2k1',
                'media_type' => MediaType::Image,
                'caption' => 'Regal lakeside ballroom setting for Sri Lankan nuptials',
                'is_cover' => true,
            ]
        );

        // 7. Choksy Cultural Troupe
        $choksyUser = User::firstOrCreate(
            ['email' => 'troupes@choksyceremonies.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Master Choksy',
                'password' => Hash::make('password'),
                'phone' => '+94774567890',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $choksy = Vendor::firstOrCreate(
            ['slug' => 'choksy-cultural-troupe'],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $choksyUser->id,
                'category_id' => $poruwaCat->id,
                'business_name' => 'Choksy Cultural Troupe & Drummers',
                'description' => 'Consecrated Kandyan drummers (Magul Bera), certified Ashtaka reciters from traditional lineages, and youth Jayamangala Gatha choir.',
                'district' => 'Kandy',
                'address' => 'Galle Road, Colombo & Kandy Cultural Center',
                'phone' => '+94 77 456 7890',
                'email' => 'troupes@choksyceremonies.lk',
                'website' => 'https://choksyceremonies.lk',
                'starting_price' => 140000.00,
                'currency' => 'LKR',
                'verification_status' => VerificationStatus::Verified,
                'is_active' => true,
                'is_featured' => true,
                'rating_avg' => 4.96,
                'reviews_count' => 130,
            ]
        );

        VendorPackage::firstOrCreate(
            ['vendor_id' => $choksy->id, 'name' => 'Sacred Poruwa Ashtaka & Magul Bera Troupe'],
            [
                'uuid' => (string) Str::uuid(),
                'description' => 'Complete ritual accompaniment including 4 Ves drummers, 2 flutists, 1 Master Ashtaka chanter, and 6-maiden Jayamangala Gatha choir.',
                'price' => 140000.00,
                'currency' => 'LKR',
                'duration_hours' => 4.0,
                'features' => ['4 Traditional Kandyan Ves Drummers', 'Venerable Lineage Ashtaka Master', 'Jayamangala Gatha Maiden Choir', 'Ceremonial Conch (Hakgediya) Blowers'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        VendorMedia::firstOrCreate(
            ['vendor_id' => $choksy->id, 'sort_order' => 1],
            [
                'uuid' => (string) Str::uuid(),
                'file_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdvX8u-VF5Q7cuJP2MmIjK2PpdtiXP7RSQx8LRum5ToF1fUCSTrVdmJtTdFLvIiJV7sZfDh7VSUi8R8pH08PiMoJ1FLqhGpQoTC7rgQtUSQojY5_EecSY0lhJiR-0siXeMyu5RfErQ_GMWFm6sklRUvxfKfJ2Lb26Jwp3ZOWXZ6n1jWEaGKTrFoKlhb68umzoexUYOF_mmAe9VcD-1WZpzhfR9rPUMurqhM9AicD2B',
                'media_type' => MediaType::Image,
                'caption' => 'Ceremonial Kandyan drummers in traditional Ves attire',
                'is_cover' => true,
            ]
        );

        // 8. Seed Verified Review with couple & completed booking (preserved for existing tests)
        $reviewCouple = User::firstOrCreate(
            ['email' => 'shenali@wickremasinghe.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Shenali & Raveen Wickremasinghe',
                'password' => Hash::make('password'),
                'phone' => '+94771122334',
                'role' => UserRole::Couple,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $wedding = Wedding::firstOrCreate(
            ['title' => 'Shenali & Raveen Poruwa Nuptials'],
            [
                'uuid' => (string) Str::uuid(),
                'owner_id' => $reviewCouple->id,
                'partner1_name' => 'Shenali Wickremasinghe',
                'partner2_name' => 'Raveen Wickremasinghe',
                'wedding_type' => WeddingType::Traditional,
                'wedding_date' => now()->subMonths(2)->toDateString(),
                'location' => 'Shangri-La Colombo',
                'district' => 'Colombo',
                'estimated_guest_count' => 350,
                'total_budget' => 4500000.00,
                'currency' => 'LKR',
                'status' => WeddingStatus::Completed,
            ]
        );

        WeddingMember::firstOrCreate(
            [
                'wedding_id' => $wedding->id,
                'user_id' => $reviewCouple->id,
            ],
            [
                'role' => WeddingMemberRole::Owner,
                'invitation_status' => 'accepted',
                'joined_at' => now()->subMonths(6),
                'permissions' => ['*'],
            ]
        );

        $package = VendorPackage::where('vendor_id', $dhanushka->id)->orderBy('id')->first();

        $booking = Booking::firstOrCreate(
            [
                'wedding_id' => $wedding->id,
                'vendor_id' => $dhanushka->id,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'package_id' => $package?->id,
                'event_date' => now()->subMonths(2)->toDateString(),
                'total_amount' => 460000.00,
                'advance_amount' => 138000.00,
                'balance_amount' => 322000.00,
                'currency' => 'LKR',
                'status' => BookingStatus::Completed,
                'confirmed_at' => now()->subMonths(4),
                'completed_at' => now()->subMonths(2),
            ]
        );

        Review::firstOrCreate(
            [
                'booking_id' => $booking->id,
                'vendor_id' => $dhanushka->id,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'wedding_id' => $wedding->id,
                'user_id' => $reviewCouple->id,
                'rating' => 5,
                'comment' => "Wedora took all the chaos out of coordinating our astrologer's Nekath with our photographers and hotel banquet team. Having our Poruwa timeline and verified vendors in one spot made our wedding week completely blissful.",
                'status' => ReviewStatus::Approved,
            ]
        );

        // Seed an upcoming booking for Dhanushka so crew-brief and imminent ceremony work dynamically
        $upcomingWedding = Wedding::firstOrCreate(
            ['title' => 'Senesh & Dilini Nuptials'],
            [
                'uuid' => (string) Str::uuid(),
                'owner_id' => $reviewCouple->id,
                'partner1_name' => 'Senesh Perera',
                'partner2_name' => 'Dilini Jayawardena',
                'wedding_type' => WeddingType::Traditional,
                'wedding_date' => now()->addDays(24)->toDateString(),
                'location' => 'Shangri-La Colombo (Grand Ballroom)',
                'district' => 'Colombo',
                'estimated_guest_count' => 300,
                'total_budget' => 5500000.00,
                'currency' => 'LKR',
                'status' => WeddingStatus::Planning,
            ]
        );

        Booking::firstOrCreate(
            [
                'wedding_id' => $upcomingWedding->id,
                'vendor_id' => $dhanushka->id,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'package_id' => $package?->id,
                'event_date' => now()->addDays(24)->toDateString(),
                'total_amount' => 460000.00,
                'advance_amount' => 230000.00,
                'balance_amount' => 230000.00,
                'currency' => 'LKR',
                'status' => BookingStatus::Confirmed,
                'confirmed_at' => now()->subDays(10),
            ]
        );

        // Seed a sample Quotation for Dhanushka
        Quotation::firstOrCreate(
            [
                'vendor_id' => $dhanushka->id,
                'wedding_id' => $upcomingWedding->id,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'requested_by_user_id' => $reviewCouple->id,
                'package_id' => $package?->id,
                'event_date' => now()->addDays(24)->toDateString(),
                'status' => QuotationStatus::Accepted,
                'total_amount' => 460000.00,
                'currency' => 'LKR',
                'valid_until' => now()->addDays(14)->toDateString(),
                'couple_message' => 'Auspicious Nekath at 09:42 AM. Dual camera crew required for morning Poruwa.',
                'accepted_at' => now()->subDays(2),
            ]
        );
    }
}
