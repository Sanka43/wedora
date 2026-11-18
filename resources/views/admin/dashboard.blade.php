<x-portal-layout title="Control Center — Super Admin Portal" portalName="Control Center" portalBadgeClass="bg-purple-100 text-purple-900 border border-purple-300">
    <div class="space-y-8">
        
        <!-- Welcome Hero -->
        <div class="bg-gradient-to-r from-[#241f1a] to-[#3a322b] rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden border border-amber-900/30">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 text-xs font-bold uppercase tracking-wider mb-3 border border-amber-400/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Platform Overview
                    </div>
                    <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold tracking-tight text-white mb-2">
                        Wedora Super Admin Control Center
                    </h1>
                    <p class="text-sm text-stone-300 max-w-2xl">
                        Monitor Sri Lanka's high-trust wedding ecosystem, approve artisan vendor listings, and track platform-wide booking volumes in real-time.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/clear-cache') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all">
                        <span class="material-symbols-outlined text-[18px]">cached</span>
                        <span>Flush Cache</span>
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs shadow-md border border-amber-300 hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[18px]">storefront</span>
                        <span>View Marketplace</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Couples -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Couples Registered</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">favorite</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">{{ number_format($totalCouples) }}</div>
                    <div class="text-xs text-emerald-600 mt-1 flex items-center gap-1 font-semibold">
                        <span>{{ number_format($totalWeddings) }} active wedding workspaces</span>
                    </div>
                </div>
            </div>

            <!-- Total Vendors -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Artisan Vendors</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#b8860b] flex items-center justify-center">
                        <span class="material-symbols-outlined">store</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">{{ number_format($totalVendors) }}</div>
                    <div class="text-xs text-amber-700 mt-1 flex items-center gap-1 font-semibold">
                        <span>{{ $pendingVerificationCount }} pending verifications</span>
                    </div>
                </div>
            </div>

            <!-- Gross Booking Value -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Gross Bookings (LKR)</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">Rs. {{ number_format($grossBookingValue / 1000000, 2) }}M</div>
                    <div class="text-xs text-[#736657] mt-1 flex items-center gap-1 font-semibold">
                        <span>{{ $totalBookings }} bookings • {{ $totalQuotations }} RFQs</span>
                    </div>
                </div>
            </div>

            <!-- Wedding Planners -->
            <div class="bg-white rounded-2xl p-6 border border-[#ebd9c2] shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#736657]">Wedding Planners</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">event_note</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold font-serif-luxury text-[#241f1a]">{{ number_format($totalPlanners) }}</div>
                    <div class="text-xs text-indigo-700 mt-1 flex items-center gap-1 font-semibold">
                        <span>Professional concierge partners</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Columns: Vendor Verification & Recent Weddings -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Vendor Verification Queue (2 cols) -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-[#ebd9c2] shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">Artisan Vendor Directory & Verification</h2>
                        <p class="text-xs text-[#736657] mt-1">Review vendor credentials, starting rates, and verification status.</p>
                    </div>
                    <span class="px-3 py-1 bg-amber-50 text-[#8c6d23] border border-amber-300 rounded-full text-xs font-bold">
                        {{ $vendors->count() }} Profiles
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-[#ebd9c2] text-[#736657] uppercase tracking-wider">
                                <th class="pb-3 font-bold">Business Name</th>
                                <th class="pb-3 font-bold">Category</th>
                                <th class="pb-3 font-bold">District</th>
                                <th class="pb-3 font-bold">Min Starting Price</th>
                                <th class="pb-3 font-bold">Status</th>
                                <th class="pb-3 font-bold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($vendors as $v)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="py-4 font-bold text-[#241f1a]">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg gold-gradient-bg flex items-center justify-center text-xs font-bold">
                                                {{ substr($v->business_name, 0, 1) }}
                                            </div>
                                            <span>{{ $v->business_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-[#736657]">{{ $v->category->name ?? 'Artisan' }}</td>
                                    <td class="py-4 text-[#736657]">{{ $v->district }}</td>
                                    <td class="py-4 font-semibold text-[#241f1a]">Rs. {{ number_format($v->starting_price, 2) }}</td>
                                    <td class="py-4">
                                        @if($v->verification_status->value === 'verified')
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Verified</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('vendors.show', $v->slug) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-stone-100 hover:bg-[#b8860b] hover:text-white transition font-bold text-[11px]">
                                            View Page
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-[#736657]">No vendors registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: System Info & Diagnostic Health -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#ebd9c2] shadow-sm space-y-6">
                <div>
                    <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">System Diagnostics</h2>
                    <p class="text-xs text-[#736657] mt-1">Runtime infrastructure and database connectivity.</p>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#faf8f5] border border-[#ebd9c2]">
                        <span class="text-[#736657] font-medium">Laravel Framework</span>
                        <span class="font-bold text-[#241f1a]">{{ $systemInfo['laravel_version'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#faf8f5] border border-[#ebd9c2]">
                        <span class="text-[#736657] font-medium">PHP Version</span>
                        <span class="font-bold text-[#241f1a]">{{ $systemInfo['php_version'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#faf8f5] border border-[#ebd9c2]">
                        <span class="text-[#736657] font-medium">MySQL Connection</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">Connected ({{ $systemInfo['database_name'] }})</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#faf8f5] border border-[#ebd9c2]">
                        <span class="text-[#736657] font-medium">Environment</span>
                        <span class="font-bold uppercase text-[#241f1a]">{{ $systemInfo['server_environment'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#faf8f5] border border-[#ebd9c2]">
                        <span class="text-[#736657] font-medium">Debug Mode</span>
                        <span class="font-bold {{ $systemInfo['debug_mode'] === 'Enabled' ? 'text-amber-600' : 'text-stone-500' }}">{{ $systemInfo['debug_mode'] }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#ebd9c2]">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#736657] mb-3">Subscription Plans</h3>
                    <div class="space-y-2">
                        @foreach($plans as $plan)
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/50 border border-amber-200 text-xs">
                                <span class="font-bold text-[#241f1a]">{{ $plan->name }}</span>
                                <span class="font-bold text-[#b8860b]">Rs. {{ number_format($plan->price_monthly, 0) }}/mo</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-portal-layout>
