<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wedora — Sri Lankan Wedding Planning SaaS & Verified Vendor Marketplace</title>

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-serif-luxury {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #d4af37 0%, #f3e5ab 50%, #aa771c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-gradient-bg {
            background: linear-gradient(135deg, #c5a059 0%, #d4af37 50%, #996515 100%);
        }
        .gold-border-glow {
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="bg-[#0c0d12] text-slate-100 antialiased selection:bg-[#d4af37] selection:text-black min-h-screen flex flex-col justify-between">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-amber-950 via-[#1e1507] to-amber-950 border-b border-amber-500/20 py-2 text-center text-xs tracking-wide text-amber-200/90 font-medium px-4">
        ✨ Welcome to Wedora — Sri Lanka's First Dedicated Multi-Tenant Wedding Planning Platform & Marketplace.
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-[#0c0d12]/85 border-b border-white/5 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl gold-gradient-bg flex items-center justify-center text-slate-950 shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" opacity=".2"/>
                        <path d="M12 4.5c-4.14 0-7.5 3.36-7.5 7.5s3.36 7.5 7.5 7.5 7.5-3.36 7.5-7.5-3.36-7.5-7.5-7.5zm0 13c-3.03 0-5.5-2.47-5.5-5.5S8.97 6.5 12 6.5s5.5 2.47 5.5 5.5-2.47 5.5-5.5 5.5z"/>
                        <path d="M12 8a4 4 0 100 8 4 4 0 000-8zm0 6a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-serif-luxury text-2xl font-bold tracking-tight text-white flex items-center gap-1.5">
                        Wedora<span class="text-[#d4af37]">.</span>
                    </span>
                    <span class="block text-[10px] tracking-widest uppercase text-amber-300/60 font-semibold -mt-1">Sri Lanka</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#marketplace" class="hover:text-[#d4af37] transition-colors">Vendor Directory</a>
                <a href="#workspace" class="hover:text-[#d4af37] transition-colors">Planning Tools</a>
                <a href="#checklists" class="hover:text-[#d4af37] transition-colors">Cultural Checklists</a>
                <a href="#pricing" class="hover:text-[#d4af37] transition-colors">Vendor Plans</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('workspace.dashboard') }}" class="gold-gradient-bg text-slate-950 font-semibold text-xs uppercase tracking-wider px-5 py-2.5 rounded-lg shadow-md hover:brightness-110 active:scale-95 transition-all">
                        ✨ Open Workspace
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs uppercase tracking-wider font-semibold text-slate-300 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="gold-gradient-bg text-slate-950 font-semibold text-xs uppercase tracking-wider px-5 py-2.5 rounded-lg shadow-md hover:brightness-110 active:scale-95 transition-all">
                        Start Planning Free
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32">
        <!-- Glow Orbs -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-amber-500/10 blur-[130px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-80 h-80 bg-rose-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-medium mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                The Modern Sri Lankan Wedding Operating System
            </div>

            <!-- Headline -->
            <h1 class="font-serif-luxury text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white leading-[1.1] mb-6 max-w-4xl mx-auto">
                Plan Your Dream Wedding Across <span class="gold-gradient-text italic font-normal">Sri Lanka</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto font-normal leading-relaxed mb-10">
                From auspicious Poruwa Nekath rituals and Kandyan Mul Anduma tailorings to beachfront reception halls in Bentota. Seamlessly manage budgets in LKR, invite guests, and book verified vendors.
            </p>

            <!-- Search Filter Bar -->
            <div class="max-w-3xl mx-auto p-2 sm:p-2.5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-2xl shadow-2xl flex flex-col sm:flex-row gap-2">
                <div class="flex-1 px-4 py-2.5 text-left border-b sm:border-b-0 sm:border-r border-white/10">
                    <label class="block text-[11px] font-semibold tracking-wider uppercase text-amber-300/80 mb-0.5">District / Region</label>
                    <select class="w-full bg-transparent text-sm text-white focus:outline-none cursor-pointer">
                        <option value="" class="bg-slate-900 text-white">All 25 Districts (Colombo, Kandy, Galle...)</option>
                        <option value="colombo" class="bg-slate-900 text-white">Colombo</option>
                        <option value="gampaha" class="bg-slate-900 text-white">Gampaha</option>
                        <option value="kandy" class="bg-slate-900 text-white">Kandy</option>
                        <option value="galle" class="bg-slate-900 text-white">Galle</option>
                        <option value="kalutara" class="bg-slate-900 text-white">Kalutara</option>
                        <option value="matara" class="bg-slate-900 text-white">Matara</option>
                        <option value="kurunegala" class="bg-slate-900 text-white">Kurunegala</option>
                        <option value="nuwara-eliya" class="bg-slate-900 text-white">Nuwara Eliya</option>
                    </select>
                </div>

                <div class="flex-1 px-4 py-2.5 text-left">
                    <label class="block text-[11px] font-semibold tracking-wider uppercase text-amber-300/80 mb-0.5">Vendor Category</label>
                    <select class="w-full bg-transparent text-sm text-white focus:outline-none cursor-pointer">
                        <option value="" class="bg-slate-900 text-white">Select Category ({{ $categories->count() }} Available)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" class="bg-slate-900 text-white">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="gold-gradient-bg text-slate-950 font-bold px-7 py-3 rounded-xl flex items-center justify-center gap-2 hover:brightness-110 active:scale-95 transition-all text-sm shadow-lg shadow-amber-500/20">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Explore Vendors
                </button>
            </div>

            <!-- Stats Bar -->
            <div class="mt-14 pt-10 border-t border-white/5 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="font-serif-luxury text-3xl font-bold text-white">100%</div>
                    <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">LKR Currency Accuracy</div>
                </div>
                <div>
                    <div class="font-serif-luxury text-3xl font-bold text-white">25</div>
                    <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Districts Supported</div>
                </div>
                <div>
                    <div class="font-serif-luxury text-3xl font-bold text-white">10+</div>
                    <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Curated Categories</div>
                </div>
                <div>
                    <div class="font-serif-luxury text-3xl font-bold text-white">Zero</div>
                    <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Quote Commission Fees</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vendor Categories Grid -->
    <section id="marketplace" class="py-20 border-t border-white/5 bg-gradient-to-b from-[#0c0d12] via-[#10121a] to-[#0c0d12]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-2">Marketplace Directory</h2>
                <p class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white">Sri Lankan Wedding Specialists</p>
                <p class="text-slate-400 text-sm mt-3">Discover verified professionals who understand the intricate traditions, Nekath schedules, and luxury expectations of island weddings.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <div class="group relative rounded-2xl p-5 bg-white/[0.02] border border-white/5 hover:border-amber-500/30 hover:bg-white/[0.04] transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-[#d4af37] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-white group-hover:text-[#d4af37] transition-colors leading-snug">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-2 line-clamp-3 leading-relaxed">
                                {{ $category->description }}
                            </p>
                        </div>
                        <div class="mt-5 pt-3 border-t border-white/5 flex items-center justify-between text-xs text-amber-300/80 font-medium">
                            <span>Browse Directory</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Planning Workspace Features -->
    <section id="workspace" class="py-24 border-t border-white/5 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-2">Dedicated Couple Workspace</h2>
                <p class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white">Full Financial & Timeline Control</p>
                <p class="text-slate-400 text-sm mt-3">Architected with strict multi-tenant isolation, ensuring your guest list, quotes, and financial records remain completely private.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-amber-500/20 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">LKR Budget & Expense Guard</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Automatic percentage category allocation (Catering 45%, Photo 15%, Poruwa 8%) with strict database constraints preventing accidental deletion of booked expenditures.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-amber-500/20 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Guest Lists & Digital RSVP</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Group guests by families, track dietary requirements, generate unique secure tokens, and assign tables without messy spreadsheets.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-amber-500/20 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-[#d4af37] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Instant Quotation Conversions</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Request itemized quotes directly from verified vendors, compare total and advance payments, and convert accepted quotes into legal bookings in one click.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cultural Checklists Section -->
    <section id="checklists" class="py-20 border-t border-white/5 bg-[#10121a]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-2">Sri Lankan Traditions</h2>
                <p class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white">Pre-Loaded Planning Timelines</p>
                <p class="text-slate-400 text-sm mt-3">From -365 days out to the exact minute of your Poruwa ceremony, never miss an astrological Nekath window.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($templates as $tmpl)
                    <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 hover:border-amber-500/30 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/20 uppercase tracking-wider">
                                {{ $tmpl->wedding_type->value }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $tmpl->items_count }} Key Milestones</span>
                        </div>
                        <h3 class="text-xl font-bold text-white font-serif-luxury mb-2">{{ $tmpl->name }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6">{{ $tmpl->description }}</p>

                        <div class="space-y-2.5 border-t border-white/5 pt-4">
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Sample Timeline Highlights:</div>
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span>Day -365: Consult Astrologer for Auspicious Times (Nekath)</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span>Day -180: Select Poruwa Master (Ashtaka) & Ves Dancers</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span>Day -60: Hand-Deliver Invitations with Betel Leaves (Bulath Athin Deema)</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing / Subscription Plans for Vendors & Planners -->
    <section id="pricing" class="py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-xs uppercase tracking-widest text-[#d4af37] font-bold mb-2">Grow With Wedora</h2>
                <p class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white">Vendor & Planner Membership</p>
                <p class="text-slate-400 text-sm mt-3">Receive high-intent inquiries from couples actively planning their weddings across all 25 districts.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                    <div class="p-6 rounded-2xl bg-white/[0.02] border {{ $plan->is_featured_badge ? 'border-amber-500/50 gold-border-glow bg-amber-500/[0.03]' : 'border-white/5' }} flex flex-col justify-between transition-all">
                        <div>
                            @if($plan->is_featured_badge)
                                <div class="inline-block text-[10px] font-bold tracking-widest uppercase px-2.5 py-0.5 rounded-full bg-[#d4af37] text-slate-950 mb-3">
                                    Most Popular
                                </div>
                            @endif

                            <h3 class="text-base font-bold text-white">{{ $plan->name }}</h3>
                            <div class="mt-4 flex items-baseline gap-1">
                                <span class="text-xs text-amber-300/80 font-medium">{{ $plan->currency }}</span>
                                <span class="text-3xl font-extrabold text-white">{{ number_format($plan->price) }}</span>
                                <span class="text-xs text-slate-400">/{{ $plan->billing_interval->value }}</span>
                            </div>

                            <ul class="mt-6 space-y-2.5 text-xs text-slate-300 border-t border-white/5 pt-5">
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-400">✓</span>
                                    <span>Up to {{ $plan->max_packages }} Packages</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-400">✓</span>
                                    <span>Up to {{ $plan->max_portfolio_images }} Portfolio Photos</span>
                                </li>
                                @if(!empty($plan->features))
                                    @foreach($plan->features as $feat)
                                        <li class="flex items-start gap-2">
                                            <span class="text-amber-400 shrink-0">✓</span>
                                            <span>{{ $feat }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="mt-8 pt-4">
                            <button class="w-full py-2.5 rounded-xl font-semibold text-xs tracking-wider uppercase transition-all {{ $plan->is_featured_badge ? 'gold-gradient-bg text-slate-950 hover:brightness-110' : 'bg-white/10 text-white hover:bg-white/15' }}">
                                Choose {{ $plan->name }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-[#090a0e] py-12 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <span class="font-serif-luxury text-xl font-bold text-white">Wedora.</span>
                <span class="text-slate-500">|</span>
                <span>Sri Lankan Wedding Planning SaaS & Marketplace</span>
            </div>
            <div>
                Built for couples, planners & vendors across all 25 districts of Sri Lanka.
            </div>
            <div class="text-slate-500">
                &copy; {{ date('Y') }} Wedora. Powered by Vertex Web Solution.
            </div>
        </div>
    </footer>

</body>
</html>
