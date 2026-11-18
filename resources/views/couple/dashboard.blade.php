<x-workspace-layout>
    <x-slot:title>{{ $wedding->title ?: ($wedding->partner1_name . ' & ' . $wedding->partner2_name . "'s Wedding") }} — Nuptial Planning Dashboard | Wedora</x-slot:title>

    <!-- Custom Print Styling for Auspicious Pocket Card & PDF Export -->
    <style>
        @media print {
            header, nav, footer, .no-print, #open-invite-modal, #export-itinerary-btn, #add-task-btn, #sync-vendors-btn, #print-pocket-btn, #manage-access-btn, #toast, .checklist-tab {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #1b1c1a !important;
            }
            .print-container {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-break {
                page-break-before: always;
            }
            .shadow-sm, .shadow-md, .shadow-2xl {
                box-shadow: none !important;
            }
            .border {
                border-color: #e2c08d !important;
            }
        }
    </style>

    <div class="relative w-full pb-16 print-container">
        <!-- Top Editorial Header & Couple Milestones Banner -->
        <section class="relative w-full rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-md overflow-hidden p-5 sm:p-8 md:p-10 mb-8 transition-all">
            <!-- Ambient Decorative Watermark Elements -->
            <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-gradient-to-br from-primary-fixed/25 to-tertiary-fixed/15 blur-3xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-20 w-64 h-64 rounded-full bg-secondary-fixed/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">
                <!-- Left: Couple Identity & Nuptial Context -->
                <div class="flex flex-col gap-2 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-label-caps text-[10px] uppercase tracking-wider font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                            Poruwa &amp; Reception Workspace
                        </span>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-title-sm text-xs font-semibold shadow-sm">
                            <span class="material-symbols-outlined text-[15px] text-primary" style="font-variation-settings: 'FILL' 1;">hourglass_top</span>
                            <span>{{ max(0, $daysRemaining) }} Days to the Big Day!</span>
                        </div>
                    </div>

                    <h1 class="font-headline-lg text-2xl sm:text-3xl md:text-4xl text-on-surface tracking-tight font-serif mt-1">
                        {{ $wedding->title ?: ($wedding->partner1_name . ' & ' . $wedding->partner2_name . "’s Wedding Celebration") }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-on-surface-variant font-body-md text-xs sm:text-sm">
                        <span class="inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[17px] text-primary">calendar_month</span>
                            {{ $weddingDate->format('F d, Y') }}
                        </span>
                        <span class="text-outline-variant">•</span>
                        <span class="inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[17px] text-primary">location_on</span>
                            {{ $wedding->location ?: 'Venue location to be finalized' }}
                        </span>
                        <span class="text-outline-variant">•</span>
                        <button type="button" onclick="openRitualModal()" class="inline-flex items-center gap-1 text-tertiary font-bold hover:underline cursor-pointer focus:outline-none">
                            <span class="material-symbols-outlined text-[17px]">verified</span>
                            Astrological Alignment Locked
                        </button>
                    </div>

                    <!-- Overall Progress Bar Gauge -->
                    <div class="w-full max-w-xl mt-3 pt-1">
                        <div class="flex items-center justify-between text-on-surface mb-1.5">
                            <span class="font-label-caps text-[11px] uppercase tracking-wider text-on-surface-variant font-semibold">Overall Nuptial Planning Progress</span>
                            <span class="font-title-sm text-xs sm:text-sm text-primary font-bold">
                                <span id="progress-percent-label">{{ $checklistProgress }}</span>% Complete 
                                <span class="font-normal text-on-surface-variant text-xs">(<span id="completed-tasks-label">{{ $completedTasks }}</span> of <span id="total-tasks-label">{{ $totalTasks }}</span> tasks)</span>
                            </span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-surface-container overflow-hidden p-0.5 border border-outline-variant/30">
                            <div id="progress-bar-fill" class="h-full rounded-full bg-gradient-to-r from-primary-container via-primary to-tertiary transition-all duration-700 ease-out" style="width: {{ min(100, max(5, $checklistProgress)) }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Right: Fast Actions -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 self-stretch xl:self-center no-print">
                    <button class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-on-background text-surface hover:bg-inverse-surface shadow-md font-title-sm text-xs sm:text-sm transition-all focus:ring-2 focus:ring-primary focus:outline-none" id="open-invite-modal" type="button">
                        <span class="material-symbols-outlined text-[18px] text-primary-fixed">person_add</span>
                        <span>Invite Partner / Planner</span>
                    </button>
                    <button class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-xs sm:text-sm transition-all shadow-sm border border-outline-variant/30 focus:ring-2 focus:ring-primary focus:outline-none" id="export-itinerary-btn" type="button">
                        <span class="material-symbols-outlined text-[18px] text-primary">picture_as_pdf</span>
                        <span>Export Itinerary</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Quick Stats Metric Row (4 Regal Metric Cards) -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Metric 1: Budget Cashflow -->
            <div class="flex flex-col justify-between p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-wider font-semibold">Total Wedding Budget</span>
                        <span class="font-title-lg text-lg sm:text-xl font-bold text-on-surface mt-1">LKR {{ number_format($totalBudget, 0) }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-primary-fixed/40 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full h-1.5 rounded-full bg-surface-container overflow-hidden mb-2">
                        <div class="h-full bg-primary rounded-full" style="width: {{ min(100, max(5, $budgetProgress)) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-on-surface-variant font-body-sm text-xs">
                        <span>Spent: <span class="font-title-sm text-on-surface font-bold">LKR {{ number_format($spentBudget, 0) }}</span> ({{ $budgetProgress }}%)</span>
                        <span class="text-tertiary font-title-sm font-bold">Rem: LKR {{ number_format($remainingBudget / 1000000, 2) }}M</span>
                    </div>
                </div>
            </div>

            <!-- Metric 2: RSVP Status -->
            <div class="flex flex-col justify-between p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-wider font-semibold">Guest RSVPs ({{ $totalGuestsInvited }} Invited)</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="font-title-lg text-lg sm:text-xl font-bold text-on-surface">{{ $attendingCount }}</span>
                            <span class="font-label-caps text-[11px] text-tertiary font-bold">{{ $confirmedRate }}% Confirmed</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-secondary-fixed/50 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">group</span>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-1.5 text-xs font-medium">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-tertiary-fixed/30 text-on-tertiary-container font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> {{ $attendingCount }} Attending
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-surface-container text-on-surface-variant">
                        {{ $pendingRsvpCount }} Pending
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-error-container/60 text-on-error-container">
                        {{ $declinedCount }} Declined
                    </span>
                </div>
            </div>

            <!-- Metric 3: Auspicious Nekath Poruwa -->
            <div class="flex flex-col justify-between p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-caps text-[10px] text-tertiary uppercase tracking-wider font-bold">Poruwa Nekath (Auspicious)</span>
                        <span class="font-headline-sm text-xl sm:text-2xl text-primary mt-1 font-serif font-bold">{{ $poruwaNekath['time'] ?? 'Pending' }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary shrink-0">
                        <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-0.5 text-xs">
                    @if($poruwaNekath)
                        <span class="text-on-surface font-semibold truncate">{{ $poruwaNekath['title'] }}</span>
                        <span class="text-on-surface-variant flex items-center gap-1 text-[11px] truncate">
                            <span class="material-symbols-outlined text-[14px] text-tertiary">workspace_premium</span>
                            {{ $poruwaNekath['astrologer'] }}
                        </span>
                    @else
                        <span class="text-on-surface-variant italic">No auspicious Nekath added yet</span>
                        <span class="text-primary text-[11px] font-semibold">Synchronize with astrologer</span>
                    @endif
                </div>
            </div>

            <!-- Metric 4: Urgent Milestone -->
            <div class="flex flex-col justify-between p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-caps text-[10px] text-error uppercase tracking-wider font-bold">Pending Milestone</span>
                        <span class="font-title-md text-base sm:text-lg font-bold text-on-surface mt-1 line-clamp-1">{{ $urgentMilestone['title'] ?? 'All Caught Up!' }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-error-container/60 flex items-center justify-center text-error shrink-0">
                        <span class="material-symbols-outlined text-[22px]">alarm</span>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-xs">
                    @if($urgentMilestone)
                        <span class="inline-flex items-center gap-1 text-on-surface font-medium">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            {{ $urgentMilestone['due_in'] }}
                        </span>
                        <span class="font-label-caps text-[10px] uppercase px-2 py-0.5 rounded bg-error-container text-on-error-container font-bold">
                            {{ $urgentMilestone['priority'] }}
                        </span>
                    @else
                        <span class="text-tertiary font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">check_circle</span>
                            No urgent deadlines
                        </span>
                    @endif
                </div>
            </div>
        </section>

        <!-- Two-Column Workspace Layout (Desktop 7:5 split) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: Interactive Checklist & Milestones (7 of 12 cols = ~58%) -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <!-- Checklist Panel Card -->
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-5 sm:p-6 md:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-2 border-b border-outline-variant/20">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif">Planning Checklist &amp; Milestones</h3>
                                <span id="task-badge-count" class="px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[11px] font-semibold">{{ count($tasksList) }} Tasks</span>
                            </div>
                            <p class="font-body-sm text-xs text-on-surface-variant mt-0.5">Track Poruwa rituals, catering arrangements, and vendor advances.</p>
                        </div>
                        <button class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-surface-container hover:bg-primary-fixed text-on-surface font-title-sm text-xs font-semibold transition-colors self-start sm:self-auto border border-outline-variant/30 no-print" id="add-task-btn" type="button" onclick="openAddTaskModal()">
                            <span class="material-symbols-outlined text-[18px] text-primary">add_circle</span>
                            <span>+ Add Custom Task</span>
                        </button>
                    </div>

                    <!-- Category Filter Tabs -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 text-nowrap scrollbar-none no-print">
                        <button class="checklist-tab active px-3.5 py-1.5 rounded-full bg-on-background text-surface font-title-sm text-xs font-medium transition-all" data-category="all">
                            All Milestones (<span id="all-tab-count">{{ count($tasksList) }}</span>)
                        </button>
                        <button class="checklist-tab px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface-variant hover:text-on-surface font-title-sm text-xs font-medium transition-all" data-category="ceremony">
                            Ceremony &amp; Poruwa
                        </button>
                        <button class="checklist-tab px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface-variant hover:text-on-surface font-title-sm text-xs font-medium transition-all" data-category="catering">
                            Reception &amp; Catering
                        </button>
                        <button class="checklist-tab px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface-variant hover:text-on-surface font-title-sm text-xs font-medium transition-all" data-category="attire">
                            Attire &amp; Jewelry
                        </button>
                        <button class="checklist-tab px-3.5 py-1.5 rounded-full bg-surface-container text-on-surface-variant hover:text-on-surface font-title-sm text-xs font-medium transition-all" data-category="vendors">
                            Vendors &amp; Media
                        </button>
                    </div>

                    <!-- Tasks List -->
                    <div class="flex flex-col gap-3" id="tasks-container">
                        @forelse($tasksList as $task)
                            @php
                                $isCompleted = ($task->status->value ?? $task->status) === 'completed';
                                $taskCategorySlug = $task->category?->slug ?? 'ceremony';
                            @endphp
                            <div class="task-card flex items-start gap-3.5 p-4 rounded-xl border border-outline-variant/20 {{ $isCompleted ? 'bg-surface-container-low' : 'bg-surface-container-lowest shadow-sm hover:shadow-md' }} transition-all" data-category="{{ $taskCategorySlug }}">
                                <input {{ $isCompleted ? 'checked' : '' }} class="task-checkbox mt-1 w-5 h-5 rounded text-primary focus:ring-primary-container cursor-pointer accent-primary shrink-0" type="checkbox"/>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <h4 class="task-title font-title-sm text-xs sm:text-sm font-semibold text-on-surface {{ $isCompleted ? 'line-through text-on-surface-variant font-normal' : '' }}">
                                            {{ $task->title }}
                                        </h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-label-caps {{ $isCompleted ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-secondary-fixed text-on-secondary-fixed font-semibold' }}">
                                            {{ $isCompleted ? 'Completed' : ucfirst($task->priority->value ?? 'Pending') }}
                                        </span>
                                    </div>
                                    @if($task->description)
                                        <p class="font-body-sm text-xs text-on-surface-variant mt-1">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-2 flex-wrap text-xs text-on-surface-variant">
                                        <span class="flex items-center gap-1 font-medium">
                                            <span class="material-symbols-outlined text-[15px] {{ $isCompleted ? 'text-tertiary' : 'text-primary' }}">
                                                {{ $isCompleted ? 'check_circle' : 'schedule' }}
                                            </span>
                                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'Ongoing' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[15px]">sell</span>
                                            {{ $task->category?->name ?? 'General Planning' }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <span>Assigned: {{ $task->assignedTo?->name ?? ($wedding->partner1_name ?: 'Workspace Lead') }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-surface-container-low rounded-xl border border-outline-variant/20">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">checklist</span>
                                <h4 class="font-title-sm text-sm font-bold text-on-surface">No tasks added yet</h4>
                                <p class="text-xs text-on-surface-variant mt-1">Create your first nuptial milestone to track progress.</p>
                                <button onclick="openAddTaskModal()" class="mt-3 px-4 py-1.5 rounded-lg bg-primary text-on-primary text-xs font-semibold">
                                    + Add First Task
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <!-- Cultural Protocol Verification banner -->
                    <div class="mt-6 pt-4 bg-surface-container-low rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 border border-outline-variant/30 hover:bg-surface-container transition-colors cursor-pointer" onclick="openRitualModal()">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-primary-fixed/60 flex items-center justify-center text-primary shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[24px]">verified_user</span>
                            </div>
                            <div>
                                <h5 class="font-title-sm text-xs sm:text-sm font-bold text-on-surface">Cultural Protocol Verification</h5>
                                <p class="font-body-sm text-xs text-on-surface-variant">All 7 traditional Poruwa customs vetted for auspicious adherence.</p>
                            </div>
                        </div>
                        <button type="button" class="font-title-sm text-xs text-primary font-bold hover:text-primary-container flex items-center gap-1 text-nowrap focus:outline-none">
                            <span>View ritual compliance</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Confirmed Reception Venue Spotlight Card -->
                <div class="w-full rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm p-5 sm:p-6 flex flex-col sm:flex-row items-center gap-5">
                    <div class="w-full sm:w-44 h-32 rounded-xl bg-surface-container flex items-center justify-center text-primary shrink-0 shadow-sm overflow-hidden">
                        <span class="material-symbols-outlined text-5xl text-primary/40">domain</span>
                    </div>
                    <div class="flex-1 flex flex-col gap-1 min-w-0">
                        <span class="font-label-caps text-[10px] text-tertiary uppercase font-bold tracking-wider">Confirmed Reception Venue</span>
                        <h4 class="font-headline-sm text-base sm:text-lg font-bold text-on-surface font-serif">
                            {{ $wedding->location ?: 'Reception Venue to be finalized' }}
                        </h4>
                        <p class="font-body-sm text-xs text-on-surface-variant">
                            {{ $wedding->location ? 'Venue confirmed for celebration on ' . $weddingDate->format('M d, Y') . ' in ' . ($wedding->district ?? 'Sri Lanka') . '.' : 'Explore verified banquet halls, beachfront lawns & luxury hotels.' }}
                        </p>
                    </div>
                    @if($wedding->location)
                        <button onclick="openSeatingMapModal()" class="px-3.5 py-2.5 rounded-xl bg-surface-container text-on-surface hover:bg-surface-container-high font-title-sm text-xs font-semibold text-nowrap border border-outline-variant/30 transition-colors no-print focus:ring-2 focus:ring-primary focus:outline-none" type="button">
                            View Seating Map
                        </button>
                    @else
                        <a href="{{ route('home') }}#marketplace-anchor" class="px-3.5 py-2.5 rounded-xl bg-primary text-on-primary hover:bg-primary-container font-title-sm text-xs font-semibold text-nowrap transition-colors no-print">
                            Find Venues
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Column: Auspicious Nekath Chronology (5 of 12 cols = ~42%) -->
            <div class="lg:col-span-5 flex flex-col gap-6" id="nekath-timeline">
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-5 sm:p-6 md:p-8 lg:sticky lg:top-24">
                    <!-- Header with Astrological Badge -->
                    <div class="flex items-start justify-between gap-3 mb-6 pb-3 border-b border-outline-variant/20">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-container font-label-caps text-[10px] uppercase tracking-wider mb-1 font-bold">
                                <span class="material-symbols-outlined text-[14px]">explore</span>
                                <span>Astrological Compass: East Facing</span>
                            </div>
                            <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif">Auspicious Nekath Chronology</h3>
                            <p class="font-body-sm text-xs text-on-surface-variant">Precise planetary moments orchestrated for Poruwa rituals.</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary-fixed/50 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        </div>
                    </div>

                    <!-- Chronological Interactive Timeline Container -->
                    <div class="relative pl-6 flex flex-col gap-6">
                        <!-- Continuous Gilded Connector Line -->
                        <div class="absolute left-2.5 top-3 bottom-3 w-0.5 bg-gradient-to-b from-primary via-tertiary to-outline-variant"></div>

                        @forelse($nekathTimeline as $event)
                            @php
                                $eventTime = \Carbon\Carbon::parse($event->start_time)->format('h:i A');
                                $isNekath = stripos($event->title, 'nekath') !== false || stripos($event->title, 'poruwa') !== false;
                            @endphp
                            @if($isNekath)
                                <!-- Auspicious Highlight Node -->
                                <div class="relative flex items-start gap-4 p-3 rounded-xl bg-primary-fixed/20 border border-primary/20 shadow-xs">
                                    <div class="absolute -left-6 top-3.5 w-5 h-5 rounded-full bg-primary flex items-center justify-center shadow-md">
                                        <span class="w-2 h-2 rounded-full bg-surface-container-lowest"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-title-md text-sm text-primary font-bold font-mono">{{ $eventTime }}</span>
                                            <span class="px-2 py-0.5 rounded-full bg-primary text-on-primary font-label-caps text-[10px] uppercase tracking-wide font-bold">
                                                Auspicious Nekath
                                            </span>
                                        </div>
                                        <h5 class="font-title-sm text-xs sm:text-sm text-on-surface font-bold mt-1">{{ $event->title }}</h5>
                                        @if($event->description)
                                            <p class="font-body-sm text-xs text-on-surface-variant mt-0.5">{{ $event->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Standard Timeline Node -->
                                <div class="relative flex items-start gap-3 group">
                                    <div class="absolute -left-6 top-1 w-5 h-5 rounded-full bg-surface-container-lowest flex items-center justify-center">
                                        <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-baseline justify-between gap-2">
                                            <span class="font-title-sm text-xs text-secondary font-bold font-mono">{{ $eventTime }}</span>
                                            <span class="font-label-caps text-[10px] text-on-surface-variant">{{ $event->location ?? 'Ceremony Grounds' }}</span>
                                        </div>
                                        <h5 class="font-title-sm text-xs sm:text-sm text-on-surface font-semibold mt-0.5">{{ $event->title }}</h5>
                                        @if($event->description)
                                            <p class="font-body-sm text-xs text-on-surface-variant">{{ $event->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="p-6 text-center bg-surface-container-low rounded-xl border border-outline-variant/20">
                                <span class="material-symbols-outlined text-3xl text-on-surface-variant mb-1">schedule</span>
                                <h4 class="font-title-sm text-xs font-bold text-on-surface">No timeline events scheduled</h4>
                                <p class="text-[11px] text-on-surface-variant mt-0.5">Add auspicious Nekath timings and program milestones.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Schedule Utility Buttons -->
                    <div class="mt-6 pt-4 border-t border-outline-variant/20 flex flex-col gap-2.5 no-print">
                        <button onclick="openSyncModal()" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs sm:text-sm transition-all shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" id="sync-vendors-btn" type="button">
                            <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">share</span>
                            <span>Sync with Vendor Phones via WhatsApp/SMS</span>
                        </button>
                        <div class="flex items-center justify-center gap-4 text-center mt-1 text-xs">
                            <button class="font-label-caps uppercase tracking-wider text-primary hover:text-primary-container flex items-center gap-1 font-bold focus:outline-none" id="print-pocket-btn" type="button" onclick="window.print()">
                                <span class="material-symbols-outlined text-[14px]">print</span>
                                <span>Print Laminated Pocket Card</span>
                            </button>
                            <span class="text-outline-variant">•</span>
                            <a class="font-label-caps uppercase tracking-wider text-on-surface-variant hover:text-on-surface font-semibold" href="{{ route('home') }}#nekath-preview">
                                Auspicious Calendar View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collaborators & Workspace Members Mini Widget -->
        <section class="mt-8 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-5 sm:p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-2 border-b border-outline-variant/20">
                <div>
                    <span class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">Collaborative Council</span>
                    <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif mt-0.5">Workspace Members &amp; Nuptial Advisors</h3>
                </div>
                <a href="{{ route('workspace.collaborators.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-xs font-semibold transition-colors self-start md:self-auto border border-outline-variant/30 no-print" id="manage-access-btn">
                    <span class="material-symbols-outlined text-[16px] text-primary">admin_panel_settings</span>
                    <span>Manage Permissions ({{ count($councilMembers) }})</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($councilMembers as $member)
                    @php
                        $memberName = $member->user?->name ?? 'Collaborator';
                        $memberRole = ucfirst($member->role->value ?? 'Member');
                        $isOwner = ($member->role->value ?? $member->role) === 'owner';
                        $isPartner = ($member->role->value ?? $member->role) === 'partner';
                        $isPlanner = ($member->role->value ?? $member->role) === 'planner';
                        $privilegeLabel = $isOwner ? 'Workspace Owner' : ($isPartner ? 'Co-Owner' : ($isPlanner ? 'Lead Planner' : 'Collaborator'));
                        $privilegeColor = $isOwner || $isPartner ? 'text-primary' : ($isPlanner ? 'text-tertiary' : 'text-secondary');
                        $avatarUrl = $member->user?->profile?->avatar_url;
                    @endphp
                    <div class="flex items-center gap-3 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20 hover:border-outline-variant/40 transition-colors">
                        @if($avatarUrl)
                            <img class="w-11 h-11 rounded-full object-cover ring-2 ring-primary/20 shrink-0" src="{{ $avatarUrl }}" alt="{{ $memberName }}"/>
                        @else
                            <div class="w-11 h-11 rounded-full bg-primary-fixed/40 flex items-center justify-center font-bold text-primary text-xs shrink-0 ring-2 ring-primary/20">
                                {{ strtoupper(substr($memberName, 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex flex-col min-w-0">
                            <span class="font-title-sm text-xs font-bold text-on-surface truncate">{{ $memberName }}</span>
                            <span class="font-body-sm text-xs text-on-surface-variant truncate">{{ $memberRole }}</span>
                            <span class="font-label-caps text-[10px] {{ $privilegeColor }} font-semibold mt-0.5">{{ $privilegeLabel }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 1. Interactive Modal Dialog: Invite Collaborator / Wedding Planner -->
        <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-on-background/50 backdrop-blur-sm no-print" id="invite-modal">
            <div class="relative w-full max-w-lg rounded-2xl bg-surface-container-lowest p-6 sm:p-8 shadow-2xl border border-outline-variant/30">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <span class="font-label-caps text-[10px] text-primary uppercase tracking-wider font-bold">Access Delegation</span>
                        <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif mt-1">Invite Partner or Nuptial Expert</h3>
                        <p class="font-body-sm text-xs text-on-surface-variant">Grant co-planning privileges to manage vendor budgets and Nekath timelines.</p>
                    </div>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors" id="close-invite-modal" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form class="flex flex-col gap-4" id="invite-form" method="POST" action="{{ route('workspace.collaborators.invite') }}">
                    @csrf
                    <div class="flex flex-col gap-1.5">
                        <label class="font-title-sm text-xs font-bold text-on-surface">Email Address or Sri Lankan Mobile (+94)</label>
                        <input name="email" required class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-colors" placeholder="e.g. planner@luxuryweddings.lk or partner@example.com" type="email"/>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="font-title-sm text-xs font-bold text-on-surface">Role in Nuptial Workspace</label>
                        <select name="role" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none">
                            <option value="partner">Betrothed Partner (Co-Owner)</option>
                            <option value="collaborator">Wedding Planner / Nuptial Advisor (Collaborator)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-surface-container-low text-on-surface-variant font-body-sm text-xs border border-outline-variant/20">
                        <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0">lock</span>
                        <span>Confidentiality agreement &amp; automated notification will be dispatched instantly.</span>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button class="px-4 py-2.5 rounded-xl bg-surface-container text-on-surface hover:bg-surface-container-high font-title-sm text-xs font-semibold transition-colors border border-outline-variant/30" id="cancel-invite-modal" type="button">
                            Cancel
                        </button>
                        <button class="px-5 py-2.5 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs font-semibold transition-colors shadow-md" type="submit">
                            Dispatch Invitation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. Interactive Modal: Add Custom Task -->
        <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-on-background/50 backdrop-blur-sm no-print" id="add-task-modal">
            <div class="relative w-full max-w-lg rounded-2xl bg-surface-container-lowest p-6 sm:p-8 shadow-2xl border border-outline-variant/30">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <span class="font-label-caps text-[10px] text-primary uppercase tracking-wider font-bold">Checklist Customization</span>
                        <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif mt-1">Create Nuptial Milestone</h3>
                        <p class="font-body-sm text-xs text-on-surface-variant">Add a bespoke traditional ritual, vendor payment, or rehearsal task.</p>
                    </div>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors" onclick="closeAddTaskModal()" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form class="flex flex-col gap-4" id="custom-task-form">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-title-sm text-xs font-bold text-on-surface">Milestone Title</label>
                        <input id="new-task-title" required class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-colors" placeholder="e.g. Order Traditional Bulath Hurulu & Shehnai Flutists" type="text"/>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-title-sm text-xs font-bold text-on-surface">Category</label>
                            <select id="new-task-category" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none">
                                <option value="ceremony">Ceremony &amp; Poruwa</option>
                                <option value="catering">Reception &amp; Catering</option>
                                <option value="attire">Attire &amp; Jewelry</option>
                                <option value="vendors">Vendors &amp; Media</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="font-title-sm text-xs font-bold text-on-surface">Target Date</label>
                            <input id="new-task-date" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none" type="date" value="{{ date('Y-m-d', strtotime('+7 days')) }}"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-title-sm text-xs font-bold text-on-surface">Priority</label>
                            <select id="new-task-priority" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none">
                                <option value="high">High Priority</option>
                                <option value="normal">Normal Priority</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="font-title-sm text-xs font-bold text-on-surface">Assignee</label>
                            <select id="new-task-assignee" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-md text-xs sm:text-sm border border-outline-variant/30 focus:bg-surface-container-lowest focus:border-primary focus:outline-none">
                                @forelse($wedding->members as $m)
                                    <option value="{{ $m->user?->name }}">{{ $m->user?->name }} ({{ ucfirst($m->role->value ?? 'Member') }})</option>
                                @empty
                                    <option value="{{ $wedding->partner1_name ?: 'Partner 1' }}">{{ $wedding->partner1_name ?: 'Partner 1' }}</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button class="px-4 py-2.5 rounded-xl bg-surface-container text-on-surface hover:bg-surface-container-high font-title-sm text-xs font-semibold transition-colors border border-outline-variant/30" onclick="closeAddTaskModal()" type="button">
                            Cancel
                        </button>
                        <button class="px-5 py-2.5 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs font-semibold transition-colors shadow-md" type="submit">
                            Save Milestone
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. Interactive Modal: Cultural Protocol Verification Details -->
        <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-on-background/50 backdrop-blur-sm no-print" id="ritual-modal">
            <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-surface-container-lowest p-6 sm:p-8 shadow-2xl border border-outline-variant/30">
                <div class="flex items-start justify-between mb-5 sticky top-0 bg-surface-container-lowest pb-3 border-b border-outline-variant/20 z-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-container font-label-caps text-[10px] uppercase font-bold tracking-wider mb-1">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            <span>Sri Lankan Heritage Protocol</span>
                        </div>
                        <h3 class="font-headline-sm text-xl font-bold text-on-surface font-serif">The 7 Auspicious Poruwa Customs</h3>
                        <p class="font-body-sm text-xs text-on-surface-variant">Validated by Astrologer K. Dharmaratne for East-facing planetary alignment.</p>
                    </div>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors" onclick="closeRitualModal()" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">1</span>
                            Mangala Ashtaka Chanting &amp; Poruwa Ascent (09:42 AM)
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            Ascent onto the Poruwa with right foot first facing East amidst the sacred blow of the Hakgediya (conch shell) and Mangala Bera drums.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">2</span>
                            Thambula &amp; Bulath Hurulu Offering
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            Offering of sheaves of betel leaves to the seven generations of maternal and paternal ancestors (Hath Muthu Parapura) seeking ancestral blessings.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">3</span>
                            Nuool Bandima &amp; Gold Ring Exchange (09:55 AM)
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            Binding of the couple’s right little fingers with consecrated gold pirith thread, symbolizing eternal spiritual communion.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">4</span>
                            Water Pouring from the Kendiya (10:08 AM)
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            The bride’s maternal uncle pours consecrated water from an ornate brass Kendiya over the bound fingers onto a silver vessel.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">5</span>
                            Jayamangala Gatha Youth Choir
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            A chorus of young maidens clad in traditional half-sarees chant the 8 sacred stanzas of the Jayamangala Gatha.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">6</span>
                            Descent &amp; Coconut Splitting (Pol Gahuwa - 10:20 AM)
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            As the couple steps down from the Poruwa, a fresh coconut is cleaved with a single stroke of a machete to ward off malevolent evil eyes (Asvaha/Katavaha).
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-2 font-bold text-on-surface text-sm mb-1">
                            <span class="w-6 h-6 rounded-full bg-primary-fixed text-primary flex items-center justify-center text-xs">7</span>
                            Lighting of the 108-Wick Brass Oil Lamp (10:45 AM)
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            Parents and newlywed couple illuminate the monumental brass lamp to invoke prosperity and harmony throughout the new matrimonial home.
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-3 flex justify-end border-t border-outline-variant/20">
                    <button class="px-5 py-2.5 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs font-semibold shadow-md" onclick="closeRitualModal()" type="button">
                        Acknowledge &amp; Close
                    </button>
                </div>
            </div>
        </div>

        <!-- 4. Interactive Modal: Cinnamon Grand Oak Room Seating Map -->
        <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-on-background/50 backdrop-blur-sm no-print" id="seating-modal">
            <div class="relative w-full max-w-2xl rounded-2xl bg-surface-container-lowest p-6 sm:p-8 shadow-2xl border border-outline-variant/30">
                <div class="flex items-start justify-between mb-4 pb-2 border-b border-outline-variant/20">
                    <div>
                        <span class="font-label-caps text-[10px] text-tertiary uppercase font-bold tracking-wider">Ballroom Layout &amp; Table Allocation</span>
                        <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif mt-0.5">{{ $wedding->location ?: ($wedding->title . ' Floor Plan') }}</h3>
                        <p class="font-body-sm text-xs text-on-surface-variant">Capacity: {{ $totalGuestsInvited }} Guests • {{ $attendingCount }} Confirmed RSVPs</p>
                    </div>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors" onclick="closeSeatingMapModal()" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Schematic Floor Plan Graphic -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col gap-3">
                    <div class="flex items-center justify-center p-3 rounded-lg bg-primary-fixed/30 border border-primary/20 text-center">
                        <span class="font-bold text-xs text-primary font-serif">🌸 Poruwa Mandapaya (East Facing Elevation) &amp; Traditional Magul Bera Troupe</span>
                    </div>

                    <div class="flex items-center justify-center p-2 rounded-lg bg-tertiary-fixed/30 border border-tertiary/20 text-center">
                        <span class="font-bold text-xs text-on-tertiary-container">👑 Table 00: Bridal Head Table (Bride, Groom, Best Man, Maid of Honour)</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 my-2">
                        <div class="p-2.5 rounded-lg bg-surface-container-lowest border border-primary/40 text-center">
                            <span class="text-[10px] uppercase font-bold text-primary block">Table 01</span>
                            <span class="font-bold text-xs text-on-surface">Groom’s Family</span>
                            <span class="text-[10px] text-on-surface-variant block mt-0.5">10 Confirmed</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-surface-container-lowest border border-primary/40 text-center">
                            <span class="text-[10px] uppercase font-bold text-primary block">Table 02</span>
                            <span class="font-bold text-xs text-on-surface">Bride’s Family</span>
                            <span class="text-[10px] text-on-surface-variant block mt-0.5">10 Confirmed</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-center">
                            <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Table 03–12</span>
                            <span class="font-bold text-xs text-on-surface">Paternal Kin</span>
                            <span class="text-[10px] text-on-surface-variant block mt-0.5">80 Confirmed</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-center">
                            <span class="text-[10px] uppercase font-bold text-on-surface-variant block">Table 13–24</span>
                            <span class="font-bold text-xs text-on-surface">Friends &amp; Peers</span>
                            <span class="text-[10px] text-on-surface-variant block mt-0.5">96 Confirmed</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-on-surface-variant px-1 pt-1">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            Grand Foyer &amp; Champagne Fountain
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                            5-Tier Wedding Cake Display
                        </span>
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between gap-3 pt-2">
                    <span class="text-xs text-on-surface-variant">Floor plan lock deadline: Jan 10, 2025</span>
                    <button class="px-5 py-2.5 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-xs font-semibold shadow-md" onclick="closeSeatingMapModal()" type="button">
                        Done
                    </button>
                </div>
            </div>
        </div>

        <!-- 5. Interactive Modal: WhatsApp & SMS Vendor Schedule Broadcast -->
        <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-on-background/50 backdrop-blur-sm no-print" id="sync-modal">
            <div class="relative w-full max-w-lg rounded-2xl bg-surface-container-lowest p-6 sm:p-8 shadow-2xl border border-outline-variant/30">
                <div class="flex items-start justify-between mb-4 pb-2 border-b border-outline-variant/20">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-container font-label-caps text-[10px] uppercase font-bold tracking-wider mb-1">
                            <span class="material-symbols-outlined text-[14px]">share</span>
                            <span>WhatsApp / SMS Broadcast</span>
                        </div>
                        <h3 class="font-headline-sm text-lg sm:text-xl font-bold text-on-surface font-serif mt-0.5">Vendor Nekath Schedule</h3>
                        <p class="font-body-sm text-xs text-on-surface-variant">Instant schedule broadcast for photographers, florists, and catering teams.</p>
                    </div>
                    <button class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors" onclick="closeSyncModal()" type="button">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="flex flex-col gap-3">
                    <label class="text-xs font-bold text-on-surface">Message Preview:</label>
                    <textarea readonly id="whatsapp-message-text" rows="8" class="w-full p-3 rounded-xl bg-surface-container-low text-on-surface font-mono text-xs border border-outline-variant/30 focus:outline-none resize-none leading-relaxed">🌸 {{ strtoupper(($wedding->partner1_name && $wedding->partner2_name) ? ($wedding->partner1_name . ' & ' . $wedding->partner2_name) : $wedding->title) }} — OFFICIAL NEKATH SCHEDULE 🌸
Date: {{ $weddingDate->format('F d, Y') }}
Venue: {{ $wedding->location ?: 'To be announced' }}

@forelse($nekathTimeline as $evt)
• {{ \Carbon\Carbon::parse($evt->start_time)->format('h:i A') }} — {{ $evt->title }}
@empty
• Sacred schedule and timings will be announced soon.
@endforelse

Please ensure all vendor crews arrive 30 minutes prior to scheduled events.</textarea>
                </div>

                <div class="mt-5 flex items-center justify-end gap-3 pt-2">
                    <button class="px-4 py-2.5 rounded-xl bg-surface-container text-on-surface hover:bg-surface-container-high font-title-sm text-xs font-semibold transition-colors border border-outline-variant/30" onclick="copyScheduleToClipboard()" type="button">
                        📋 Copy Schedule
                    </button>
                    <button class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-title-sm text-xs font-semibold transition-colors shadow-md flex items-center gap-1.5" onclick="shareToWhatsApp()" type="button">
                        <span>Share to WhatsApp</span>
                        <span class="material-symbols-outlined text-[16px]">send</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Toast Element -->
        <div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-2.5 px-4 py-3 rounded-xl bg-on-background text-surface shadow-2xl font-title-sm text-xs sm:text-sm" id="toast">
            <span class="material-symbols-outlined text-[20px] text-primary-fixed" id="toast-icon">check_circle</span>
            <span id="toast-msg">Task updated successfully!</span>
        </div>
    </div>

    <!-- Client-side Interactions Script -->
    <script>
        (function initDashboard() {
            // Global modal controls
            window.openAddTaskModal = function() {
                const m = document.getElementById('add-task-modal');
                if (m) m.classList.remove('hidden');
            };
            window.closeAddTaskModal = function() {
                const m = document.getElementById('add-task-modal');
                if (m) m.classList.add('hidden');
            };

            window.openRitualModal = function() {
                const m = document.getElementById('ritual-modal');
                if (m) m.classList.remove('hidden');
            };
            window.closeRitualModal = function() {
                const m = document.getElementById('ritual-modal');
                if (m) m.classList.add('hidden');
            };

            window.openSeatingMapModal = function() {
                const m = document.getElementById('seating-modal');
                if (m) m.classList.remove('hidden');
            };
            window.closeSeatingMapModal = function() {
                const m = document.getElementById('seating-modal');
                if (m) m.classList.add('hidden');
            };

            window.openSyncModal = function() {
                const m = document.getElementById('sync-modal');
                if (m) m.classList.remove('hidden');
            };
            window.closeSyncModal = function() {
                const m = document.getElementById('sync-modal');
                if (m) m.classList.add('hidden');
            };

            window.copyScheduleToClipboard = function() {
                const text = document.getElementById('whatsapp-message-text').value;
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Ceremonial Nekath schedule copied to clipboard!');
                    closeSyncModal();
                });
            };

            window.shareToWhatsApp = function() {
                const text = encodeURIComponent(document.getElementById('whatsapp-message-text').value);
                window.open('https://wa.me/?text=' + text, '_blank');
                closeSyncModal();
            };

            // Recalculate tasks and dynamic progress bar
            function refreshTaskProgress() {
                const allCheckboxes = document.querySelectorAll('.task-card input[type="checkbox"]');
                const checkedBoxes = document.querySelectorAll('.task-card input[type="checkbox"]:checked');
                const total = Math.max(1, allCheckboxes.length);
                const completed = checkedBoxes.length;
                const percentage = Math.round((completed / total) * 100);

                const progressBar = document.getElementById('progress-bar-fill');
                const percentLabel = document.getElementById('progress-percent-label');
                const completedLabel = document.getElementById('completed-tasks-label');
                const totalLabel = document.getElementById('total-tasks-label');
                const badgeCount = document.getElementById('task-badge-count');
                const allTabCount = document.getElementById('all-tab-count');

                if (progressBar) progressBar.style.width = Math.min(100, Math.max(5, percentage)) + '%';
                if (percentLabel) percentLabel.textContent = percentage;
                if (completedLabel) completedLabel.textContent = completed;
                if (totalLabel) totalLabel.textContent = total;
                if (badgeCount) badgeCount.textContent = total + ' Tasks';
                if (allTabCount) allTabCount.textContent = total;
            }

            // Tab filtering for checklist items
            const tabs = document.querySelectorAll('.checklist-tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('bg-on-background', 'text-surface');
                        t.classList.add('bg-surface-container', 'text-on-surface-variant');
                    });
                    tab.classList.remove('bg-surface-container', 'text-on-surface-variant');
                    tab.classList.add('bg-on-background', 'text-surface');

                    const cat = tab.getAttribute('data-category');
                    const cards = document.querySelectorAll('.task-card');
                    cards.forEach(task => {
                        if (cat === 'all' || task.getAttribute('data-category') === cat) {
                            task.style.display = 'flex';
                        } else {
                            task.style.display = 'none';
                        }
                    });
                });
            });

            // Checkbox toggling behavior
            function bindCheckboxEvents() {
                const checkboxes = document.querySelectorAll('.task-card input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    cb.onchange = (e) => {
                        const card = e.target.closest('.task-card');
                        const heading = card.querySelector('.task-title');
                        if (e.target.checked) {
                            heading.classList.add('line-through', 'text-on-surface-variant', 'font-normal');
                            heading.classList.remove('font-semibold');
                            card.classList.add('bg-surface-container-low');
                            card.classList.remove('bg-surface-container-lowest', 'shadow-sm', 'hover:shadow-md');
                            showToast('Milestone flagged as completed');
                        } else {
                            heading.classList.remove('line-through', 'text-on-surface-variant', 'font-normal');
                            heading.classList.add('font-semibold');
                            card.classList.remove('bg-surface-container-low');
                            card.classList.add('bg-surface-container-lowest', 'shadow-sm', 'hover:shadow-md');
                            showToast('Milestone moved back to in-progress');
                        }
                        refreshTaskProgress();
                    };
                });
            }
            bindCheckboxEvents();

            // Custom task form submission
            const taskForm = document.getElementById('custom-task-form');
            if (taskForm) {
                taskForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const title = document.getElementById('new-task-title').value.trim();
                    const category = document.getElementById('new-task-category').value;
                    const dateVal = document.getElementById('new-task-date').value;
                    const priority = document.getElementById('new-task-priority').value;
                    const assignee = document.getElementById('new-task-assignee').value;

                    if (!title) return;

                    const categoryLabels = {
                        'ceremony': 'Ceremony & Rituals',
                        'catering': 'Reception & Catering',
                        'attire': 'Attire & Jewelry',
                        'vendors': 'Vendors & Media'
                    };

                    const container = document.getElementById('tasks-container');
                    const newCard = document.createElement('div');
                    newCard.className = 'task-card flex items-start gap-3.5 p-4 rounded-xl border border-outline-variant/20 bg-surface-container-lowest shadow-sm hover:shadow-md transition-all';
                    newCard.setAttribute('data-category', category);

                    newCard.innerHTML = `
                        <input class="task-checkbox mt-1 w-5 h-5 rounded text-primary focus:ring-primary-container cursor-pointer accent-primary shrink-0" type="checkbox"/>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <h4 class="task-title font-title-sm text-xs sm:text-sm font-semibold text-on-surface">
                                    ${escapeHtml(title)}
                                </h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-label-caps ${priority === 'urgent' ? 'bg-error-container text-on-error-container font-bold' : (priority === 'high' ? 'bg-amber-100 text-amber-900 font-bold' : 'bg-surface-container text-on-surface-variant')}">
                                    ${priority === 'urgent' ? 'Urgent' : (priority === 'high' ? 'High Priority' : 'Normal Priority')}
                                </span>
                            </div>
                            <div class="flex items-center gap-3 mt-2 flex-wrap text-xs text-on-surface-variant">
                                <span class="flex items-center gap-1 font-medium">
                                    <span class="material-symbols-outlined text-[15px] text-primary">schedule</span>
                                    Due ${dateVal || 'Soon'}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">sell</span>
                                    ${categoryLabels[category] || 'General'}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span>Assigned: ${escapeHtml(assignee)}</span>
                                </span>
                            </div>
                        </div>
                    `;

                    container.prepend(newCard);
                    bindCheckboxEvents();
                    refreshTaskProgress();
                    closeAddTaskModal();
                    taskForm.reset();
                    showToast('✨ New nuptial milestone added to your checklist!');
                });
            }

            function escapeHtml(text) {
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, m => map[m]);
            }

            // Invite Modal Controller
            const openModalBtn = document.getElementById('open-invite-modal');
            const closeModalBtn = document.getElementById('close-invite-modal');
            const cancelModalBtn = document.getElementById('cancel-invite-modal');
            const modal = document.getElementById('invite-modal');

            function toggleInviteModal(show) {
                if (!modal) return;
                if (show) modal.classList.remove('hidden');
                else modal.classList.add('hidden');
            }

            if (openModalBtn) openModalBtn.addEventListener('click', () => toggleInviteModal(true));
            if (closeModalBtn) closeModalBtn.addEventListener('click', () => toggleInviteModal(false));
            if (cancelModalBtn) cancelModalBtn.addEventListener('click', () => toggleInviteModal(false));

            // Export PDF Trigger
            const exportBtn = document.getElementById('export-itinerary-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', () => {
                    showToast('Generating ceremonial PDF itinerary...');
                    setTimeout(() => window.print(), 800);
                });
            }

            // Toast helper
            window.showToast = function(message) {
                const toast = document.getElementById('toast');
                const msg = document.getElementById('toast-msg');
                if (!toast || !msg) return;
                msg.textContent = message;
                toast.classList.remove('translate-y-24', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-24', 'opacity-0');
                }, 3200);
            };
        })();
    </script>
</x-workspace-layout>
