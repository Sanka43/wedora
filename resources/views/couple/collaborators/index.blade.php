<x-workspace-layout>
    <x-slot:title>Partner & Team Collaboration — {{ $wedding->title }}</x-slot:title>

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-white/5">
            <div>
                <h1 class="font-serif-luxury text-3xl font-bold text-white mb-1">
                    Partner & Team Collaboration
                </h1>
                <p class="text-xs sm:text-sm text-slate-400">
                    Invite your partner, wedding planner, maid of honor, or family members to plan {{ $wedding->title }} together.
                </p>
            </div>

            <!-- Workspace Switcher if user has multiple weddings -->
            @if(isset($userWeddings) && $userWeddings->count() > 1)
                <div class="flex items-center gap-2 bg-[#14161f] border border-white/10 rounded-xl p-2 text-xs">
                    <span class="text-slate-400 pl-2">Active:</span>
                    <form method="POST" action="" id="switch-wedding-form" class="inline">
                        @csrf
                        <select onchange="if(this.value) { this.form.action = '/workspace/switch/' + this.value; this.form.submit(); }"
                                class="bg-[#0c0d12] border border-white/10 rounded-lg px-3 py-1.5 text-white font-semibold focus:outline-none focus:border-[#d4af37] text-xs">
                            @foreach($userWeddings as $w)
                                <option value="{{ $w->uuid }}" {{ $w->id === $wedding->id ? 'selected' : '' }}>
                                    {{ $w->title }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Invite New Member Form (1 Column) -->
            <div class="lg:col-span-1">
                <div class="bg-[#14161f] border border-white/10 rounded-2xl p-6 shadow-xl sticky top-28">
                    <div class="flex items-center gap-2 text-sm font-bold text-white mb-2">
                        <span class="text-amber-400 text-lg">💌</span> Invite to Workspace
                    </div>
                    <p class="text-xs text-slate-400 mb-5">
                        Send a secure invitation link via email to your partner or wedding team.
                    </p>

                    @if($canManage)
                        <form method="POST" action="{{ route('workspace.collaborators.invite') }}" class="space-y-4">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                                    Recipient Email
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-3.5 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] text-xs transition"
                                       placeholder="partner@example.com">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                                    Collaboration Role
                                </label>
                                <select id="role" name="role" onchange="togglePermissions(this.value)" class="w-full px-3.5 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#d4af37] text-xs transition">
                                    <option value="partner" {{ old('role') === 'partner' ? 'selected' : '' }}>Partner / Co-Planner (Full Access)</option>
                                    <option value="collaborator" {{ old('role') === 'collaborator' ? 'selected' : '' }}>Collaborator (Custom Permissions)</option>
                                </select>
                            </div>

                            <!-- Granular Permissions (if Collaborator) -->
                            <div id="permissions-container" class="space-y-2 p-3.5 rounded-xl bg-[#0c0d12] border border-white/5 hidden text-xs">
                                <div class="text-[11px] font-bold text-amber-300 uppercase tracking-wider mb-1">
                                    Allowed Capabilities:
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                                    <input type="checkbox" name="permissions[manage_checklist]" value="1" checked class="rounded border-white/10 bg-[#14161f] text-amber-500">
                                    <span>Manage Tasks & Checklist</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                                    <input type="checkbox" name="permissions[manage_guests]" value="1" checked class="rounded border-white/10 bg-[#14161f] text-amber-500">
                                    <span>Manage Guest List & RSVP</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                                    <input type="checkbox" name="permissions[view_budget]" value="1" checked class="rounded border-white/10 bg-[#14161f] text-amber-500">
                                    <span>View Budget Summary</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                                    <input type="checkbox" name="permissions[manage_budget]" value="1" class="rounded border-white/10 bg-[#14161f] text-amber-500">
                                    <span>Edit Budget & Expenses</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                                Send Workspace Invitation
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl bg-slate-900/50 border border-white/5 text-xs text-slate-400">
                            Only the workspace owner or partner can invite new members.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Members & Pending Invitations (2 Columns) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Active Members Section -->
                <div class="bg-[#14161f] border border-white/10 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="font-serif-luxury text-xl font-bold text-white">
                                Active Workspace Members
                            </h2>
                            <p class="text-xs text-slate-400">
                                People who currently have access to plan this wedding.
                            </p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/30">
                            {{ $members->count() }} Active
                        </span>
                    </div>

                    <div class="divide-y divide-white/5">
                        @foreach($members as $member)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-full {{ $member->role->value === 'owner' ? 'gold-gradient-bg text-slate-950' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }} font-bold flex items-center justify-center text-sm shadow">
                                        {{ substr($member->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white flex items-center gap-2">
                                            {{ $member->user->name }}
                                            @if($member->user_id === $user->id)
                                                <span class="text-[10px] bg-white/10 text-slate-300 px-2 py-0.5 rounded-full">You</span>
                                            @endif
                                            <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full border
                                                {{ $member->role->value === 'owner' ? 'bg-amber-500/10 text-amber-300 border-amber-500/30' :
                                                   ($member->role->value === 'partner' ? 'bg-rose-500/10 text-rose-300 border-rose-500/30' : 'bg-blue-500/10 text-blue-300 border-blue-500/30') }}">
                                                {{ $member->role->label() }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-slate-400 mt-0.5">
                                            {{ $member->user->email }}
                                            @if($member->joined_at)
                                                • Joined {{ $member->joined_at->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Member Actions -->
                                @if($canManage && $member->role->value !== 'owner' && $member->user_id !== $user->id)
                                    <div>
                                        <form method="POST" action="{{ route('workspace.collaborators.remove', ['id' => $member->id]) }}" onsubmit="return confirm('Are you sure you want to remove this member from the wedding workspace?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 px-3 py-1.5 rounded-lg border border-rose-500/20 hover:bg-rose-500/10 transition">
                                                Remove Member
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pending Invitations Section -->
                <div class="bg-[#14161f] border border-white/10 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="font-serif-luxury text-xl font-bold text-white">
                                Pending Invitations
                            </h2>
                            <p class="text-xs text-slate-400">
                                Invitations awaiting acceptance by the recipient.
                            </p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white/5 text-slate-300 border border-white/10">
                            {{ $invitations->where('status.value', 'pending')->count() }} Pending
                        </span>
                    </div>

                    <div class="divide-y divide-white/5">
                        @forelse($invitations as $invite)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <div class="text-sm font-semibold text-white flex items-center gap-2">
                                        {{ $invite->email }}
                                        <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full border
                                            {{ $invite->status->value === 'pending' ? 'bg-amber-500/10 text-amber-300 border-amber-500/30' :
                                               ($invite->status->value === 'accepted' ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/30' : 'bg-slate-500/10 text-slate-400 border-white/10') }}">
                                            {{ $invite->status->label() }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            Role: {{ $invite->role->label() }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        Invited by {{ $invite->invitedBy?->name ?? 'You' }} •
                                        @if($invite->status->value === 'pending')
                                            Expires {{ $invite->expires_at->diffForHumans() }}
                                        @else
                                            {{ $invite->status->label() }}
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions for Pending Invite -->
                                @if($invite->status->value === 'pending' && $canManage)
                                    <div class="flex items-center gap-2">
                                        <button onclick="navigator.clipboard.writeText('{{ route('invitations.show', ['token' => $invite->token]) }}'); alert('Invitation link copied to clipboard!');"
                                                class="text-xs bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 px-3 py-1.5 rounded-lg transition font-medium">
                                            📋 Copy Link
                                        </button>

                                        <form method="POST" action="{{ route('workspace.collaborators.revoke', ['uuid' => $invite->uuid]) }}">
                                            @csrf
                                            <button type="submit" class="text-xs text-slate-400 hover:text-rose-400 px-3 py-1.5 rounded-lg border border-white/10 hover:bg-rose-500/10 transition">
                                                Revoke
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="py-8 text-center text-xs text-slate-500">
                                No pending or past invitations found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePermissions(role) {
            const container = document.getElementById('permissions-container');
            if (role === 'collaborator') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-workspace-layout>
