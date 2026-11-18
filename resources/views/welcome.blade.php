<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="web_standard" name="shell-type">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wedora — Sri Lankan Wedding Planning Platform & Verified Vendor Directory</title>

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
            h1, h2, h3, h4, h5, h6 { font-family: 'Cormorant Garamond', Georgia, serif; }
        }
        ::-webkit-scrollbar { display: none; }
    </style>

    <!-- Tailwind Config & Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-error-container": "#93000a",
                        "secondary-fixed-dim": "#bec6e0",
                        "tertiary-fixed-dim": "#a1d1b8",
                        "on-tertiary": "#ffffff",
                        "primary-fixed": "#ffdea5",
                        "surface": "#fbf9f6",
                        "surface-container-high": "#eae8e5",
                        "error": "#ba1a1a",
                        "primary-fixed-dim": "#e9c176",
                        "on-background": "#1b1c1a",
                        "secondary": "#565e74",
                        "on-primary-fixed-variant": "#5d4201",
                        "inverse-primary": "#e9c176",
                        "background": "#fbf9f6",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-error": "#ffffff",
                        "surface-variant": "#e4e2df",
                        "on-primary": "#ffffff",
                        "surface-bright": "#fbf9f6",
                        "primary-container": "#c5a059",
                        "surface-container": "#efeeeb",
                        "on-secondary-fixed": "#131b2e",
                        "tertiary-container": "#81b098",
                        "surface-container-low": "#f5f3f0",
                        "outline-variant": "#d1c5b4",
                        "on-tertiary-fixed-variant": "#224f3c",
                        "on-primary-fixed": "#261900",
                        "inverse-on-surface": "#f2f0ed",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed": "#002114",
                        "inverse-surface": "#30312f",
                        "secondary-container": "#dae2fd",
                        "on-tertiary-container": "#144331",
                        "surface-container-highest": "#e4e2df",
                        "on-surface": "#1b1c1a",
                        "on-primary-container": "#4e3700",
                        "surface-tint": "#775a19",
                        "on-surface-variant": "#4e4639",
                        "surface-dim": "#dbdad7",
                        "secondary-fixed": "#dae2fd",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#bceed3",
                        "on-secondary-container": "#5c647a",
                        "tertiary": "#3a6752",
                        "primary": "#775a19",
                        "outline": "#7f7667"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "gutter": "1.5rem",
                        "space-xl": "2.5rem",
                        "space-md": "1rem",
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem",
                        "space-2xl": "4rem",
                        "gutter-mobile": "1rem",
                        "space-xs": "0.25rem",
                        "margin": "3rem",
                        "margin-mobile": "1.25rem"
                    },
                    fontFamily: {
                        "title-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "title-md": ["Plus Jakarta Sans", "sans-serif"],
                        "display-lg": ["Cormorant Garamond", "Georgia", "serif"],
                        "label-md": ["Plus Jakarta Sans", "sans-serif"],
                        "body-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "display-lg-mobile": ["Cormorant Garamond", "Georgia", "serif"],
                        "headline-md": ["Cormorant Garamond", "Georgia", "serif"],
                        "title-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-sm": ["Cormorant Garamond", "Georgia", "serif"],
                        "label-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "body-md": ["Plus Jakarta Sans", "sans-serif"],
                        "label-caps": ["Plus Jakarta Sans", "sans-serif"],
                        "display-md-mobile": ["Cormorant Garamond", "Georgia", "serif"],
                        "display-md": ["Cormorant Garamond", "Georgia", "serif"],
                        "headline-lg": ["Cormorant Garamond", "Georgia", "serif"],
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                        serif: ["Cormorant Garamond", "Georgia", "serif"]
                    },
                    fontSize: {
                        "title-lg": ["18px", { lineHeight: "26px", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "26px", fontWeight: "400" }],
                        "title-md": ["16px", { lineHeight: "24px", fontWeight: "600" }],
                        "display-lg": ["56px", { lineHeight: "68px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "label-md": ["11px", { lineHeight: "16px", letterSpacing: "0.06em", fontWeight: "600" }],
                        "body-sm": ["12px", { lineHeight: "18px", fontWeight: "400" }],
                        "display-lg-mobile": ["38px", { lineHeight: "48px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-md": ["26px", { lineHeight: "34px", fontWeight: "600" }],
                        "title-sm": ["14px", { lineHeight: "20px", fontWeight: "600" }],
                        "headline-sm": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "label-lg": ["13px", { lineHeight: "18px", letterSpacing: "0.04em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "22px", fontWeight: "400" }],
                        "label-caps": ["10px", { lineHeight: "14px", letterSpacing: "0.12em", fontWeight: "700" }],
                        "display-md-mobile": ["32px", { lineHeight: "42px", letterSpacing: "-0.01em", fontWeight: "500" }],
                        "display-md": ["44px", { lineHeight: "54px", letterSpacing: "-0.015em", fontWeight: "500" }],
                        "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "600" }]
                    }
                }
            }
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-fixed selection:text-on-primary-fixed">

    @php
        $portalRoute = route('workspace.dashboard');
        $portalLabel = 'My Workspace';
        $portalIcon = 'spa';
        if (auth()->check()) {
            $u = auth()->user();
            if ($u->isSuperAdmin()) {
                $portalRoute = route('admin.dashboard');
                $portalLabel = 'Control Center';
                $portalIcon = 'admin_panel_settings';
            } elseif ($u->isVendor()) {
                $portalRoute = route('vendor.dashboard');
                $portalLabel = 'Vendor Portal';
                $portalIcon = 'storefront';
            } elseif ($u->isPlanner()) {
                $portalRoute = route('planner.dashboard');
                $portalLabel = 'Planner Studio';
                $portalIcon = 'event_note';
            }
        }
    @endphp

    <!-- Top Navigation Bar -->
    <x-top-navbar />

    <main class="w-full pt-20 bg-surface min-h-[calc(100vh-80px)]">
        <div class="flex flex-col w-full">

            <!-- Immersive Editorial Romantic Hero Section -->
            <section class="relative w-full overflow-hidden bg-surface pb-space-2xl">
                <!-- Atmospheric Ambient Glows -->
                <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-primary-fixed/25 blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/4 -right-24 w-[32rem] h-[32rem] rounded-full bg-tertiary-fixed/20 blur-3xl pointer-events-none"></div>

                <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin pt-space-xl">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                        <!-- Hero Text Column -->
                        <div class="lg:col-span-7 flex flex-col items-start">
                            <h1 class="font-display-lg text-display-lg-mobile sm:text-display-lg text-on-background tracking-tight">
                                Craft Your Dream <br class="hidden sm:inline">
                                <span class="italic font-normal text-primary underline decoration-primary-fixed-dim/60 decoration-wavy decoration-1 underline-offset-8">Sri Lankan Wedding</span>, Effortlessly
                            </h1>

                            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mt-space-lg mb-space-xl">
                                Discover curated top-tier vendors across all 25 districts, calculate auspicious Nekath times, and orchestrate traditional Poruwa to modern receptions in one cohesive sanctuary.
                            </p>

                            <div class="flex flex-wrap items-center gap-space-md w-full sm:w-auto">
                                <a class="inline-flex items-center justify-center gap-space-xs px-space-xl py-3.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container transition-all shadow-md font-title-sm text-title-sm group" href="#marketplace-anchor">
                                    <span>Explore Verified Vendors</span>
                                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>

                                @auth
                                    <a class="inline-flex items-center justify-center gap-space-xs px-space-xl py-3.5 rounded-lg bg-surface-container-lowest text-on-background hover:bg-surface-container transition-all shadow-sm font-title-sm text-title-sm" href="{{ $portalRoute }}">
                                        <span class="material-symbols-outlined text-[18px] text-tertiary">{{ $portalIcon }}</span>
                                        <span>{{ $portalLabel }}</span>
                                    </a>
                                @else
                                    <a class="inline-flex items-center justify-center gap-space-xs px-space-xl py-3.5 rounded-lg bg-surface-container-lowest text-on-background hover:bg-surface-container transition-all shadow-sm font-title-sm text-title-sm" href="{{ route('register') }}">
                                        <span class="material-symbols-outlined text-[18px] text-tertiary">spa</span>
                                        <span>Sign Up Free</span>
                                    </a>
                                @endauth
                            </div>

                            <!-- Trust statistics pill row -->
                            <div class="w-full mt-space-2xl pt-space-lg bg-surface-container-low rounded-xl px-space-lg py-space-md shadow-sm">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md">
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm text-on-background">4,800+</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Sri Lankan Couples</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm text-on-background">1,250+</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Verified Ateliers</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1">
                                            <span class="font-headline-sm text-headline-sm text-tertiary">99.4%</span>
                                            <span class="material-symbols-outlined text-[14px] text-tertiary">verified</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Nekath Precision</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1">
                                            <span class="font-headline-sm text-headline-sm text-primary">4.95</span>
                                            <span class="material-symbols-outlined text-[16px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Couple Satisfaction</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hero Visual Mosaic / Mood Collage -->
                        <div class="lg:col-span-5 relative mt-8 lg:mt-0">
                            <div class="relative w-full aspect-[4/5] rounded-xl overflow-hidden shadow-xl bg-surface-container-high">
                                <img class="w-full h-full object-cover" data-alt="An ethereal high-end Sri Lankan bride in an exquisite gold-embroidered Kandyan Osariya saree adorned with traditional Ceylon Nalalpatiya forehead jewelry and Agasti necklaces, standing gracefully beside an ornate hand-carved floral Poruwa bathed in warm morning golden sunlight, peaceful, serene, luxury editorial wedding aesthetic, natural warm palette." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBc11vPU5D96STDyAiRhz71PN8Hnjo3JlE3m52iTiW5r9gJgNJsDCRDkQcFVf_3aLnijQc-JIasEfsb-z1FiQCe-nLW0QbLTw4R9FNbZUO2dgeeOA7ghtMuuEzvGYF1Cfe60PiO_zhp2OLnZoDY1XP58eMHgJkP-nyUxHu3bgWd0jLQOEryDcXLCUCkrCf_fveNMrueSunfMybDyPzSEtGjgLxn7D_JCyEkhivTkB4">
                                <div class="absolute inset-0 bg-gradient-to-t from-on-background/80 via-transparent to-transparent"></div>
                                
                                <!-- Live Poruwa Ritual Pill Overlay -->
                                <div class="absolute bottom-4 left-4 right-4 bg-surface-container-lowest/95 backdrop-blur-md p-space-md rounded-lg shadow-lg flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">wb_twilight</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1">
                                                <span class="font-label-caps text-label-caps text-tertiary uppercase">Auspicious Nekath Window</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                            </div>
                                            <p class="font-title-sm text-title-sm text-on-surface">Subha Muhurthaya: 09:24 AM</p>
                                        </div>
                                    </div>
                                    <span class="font-label-caps text-label-caps px-2 py-1 bg-surface-container text-on-surface-variant rounded hidden sm:inline-block">Colombo District</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Prominent Floating Search & Filter Atelier Bar -->
            <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin -mt-8 relative z-20" id="marketplace-anchor">
                <div class="w-full bg-surface-container-lowest rounded-xl p-space-md shadow-xl bg-gradient-to-b from-surface-container-lowest to-surface-container-low border border-outline-variant/30">
                    <div class="flex flex-col lg:flex-row items-center gap-space-md">
                        <!-- Category Dropdown -->
                        <div class="w-full lg:w-1/3 flex flex-col gap-1 px-space-sm">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-primary">category</span>
                                <span>Wedding Discipline</span>
                            </label>
                            <div class="relative w-full">
                                <select class="w-full bg-surface py-2.5 px-space-md rounded-lg font-title-sm text-title-sm text-on-surface appearance-none focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm border border-outline-variant/30" id="filter-discipline">
                                    <option value="all">All Elite Categories</option>
                                    <option value="venues" selected>Venues &amp; Heritage Grand Ballrooms</option>
                                    <option value="bridal">Bridal Dressing &amp; Kandyan Osariya Draping</option>
                                    <option value="photo">Cinematography &amp; Fine Art Photography</option>
                                    <option value="poruwa">Floral Sculptures &amp; Poruwa Concepts</option>
                                    <option value="drummers">Traditional Drummers, Ashtaka &amp; Mangalam</option>
                                    <option value="music">Live Bands &amp; Acoustic Lounge Quintets</option>
                                    @if(isset($categories))
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="material-symbols-outlined text-[18px] text-on-surface-variant absolute right-3 top-3 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Sri Lankan District Selector -->
                        <div class="w-full lg:w-1/4 flex flex-col gap-1 px-space-sm">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-primary">pin_drop</span>
                                <span>Sri Lankan District</span>
                            </label>
                            <div class="relative w-full">
                                <select class="w-full bg-surface py-2.5 px-space-md rounded-lg font-title-sm text-title-sm text-on-surface appearance-none focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm border border-outline-variant/30" id="filter-district">
                                    <option value="all">All 25 Districts (Islandwide)</option>
                                    <option value="colombo" selected>Colombo (Western Province)</option>
                                    <option value="kandy">Kandy (Central Hill Country)</option>
                                    <option value="galle">Galle &amp; Coastal South</option>
                                    <option value="gampaha">Gampaha</option>
                                    <option value="kurunegala">Kurunegala</option>
                                    <option value="kalutara">Kalutara &amp; Bentota</option>
                                    <option value="nuwara-eliya">Nuwara Eliya (Tea Estates)</option>
                                    <option value="matara">Matara</option>
                                    <option value="jaffna">Jaffna</option>
                                    <option value="batticaloa">Batticaloa</option>
                                    <option value="trincomalee">Trincomalee</option>
                                    <option value="anuradhapura">Anuradhapura</option>
                                    <option value="hambantota">Hambantota</option>
                                </select>
                                <span class="material-symbols-outlined text-[18px] text-on-surface-variant absolute right-3 top-3 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Nuptial Style & Budget Tier -->
                        <div class="w-full lg:w-1/3 flex flex-col gap-1 px-space-sm">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-primary">payments</span>
                                <span>Style &amp; Investment Tier</span>
                            </label>
                            <div class="relative w-full">
                                <select class="w-full bg-surface py-2.5 px-space-md rounded-lg font-title-sm text-title-sm text-on-surface appearance-none focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm border border-outline-variant/30" id="filter-tier">
                                    <option value="all">All Ceremonial Aesthetics</option>
                                    <option value="heritage">Heritage Traditional Poruwa Rituals</option>
                                    <option value="royal">Royal Kandyan Dynasty Nuptials</option>
                                    <option value="coastal">Coastal Romance (Galle Fort / Bentota)</option>
                                    <option value="ballroom">Intimate Luxury Ballroom</option>
                                    <option value="tier-mid">Premium (LKR 2,500,000 – 5,000,000)</option>
                                    <option value="tier-high">Ultra-Luxury (LKR 10,000,000+)</option>
                                </select>
                                <span class="material-symbols-outlined text-[18px] text-on-surface-variant absolute right-3 top-3 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Search CTA Button -->
                        <div class="w-full lg:w-auto pt-3 lg:pt-5">
                            <button class="w-full lg:w-auto flex items-center justify-center gap-space-xs px-space-xl py-3 rounded-lg bg-on-background text-surface hover:bg-inverse-surface transition-all shadow-md font-title-sm text-title-sm cursor-pointer" id="search-vendors-btn" type="button">
                                <span class="material-symbols-outlined text-[18px] text-primary-fixed">search</span>
                                <span>Find Vendors</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Curated High-End Vendor Cards Showcase -->
            <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin pt-space-2xl pb-space-2xl" id="vendor-showcase-section">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-space-xl gap-space-md">
                    <div>
                        <div class="flex items-center gap-space-xs text-primary mb-1">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span class="font-label-caps text-label-caps uppercase tracking-widest">Hand-Vetted Excellence</span>
                        </div>
                        <h2 class="font-headline-lg text-headline-lg text-on-background">Featured Island Vendors &amp; Ateliers</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Directly book Sri Lanka's most celebrated wedding artisans with audited credibility.</p>
                    </div>

                    <!-- Quick category filter pills -->
                    <div class="flex flex-wrap items-center gap-space-xs" id="quick-category-pills">
                        <button class="category-pill active px-space-md py-1.5 rounded-full bg-on-background text-surface font-title-sm text-title-sm shadow-sm transition-all" data-category="all">All Ateliers</button>
                        <button class="category-pill px-space-md py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-title-sm text-title-sm" data-category="venues">Venues</button>
                        <button class="category-pill px-space-md py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-title-sm text-title-sm" data-category="photo">Photography</button>
                        <button class="category-pill px-space-md py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-title-sm text-title-sm" data-category="poruwa">Poruwa Styling</button>
                        <button class="category-pill px-space-md py-1.5 rounded-full bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-title-sm text-title-sm" data-category="bridal">Bridal</button>
                    </div>
                </div>

                <!-- Vendor Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-xl" id="vendor-cards-grid">
                    @forelse($featuredVendors as $vendor)
                        @php
                            $catSlug = match(strtolower($vendor->category?->slug ?? '')) {
                                'venues' => 'venues',
                                'photography' => 'photo',
                                'poruwa' => 'poruwa',
                                'attire' => 'bridal',
                                default => strtolower($vendor->category?->slug ?? 'venues'),
                            };
                            $coverUrl = $vendor->coverMedia?->file_url ?? ($vendor->media->first()?->file_url ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80');
                        @endphp
                        <article class="vendor-card group bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between border border-outline-variant/20" data-category="{{ $catSlug }}" data-district="{{ strtolower($vendor->district ?? 'colombo') }}">
                            <div>
                                <a href="{{ route('vendors.show', $vendor->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-surface-container">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $vendor->business_name }}" src="{{ $coverUrl }}">
                                    <div class="absolute top-3 left-3 flex gap-1">
                                        @if($vendor->is_featured)
                                            <span class="px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-caps text-label-caps font-bold uppercase tracking-wider shadow-sm">Featured Atelier</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant font-label-caps text-label-caps font-bold uppercase tracking-wider shadow-sm">Verified Atelier</span>
                                        @endif
                                    </div>
                                    <div class="absolute top-3 right-3 px-2 py-0.5 rounded bg-surface-container-lowest/90 backdrop-blur font-title-sm text-title-sm text-on-surface flex items-center gap-1 shadow-sm">
                                        <span class="material-symbols-outlined text-[16px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                                        <span>{{ number_format($vendor->rating_avg, 1) }}</span>
                                        <span class="text-on-surface-variant font-body-sm text-body-sm">({{ $vendor->reviews_count }})</span>
                                    </div>
                                </a>
                                <div class="p-space-lg flex flex-col">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-label-caps text-label-caps text-primary uppercase tracking-wider">{{ $vendor->category?->name ?? 'Wedding Atelier' }}</span>
                                        <div class="flex items-center gap-1 text-on-surface-variant font-body-sm text-body-sm">
                                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                                            <span>{{ $vendor->district ?: 'Colombo' }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('vendors.show', $vendor->slug) }}" class="group-hover:text-primary transition-colors">
                                        <h3 class="font-headline-sm text-headline-sm text-on-background group-hover:text-primary transition-colors">{{ $vendor->business_name }}</h3>
                                    </a>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">{{ $vendor->description }}</p>
                                    <div class="flex flex-wrap gap-1.5 mt-space-md">
                                        @forelse($vendor->packages->take(3) as $pkg)
                                            <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-md text-label-md">{{ $pkg->name }}</span>
                                        @empty
                                            <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-md text-label-md">Bespoke Inquiries</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="px-space-lg pb-space-lg pt-space-sm flex items-center justify-between bg-surface-container-low/40 border-t border-outline-variant/10">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Starting from</span>
                                    <span class="font-title-lg text-title-lg text-on-background font-bold tracking-tight">LKR {{ number_format($vendor->starting_price) }}</span>
                                </div>
                                <button class="quote-btn px-space-md py-2 rounded-lg bg-surface text-on-surface hover:bg-on-background hover:text-surface transition-all font-title-sm text-title-sm shadow-sm flex items-center gap-1 cursor-pointer" data-vendor="{{ $vendor->business_name }}" type="button">
                                    <span>Quick Quote</span>
                                    <span class="material-symbols-outlined text-[16px]">send</span>
                                </button>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full p-12 text-center bg-surface-container-lowest rounded-xl border border-outline-variant/20">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 mb-2">storefront</span>
                            <h3 class="font-headline-sm text-on-surface">No Featured Ateliers Currently Listed</h3>
                            <p class="font-body-sm text-on-surface-variant mt-1">Our curated vendor directory will update shortly as verified artisans finalize onboarding.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Browse all CTA button -->
                <div class="flex justify-center mt-space-2xl">
                    <a class="inline-flex items-center gap-space-xs px-space-xl py-3.5 rounded-lg bg-surface-container-high text-on-surface hover:bg-on-background hover:text-surface transition-all font-title-sm text-title-sm shadow-sm" href="#marketplace-anchor">
                        <span>Browse All 1,250+ Island Wedding Vendors</span>
                        <span class="material-symbols-outlined text-[18px]">keyboard_double_arrow_right</span>
                    </a>
                </div>
            </section>

            <!-- Interactive SaaS Planning Suite Preview -->
            <section class="w-full bg-surface-container-low py-space-2xl" id="workspace-preview">
                <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin">
                    <div class="text-center max-w-2xl mx-auto mb-space-2xl">
                        <span class="font-label-caps text-label-caps text-tertiary uppercase tracking-widest px-3 py-1 rounded-full bg-tertiary-fixed/50 inline-block mb-space-xs">Proprietary Nuptial Software</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-background">Engineered for Ceylon Nuptial Complexity</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">Harmonize centuries of astrological Poruwa traditions with the precision of contemporary wedding management.</p>
                    </div>

                    <!-- 3 Feature Highlights Bento Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-xl">
                        <!-- Feature Card A: Auspicious Nekath Synchronizer -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-xl shadow-md hover:shadow-xl transition-all flex flex-col justify-between relative overflow-hidden group border border-outline-variant/20" id="nekath-preview">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-fixed/20 rounded-bl-full -mr-8 -mt-8 pointer-events-none transition-transform group-hover:scale-125"></div>
                            <div>
                                <div class="w-12 h-12 rounded-xl bg-primary-fixed/40 text-primary flex items-center justify-center mb-space-lg">
                                    <span class="material-symbols-outlined text-[28px]">schedule</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-primary uppercase">Astrological Alignment</span>
                                <h3 class="font-headline-md text-headline-md text-on-background mt-1 mb-space-sm">Auspicious Nekath Synchronizer</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant">Automatically plot astrologer-approved times for Poruwa entry, finger-tying (Nuul Bendeema), and oil lamp lighting down to the exact second.</p>
                            </div>

                            <!-- Mini Timeline Visual Preview -->
                            <div class="mt-space-xl pt-space-md bg-surface-container-low/70 rounded-lg p-space-md border border-outline-variant/20">
                                <div class="flex items-center justify-between text-on-surface-variant font-label-caps text-label-caps mb-2">
                                    <span>PORUWA PHASE</span>
                                    <span>NEKATH TIME</span>
                                </div>
                                <div class="space-y-2 font-body-sm text-body-sm">
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest shadow-xs">
                                        <span class="text-on-surface font-medium">1. Poruwa Step-Up</span>
                                        <span class="font-title-sm text-title-sm text-tertiary">09:24:10 AM</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest shadow-xs">
                                        <span class="text-on-surface font-medium">2. Nuul Bandheema</span>
                                        <span class="font-title-sm text-title-sm text-tertiary">09:31:00 AM</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest shadow-xs">
                                        <span class="text-on-surface font-medium">3. Lighting Polthela</span>
                                        <span class="font-title-sm text-title-sm text-tertiary">09:42:15 AM</span>
                                    </div>
                                </div>
                                @auth
                                    <a class="mt-3 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('workspace.dashboard') }}">
                                        <span>View Interactive Chronology</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @else
                                    <a class="mt-3 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('register') }}">
                                        <span>View Interactive Chronology</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Feature Card B: Smart LKR Budget & Milestones -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-xl shadow-md hover:shadow-xl transition-all flex flex-col justify-between relative overflow-hidden group border border-outline-variant/20" id="budget-preview">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-tertiary-fixed/20 rounded-bl-full -mr-8 -mt-8 pointer-events-none transition-transform group-hover:scale-125"></div>
                            <div>
                                <div class="w-12 h-12 rounded-xl bg-tertiary-fixed/50 text-tertiary flex items-center justify-center mb-space-lg">
                                    <span class="material-symbols-outlined text-[28px]">account_balance_wallet</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-tertiary uppercase">Treasury Control</span>
                                <h3 class="font-headline-md text-headline-md text-on-background mt-1 mb-space-sm">Smart LKR Budget &amp; Milestones</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant">Track advances, vendor bank transfers, and cash disbursements in Sri Lankan Rupees with real-time category allocations.</p>
                            </div>

                            <!-- Mini Budget Breakdown Visualization -->
                            <div class="mt-space-xl pt-space-md bg-surface-container-low/70 rounded-lg p-space-md border border-outline-variant/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Target Budget</span>
                                    <span class="font-title-sm text-title-sm text-on-surface font-bold">LKR 4,500,000</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="w-full h-2.5 rounded-full bg-surface-container overflow-hidden flex mb-2">
                                    <div class="h-full bg-primary" style="width: 45%;"></div>
                                    <div class="h-full bg-tertiary" style="width: 30%;"></div>
                                    <div class="h-full bg-secondary" style="width: 15%;"></div>
                                </div>
                                <div class="grid grid-cols-3 text-center gap-1 text-[11px] text-on-surface-variant">
                                    <div><span class="font-bold text-on-surface">45%</span> Venue</div>
                                    <div><span class="font-bold text-on-surface">30%</span> Decor</div>
                                    <div><span class="font-bold text-on-surface">15%</span> Photo</div>
                                </div>
                                @auth
                                    <a class="mt-3 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('workspace.dashboard') }}">
                                        <span>Open Budget Ledger</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @else
                                    <a class="mt-3 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('register') }}">
                                        <span>Open Budget Ledger</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Feature Card C: Digital RSVP & Poruwa Seating -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-xl shadow-md hover:shadow-xl transition-all flex flex-col justify-between relative overflow-hidden group border border-outline-variant/20" id="rsvp-preview">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-secondary-fixed/30 rounded-bl-full -mr-8 -mt-8 pointer-events-none transition-transform group-hover:scale-125"></div>
                            <div>
                                <div class="w-12 h-12 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center mb-space-lg">
                                    <span class="material-symbols-outlined text-[28px]">groups</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-secondary uppercase">Guest Hospitality</span>
                                <h3 class="font-headline-md text-headline-md text-on-background mt-1 mb-space-sm">Digital RSVP &amp; Poruwa Seating</h3>
                                <p class="font-body-md text-body-md text-on-surface-variant">WhatsApp invitations with one-tap confirmation, dietary curation (Traditional Ceylon Buffet, Halal, Jain, Vegan), and ceremonial seating tables.</p>
                            </div>

                            <!-- RSVP Stats Preview -->
                            <div class="mt-space-xl pt-space-md bg-surface-container-low/70 rounded-lg p-space-md border border-outline-variant/20">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">RSVP Response Rate</span>
                                    <span class="font-title-sm text-title-sm text-on-surface font-bold">284 / 350 Guests</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded bg-surface-container-lowest shadow-xs text-on-surface font-body-sm text-body-sm mb-2 border border-outline-variant/10">
                                    <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                    <span class="flex-1 truncate">VIP Family Poruwa Circle</span>
                                    <span class="font-label-caps text-label-caps bg-tertiary-fixed/50 text-tertiary px-1.5 py-0.5 rounded">All Confirmed</span>
                                </div>
                                @auth
                                    <a class="mt-2 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('workspace.dashboard') }}">
                                        <span>Manage Seating Charts</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @else
                                    <a class="mt-2 inline-flex items-center gap-1 font-title-sm text-title-sm text-primary hover:underline" href="{{ route('register') }}">
                                        <span>Manage Seating Charts</span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Editorial Couple Testimonial Highlight -->
            @if(isset($featuredReview) && $featuredReview)
                <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin py-space-2xl">
                    <div class="relative bg-surface-container-lowest rounded-2xl p-space-xl md:p-space-2xl shadow-xl overflow-hidden border border-outline-variant/20">
                        <!-- Decorative Backdrop Graphic -->
                        <div class="absolute -right-16 -bottom-16 w-80 h-80 rounded-full bg-primary-fixed/20 blur-2xl pointer-events-none"></div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                            <div class="lg:col-span-4">
                                <div class="relative aspect-square rounded-xl overflow-hidden shadow-md">
                                    <img class="w-full h-full object-cover" alt="Verified Wedora Nuptials" src="{{ $featuredReview->vendor?->coverMedia?->file_url ?? ($featuredReview->vendor?->media->first()?->file_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuDy10efhekyW--9SNEgRnTPhsdZiEhAS0o4yY2fVEZKv0lZ30ySwa3sFcDLs5I4wJKrUNbK0-ZmUlUiJUzzhrwqLWYYcl1gly_2PVpC4UUBAXiPY3hvLA8m-PuzIWuiWxAmz0R2VmzRjZNSo5hwzwwmXaeyVwQJ0TXWBlzibeYLf0iX86t9ntjA8Jc5VOEBNzuWqUEKKrea8j5SJRqg-mwm5OQdFCTWJWAPiQVArOtS') }}">
                                    <div class="absolute bottom-3 left-3 bg-surface-container-lowest/90 backdrop-blur px-space-sm py-1 rounded-full text-on-surface font-label-caps text-label-caps uppercase tracking-wider flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                        <span>{{ $featuredReview->vendor?->business_name ?? 'Wedora Nuptials' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-8 flex flex-col items-start">
                                <div class="flex items-center gap-1 text-primary mb-space-md">
                                    @for($i = 1; $i <= ($featuredReview->rating ?? 5); $i++)
                                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                    @endfor
                                </div>
                                <blockquote class="font-headline-md text-headline-md text-on-background italic leading-snug tracking-tight">
                                    “{{ $featuredReview->comment }}”
                                </blockquote>
                                <div class="mt-space-lg flex flex-wrap items-center gap-space-md">
                                    <div>
                                        <p class="font-title-lg text-title-lg text-on-background">{{ $featuredReview->user?->name ?? 'Verified Wedora Couple' }}</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $featuredReview->wedding?->title ?? 'Poruwa Ceremony & Reception' }} • {{ $featuredReview->created_at->format('F Y') }}</p>
                                    </div>
                                    <div class="h-8 w-px bg-surface-container-high mx-2 hidden sm:block"></div>
                                    <div class="flex items-center gap-1 text-tertiary font-label-caps text-label-caps uppercase">
                                        <span class="material-symbols-outlined text-[16px]">verified</span>
                                        <span>Verified Wedora Client Review</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            @if(isset($plans) && $plans->count())
                <!-- Optional Verified Vendor Memberships / Subscription Atelier -->
                <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin py-space-xl" id="pricing-preview">
                    <div class="text-center max-w-2xl mx-auto mb-space-xl">
                        <span class="font-label-caps text-label-caps text-primary uppercase tracking-widest px-3 py-1 rounded-full bg-primary-fixed/40 inline-block mb-space-xs">Vendor Membership</span>
                        <h2 class="font-headline-lg text-headline-lg text-on-background">Empowering Sri Lanka's Elite Artisans</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Showcase your portfolio, receive itemized quote inquiries, and manage wedding contracts seamlessly.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-lg">
                        @foreach($plans as $plan)
                            <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm hover:shadow-xl transition-all border {{ $plan->is_featured_badge ? 'border-primary ring-1 ring-primary/30' : 'border-outline-variant/30' }} flex flex-col justify-between">
                                <div>
                                    @if($plan->is_featured_badge)
                                        <span class="font-label-caps text-label-caps px-2 py-0.5 rounded-full bg-primary text-on-primary uppercase font-bold tracking-wider inline-block mb-2">Featured Partner</span>
                                    @endif
                                    <h3 class="font-headline-sm text-headline-sm text-on-background">{{ $plan->name }}</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $plan->tagline ?? 'Tailored for growing wedding specialists.' }}</p>
                                    
                                    <div class="mt-space-md pb-space-sm border-b border-outline-variant/20">
                                        <span class="font-headline-lg text-headline-lg text-primary font-bold">LKR {{ number_format($plan->price_lkr) }}</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">/ month</span>
                                    </div>

                                    <ul class="mt-space-md space-y-2 font-body-sm text-body-sm text-on-surface-variant">
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[16px] text-tertiary">check_circle</span>
                                            <span>Up to {{ $plan->max_packages }} Packages</span>
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[16px] text-tertiary">check_circle</span>
                                            <span>Up to {{ $plan->max_portfolio_images }} Portfolio Photos</span>
                                        </li>
                                        @if(!empty($plan->features))
                                            @foreach(array_slice($plan->features, 0, 3) as $feat)
                                                <li class="flex items-start gap-2">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary shrink-0">check_circle</span>
                                                    <span>{{ $feat }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <div class="mt-space-lg">
                                    <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center py-2.5 rounded-lg font-title-sm text-title-sm transition-all {{ $plan->is_featured_badge ? 'bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container' : 'bg-surface-container text-on-surface hover:bg-on-background hover:text-surface' }}">
                                        Join as {{ $plan->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Final Call to Action Sanctuary Banner -->
            <section class="w-full max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin pb-space-2xl">
                <div class="bg-gradient-to-r from-on-background via-inverse-surface to-on-background text-surface rounded-2xl p-space-xl md:p-space-2xl shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-space-xl">
                    <div class="max-w-xl">
                        <span class="font-label-caps text-label-caps text-primary-fixed uppercase tracking-widest">Begin Your Nuptial Journey</span>
                        <h2 class="font-headline-lg text-headline-lg text-surface mt-2">Ready to plan with islandwide serenity?</h2>
                        <p class="font-body-md text-body-md text-surface-container mt-2">Join over 4,800 couples who turned ancestral tradition into effortless modern celebration.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-space-md">
                        @auth
                            <a class="px-space-xl py-3.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container font-title-sm text-title-sm transition-all shadow-md" href="{{ $portalRoute }}">
                                {{ $portalLabel }}
                            </a>
                        @else
                            <a class="px-space-xl py-3.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container font-title-sm text-title-sm transition-all shadow-md" href="{{ route('register') }}">
                                Start Your Free Workspace
                            </a>
                        @endauth
                        <a class="px-space-xl py-3.5 rounded-lg bg-surface-container-highest/20 text-surface hover:bg-surface-container-highest/40 font-title-sm text-title-sm transition-all" href="#marketplace-anchor">
                            Explore Vendors
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Quick Quote Modal Popup -->
    <div id="quote-modal" class="fixed inset-0 z-50 hidden bg-on-background/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-outline-variant/30 relative">
            <button id="close-quote-modal" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface p-1 rounded-lg">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
            <div class="flex items-center gap-2 text-primary mb-2">
                <span class="material-symbols-outlined text-[20px]">spa</span>
                <span class="font-label-caps text-label-caps uppercase">Wedora Bespoke Concierge</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-background" id="modal-vendor-title">Request Vendor Quotation</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 mb-4">Receive an audited availability check &amp; ceremonial quotation directly in LKR.</p>

            <form id="quote-form" onsubmit="handleQuoteSubmit(event)" class="space-y-3 font-body-sm">
                <div>
                    <label class="font-title-sm text-title-sm text-on-surface block mb-1">Couple Name / Contact Person</label>
                    <input type="text" required placeholder="e.g. Kasun & Dilini" class="w-full bg-surface border border-outline-variant/40 rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-title-sm text-title-sm text-on-surface block mb-1">Wedding Date</label>
                        <input type="date" required class="w-full bg-surface border border-outline-variant/40 rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary">
                    </div>
                    <div>
                        <label class="font-title-sm text-title-sm text-on-surface block mb-1">Estimated Guests</label>
                        <input type="number" placeholder="e.g. 250" class="w-full bg-surface border border-outline-variant/40 rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary">
                    </div>
                </div>
                <div>
                    <label class="font-title-sm text-title-sm text-on-surface block mb-1">WhatsApp / Contact Number</label>
                    <input type="tel" required placeholder="+94 77 123 4567" class="w-full bg-surface border border-outline-variant/40 rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary">
                </div>
                <div>
                    <label class="font-title-sm text-title-sm text-on-surface block mb-1">Specific Ceremony Notes</label>
                    <textarea rows="2" placeholder="Poruwa rituals, Nekath synchronization, dietary requirements..." class="w-full bg-surface border border-outline-variant/40 rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary"></textarea>
                </div>
                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="cancel-quote-btn" class="px-4 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container font-title-sm text-title-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container font-title-sm text-title-sm transition-all shadow-md flex items-center gap-1">
                        <span>Send Request</span>
                        <span class="material-symbols-outlined text-[16px]">send</span>
                    </button>
                </div>
            </form>
            <div id="quote-success" class="hidden text-center py-6">
                <span class="material-symbols-outlined text-4xl text-tertiary mb-2">check_circle</span>
                <h4 class="font-headline-sm text-headline-sm text-on-background">Quotation Request Dispatched!</h4>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">The vendor and Wedora Concierge have received your inquiry. We will contact you via WhatsApp shortly.</p>
                <button type="button" onclick="closeQuoteModal()" class="mt-4 px-4 py-2 rounded-lg bg-surface-container-high text-on-surface font-title-sm text-title-sm">Close</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-surface-container-low mt-space-2xl border-t border-outline-variant/20">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin py-space-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-xl mb-space-2xl">
                <!-- Col 1 & 2: Brand Info -->
                <div class="lg:col-span-2 flex flex-col gap-space-md">
                    <div class="flex items-center gap-space-sm">
                        <span class="font-headline-md text-headline-md text-primary font-bold">Wedora</span>
                        <span class="font-label-caps text-label-caps text-tertiary px-2 py-0.5 rounded-full bg-tertiary-fixed/40">Island Atelier</span>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                        Honoring Sri Lankan matrimonial heritage through refined editorial technology. Orchestrating Poruwa ceremonies, Nekath timings, and elite vendors across Colombo, Kandy, Galle, and beyond.
                    </p>
                    <div class="flex items-center gap-space-xs text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[18px] text-primary">spa</span>
                        <span>Curated for high-profile nuptials &amp; destination weddings</span>
                    </div>
                </div>

                <!-- Col 3: Workspace -->
                <div class="flex flex-col gap-space-md">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Nuptial Workspace</span>
                    <ul class="flex flex-col gap-space-sm font-body-md text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="#nekath-preview">Nekath Ritual Chronology</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#budget-preview">LKR Budget &amp; Cash Flow</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#rsvp-preview">Guest Seating &amp; Dietary RSVP</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('register') }}">Vendor Quotations &amp; Contracts</a></li>
                    </ul>
                </div>

                <!-- Col 4: Vendor Directory -->
                <div class="flex flex-col gap-space-md">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Vendor Atelier</span>
                    <ul class="flex flex-col gap-space-sm font-body-md text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="#marketplace-anchor">Ballrooms &amp; Estate Venues</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#marketplace-anchor">Traditional Poruwa Designers</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#marketplace-anchor">Kandyan Bridal &amp; Groom Attire</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#marketplace-anchor">Island Photographers</a></li>
                    </ul>
                </div>

                <!-- Col 5: Private Concierge -->
                <div class="flex flex-col gap-space-md">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Private Concierge</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Bespoke assistance for island estate bookings and heritage rituals.</p>
                    <div class="flex flex-col gap-space-xs font-title-sm text-title-sm text-primary">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">call</span>
                            <span>+94 (11) 782 9900</span>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                            <span>concierge@wedora.lk</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-space-lg flex flex-col md:flex-row items-center justify-between gap-space-md border-t border-outline-variant/20">
                <div class="flex items-center gap-space-sm">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">© {{ date('Y') }} Wedora Technologies Pvt Ltd. All rights reserved.</span>
                </div>
                <div class="flex items-center gap-space-lg font-label-caps text-label-caps text-on-surface-variant">
                    <a class="hover:text-on-surface transition-colors" href="#">Privacy Policy</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Terms of Service</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Sri Lanka Cultural Guidelines</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Search, Filter, Modal & Mobile Scripts -->
    <script>
        (function() {
            // Search Button Click Handler & Micro-interaction
            const searchBtn = document.getElementById('search-vendors-btn');
            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    const discipline = document.getElementById('filter-discipline')?.value || 'all';
                    const district = document.getElementById('filter-district')?.value || 'all';
                    const tier = document.getElementById('filter-tier')?.value || 'all';
                    
                    searchBtn.classList.add('opacity-75', 'scale-95');
                    setTimeout(() => {
                        searchBtn.classList.remove('opacity-75', 'scale-95');
                        filterVendors(discipline, district);
                        const showcase = document.getElementById('vendor-showcase-section');
                        if (showcase) {
                            showcase.scrollIntoView({ behavior: 'smooth' });
                        }
                    }, 200);
                });
            }

            // Quick Category Pills Filter
            const categoryPills = document.querySelectorAll('#quick-category-pills .category-pill');
            categoryPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    categoryPills.forEach(p => {
                        p.classList.remove('bg-on-background', 'text-surface', 'shadow-sm', 'active');
                        p.classList.add('bg-surface-container', 'text-on-surface');
                    });
                    this.classList.add('bg-on-background', 'text-surface', 'shadow-sm', 'active');
                    this.classList.remove('bg-surface-container', 'text-on-surface');

                    const category = this.getAttribute('data-category');
                    filterVendors(category, 'all');
                });
            });

            function filterVendors(category, district) {
                const cards = document.querySelectorAll('.vendor-card');
                cards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    const cardDist = card.getAttribute('data-district');

                    let matchCat = (category === 'all' || cardCat === category);
                    let matchDist = (district === 'all' || cardDist === district);

                    if (matchCat && matchDist) {
                        card.style.display = 'flex';
                    } else if (category === 'all') {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Mobile Menu Drawer Toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileDrawer = document.getElementById('mobile-drawer');
            if (mobileBtn && mobileDrawer) {
                mobileBtn.addEventListener('click', function() {
                    mobileDrawer.classList.toggle('hidden');
                });
            }

            // Quick Quote Modal Triggering
            const quoteButtons = document.querySelectorAll('.quote-btn');
            const quoteModal = document.getElementById('quote-modal');
            const modalTitle = document.getElementById('modal-vendor-title');
            const closeModalBtn = document.getElementById('close-quote-modal');
            const cancelModalBtn = document.getElementById('cancel-quote-btn');

            quoteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const vendorName = this.getAttribute('data-vendor') || 'Vendor Atelier';
                    if (modalTitle) modalTitle.textContent = 'Quote Request: ' + vendorName;
                    if (quoteModal) {
                        quoteModal.classList.remove('hidden');
                        document.getElementById('quote-form')?.classList.remove('hidden');
                        document.getElementById('quote-success')?.classList.add('hidden');
                    }
                });
            });

            window.closeQuoteModal = function() {
                if (quoteModal) quoteModal.classList.add('hidden');
            };

            if (closeModalBtn) closeModalBtn.addEventListener('click', closeQuoteModal);
            if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeQuoteModal);

            window.handleQuoteSubmit = function(e) {
                e.preventDefault();
                document.getElementById('quote-form')?.classList.add('hidden');
                document.getElementById('quote-success')?.classList.remove('hidden');
            };
        })();
    </script>
</body>
</html>