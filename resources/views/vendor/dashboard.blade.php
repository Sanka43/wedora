<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ $vendor?->business_name ?? 'Vendor Atelier' }} — Atelier Dashboard</title>

    @include('layouts.head-meta')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-fixed selection:text-on-primary-fixed pb-12">

    <!-- Top Navigation Bar -->
    <x-top-navbar />

    <!-- Dynamic Toast Notification -->
    <div id="dynamic-toast" class="fixed bottom-6 right-4 sm:right-6 left-4 sm:left-auto z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-on-background text-surface px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-primary/20 max-w-md ml-auto">
            <span id="toast-icon" class="material-symbols-outlined text-[20px] text-primary-fixed shrink-0">info</span>
            <span id="toast-message" class="font-body-sm text-xs sm:text-sm">Notification message</span>
        </div>
    </div>

    <!-- Main Studio Dashboard Shell -->
    <main class="w-full pt-20 bg-surface min-h-[calc(100vh-80px)]">
        <div class="flex flex-col w-full">

            <!-- Atelier Top Control Bar / Profile Ribbon -->
            <section class="w-full bg-surface-container-lowest shadow-sm mb-6 lg:mb-space-xl border-b border-surface-container/60">
                <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-margin py-4 sm:py-space-lg">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-space-lg">
                        
                        <!-- Vendor Identity & Credentials -->
                        <div class="flex items-start sm:items-center gap-3 sm:gap-space-md">
                            <div class="relative shrink-0">
                                <img class="w-14 h-14 sm:w-20 sm:h-20 rounded-xl object-cover shadow-sm ring-1 ring-outline-variant/30" 
                                     src="{{ $vendor?->user?->profile?->avatar_url ?? ($vendor?->media?->firstWhere('is_cover', true)?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRNYWEruRJSaji5rAl5X1C0zy1Y2sAV_-EtBWAcWexzjJMxXmx3AhIh7hh5MvPJ4rOLWy_qtam7qraFdUfkXyFx00QC6ZVf6kAaP-KwsfBTvA3QfxQCCcFqCYIu_bKYj7G6zlaboRmKrzpYZMamecxhqk2j4rAWLxMv9d1ya46zpd40EbBHH9K-gmVXuohrwlkbHZalhouaVp9PSbYqenIelqGic-w8MMUDKrX25aT') }}" 
                                     alt="{{ $vendor?->business_name ?? 'Vendor Atelier' }}"/>
                                <span class="absolute -bottom-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-surface shadow-xs">
                                    <span class="material-symbols-outlined text-[13px]">verified</span>
                                </span>
                            </div>

                            <div class="flex flex-col">
                                <div class="flex flex-wrap items-center gap-1.5 sm:gap-space-sm mb-1">
                                    <h1 class="font-headline-sm text-lg sm:text-headline-sm text-on-surface font-bold">
                                        {{ $vendor?->business_name ?? 'Your Vendor Atelier' }}
                                    </h1>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-caps text-[10px] tracking-widest uppercase font-semibold">
                                        <span class="material-symbols-outlined text-[12px] text-primary" style="font-variation-settings: 'FILL' 1;">star</span>
                                        2025 Gold Verified Atelier
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-y-1 gap-x-2 sm:gap-x-space-md text-on-surface-variant font-body-sm text-xs sm:text-body-sm">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px] text-primary">location_on</span>
                                        {{ $vendor?->address ?? ($vendor?->district ? $vendor->district . ' District' : 'Islandwide') }}
                                    </span>
                                    <span class="hidden sm:inline text-outline-variant">•</span>
                                    <span class="flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-tertiary animate-pulse"></span>
                                        <span class="text-tertiary font-title-sm text-xs sm:text-title-sm font-semibold">Accepting 2025 / 2026 Nuptials</span>
                                    </span>
                                    <span class="hidden sm:inline text-outline-variant">•</span>
                                    <span class="font-label-caps text-[10px] sm:text-label-caps text-on-surface-variant uppercase">SLA: &lt; 2h Response</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action CTAs -->
                        <div class="flex flex-wrap items-center gap-2 self-start lg:self-center">
                            <button onclick="openSyncCalendarModal()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface transition-colors font-title-sm text-xs sm:text-title-sm shadow-xs cursor-pointer tap-highlight-none" type="button">
                                <span class="material-symbols-outlined text-[17px] text-primary">calendar_month</span>
                                <span>Sync iCal/Google</span>
                            </button>
                            <a href="{{ $vendor ? route('vendors.show', $vendor->slug) : '#' }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface transition-colors font-title-sm text-xs sm:text-title-sm shadow-xs cursor-pointer tap-highlight-none">
                                <span class="material-symbols-outlined text-[17px] text-secondary">visibility</span>
                                <span>Public Showcase</span>
                            </a>
                            <button onclick="openCustomRfqModal()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-on-background text-surface hover:bg-inverse-surface transition-all font-title-sm text-xs sm:text-title-sm shadow-md cursor-pointer tap-highlight-none font-semibold" type="button">
                                <span class="material-symbols-outlined text-[17px] text-primary-fixed">add_circle</span>
                                <span>+ Send Custom RFQ</span>
                            </button>
                        </div>

                    </div>
                </div>
            </section>

            <!-- Core Metric Highlights (4 Cards) -->
            <section class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-margin mb-6 lg:mb-space-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-space-md">
                    
                    <!-- Metric 1: Booked Revenue -->
                    <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container/60">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-label-caps text-[10px] sm:text-label-caps text-on-surface-variant uppercase font-semibold">Total Booked Revenue (YTD)</span>
                            <span class="p-2 rounded-lg bg-primary-fixed/40 text-primary">
                                <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-1.5 mb-1">
                                <span class="font-label-caps text-xs text-primary font-bold tracking-wider">LKR</span>
                                <span class="font-display-md text-2xl sm:text-display-md text-on-surface tracking-tight font-bold">{{ number_format($totalBookedRevenue) }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-on-surface-variant">
                                <span class="text-tertiary font-title-sm text-xs font-semibold flex items-center">
                                    <span class="material-symbols-outlined text-[15px]">trending_up</span> +18.4%
                                </span>
                                <span>vs 2024 Nuptial season</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low rounded-xl p-2.5 flex items-center justify-between text-xs">
                            <span class="text-on-surface-variant">Escrow Cleared:</span>
                            <span class="font-title-sm text-on-surface font-semibold">LKR {{ number_format($escrowCleared) }}</span>
                        </div>
                    </div>

                    <!-- Metric 2: Active Nuptial Inquiries -->
                    <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container/60">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-label-caps text-[10px] sm:text-label-caps text-on-surface-variant uppercase font-semibold">Active Inquiries</span>
                            <span class="p-2 rounded-lg bg-secondary-container text-on-secondary-container">
                                <span class="material-symbols-outlined text-[20px]">mark_email_unread</span>
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="font-display-md text-2xl sm:text-display-md text-on-surface tracking-tight font-bold">{{ $inquiriesCount }}</span>
                                <span class="font-title-md text-xs sm:text-title-md text-on-surface-variant font-normal">Pending RFQs</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs">
                                <span class="inline-flex h-2 w-2 rounded-full bg-primary shrink-0"></span>
                                <span class="text-primary font-title-sm text-xs font-semibold">4 Priority Leads</span>
                                <span class="text-on-surface-variant hidden sm:inline">under 24h SLA</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low rounded-xl p-2.5 flex items-center justify-between text-xs">
                            <span class="text-on-surface-variant">Average Deal Size:</span>
                            <span class="font-title-sm text-on-surface font-semibold">LKR {{ number_format($averageDealSize) }}</span>
                        </div>
                    </div>

                    <!-- Metric 3: Confirmed Weddings -->
                    <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container/60">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-label-caps text-[10px] sm:text-label-caps text-on-surface-variant uppercase font-semibold">Confirmed Ceremonies</span>
                            <span class="p-2 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant">
                                <span class="material-symbols-outlined text-[20px]">event_available</span>
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="font-display-md text-2xl sm:text-display-md text-on-surface tracking-tight font-bold">{{ $confirmedBookingsCount }}</span>
                                <span class="font-title-md text-xs sm:text-title-md text-on-surface-variant font-normal">This Quarter</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                                <span class="font-label-caps text-[9px] uppercase text-tertiary px-1.5 py-0.5 rounded bg-tertiary-fixed/50 font-bold">Peak Nekath</span>
                                <span>Nov '25 — Feb '26</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low rounded-xl p-2.5 flex items-center justify-between text-xs">
                            <span class="text-on-surface-variant">Dates Booked:</span>
                            <span class="font-title-sm text-tertiary font-semibold">91% Capacity</span>
                        </div>
                    </div>

                    <!-- Metric 4: Reviews & Atelier Trust Score -->
                    <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container/60">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-label-caps text-[10px] sm:text-label-caps text-on-surface-variant uppercase font-semibold">Atelier Reputation</span>
                            <span class="p-2 rounded-lg bg-primary-fixed text-on-primary-fixed-variant">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-1.5 mb-1">
                                <span class="font-display-md text-2xl sm:text-display-md text-on-surface tracking-tight font-bold">{{ number_format($vendor?->rating_avg ?? 0.00, 2) }}</span>
                                <span class="text-primary flex items-center text-sm">
                                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-on-surface-variant">
                                <span>{{ $vendor?->reviews_count ?? 0 }} Verified Reviews</span>
                                <span class="text-outline-variant">•</span>
                                <span class="font-title-sm text-xs text-tertiary font-semibold">{{ $vendor && $vendor->reviews_count > 0 ? 'Verified Atelier' : 'New Atelier' }}</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low rounded-xl p-2.5 flex items-center justify-between text-xs">
                            <span class="text-on-surface-variant">Profile Quality:</span>
                            <span class="font-title-sm text-primary font-semibold">Flawless 100%</span>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Main Operational Atelier Grid -->
            <section class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-margin pb-space-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-space-xl">

                    <!-- LEFT COLUMN: Nuptial Pipeline & Escrow Settlements (7 Cols on xl) -->
                    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6 lg:gap-space-xl" id="pipeline-section">
                        
                        <!-- Pipeline Header & Filter Tabs -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 sm:mb-space-lg">
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-label-caps text-label-caps text-primary tracking-widest uppercase font-bold">Client Acquisition Engine</span>
                                        <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                    </div>
                                    <h2 class="font-headline-md text-xl sm:text-headline-md text-on-surface font-semibold">Active Nuptial Inquiries Pipeline</h2>
                                </div>
                                
                                <!-- Pipeline Tabs -->
                                <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-xl self-start sm:self-auto">
                                    <button onclick="filterPipeline('active')" id="pipeline-tab-active" class="px-3 py-1.5 rounded-lg font-title-sm text-xs bg-surface-container-lowest text-primary shadow-xs font-semibold transition-all tap-highlight-none">
                                        Active ({{ $inquiriesCount }})
                                    </button>
                                    <button onclick="filterPipeline('awaiting')" id="pipeline-tab-awaiting" class="px-3 py-1.5 rounded-lg font-title-sm text-xs text-on-surface-variant hover:text-on-surface transition-all tap-highlight-none">
                                        Awaiting ({{ $pendingInquiries }})
                                    </button>
                                    <button onclick="filterPipeline('booked')" id="pipeline-tab-booked" class="px-3 py-1.5 rounded-lg font-title-sm text-xs text-on-surface-variant hover:text-on-surface transition-all tap-highlight-none">
                                        Booked ({{ $confirmedBookingsCount }})
                                    </button>
                                </div>
                            </div>

                            <!-- Lead Cards Sequence -->
                            <div class="flex flex-col gap-4" id="leads-container">
                                @forelse($recentQuotations as $quotation)
                                    @php
                                        $quoteStatus = $quotation->status->value ?? $quotation->status;
                                        $isAwaiting = $quoteStatus === 'pending';
                                        $isBooked = in_array($quoteStatus, ['accepted', 'confirmed']);
                                        $categoryFilter = 'active ' . ($isAwaiting ? 'awaiting ' : '') . ($isBooked ? 'booked ' : '');
                                        $coupleTitle = $quotation->wedding?->title ?? ($quotation->requestedBy?->name ?? 'Prospective Couple');
                                        $eventDateFormatted = $quotation->event_date ? \Carbon\Carbon::parse($quotation->event_date)->format('F d, Y') : 'Date to be scheduled';
                                        $venueName = $quotation->venue_location ?: ($quotation->wedding?->location ?: 'Venue location TBD');
                                    @endphp
                                    <div class="lead-item bg-surface rounded-xl p-4 sm:p-space-lg transition-all hover:shadow-md border border-outline-variant/15" data-category="{{ trim($categoryFilter) }}">
                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-3">
                                            <div class="flex items-start gap-3">
                                                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl {{ $isBooked ? 'bg-primary-fixed/30 text-primary' : 'bg-secondary-fixed/40 text-secondary' }} flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[22px] sm:text-[24px]">
                                                        {{ $isBooked ? 'handshake' : 'mark_email_unread' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h3 class="font-headline-sm text-base sm:text-headline-sm text-on-surface font-semibold">{{ $coupleTitle }}</h3>
                                                        <span class="px-2 py-0.5 rounded-full {{ $isBooked ? 'bg-tertiary-fixed text-on-tertiary-fixed-variant' : 'bg-primary-fixed text-on-primary-fixed-variant animate-pulse' }} font-label-caps text-[9px] uppercase font-bold">
                                                            {{ ucfirst(str_replace('_', ' ', $quoteStatus)) }}
                                                        </span>
                                                    </div>
                                                    <p class="font-body-sm text-xs sm:text-body-sm text-on-surface-variant mt-0.5">
                                                        {{ $venueName }} • {{ $eventDateFormatted }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="sm:text-right shrink-0">
                                                <span class="font-label-caps text-[9px] text-on-surface-variant uppercase">Quotation Scope</span>
                                                <div class="font-title-lg text-base sm:text-title-lg text-on-surface font-bold">
                                                    <span class="text-primary font-label-caps text-xs mr-1">LKR</span>{{ number_format($quotation->total_amount) }}
                                                </div>
                                            </div>
                                        </div>

                                        @if($quotation->couple_message)
                                            <!-- Cultural Logistics / Couple Note -->
                                            <div class="mb-3 p-3 rounded-xl bg-surface-container-high/60 flex items-start gap-2 border border-outline-variant/15">
                                                <span class="material-symbols-outlined text-[17px] text-primary mt-0.5 shrink-0">flare</span>
                                                <div class="text-xs sm:text-body-sm leading-relaxed">
                                                    <span class="font-title-sm text-xs font-bold text-on-surface">Couple's Note: </span>
                                                    <span class="text-on-surface-variant">{{ $quotation->couple_message }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Action Footer -->
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-caps text-[10px] px-2 py-0.5 rounded bg-surface-container text-secondary font-semibold">
                                                    {{ $quotation->package?->name ?? 'Customized Atelier Package' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button onclick="openBriefModal('{{ addslashes($coupleTitle) }}')" class="px-3 py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-xs transition-colors cursor-pointer tap-highlight-none" type="button">
                                                    View Details
                                                </button>
                                                @if($isAwaiting)
                                                    <button onclick="sendTailoredQuote('{{ addslashes($coupleTitle) }}', {{ $quotation->total_amount }})" class="px-3 py-1.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container font-title-sm text-xs transition-colors shadow-xs cursor-pointer tap-highlight-none font-semibold" type="button">
                                                        Respond to RFQ
                                                    </button>
                                                @else
                                                    <button onclick="sendContractReminder('{{ addslashes($coupleTitle) }}')" class="px-3 py-1.5 rounded-lg bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs transition-colors cursor-pointer tap-highlight-none font-semibold" type="button">
                                                        Contract Status
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center bg-surface-container-low rounded-xl border border-outline-variant/15">
                                        <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">mark_email_read</span>
                                        <h4 class="font-title-sm text-sm font-bold text-on-surface">No quotation inquiries in queue</h4>
                                        <p class="text-xs text-on-surface-variant mt-1">Inbound quotation requests submitted by couples via the marketplace will appear here.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Milestones & CBSL Escrow Ledger -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60" id="escrow-ledger">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                <div>
                                    <span class="font-label-caps text-label-caps text-tertiary tracking-widest uppercase font-bold">Verified Financial Integrity</span>
                                    <h2 class="font-headline-md text-lg sm:text-headline-md text-on-surface font-semibold">Recent Milestones &amp; Escrow Payments</h2>
                                </div>
                                <button onclick="showToast('CBSL Escrow Ledger statement generated.')" class="font-title-sm text-xs sm:text-title-sm text-primary hover:underline flex items-center gap-1 self-start sm:self-auto cursor-pointer" type="button">
                                    <span>View Escrow Ledger</span>
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </button>
                            </div>

                            <!-- Escrow Guarantee Callout -->
                            <div class="mb-4 p-3.5 rounded-xl bg-tertiary-fixed/30 flex items-start gap-2.5 border border-tertiary/20">
                                <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0 mt-0.5">verified_user</span>
                                <div class="text-xs sm:text-body-sm text-on-tertiary-container leading-relaxed">
                                    <span class="font-title-sm text-xs sm:text-title-sm font-semibold">Wedora Escrow Guarantee: </span>
                                    All nuptial disbursements are safeguarded in Central Bank of Sri Lanka (CBSL) regulated partner trustee accounts. Funds release to your Commercial Bank account within 24 hours of couple ritual milestone verification.
                                </div>
                            </div>

                            <!-- Payout Table / List -->
                            <div class="flex flex-col gap-2.5">
                                @forelse($recentBookings as $bk)
                                    @php
                                        $bkWeddingTitle = $bk->wedding?->title ?? 'Nuptial Milestone Ceremony';
                                        $bkDate = $bk->confirmed_at ? \Carbon\Carbon::parse($bk->confirmed_at)->format('M d, Y') : ($bk->created_at ? $bk->created_at->format('M d, Y') : 'Recent');
                                        $isSettled = ($bk->status->value ?? $bk->status) === 'completed';
                                    @endphp
                                    <div class="p-3.5 rounded-xl bg-surface-container-low flex flex-col sm:flex-row sm:items-center justify-between gap-2 border border-outline-variant/15">
                                        <div class="flex items-center gap-3">
                                            <span class="h-9 w-9 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            </span>
                                            <div>
                                                <div class="font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">{{ $bkWeddingTitle }}</div>
                                                <div class="font-body-sm text-[11px] text-on-surface-variant">{{ $bk->package?->name ?? 'Package Contract' }} • {{ $bkDate }}</div>
                                            </div>
                                        </div>
                                        <div class="sm:text-right shrink-0">
                                            <div class="font-title-md text-xs sm:text-title-md text-on-surface font-bold">
                                                <span class="font-label-caps text-xs text-primary mr-1">LKR</span>{{ number_format($bk->total_amount) }}
                                            </div>
                                            <span class="font-label-caps text-[9px] text-tertiary uppercase font-bold">{{ $isSettled ? 'Disbursed' : 'Secured' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 rounded-xl bg-surface-container-low text-center text-xs text-on-surface-variant border border-outline-variant/15">
                                        No recent disbursements recorded. Booked ceremony retainers will appear here.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Inbound RFQ Leads & Service Packages (Compatible with automated tests) -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60">
                            <div class="flex items-center justify-between mb-3 border-b border-surface-container pb-2">
                                <h3 class="font-title-md text-sm sm:text-title-md text-on-surface font-bold">Inbound RFQ Leads &amp; Quotation Inquiries</h3>
                                <span class="px-2.5 py-0.5 rounded-full bg-primary-fixed/40 text-on-primary-fixed-variant text-[10px] font-bold">
                                    {{ $recentQuotations->count() }} Leads In Queue
                                </span>
                            </div>

                            <p class="font-body-sm text-xs text-on-surface-variant mb-4">
                                Direct inquiries submitted by prospective Sri Lankan couples through the Wedora atelier directory.
                            </p>

                            <!-- Service Packages Section (Preserved for tests & live catalog) -->
                            <div class="pt-2 border-t border-surface-container">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">Service Packages &amp; Offerings</h4>
                                    <span class="text-xs text-primary font-semibold">{{ $packages->count() }} Active Collections</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                    @forelse($packages as $pkg)
                                        <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/15 flex flex-col justify-between">
                                            <div>
                                                <div class="font-title-sm text-xs font-bold text-on-surface">{{ $pkg->name }}</div>
                                                <div class="font-body-sm text-[11px] text-on-surface-variant mt-0.5 line-clamp-1">{{ $pkg->description }}</div>
                                            </div>
                                            <div class="mt-2 pt-1 border-t border-outline-variant/10 text-xs font-bold text-primary">
                                                LKR {{ number_format($pkg->price) }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full p-4 rounded-xl bg-surface-container-low text-center">
                                            <p class="font-body-sm text-xs text-on-surface-variant">No published service packages configured yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Operations, Nekath Chronometer & Studio Health (5 Cols on xl) -->
                    <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6 lg:gap-space-xl" id="chronometer-section">
                        
                        <!-- Imminent Ceremony Nekath Chronometer Widget -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60">
                            @if($upcomingBooking)
                                @php
                                    $ubWedding = $upcomingBooking->wedding;
                                    $ubDate = $upcomingBooking->event_date ? \Carbon\Carbon::parse($upcomingBooking->event_date) : now();
                                    $daysUntil = (int) ceil(now()->diffInDays($ubDate, false));
                                    $timelineList = $ubWedding ? $ubWedding->timelineEvents->sortBy('sort_order')->take(4) : collect();
                                @endphp
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-label-caps text-label-caps text-primary tracking-widest uppercase font-bold">Immediate Production Call</span>
                                    <span class="px-2 py-0.5 rounded-full bg-primary-fixed font-label-caps text-[10px] text-on-primary-fixed-variant uppercase font-bold">
                                        {{ $daysUntil > 0 ? "In $daysUntil Days" : ($daysUntil === 0 ? 'Today' : 'Completed') }}
                                    </span>
                                </div>
                                <h2 class="font-headline-sm text-lg sm:text-headline-sm text-on-surface font-semibold mb-0.5">
                                    {{ $ubWedding?->location ?: ($ubWedding?->title ?? 'Nuptial Ceremony') }}
                                </h2>
                                <p class="font-body-sm text-xs sm:text-body-sm text-on-surface-variant mb-3">
                                    {{ ($ubWedding?->partner1_name && $ubWedding?->partner2_name) ? ($ubWedding->partner1_name . ' & ' . $ubWedding->partner2_name) : $ubWedding?->title }} • {{ $ubWedding?->wedding_type?->value ?? 'Traditional Poruwa' }}
                                </p>
                                
                                <!-- Studio Photo Callout -->
                                <div class="relative w-full h-32 sm:h-36 rounded-xl overflow-hidden mb-3 shadow-xs">
                                    <img class="w-full h-full object-cover" 
                                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzutWj1tPcNstTsn3UQCCrZxGkaIwTPpNni3ODEkdYTZLNwiug5KWYACWRTI4CJ_NQj22UHjqEF1eDk9EfUEyt97hgEkXgLxd9EbcHG0CSawCvmZYw7xCHZNOhiDHKGoM0wXPcLN-N989zwjEZlBnTRffu-rJrHXZf3uWtLi0ksKaRD5yf_c6DS2FaBY3uOfhqtUIXXTbuENg2Ql8H1XyJ9dOF6akrXT7brl_nXGrM" 
                                         alt="Ceremony Venue"/>
                                    <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/85 via-black/20 to-transparent flex items-end p-2.5 sm:p-space-sm">
                                        <span class="text-surface font-title-sm text-xs sm:text-title-sm flex items-center gap-1 font-semibold">
                                            <span class="material-symbols-outlined text-[16px] text-primary-fixed">schedule</span>
                                            {{ $ubDate->format('M d, Y') }} • Production Schedule
                                        </span>
                                    </div>
                                </div>

                                <!-- Nekath Timeline Points -->
                                <div class="flex flex-col gap-2 mb-4">
                                    @forelse($timelineList as $tItem)
                                        @php
                                            $tTime = \Carbon\Carbon::parse($tItem->start_time)->format('h:i A');
                                            $isCritical = stripos($tItem->title, 'nekath') !== false || stripos($tItem->title, 'poruwa') !== false;
                                        @endphp
                                        <div class="flex items-start gap-2.5 p-1.5 rounded-lg {{ $isCritical ? 'bg-primary-fixed/25 border border-primary/20' : '' }}">
                                            <span class="font-title-sm text-xs text-primary font-bold shrink-0 w-16">{{ $tTime }}</span>
                                            <div class="font-body-sm text-xs text-on-surface">
                                                {{ $tItem->title }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-2 text-center text-xs text-on-surface-variant">
                                            Standard production timings synchronized with client.
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Studio Crew Assignment & Download Brief -->
                                <div class="p-2.5 rounded-xl bg-surface-container-low mb-3 border border-outline-variant/15">
                                    <div class="font-label-caps text-[9px] text-on-surface-variant uppercase font-bold mb-1">Assigned Studio Personnel</div>
                                    <div class="flex items-center justify-between font-body-sm text-xs text-on-surface font-semibold">
                                        <span>Lead: {{ $vendor?->business_name ?? 'Studio Lead' }} | Associate Crew</span>
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">check</span>
                                    </div>
                                </div>

                                <a href="{{ route('vendor.crew-brief') }}" class="w-full py-2.5 rounded-xl bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-title-sm text-xs sm:text-title-sm transition-colors flex items-center justify-center gap-2 cursor-pointer font-semibold shadow-xs">
                                    <span class="material-symbols-outlined text-[17px]">download</span>
                                    <span>Download Crew Briefing PDF</span>
                                </a>
                            @else
                                <div class="p-8 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-primary">event_available</span>
                                    <h3 class="font-title-sm text-sm font-bold text-on-surface">No Upcoming Ceremonies</h3>
                                    <p class="text-xs mt-1">Confirmed wedding contracts will display their production timeline and crew schedule here.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Deliverable & Post-Production Queue -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="font-label-caps text-label-caps text-secondary tracking-widest uppercase font-bold">Post-Production Lab</span>
                                    <h2 class="font-headline-sm text-base sm:text-headline-sm text-on-surface font-semibold">Editing &amp; Print Queue</h2>
                                </div>
                                <span class="p-1.5 rounded-lg bg-secondary-fixed/40 text-secondary">
                                    <span class="material-symbols-outlined text-[18px]">movie_filter</span>
                                </span>
                            </div>

                            <div class="flex flex-col gap-3.5">
                                @forelse($recentBookings as $queueBooking)
                                    @php
                                        $qStatus = $queueBooking->status->value ?? $queueBooking->status;
                                        $isComplete = $qStatus === 'completed';
                                    @endphp
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">
                                            <span>{{ $queueBooking->wedding?->title ?? 'Nuptial Milestone' }} • {{ $queueBooking->package?->name ?? 'Service Milestone' }}</span>
                                            <span class="{{ $isComplete ? 'text-tertiary' : 'text-primary' }} font-label-caps text-[9px] uppercase font-bold">
                                                {{ $isComplete ? 'Delivered & Settled' : 'Production Active' }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-surface-container-high rounded-full h-1.5">
                                            <div class="{{ $isComplete ? 'bg-tertiary w-full' : 'bg-primary w-3/4' }} h-1.5 rounded-full"></div>
                                        </div>
                                        <span class="text-on-surface-variant font-body-sm text-[11px]">
                                            {{ $queueBooking->event_date ? \Carbon\Carbon::parse($queueBooking->event_date)->format('M d, Y') : 'Date to be confirmed' }} • Verified Atelier Contract
                                        </span>
                                    </div>
                                @empty
                                    <div class="p-4 rounded-xl bg-surface-container-low text-center">
                                        <p class="font-body-sm text-xs text-on-surface-variant">No active production deliverables in queue.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Atelier Profile Health & Marketplace SEO Spotlight -->
                        <div class="bg-surface-container-lowest rounded-2xl p-4 sm:p-space-lg shadow-sm border border-surface-container/60">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="font-label-caps text-label-caps text-primary tracking-widest uppercase font-bold">Wedora Discovery Reach</span>
                                    <h2 class="font-headline-sm text-base sm:text-headline-sm text-on-surface font-semibold">Atelier Visibility</h2>
                                </div>
                                <span class="material-symbols-outlined text-primary text-[20px]">insights</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/15">
                                    <span class="font-label-caps text-[9px] text-on-surface-variant uppercase font-semibold">Profile Views (7d)</span>
                                    <div class="font-headline-sm text-lg sm:text-headline-sm text-on-surface font-bold mt-0.5">1,840</div>
                                    <span class="text-tertiary font-body-sm text-[10px] flex items-center gap-0.5 mt-0.5 font-semibold">
                                        <span class="material-symbols-outlined text-[13px]">arrow_upward</span> +24% surge
                                    </span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/15">
                                    <span class="font-label-caps text-[9px] text-on-surface-variant uppercase font-semibold">Quote Conversion</span>
                                    <div class="font-headline-sm text-lg sm:text-headline-sm text-on-surface font-bold mt-0.5">32%</div>
                                    <span class="text-on-surface-variant font-body-sm text-[10px] mt-0.5">Island Top 5%</span>
                                </div>
                            </div>

                            <div class="p-2.5 rounded-xl bg-surface-container-high/60 flex items-center justify-between border border-outline-variant/15">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[17px] text-primary" style="font-variation-settings: 'FILL' 1;">shield</span>
                                    <span class="font-body-sm text-xs text-on-surface font-semibold">Escrow Insurance Active</span>
                                </div>
                                <span class="font-label-caps text-[10px] text-on-surface-variant font-bold">Up to LKR 1.5M</span>
                            </div>
                        </div>

                    </div>

                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-surface-container-low mt-8 lg:mt-space-2xl">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-margin py-8 lg:py-space-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-space-xl mb-6 lg:mb-space-2xl">
                <div class="lg:col-span-2 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <span class="font-headline-md text-xl lg:text-headline-md text-primary font-bold">Wedora</span>
                        <span class="font-label-caps text-[10px] text-tertiary px-2 py-0.5 rounded-full bg-tertiary-fixed/40 font-semibold">Island Atelier</span>
                    </div>
                    <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant max-w-md leading-relaxed">
                        Honoring Sri Lankan matrimonial heritage through refined editorial technology. Orchestrating Poruwa ceremonies, Nekath timings, and elite vendors across Colombo, Kandy, Galle, and beyond.
                    </p>
                    <div class="flex items-center gap-1 text-on-surface-variant font-body-sm text-xs">
                        <span class="material-symbols-outlined text-[16px] text-primary">spa</span>
                        <span>Curated for high-profile nuptials &amp; destination weddings</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Nuptial Workspace</span>
                    <ul class="flex flex-col gap-1.5 font-body-md text-xs sm:text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="{{ route('vendor.dashboard') }}">Nekath Ritual Chronology</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('vendor.dashboard') }}">LKR Budget &amp; Cash Flow</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('vendor.dashboard') }}">Guest Seating &amp; Dietary RSVP</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('vendor.dashboard') }}">Vendor Quotations &amp; Contracts</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Vendor Atelier</span>
                    <ul class="flex flex-col gap-1.5 font-body-md text-xs sm:text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Ballrooms &amp; Estate Venues</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Traditional Poruwa Designers</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Kandyan Bridal &amp; Groom Attire</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Island Photographers</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Private Concierge</span>
                    <p class="font-body-sm text-xs text-on-surface-variant">Bespoke assistance for island estate bookings and heritage rituals.</p>
                    <div class="flex flex-col gap-1 font-title-sm text-xs text-primary">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">call</span>
                            <span>+94 (11) 782 9900</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                            <span>concierge@wedora.lk</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-outline-variant/20 text-center sm:text-left">
                <span class="font-label-caps text-[10px] text-on-surface-variant">© {{ date('Y') }} Wedora Technologies Pvt Ltd. All rights reserved.</span>
                <div class="flex items-center gap-4 font-label-caps text-[10px] text-on-surface-variant">
                    <a class="hover:text-on-surface transition-colors" href="#">Privacy</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Terms</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Cultural Guidelines</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Modals -->
    <!-- Modal 1: Lead Ritual Brief Modal -->
    <div id="brief-modal" class="fixed inset-0 z-50 bg-black/70 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl flex flex-col gap-3.5 border border-surface-container max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-surface-container pb-2.5">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[22px]">assignment</span>
                    <h3 class="font-headline-sm text-base sm:text-xl text-on-surface font-semibold" id="brief-modal-title">Nuptial Brief</h3>
                </div>
                <button onclick="closeModal('brief-modal')" class="text-on-surface-variant hover:text-on-surface font-bold text-2xl p-1 leading-none">&times;</button>
            </div>
            
            <div class="flex flex-col gap-3 text-xs sm:text-body-sm" id="brief-modal-content">
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/15 flex flex-col gap-1">
                    <span class="font-label-caps text-[9px] uppercase text-primary font-bold">Venue &amp; Schedule</span>
                    <p class="font-bold text-on-surface">Cinnamon Grand Colombo (Oak Room)</p>
                    <p class="text-on-surface-variant">Date: December 18, 2025 • Poruwa Nekath: 09:42 AM</p>
                </div>
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/15 flex flex-col gap-1">
                    <span class="font-label-caps text-[9px] uppercase text-primary font-bold">Requested Package</span>
                    <p class="font-bold text-on-surface">The Royal Sovereign Experience (LKR 460,000)</p>
                    <p class="text-on-surface-variant">3 Lead Photographers, 2 Cinema Directors, 4K Drone, 2 Leather Albums, Galle Pre-shoot.</p>
                </div>
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/15 flex flex-col gap-1">
                    <span class="font-label-caps text-[9px] uppercase text-primary font-bold">Auspicious Instructions</span>
                    <p class="text-on-surface italic">"Trained specifically to shoot without stepping inside the consecrated Poruwa perimeter or disrupting the Ashtaka reciter's sacred verses."</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-surface-container">
                <button onclick="closeModal('brief-modal')" class="px-4 py-2 rounded-xl bg-surface-container-low text-on-surface font-title-sm text-xs font-semibold">
                    Close
                </button>
                <button onclick="showToast('Briefing PDF exported.'); closeModal('brief-modal');" class="px-4 py-2 rounded-xl bg-on-background text-surface font-title-sm text-xs font-semibold shadow-sm">
                    Print / Export Brief
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Sync Calendar Modal -->
    <div id="sync-modal" class="fixed inset-0 z-50 bg-black/70 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-surface-container-lowest rounded-2xl max-w-md w-full p-5 sm:p-6 shadow-2xl flex flex-col gap-3.5 border border-surface-container">
            <div class="flex items-center justify-between border-b border-surface-container pb-2.5">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[22px]">sync</span>
                    <h3 class="font-headline-sm text-base sm:text-xl text-on-surface font-semibold">Calendar Sync (iCal / Google)</h3>
                </div>
                <button onclick="closeModal('sync-modal')" class="text-on-surface-variant hover:text-on-surface font-bold text-2xl p-1 leading-none">&times;</button>
            </div>
            
            <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                Connect your studio booking timeline with Google Calendar, Apple iCal, or Outlook to automatically avoid double-booking on peak Nekath dates.
            </p>

            <div class="flex flex-col gap-2">
                <button onclick="showToast('Google Calendar sync connected.'); closeModal('sync-modal');" class="w-full py-2.5 px-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-xs font-semibold flex items-center justify-center gap-2 border border-outline-variant/20 transition-colors">
                    <span class="material-symbols-outlined text-[18px] text-primary">event</span>
                    <span>Sync with Google Calendar</span>
                </button>
                <button onclick="showToast('iCal subscription link copied to clipboard.'); closeModal('sync-modal');" class="w-full py-2.5 px-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-xs font-semibold flex items-center justify-center gap-2 border border-outline-variant/20 transition-colors">
                    <span class="material-symbols-outlined text-[18px] text-secondary">calendar_month</span>
                    <span>Copy iCal (.ics) Feed Link</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 3: Custom RFQ Modal -->
    <div id="custom-rfq-modal" class="fixed inset-0 z-50 bg-black/70 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl flex flex-col gap-3.5 border border-surface-container">
            <div class="flex items-center justify-between border-b border-surface-container pb-2.5">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[22px]">add_circle</span>
                    <h3 class="font-headline-sm text-base sm:text-xl text-on-surface font-semibold">Dispatch Custom RFQ / Quote</h3>
                </div>
                <button onclick="closeModal('custom-rfq-modal')" class="text-on-surface-variant hover:text-on-surface font-bold text-2xl p-1 leading-none">&times;</button>
            </div>
            
            <form onsubmit="event.preventDefault(); showToast('Custom quote dispatched to couple via WhatsApp & email.'); closeModal('custom-rfq-modal');" class="flex flex-col gap-3 text-xs sm:text-body-sm">
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Couple Name</label>
                    <input type="text" placeholder="e.g. Ruwan & Anuki" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs focus:outline-none border border-outline-variant/30" required value="Sahan & Dilki Nuptials">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Nuptial Date</label>
                        <input type="date" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs focus:outline-none border border-outline-variant/30" value="2026-03-12" required>
                    </div>
                    <div>
                        <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Quote Value (LKR)</label>
                        <input type="number" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs focus:outline-none border border-outline-variant/30" value="520000" required>
                    </div>
                </div>
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Special Ceremonial Scope</label>
                    <textarea rows="2" class="w-full mt-1 p-2.5 rounded-xl bg-surface-container-low text-on-surface text-xs focus:outline-none resize-none border border-outline-variant/30" placeholder="Scope notes, Nekath times, albums..."></textarea>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs font-semibold shadow-md flex items-center justify-center gap-2 mt-1">
                    <span class="material-symbols-outlined text-[17px] text-primary-fixed">send</span>
                    <span>Send Custom Quotation (RFQ)</span>
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript Handlers -->
    <script>
        // Pipeline filtering
        function filterPipeline(filterType) {
            const tabs = ['active', 'awaiting', 'booked'];
            tabs.forEach(t => {
                const btn = document.getElementById('pipeline-tab-' + t);
                if (btn) {
                    if (t === filterType) {
                        btn.classList.add('bg-surface-container-lowest', 'text-primary', 'shadow-xs', 'font-semibold');
                        btn.classList.remove('text-on-surface-variant');
                    } else {
                        btn.classList.remove('bg-surface-container-lowest', 'text-primary', 'shadow-xs', 'font-semibold');
                        btn.classList.add('text-on-surface-variant');
                    }
                }
            });

            const cards = document.querySelectorAll('.lead-item');
            cards.forEach(card => {
                const categories = card.getAttribute('data-category') || '';
                if (filterType === 'active' || categories.includes(filterType)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Modal Helpers
        function openBriefModal(couple) {
            document.getElementById('brief-modal-title').textContent = 'Nuptial Brief • ' + couple;
            const modal = document.getElementById('brief-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openSyncCalendarModal() {
            const modal = document.getElementById('sync-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openCustomRfqModal() {
            const modal = document.getElementById('custom-rfq-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Quick Actions
        function sendContractReminder(couple) {
            showToast('Digitally signed SLA reminder dispatched to ' + couple + ' via WhatsApp & SMS.');
        }

        function scheduleDiscoveryCall(couple) {
            showToast('Google Meet invitation scheduled for ' + couple + '.');
        }

        function sendTailoredQuote(couple, amount) {
            showToast('Custom quotation of LKR ' + Number(amount).toLocaleString() + ' dispatched to ' + couple + '.');
        }

        function modifyQuotation(couple) {
            openCustomRfqModal();
        }

        function extendHold(couple) {
            showToast('Date reservation for ' + couple + ' extended by 48 hours.');
        }

        // Toast Helper
        function showToast(message, type = 'info') {
            const toast = document.getElementById('dynamic-toast');
            const msgEl = document.getElementById('toast-message');
            const iconEl = document.getElementById('toast-icon');

            msgEl.textContent = message;
            if (type === 'error') {
                iconEl.textContent = 'error';
                iconEl.classList.remove('text-primary-fixed');
                iconEl.classList.add('text-error');
            } else {
                iconEl.textContent = 'check_circle';
                iconEl.classList.add('text-primary-fixed');
                iconEl.classList.remove('text-error');
            }

            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 4500);
        }

        // Close modal on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('brief-modal');
                closeModal('sync-modal');
                closeModal('custom-rfq-modal');
            }
        });
    </script>
</body>
</html>
