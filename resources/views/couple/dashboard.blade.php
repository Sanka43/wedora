<x-workspace-layout>
    <x-slot:title>{{ $wedding->title }} — Couple Workspace</x-slot:title>

    <div class="space-y-8">
        <!-- Hero Wedding Header -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-50 via-white to-amber-50 border border-[#ebd9c2] p-6 sm:p-10 shadow-xl shadow-amber-900/5">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-100/50 blur-[100px] rounded-full pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-100/70 border border-amber-300 text-[#8c6d23] text-xs font-bold mb-3 shadow-sm">
                        <span>🪷</span> {{ $wedding->wedding_type->label() }} Celebration • {{ $wedding->district }}
                    </div>
                    <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-[#241f1a] tracking-tight mb-2">
                        {{ $wedding->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-[#665c50] flex items-center gap-2 font-medium">
                        <span>📅</span> {{ $weddingDate->format('l, F j, Y') }}
                        @if($wedding->location)
                            <span class="text-[#c5a059]">•</span>
                            <span>📍</span> {{ $wedding->location }}
                        @endif
                    </p>
                </div>

                <!-- Countdown Clock Card -->
                <div class="flex items-center gap-4 bg-white border border-[#ebd9c2] rounded-2xl p-4 sm:p-5 shadow-sm self-start lg:self-auto">
                    <div class="text-center px-4 border-r border-[#ebd9c2]">
                        <div class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#8c6d23]">
                            {{ max(0, $daysRemaining) }}
                        </div>
                        <div class="text-[10px] tracking-wider uppercase text-[#736657] font-bold mt-0.5">
                            Days to Go
                        </div>
                    </div>
                    <div class="text-xs text-[#665c50] pl-1">
                        <div class="font-bold text-[#241f1a]">Auspicious Countdown</div>
                        <div class="text-[11px] text-[#8c6d23] font-medium">Every moment planned with love</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Collaboration Spotlight Banner -->
        <div class="rounded-2xl bg-white border border-[#ebd9c2] p-6 sm:p-7 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-[#ebd9c2]">
                <div>
                    <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a] flex items-center gap-2">
                        <span>👥</span> Couple Co-Planning Hub
                    </h2>
                    <p class="text-xs text-[#665c50] mt-0.5">
                        Wedora is designed for two. Plan together in real-time with full transparency.
                    </p>
                </div>
                <a href="{{ route('workspace.collaborators.index') }}" class="text-xs text-[#8c6d23] font-bold hover:underline flex items-center gap-1 self-start sm:self-auto">
                    Manage Team & Permissions →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                <!-- Partner 1 (Owner) -->
                <div class="p-4 rounded-xl bg-[#faf8f5] border border-[#ebd9c2] flex items-center justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full gold-gradient-bg text-[#1a140a] font-bold flex items-center justify-center text-sm shadow-sm border border-amber-300">
                            {{ substr($wedding->partner1_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-[#241f1a] flex items-center gap-2">
                                {{ $wedding->partner1_name }}
                                <span class="text-[10px] bg-amber-100 text-[#8c6d23] border border-amber-300 px-2 py-0.5 rounded-full font-bold">Owner</span>
                            </div>
                            <div class="text-xs text-[#736657] mt-0.5 font-medium">
                                {{ $ownerMember?->user?->email ?? 'Primary account holder' }}
                            </div>
                        </div>
                    </div>
                    <span class="text-emerald-800 text-xs flex items-center gap-1 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Active
                    </span>
                </div>

                <!-- Partner 2 (Spouse) -->
                <div class="p-4 rounded-xl bg-[#faf8f5] border border-[#ebd9c2] flex items-center justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full bg-amber-100 border border-amber-300 text-[#8c6d23] font-bold flex items-center justify-center text-sm shadow-sm">
                            {{ substr($wedding->partner2_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-[#241f1a] flex items-center gap-2">
                                {{ $wedding->partner2_name }}
                                <span class="text-[10px] bg-white text-[#736657] border border-[#ebd9c2] px-2 py-0.5 rounded-full font-bold">Partner</span>
                            </div>
                            <div class="text-xs text-[#736657] mt-0.5 font-medium">
                                @if($partnerMember)
                                    {{ $partnerMember->user->email }}
                                @elseif($pendingInvitesCount > 0)
                                    <span class="text-[#8c6d23] font-bold">Invitation pending acceptance</span>
                                @else
                                    <span class="text-[#9c9184]">Not yet joined the workspace</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($partnerMember)
                        <span class="text-emerald-800 text-xs flex items-center gap-1 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Active
                        </span>
                    @else
                        <a href="{{ route('workspace.collaborators.index') }}" class="text-xs gold-gradient-bg text-[#1a140a] font-bold px-3 py-1.5 rounded-lg shadow-sm hover:brightness-105 transition border border-amber-300">
                            Invite Partner
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Planning KPI Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Checklist Progress -->
            <div class="bg-white border border-[#ebd9c2] rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between text-xs text-[#736657] mb-2 font-bold uppercase tracking-wider">
                    <span>Checklist</span>
                    <span class="text-[#8c6d23] font-extrabold">{{ $checklistProgress }}%</span>
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-[#241f1a] mb-2">
                    {{ $completedTasks }} <span class="text-xs font-normal text-[#736657]">/ {{ $totalTasks }} Tasks</span>
                </div>
                <div class="w-full bg-[#faf8f5] rounded-full h-2 overflow-hidden border border-[#ebd9c2]">
                    <div class="gold-gradient-bg h-2 rounded-full transition-all duration-500" style="width: {{ $checklistProgress }}%"></div>
                </div>
            </div>

            <!-- Planned Budget -->
            <div class="bg-white border border-[#ebd9c2] rounded-2xl p-5 shadow-sm">
                <div class="text-xs text-[#736657] mb-2 font-bold uppercase tracking-wider">
                    Planned Budget
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-[#241f1a] mb-1">
                    Rs. {{ number_format($wedding->total_budget, 0) }}
                </div>
                <div class="text-[11px] text-[#8c6d23] font-medium">
                    Sri Lankan Rupees (LKR)
                </div>
            </div>

            <!-- Guest Count -->
            <div class="bg-white border border-[#ebd9c2] rounded-2xl p-5 shadow-sm">
                <div class="text-xs text-[#736657] mb-2 font-bold uppercase tracking-wider">
                    Estimated Guests
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-[#241f1a] mb-1">
                    {{ number_format($wedding->estimated_guest_count) }}
                </div>
                <div class="text-[11px] text-[#736657] font-medium">
                    RSVP tracking ready
                </div>
            </div>

            <!-- Collaborators -->
            <div class="bg-white border border-[#ebd9c2] rounded-2xl p-5 shadow-sm">
                <div class="text-xs text-[#736657] mb-2 font-bold uppercase tracking-wider">
                    Collaborators & Team
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-[#241f1a] mb-1">
                    {{ $wedding->members->count() }} <span class="text-xs font-normal text-[#736657]">Members</span>
                </div>
                <div class="text-[11px] text-[#736657] font-medium">
                    {{ $pendingInvitesCount }} pending invitation{{ $pendingInvitesCount === 1 ? '' : 's' }}
                </div>
            </div>
        </div>

        <!-- Planning Tasks Preview -->
        <div class="bg-white border border-[#ebd9c2] rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-serif-luxury text-lg font-bold text-[#241f1a]">
                        Priority Planning Milestones
                    </h3>
                    <p class="text-xs text-[#665c50]">
                        Seeded from the Sri Lankan {{ $wedding->wedding_type->label() }} planning playbook.
                    </p>
                </div>
                <span class="text-xs text-[#736657] font-medium">
                    Showing top milestones
                </span>
            </div>

            <div class="divide-y divide-[#ebd9c2]">
                @forelse($wedding->tasks->take(6) as $task)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-lg bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold flex items-center justify-center">
                                @if($task->status->value === 'completed') ✓ @else ⏳ @endif
                            </span>
                            <div>
                                <div class="text-sm font-bold text-[#241f1a]">{{ $task->title }}</div>
                                <div class="text-[11px] text-[#736657] font-medium">
                                    {{ $task->category?->name ?? 'General' }}
                                    @if($task->due_date)
                                        • Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border
                                {{ $task->priority->value === 'urgent' ? 'bg-rose-50 text-rose-800 border-rose-200' :
                                   ($task->priority->value === 'high' ? 'bg-amber-50 text-[#8c6d23] border-amber-300' : 'bg-[#faf8f5] text-[#52483d] border-[#ebd9c2]') }}">
                                {{ $task->priority->label() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-[#736657]">
                        No checklist items created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-workspace-layout>