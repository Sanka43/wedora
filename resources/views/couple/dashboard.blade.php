<x-workspace-layout>
    <x-slot:title>{{ $wedding->title }} — Couple Workspace</x-slot:title>

    <div class="space-y-8">
        <!-- Hero Wedding Header -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#14161f] via-[#1a1712] to-[#14161f] border border-amber-500/20 p-6 sm:p-10 shadow-2xl">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-500/10 blur-[100px] rounded-full pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-semibold mb-3">
                        <span>🕊️</span> {{ $wedding->wedding_type->label() }} Celebration • {{ $wedding->district }}
                    </div>
                    <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-white tracking-tight mb-2">
                        {{ $wedding->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 flex items-center gap-2">
                        <span>📅</span> {{ $weddingDate->format('l, F j, Y') }}
                        @if($wedding->location)
                            <span class="text-amber-500/40">•</span>
                            <span>📍</span> {{ $wedding->location }}
                        @endif
                    </p>
                </div>

                <!-- Countdown Clock Card -->
                <div class="flex items-center gap-3 bg-[#0c0d12]/80 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-md self-start lg:self-auto">
                    <div class="text-center px-3 border-r border-white/10">
                        <div class="font-serif-luxury text-3xl sm:text-4xl font-bold gold-gradient-text">
                            {{ max(0, $daysRemaining) }}
                        </div>
                        <div class="text-[10px] tracking-wider uppercase text-slate-400 font-semibold mt-0.5">
                            Days to Go
                        </div>
                    </div>
                    <div class="text-xs text-slate-400 pl-2">
                        <div class="font-semibold text-white">Counting Down</div>
                        <div class="text-[11px] text-amber-300/80">Every moment planned with love</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Collaboration Spotlight Banner -->
        <div class="rounded-2xl bg-[#14161f] border border-white/10 p-6 sm:p-7 shadow-xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-white/5">
                <div>
                    <h2 class="font-serif-luxury text-xl font-bold text-white flex items-center gap-2">
                        <span>👥</span> Couple Co-Planning Hub
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Wedora is designed for two. Plan together in real-time with full transparency.
                    </p>
                </div>
                <a href="{{ route('workspace.collaborators.index') }}" class="text-xs text-[#d4af37] font-semibold hover:underline flex items-center gap-1 self-start sm:self-auto">
                    Manage Team & Permissions →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                <!-- Partner 1 (Owner) -->
                <div class="p-4 rounded-xl bg-[#0c0d12] border border-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full gold-gradient-bg text-slate-950 font-bold flex items-center justify-center text-sm shadow-md">
                            {{ substr($wedding->partner1_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white flex items-center gap-2">
                                {{ $wedding->partner1_name }}
                                <span class="text-[10px] bg-amber-500/10 text-amber-300 border border-amber-500/30 px-2 py-0.5 rounded-full font-medium">Owner</span>
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                {{ $ownerMember?->user?->email ?? 'Primary account holder' }}
                            </div>
                        </div>
                    </div>
                    <span class="text-emerald-400 text-xs flex items-center gap-1 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                    </span>
                </div>

                <!-- Partner 2 (Spouse) -->
                <div class="p-4 rounded-xl bg-[#0c0d12] border border-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 font-bold flex items-center justify-center text-sm shadow-md">
                            {{ substr($wedding->partner2_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white flex items-center gap-2">
                                {{ $wedding->partner2_name }}
                                <span class="text-[10px] bg-white/5 text-slate-300 border border-white/10 px-2 py-0.5 rounded-full font-medium">Partner</span>
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                @if($partnerMember)
                                    {{ $partnerMember->user->email }}
                                @elseif($pendingInvitesCount > 0)
                                    <span class="text-amber-400">Invitation pending acceptance</span>
                                @else
                                    <span class="text-slate-500">Not yet joined the workspace</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($partnerMember)
                        <span class="text-emerald-400 text-xs flex items-center gap-1 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                        </span>
                    @else
                        <a href="{{ route('workspace.collaborators.index') }}" class="text-xs gold-gradient-bg text-slate-950 font-bold px-3 py-1.5 rounded-lg shadow hover:brightness-110 transition">
                            Invite Partner
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Planning KPI Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Checklist Progress -->
            <div class="bg-[#14161f] border border-white/10 rounded-2xl p-5 shadow-lg">
                <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                    <span class="font-medium">Checklist Progress</span>
                    <span class="text-amber-400 font-bold">{{ $checklistProgress }}%</span>
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-white mb-2">
                    {{ $completedTasks }} <span class="text-xs font-normal text-slate-400">/ {{ $totalTasks }} Tasks</span>
                </div>
                <div class="w-full bg-[#0c0d12] rounded-full h-2 overflow-hidden border border-white/5">
                    <div class="gold-gradient-bg h-2 rounded-full transition-all duration-500" style="width: {{ $checklistProgress }}%"></div>
                </div>
            </div>

            <!-- Planned Budget -->
            <div class="bg-[#14161f] border border-white/10 rounded-2xl p-5 shadow-lg">
                <div class="text-xs text-slate-400 mb-2 font-medium">
                    Planned Budget
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-white mb-1">
                    Rs. {{ number_format($wedding->total_budget, 0) }}
                </div>
                <div class="text-[11px] text-amber-300/80">
                    Sri Lankan Rupees (LKR)
                </div>
            </div>

            <!-- Guest Count -->
            <div class="bg-[#14161f] border border-white/10 rounded-2xl p-5 shadow-lg">
                <div class="text-xs text-slate-400 mb-2 font-medium">
                    Estimated Guests
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-white mb-1">
                    {{ number_format($wedding->estimated_guest_count) }}
                </div>
                <div class="text-[11px] text-slate-400">
                    RSVP tracking ready
                </div>
            </div>

            <!-- Collaborators -->
            <div class="bg-[#14161f] border border-white/10 rounded-2xl p-5 shadow-lg">
                <div class="text-xs text-slate-400 mb-2 font-medium">
                    Collaborators & Team
                </div>
                <div class="font-serif-luxury text-2xl font-bold text-white mb-1">
                    {{ $wedding->members->count() }} <span class="text-xs font-normal text-slate-400">Members</span>
                </div>
                <div class="text-[11px] text-slate-400">
                    {{ $pendingInvitesCount }} pending invitation{{ $pendingInvitesCount === 1 ? '' : 's' }}
                </div>
            </div>
        </div>

        <!-- Planning Tasks Preview -->
        <div class="bg-[#14161f] border border-white/10 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-serif-luxury text-lg font-bold text-white">
                        Priority Planning Milestones
                    </h3>
                    <p class="text-xs text-slate-400">
                        Seeded from the Sri Lankan {{ $wedding->wedding_type->label() }} planning playbook.
                    </p>
                </div>
                <span class="text-xs text-slate-400">
                    Showing top milestones
                </span>
            </div>

            <div class="divide-y divide-white/5">
                @forelse($wedding->tasks->take(6) as $task)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-center justify-center">
                                @if($task->status->value === 'completed') ✓ @else ⏳ @endif
                            </span>
                            <div>
                                <div class="text-sm font-semibold text-white">{{ $task->title }}</div>
                                <div class="text-[11px] text-slate-400">
                                    {{ $task->category?->name ?? 'General' }}
                                    @if($task->due_date)
                                        • Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded border
                                {{ $task->priority->value === 'urgent' ? 'bg-rose-500/10 text-rose-300 border-rose-500/30' :
                                   ($task->priority->value === 'high' ? 'bg-amber-500/10 text-amber-300 border-amber-500/30' : 'bg-slate-500/10 text-slate-300 border-slate-500/30') }}">
                                {{ $task->priority->label() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-500">
                        No checklist items created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-workspace-layout>
