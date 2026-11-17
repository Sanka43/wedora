<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wedora — Sri Lankan Wedding Planning Platform & Verified Vendor Directory</title>

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf8f5] text-[#241f1a] antialiased selection:bg-[#d8b467] selection:text-[#1a140a] min-h-screen flex flex-col justify-between">

    <!-- Top Sri Lankan Celebration Announcement Bar -->
    <div class="bg-gradient-to-r from-[#8c6d23] via-[#b8860b] to-[#8c6d23] text-white py-2 text-center text-xs tracking-wide font-medium px-4 shadow-sm">
        <span class="inline-flex items-center gap-2">
            <span>✨</span>
            <span class="font-semibold">Sri Lanka's Premier Wedding Planning Operating System & Verified Artisan Network</span>
            <span class="hidden sm:inline text-amber-100">|</span>
            <span class="hidden sm:inline">Seamlessly Plan Across All 25 Districts</span>
        </span>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-[#faf8f5]/90 border-b border-[#ebd9c2] transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3.5 group">
                <div class="w-11 h-11 rounded-2xl gold-gradient-bg flex items-center justify-center text-[#1a140a] shadow-md shadow-[#c5a059]/25 group-hover:scale-105 transition-transform border border-amber-300">
                    <!-- Traditional Brass Lamp / Auspicious Flame Icon -->
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2C11.5 3.5 10 5.5 10 7.5c0 1.38.9 2.5 2 2.5s2-1.12 2-2.5C14 5.5 12.5 3.5 12 2z" />
                        <path d="M12 11c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6zm-4 5c.55-1.74 2.14-3 4-3s3.45 1.26 4 3H8z" />
                        <path d="M7 19h10v2H7z" />
                    </svg>
                </div>
                <div>
                    <span class="font-serif-luxury text-2xl font-bold tracking-tight text-[#241f1a] flex items-center gap-1">
                        Wedora<span class="text-[#b8860b]">.</span>
                    </span>
                    <span class="block text-[10px] tracking-widest uppercase text-[#8c6d23] font-bold -mt-1">Sri Lanka</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-[#5c5245]">
                <a href="#features" class="hover:text-[#b8860b] transition-colors flex items-center gap-1.5">
                    <span>🪷</span> Celebration Pillars
                </a>
                <a href="#marketplace" class="hover:text-[#b8860b] transition-colors">Vendor Directory</a>
                <a href="#workspace" class="hover:text-[#b8860b] transition-colors">Planning Tools</a>
                <a href="#checklists" class="hover:text-[#b8860b] transition-colors">Ceremonial Timelines</a>
                <a href="#pricing" class="hover:text-[#b8860b] transition-colors">Vendor Memberships</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('workspace.dashboard') }}" class="gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-md hover:brightness-105 active:scale-95 transition-all border border-amber-300">
                        ✨ Open Workspace
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs uppercase tracking-wider font-bold text-[#5c5245] hover:text-[#1a140a] px-4 py-2 rounded-xl hover:bg-[#ebd9c2]/40 transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-md hover:brightness-105 active:scale-95 transition-all border border-amber-300">
                        Start Planning Free
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-[#faf8f5] via-[#f7f2ea] to-[#faf8f5]">
        <!-- Soft Warm Ambient Orbs -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[750px] h-[450px] bg-amber-200/40 blur-[130px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/4 -right-20 w-80 h-80 bg-rose-200/30 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/3 -left-20 w-80 h-80 bg-emerald-100/30 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Universal Unity Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-amber-300/80 bg-amber-50/90 text-[#8c6d23] text-xs font-bold mb-7 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#c5a059] animate-pulse"></span>
                <span>One Unified Platform — Crafted for Every Sri Lankan Wedding Celebration</span>
            </div>

            <!-- Headline -->
            <h1 class="font-serif-luxury text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-[#241f1a] leading-[1.12] mb-6 max-w-4xl mx-auto">
                Celebrate Your Sacred Love Across <span class="gold-gradient-text italic font-normal">Sri Lanka</span>
            </h1>

            <p class="text-base sm:text-lg text-[#665c50] max-w-2xl mx-auto font-normal leading-relaxed mb-10">
                From auspicious ceremonial hours and bespoke wedding couture to grand stage artistry, gourmet banquets, and seaside receptions in Bentota. Plan budgets in LKR with verified specialists across all 25 districts.
            </p>

            <!-- Search Filter Bar -->
            <div class="max-w-3xl mx-auto p-2 sm:p-3 rounded-2xl bg-white border border-[#ebd9c2] shadow-xl shadow-amber-900/5 flex flex-col sm:flex-row gap-2">
                <div class="flex-1 px-4 py-2.5 text-left border-b sm:border-b-0 sm:border-r border-[#ebd9c2]">
                    <label class="block text-[11px] font-bold tracking-wider uppercase text-[#8c6d23] mb-0.5">District / Region</label>
                    <select class="w-full bg-transparent text-sm text-[#241f1a] font-medium focus:outline-none cursor-pointer">
                        <option value="">All 25 Districts (Colombo, Kandy, Galle...)</option>
                        <option value="colombo">Colombo (Western Province)</option>
                        <option value="kandy">Kandy (Central Highlands)</option>
                        <option value="galle">Galle & Southern Coast</option>
                        <option value="gampaha">Gampaha / Negombo</option>
                        <option value="jaffna">Jaffna & Northern Province</option>
                        <option value="matara">Matara / Mirissa</option>
                        <option value="kalutara">Kalutara / Wadduwa</option>
                        <option value="kurunegala">Kurunegala</option>
                        <option value="nuwara-eliya">Nuwara Eliya</option>
                    </select>
                </div>

                <div class="flex-1 px-4 py-2.5 text-left">
                    <label class="block text-[11px] font-bold tracking-wider uppercase text-[#8c6d23] mb-0.5">Wedding Specialist</label>
                    <select class="w-full bg-transparent text-sm text-[#241f1a] font-medium focus:outline-none cursor-pointer">
                        <option value="">Select Category ({{ $categories->count() }} Available)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="gold-gradient-bg text-[#1a140a] font-bold px-7 py-3.5 rounded-xl flex items-center justify-center gap-2 hover:brightness-105 active:scale-95 transition-all text-sm shadow-md shadow-[#c5a059]/30 border border-amber-300">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Find Specialists
                </button>
            </div>

            <!-- Stats Bar -->
            <div class="mt-14 pt-10 border-t border-[#ebd9c2] grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-3">
                    <div class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">25</div>
                    <div class="text-xs text-[#736657] mt-1 font-semibold uppercase tracking-wider">Districts Supported</div>
                </div>
                <div class="p-3">
                    <div class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">100%</div>
                    <div class="text-xs text-[#736657] mt-1 font-semibold uppercase tracking-wider">LKR Budget Precision</div>
                </div>
                <div class="p-3">
                    <div class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">All Styles</div>
                    <div class="text-xs text-[#736657] mt-1 font-semibold uppercase tracking-wider">Customary & Modern Playbooks</div>
                </div>
                <div class="p-3">
                    <div class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">0%</div>
                    <div class="text-xs text-[#736657] mt-1 font-semibold uppercase tracking-wider">Quote Commission Fees</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Essential Pillars of Sri Lankan Weddings -->
    <section id="features" class="py-20 border-t border-[#ebd9c2] bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    <span>🪷</span> Celebrating Island Elegance
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    The Pillars of an Unforgettable Wedding
                </h2>
                <p class="text-[#665c50] text-sm sm:text-base mt-3 leading-relaxed">
                    Every Sri Lankan wedding is unique, sacred, and deeply cherished. Wedora brings structure, joy, and peace of mind to every celebration with specialized tools and verified island artisans.
                </p>
            </div>

            <!-- 4 Universal Celebration Pillar Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pillar 1: Sacred Ceremonies & Auspicious Hours -->
                <div class="rounded-2xl p-6 bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-lg flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl gold-gradient-subtle border border-amber-300 text-[#8c6d23] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-transform">
                            🪷
                        </div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-[#8c6d23] mb-1">
                            Ceremonial Rites & Traditions
                        </div>
                        <h3 class="font-serif-luxury text-xl font-bold text-[#241f1a] mb-2.5">
                            Sacred Ceremonies & Timings
                        </h3>
                        <p class="text-xs text-[#665c50] leading-relaxed mb-4">
                            Astrological hour synchronization, traditional ceremony masters, ceremonial blessing chants, drummers, and customary exchanges of family honours and tokens.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#ebd9c2] flex items-center justify-between text-xs font-semibold text-[#8c6d23]">
                        <span>Pre-seeded Timelines</span>
                        <span>→</span>
                    </div>
                </div>

                <!-- Pillar 2: Stage Architecture & Floral Grandeur -->
                <div class="rounded-2xl p-6 bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-lg flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-transform">
                            🪔
                        </div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-rose-700 mb-1">
                            Bespoke Visual Artistry
                        </div>
                        <h3 class="font-serif-luxury text-xl font-bold text-[#241f1a] mb-2.5">
                            Stage & Floral Architecture
                        </h3>
                        <p class="text-xs text-[#665c50] leading-relaxed mb-4">
                            Ornate ceremonial platforms, handcrafted mandaps, floral arches, illuminated stage backdrops, fresh jasmine garlands, and breathtaking venue transformations.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#ebd9c2] flex items-center justify-between text-xs font-semibold text-rose-700">
                        <span>Explore Decor Specialists</span>
                        <span>→</span>
                    </div>
                </div>

                <!-- Pillar 3: Artisanal Couture & Heirloom Styling -->
                <div class="rounded-2xl p-6 bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-lg flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-transform">
                            👑
                        </div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-amber-800 mb-1">
                            Master Tailoring & Jewelry
                        </div>
                        <h3 class="font-serif-luxury text-xl font-bold text-[#241f1a] mb-2.5">
                            Couture & Heirloom Styling
                        </h3>
                        <p class="text-xs text-[#665c50] leading-relaxed mb-4">
                            Traditional ceremonial dress, handloom silks, custom bridal gowns, fine heirloom jewelry coordination, and professional bridal artistry and styling.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#ebd9c2] flex items-center justify-between text-xs font-semibold text-amber-800">
                        <span>Explore Couture Specialists</span>
                        <span>→</span>
                    </div>
                </div>

                <!-- Pillar 4: Grand Banquets & Hospitality -->
                <div class="rounded-2xl p-6 bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-lg flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-transform">
                            🕊️
                        </div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 mb-1">
                            Feasts & Receptions
                        </div>
                        <h3 class="font-serif-luxury text-xl font-bold text-[#241f1a] mb-2.5">
                            Banquets & Hospitality
                        </h3>
                        <p class="text-xs text-[#665c50] leading-relaxed mb-4">
                            Curated gourmet dining, traditional delicacy feasts, custom dietary accommodations, live entertainment, and unforgettable ballroom celebrations.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-[#ebd9c2] flex items-center justify-between text-xs font-semibold text-emerald-800">
                        <span>Explore Venues & Caterers</span>
                        <span>→</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Verified Vendor Marketplace Categories -->
    <section id="marketplace" class="py-20 border-t border-[#ebd9c2] bg-[#faf8f5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    Verified Vendor Directory
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    Sri Lankan Wedding Artisans
                </h2>
                <p class="text-[#665c50] text-sm mt-3">
                    Discover verified professionals who understand the intricate traditions, ceremonial schedules, and luxury expectations of island celebrations.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <div class="group relative rounded-2xl p-5 bg-white border border-[#ebd9c2] hover:border-[#c5a059] hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl gold-gradient-subtle border border-amber-300 text-[#8c6d23] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-[#241f1a] group-hover:text-[#8c6d23] transition-colors leading-snug">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-[#665c50] mt-2 line-clamp-3 leading-relaxed">
                                {{ $category->description }}
                            </p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-[#ebd9c2] flex items-center justify-between text-xs text-[#8c6d23] font-semibold">
                            <span>Browse Directory</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Couple Workspace Features -->
    <section id="workspace" class="py-20 border-t border-[#ebd9c2] bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    Couple Workspace
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    Total Budget & Timeline Mastery
                </h2>
                <p class="text-[#665c50] text-sm mt-3">
                    Architected with multi-tenant isolation, ensuring your guest list, quotes, and financial records remain completely private to you and your partner.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: LKR Budget Guard -->
                <div class="p-8 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#241f1a] mb-2">LKR Budget & Expense Guard</h3>
                    <p class="text-sm text-[#665c50] leading-relaxed">
                        Automatic percentage category allocation (Catering 45%, Photography 15%, Ceremonial Stage 8%) with strict financial constraints preventing accidental deletion of booked expenditures.
                    </p>
                </div>

                <!-- Feature 2: Digital RSVP & Guest Lists -->
                <div class="p-8 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#241f1a] mb-2">Guest Lists & Digital RSVP</h3>
                    <p class="text-sm text-[#665c50] leading-relaxed">
                        Group guests by families, accommodate cultural dietary needs (Vegetarian, Halal, Custom), generate secure digital invite tokens, and assign tables without spreadsheets.
                    </p>
                </div>

                <!-- Feature 3: Quotation Conversions -->
                <div class="p-8 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] hover:border-[#c5a059] transition-all hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl gold-gradient-subtle border border-amber-300 text-[#8c6d23] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#241f1a] mb-2">Instant Quotation Conversions</h3>
                    <p class="text-sm text-[#665c50] leading-relaxed">
                        Request itemized quotes directly from verified vendors, compare total and advance payments in LKR, and convert accepted quotes into legal bookings in one click.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Checklists Section -->
    <section id="checklists" class="py-20 border-t border-[#ebd9c2] bg-[#faf8f5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    Auspicious Timelines & Milestones
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    Pre-Loaded Ceremonial Checklists
                </h2>
                <p class="text-[#665c50] text-sm mt-3">
                    From 365 days out to the exact minute of your ceremonial vows and reception.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($templates as $tmpl)
                    <div class="p-7 rounded-2xl bg-white border border-[#ebd9c2] hover:border-[#c5a059] hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-50 text-[#8c6d23] border border-amber-200 uppercase tracking-wider">
                                {{ $tmpl->wedding_type->value }}
                            </span>
                            <span class="text-xs font-semibold text-[#736657]">{{ $tmpl->items_count }} Key Milestones</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#241f1a] font-serif-luxury mb-2">{{ $tmpl->name }}</h3>
                        <p class="text-xs text-[#665c50] leading-relaxed mb-6">{{ $tmpl->description }}</p>

                        <div class="space-y-3 border-t border-[#ebd9c2] pt-4">
                            <div class="text-[11px] font-bold text-[#8c6d23] uppercase tracking-wider">Sample Timeline Highlights:</div>
                            <div class="flex items-center gap-2.5 text-xs text-[#423a31]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#c5a059]"></span>
                                <span>Day -365: Confirm Auspicious Dates & Ceremonial Venues</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-[#423a31]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#c5a059]"></span>
                                <span>Day -180: Select Ceremonial Masters & Stage Decorators</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-[#423a31]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#c5a059]"></span>
                                <span>Day -60: Hand-Deliver Invitations with Traditional Honours</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing / Membership Plans for Vendors -->
    <section id="pricing" class="py-20 border-t border-[#ebd9c2] bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    Vendor Marketplace Growth
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    Vendor & Planner Memberships
                </h2>
                <p class="text-[#665c50] text-sm mt-3">
                    Receive direct, high-intent inquiries from couples planning weddings across all 25 districts of Sri Lanka.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                    <div class="p-6 rounded-2xl bg-[#faf8f5] border {{ $plan->is_featured_badge ? 'border-[#c5a059] shadow-xl ring-2 ring-[#c5a059]/20' : 'border-[#ebd9c2]' }} flex flex-col justify-between transition-all hover:shadow-lg">
                        <div>
                            @if($plan->is_featured_badge)
                                <div class="inline-block text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full gold-gradient-bg text-[#1a140a] mb-3 border border-amber-300">
                                    Most Popular
                                </div>
                            @endif

                            <h3 class="text-base font-bold text-[#241f1a]">{{ $plan->name }}</h3>
                            <div class="mt-4 flex items-baseline gap-1">
                                <span class="text-xs text-[#8c6d23] font-bold">{{ $plan->currency }}</span>
                                <span class="text-3xl font-extrabold text-[#241f1a]">{{ number_format($plan->price) }}</span>
                                <span class="text-xs text-[#736657]">/{{ $plan->billing_interval->value }}</span>
                            </div>

                            <ul class="mt-6 space-y-2.5 text-xs text-[#52483d] border-t border-[#ebd9c2] pt-5">
                                <li class="flex items-center gap-2">
                                    <span class="text-[#8c6d23] font-bold">✓</span>
                                    <span>Up to {{ $plan->max_packages }} Packages</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-[#8c6d23] font-bold">✓</span>
                                    <span>Up to {{ $plan->max_portfolio_images }} Portfolio Photos</span>
                                </li>
                                @if(!empty($plan->features))
                                    @foreach($plan->features as $feat)
                                        <li class="flex items-start gap-2">
                                            <span class="text-[#8c6d23] font-bold shrink-0">✓</span>
                                            <span>{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="mt-8 pt-4">
                            <button class="w-full py-2.5 rounded-xl font-bold text-xs tracking-wider uppercase transition-all {{ $plan->is_featured_badge ? 'gold-gradient-bg text-[#1a140a] hover:brightness-105 border border-amber-300' : 'bg-white border border-[#ebd9c2] text-[#241f1a] hover:bg-[#ebd9c2]/30' }}">
                                Choose {{ $plan->name }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Couple Love Stories Showcase -->
    <section class="py-20 border-t border-[#ebd9c2] bg-[#faf8f5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold uppercase tracking-wider mb-2">
                    Loved by Sri Lankan Couples
                </div>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a]">
                    Stories Across The Island
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="p-6 rounded-2xl bg-white border border-[#ebd9c2] shadow-sm flex flex-col justify-between">
                    <p class="text-xs sm:text-sm text-[#52483d] italic leading-relaxed mb-4">
                        "The ceremonial countdown made sure our traditional masters, drummers, and families were ready at the exact auspicious second. Being able to track every vendor quotation in LKR gave us total peace of mind."
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-[#ebd9c2]">
                        <div class="w-10 h-10 rounded-full gold-gradient-bg text-[#1a140a] font-bold flex items-center justify-center text-xs">
                            K&A
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#241f1a]">Kasun & Amaya</div>
                            <div class="text-[11px] text-[#736657]">Hill Country Celebration • Kandy</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-6 rounded-2xl bg-white border border-[#ebd9c2] shadow-sm flex flex-col justify-between">
                    <p class="text-xs sm:text-sm text-[#52483d] italic leading-relaxed mb-4">
                        "We booked our grand stage decorators and traditional musicians directly through Wedora. Managing dietary preferences for 350+ guests across our families was effortless with the digital RSVP tool."
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-[#ebd9c2]">
                        <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-800 font-bold flex items-center justify-center text-xs">
                            S&P
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#241f1a]">Shan & Priyadharshini</div>
                            <div class="text-[11px] text-[#736657]">Grand Reception • Colombo</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="p-6 rounded-2xl bg-white border border-[#ebd9c2] shadow-sm flex flex-col justify-between">
                    <p class="text-xs sm:text-sm text-[#52483d] italic leading-relaxed mb-4">
                        "Our sacred ceremony and celebration banquet were seamlessly coordinated. The itemized quotation tool let us verify advance payments and keep our budget strictly on track. Exceptional experience!"
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-[#ebd9c2]">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-xs">
                            R&F
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#241f1a]">Rizwan & Fathima</div>
                            <div class="text-[11px] text-[#736657]">Coastal Celebration • Galle Fort</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-[#ebd9c2] bg-[#f5f0e8] py-14 text-[#665c50] text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10 pb-10 border-b border-[#ebd9c2]">
                <!-- Brand col -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="font-serif-luxury text-2xl font-bold text-[#241f1a]">Wedora<span class="text-[#b8860b]">.</span></span>
                        <span class="text-[#8c6d23] font-bold text-[11px] uppercase tracking-wider">Sri Lanka</span>
                    </div>
                    <p class="text-xs leading-relaxed max-w-sm mb-4">
                        Sri Lanka's dedicated multi-tenant wedding operating system. Bridging centuries of sacred culture with modern financial and timeline precision.
                    </p>
                    <div class="text-[11px] text-[#8c6d23] font-semibold">
                        Celebrating Island Love Stories Across All 25 Districts
                    </div>
                </div>

                <!-- Pillars Col -->
                <div>
                    <div class="font-bold text-[#241f1a] uppercase tracking-wider text-[11px] mb-3">Celebration Pillars</div>
                    <ul class="space-y-2">
                        <li><a href="#features" class="hover:text-[#b8860b]">Customary Ceremonies & Rituals</a></li>
                        <li><a href="#features" class="hover:text-[#b8860b]">Stage & Floral Architecture</a></li>
                        <li><a href="#features" class="hover:text-[#b8860b]">Couture & Heirloom Styling</a></li>
                        <li><a href="#features" class="hover:text-[#b8860b]">Banquets & Receptions</a></li>
                        <li><a href="#features" class="hover:text-[#b8860b]">Photography & Cinematography</a></li>
                    </ul>
                </div>

                <!-- Coverage Col -->
                <div>
                    <div class="font-bold text-[#241f1a] uppercase tracking-wider text-[11px] mb-3">Island-Wide Coverage</div>
                    <p class="leading-relaxed">
                        Serving Colombo, Kandy, Galle, Gampaha, Kurunegala, Jaffna, Matara, Kalutara, Nuwara Eliya, and all 25 administrative districts of Sri Lanka.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-[#736657]">
                <div>
                    &copy; {{ date('Y') }} Wedora Sri Lanka. Built for couples, planners & artisans.
                </div>
                <div class="flex items-center gap-4">
                    <span>LKR Currency Compliance</span>
                    <span>•</span>
                    <span>Auspicious Timeline Synchronization</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>