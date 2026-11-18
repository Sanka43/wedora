<x-portal-layout title="Planner Portal — Wedora Sri Lanka" portalName="Planner Studio" portalBadgeClass="bg-indigo-100 text-indigo-900 border border-indigo-300">
    <div class="space-y-8">

        <!-- Welcome Hero -->
        <div class="bg-gradient-to-r from-[#1e1b4b] to-[#312e81] rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden border border-indigo-900/30">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-400/20 text-indigo-200 text-xs font-bold uppercase tracking-wider mb-3 border border-indigo-400/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Executive Wedding Planning
                    </div>
                    <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold tracking-tight text-white mb-2">
                        Professional Planner Concierge
                    </h1>
                    <p class="text-sm text-indigo-100 max-w-2xl">
                        Seamlessly coordinate auspicious timings (Nekath), multi-tier vendor contracts, and client nuptials across Sri Lanka with collaborative workspace tools.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        <span>Vendor Directory</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Active Client Weddings -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Client Weddings</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">diversity_1</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">{{ $activeClientsCount }}</div>
                    <div class="text-xs text-indigo-700 mt-1 font-semibold">
                        <span>Active planning workspaces</span>
                    </div>
                </div>
            </div>

            <!-- Overlooked Budget -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Total Budget Overlooked</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">Rs. {{ number_format($totalOverlookedBudget / 1000000, 2) }}M</div>
                    <div class="text-xs text-emerald-700 mt-1 font-semibold">
                        <span>Managed client spend</span>
                    </div>
                </div>
            </div>

            <!-- Contracts Coordinated -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Vendor Bookings</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#b8860b] flex items-center justify-center">
                        <span class="material-symbols-outlined">handshake</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">{{ $totalBookingsCoordinated }}</div>
                    <div class="text-xs text-amber-700 mt-1 font-semibold">
                        <span>Contracts and retainers overseen</span>
                    </div>
                </div>
            </div>

            <!-- Client Satisfaction -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Satisfaction Rating</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">stars</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">4.98 ⭐</div>
                    <div class="text-xs text-rose-700 mt-1 font-semibold">
                        <span>Top rated Sri Lankan planner</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Weddings Grid -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#ebd9c2] shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">Client Wedding Portfolios</h2>
                    <p class="text-xs text-[#736657] mt-1">Directly manage schedules, budgets, and guest allocations.</p>
                </div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-xs font-bold">
                    {{ $clientWeddings->count() }} Nuptials
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($clientWeddings as $cw)
                    <div class="rounded-2xl p-6 border border-[#ebd9c2] bg-[#faf8f5] hover:border-[#b8860b] transition space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-[#241f1a] text-base">{{ $cw->title }}</h3>
                                <div class="text-xs text-[#736657] mt-0.5">
                                    {{ $cw->partner1_name }} & {{ $cw->partner2_name }} • {{ $cw->district }}
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-[#8c6d23] text-[11px] font-bold">
                                {{ ucfirst($cw->status->value ?? 'Planning') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 py-3 border-y border-[#ebd9c2]/60 text-xs">
                            <div>
                                <span class="text-[#736657] block text-[10px] uppercase font-bold">Event Date</span>
                                <span class="font-semibold text-[#241f1a]">{{ \Carbon\Carbon::parse($cw->wedding_date)->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-[#736657] block text-[10px] uppercase font-bold">Total Budget</span>
                                <span class="font-semibold text-[#241f1a]">Rs. {{ number_format($cw->total_budget, 0) }}</span>
                            </div>
                            <div>
                                <span class="text-[#736657] block text-[10px] uppercase font-bold">Guests</span>
                                <span class="font-semibold text-[#241f1a]">{{ $cw->estimated_guest_count }} guests</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-xs text-[#736657]">{{ $cw->bookings->count() }} vendor bookings</span>
                            <form method="POST" action="{{ route('workspace.switch', $cw->uuid) }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl gold-gradient-bg text-[#1a140a] text-xs font-bold border border-amber-300 hover:scale-105 transition">
                                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    <span>Enter Workspace</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 text-xs text-[#736657]">
                        No client weddings assigned.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Auspicious Timings & Nekath Alert Schedule -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#ebd9c2] shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">Auspicious Timings & Poruwa Nekath Alerts</h2>
                    <p class="text-xs text-[#736657] mt-1">Astrologer-verified sacred timings synchronized across traditional dressers, venues, and photographers.</p>
                </div>
                <span class="px-3 py-1 bg-amber-50 text-[#8c6d23] border border-amber-300 rounded-full text-xs font-bold">
                    Sinhala & Hindu Nuptials
                </span>
            </div>

            <div class="space-y-3">
                @forelse($ceremoniesTimeline as $timeline)
                    @php
                        $tWedding = $timeline->wedding;
                        $coupleName = ($tWedding?->partner1_name && $tWedding?->partner2_name)
                            ? ($tWedding->partner1_name . ' & ' . $tWedding->partner2_name)
                            : ($tWedding?->title ?? 'Client Nuptial');
                        $tVenue = $timeline->location ?: ($tWedding?->location ?: ($tWedding?->district ?? 'Venue TBD'));
                        $tTime = \Carbon\Carbon::parse($timeline->start_time)->format('h:i A');
                        $tDate = $timeline->event_date ? \Carbon\Carbon::parse($timeline->event_date)->format('M d, Y') : '';
                        $isNekath = stripos($timeline->title, 'nekath') !== false || stripos($timeline->title, 'poruwa') !== false;
                    @endphp
                    <div class="p-4 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-[#b8860b] transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl gold-gradient-bg flex items-center justify-center text-[#1a140a] border border-amber-300 font-bold text-xs">
                                🪷
                            </div>
                            <div>
                                <div class="font-bold text-[#241f1a] text-sm">{{ $timeline->title }}</div>
                                <div class="text-xs text-[#736657]">{{ $coupleName }} • {{ $tVenue }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <div class="font-serif-luxury font-bold text-[#b8860b] text-base">{{ $tTime }}</div>
                                <div class="text-[11px] text-[#736657]">{{ $tDate }}</div>
                            </div>
                            <span class="px-3 py-1 rounded-full {{ $isNekath ? 'bg-amber-100 text-[#8c6d23]' : 'bg-emerald-100 text-emerald-800' }} text-[11px] font-bold">
                                {{ $isNekath ? 'Sacred Nekath' : 'Scheduled' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-[#736657] bg-[#faf8f5] rounded-2xl border border-[#ebd9c2]">
                        No auspicious ceremonies or timeline events scheduled across active client portfolios.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-portal-layout>
