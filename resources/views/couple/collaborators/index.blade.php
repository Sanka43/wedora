<x-workspace-layout>
    <x-slot:title>Partner & Team Collaboration — {{ $wedding->title }}</x-slot:title>

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-[#ebd9c2]">
            <div>
                <h1 class="font-serif-luxury text-3xl font-bold text-[#241f1a] mb-1">
                    Partner & Team Collaboration
                </h1>
                <p class="text-xs sm:text-sm text-[#665c50]">
                    Invite your partner, wedding planner, maid of honor, or family members to plan {{ $wedding->title }} together.
                </p>
            </div>

            <!-- Workspace Switcher if user has multiple weddings -->
            @if(isset($userWeddings) && $userWeddings->count() > 1)
                <div class="flex items-center gap-2 bg-white border border-[#ebd9c2] rounded-xl p-2 text-xs shadow-sm">
                    <span class="text-[#736657] pl-2 font-medium">Active:</span>
                    <form method="POST" action="" id="switch-wedding-form" class="inline">
                        @csrf
                        <select onchange="if(this.value) { this.form.action = '/workspace/switch/' + this.value; this.form.submit(); }"
                                class="bg-[#faf8f5] border border-[#ebd9c2] rounded-lg px-3 py-1.5 text-[#241f1a] font-bold focus:outline-none focus:border-[#b8860b] text-xs">
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
                <div class="bg-white border border-[#ebd9c2] rounded-2xl p-6 shadow-sm sticky top-28">
                    <div class="flex items-center gap-2 text-sm font-bold text-[#241f1a] mb-2">
                        <span class="text-[#8c6d23] text-lg">💌</span> Invite to Workspace
                    </div>
                    <p class="text-xs text-[#665c50] mb-5">
                        Send a secure invitation link via email to your partner or wedding team.
                    </p>

                    @if($canManage)
                        <form method="POST" action="{{ route('workspace.collaborators.invite') }}" class="space-y-4">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                                    Recipient Email
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-3.5 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-xs transition"
                                       placeholder="partner@example.com">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                                    Collaboration Role
                                </label>
                                <select id="role" name="role" onchange="togglePermissions(this.value)" class="w-full px-3.5 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-xs transition">
                                    <option value="partner" {{ old('role') === 'partner' ? 'selected' : '' }}>Partner / Co-Planner (Full Access)</option>
                                    <option value="collaborator" {{ old('role') === 'collaborator' ? 'selected' : '' }}>Collaborator (Custom Permissions)</option>
                                </select>
                            </div>

                            <!-- Granular Permissions (if Collaborator) -->
                            <div id="permissions-container" class="space-y-2 p-3.5 rounded-xl bg-[#faf8f5] border border-[#ebd9c2] hidden text-xs">
                                <div class="text-[11px] font-bold text-[#8c6d23] uppercase tracking-wider mb-1">
                                    Allowed Capabilities:
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer text-[#52483d] font-medium">
                                    <input type="checkbox" name="permissions[manage_checklist]" value="1" checked class="rounded border-[#ebd9c2] text-[#b8860b]">
                                    <span>Manage Tasks & Checklist</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#52483d] font-medium">
                                    <input type="checkbox" name="permissions[manage_guests]" value="1" checked class="rounded border-[#ebd9c2] text-[#b8860b]">
                                    <span>Manage Guest List & RSVP</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#52483d] font-medium">
                                    <input type="checkbox" name="permissions[view_budget]" value="1" checked class="rounded border-[#ebd9c2] text-[#b8860b]">
                                    <span>View Budget Summary</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#52483d] font-medium">
                                    <input type="checkbox" name="permissions[manage_budget]" value="1" class="rounded border-[#ebd9c2] text-[#b8860b]">
                                    <span>Edit Budget & Expenses</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full py-3 px-4 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                                Send Workspace Invitation
                            </button>
                        </form>
                    @else
                        <div class="p-4 rounded-xl bg-[#faf8f5] border border-[#ebd9c2] text-xs text-[#736657]">
                            Only the workspace owner or partner can invite new members.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Members & Pending Invitations (2 Columns) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Active Members Section -->
                <div class="bg-white border border-[#ebd9c2] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">
                                Active Workspace Members
                            </h2>
                            <p class="text-xs text-[#665c50]">
                                People who currently have access to plan this wedding.
                            </p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-50 text-[#8c6d23] border border-amber-300">
                            {{ $members->count() }} Active
                        </span>
                    </div>

                    <div class="divide-y divide-[#ebd9c2]">
                        @foreach($members as $member)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-full {{ $member->role->value === 'owner' ? 'gold-gradient-bg text-[#1a140a] border border-amber-300' : 'bg-amber-100 text-[#8c6d23] border border-amber-300' }} font-bold flex items-center justify-center text-sm shadow-sm">
                                        {{ substr($member->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-[#241f1a] flex items-center gap-2">
                                            {{ $member->user->name }}
                                            @if($member->user_id === $user->id)
                                                <span class="text-[10px] bg-amber-100 text-[#8c6d23] px-2 py-0.5 rounded-full font-bold">You</span>
                                            @endif
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border
                                                {{ $member->role->value === 'owner' ? 'bg-amber-50 text-[#8c6d23] border-amber-300' :
                                                   ($member->role->value === 'partner' ? 'bg-rose-50 text-rose-800 border-rose-200' : 'bg-blue-50 text-blue-800 border-blue-200') }}">
                                                {{ $member->role->label() }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-[#736657] mt-0.5 font-medium">
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
                                            <button type="submit" class="text-xs text-rose-700 hover:text-rose-900 px-3 py-1.5 rounded-lg border border-rose-200 hover:bg-rose-50 transition font-bold">
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
                <div class="bg-white border border-[#ebd9c2] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="font-serif-luxury text-xl font-bold text-[#241f1a]">
                                Pending Invitations
                            </h2>
                            <p class="text-xs text-[#665c50]">
                                Invitations awaiting acceptance by the recipient.
                            </p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-[#faf8f5] text-[#736657] border border-[#ebd9c2]">
                            {{ $invitations->where('status.value', 'pending')->count() }} Pending
                        </span>
                    </div>

                    <div class="divide-y divide-[#ebd9c2]">
                        @forelse($invitations as $invite)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <div class="text-sm font-bold text-[#241f1a] flex items-center gap-2">
                                        {{ $invite->email }}
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border
                                            {{ $invite->status->value === 'pending' ? 'bg-amber-50 text-[#8c6d23] border-amber-300' :
                                               ($invite->status->value === 'accepted' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-slate-50 text-[#736657] border-[#ebd9c2]') }}">
                                            {{ $invite->status->label() }}
                                        </span>
                                        <span class="text-[10px] text-[#736657]">
                                            Role: {{ $invite->role->label() }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-[#736657] mt-0.5 font-medium">
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
                                                class="text-xs bg-amber-50 hover:bg-amber-100 text-[#8c6d23] border border-amber-300 px-3 py-1.5 rounded-lg transition font-bold shadow-sm">
                                            📋 Copy Link
                                        </button>

                                        <form method="POST" action="{{ route('workspace.collaborators.revoke', ['uuid' => $invite->uuid]) }}">
                                            @csrf
                                            <button type="submit" class="text-xs text-[#736657] hover:text-rose-700 px-3 py-1.5 rounded-lg border border-[#ebd9c2] hover:bg-rose-50 transition font-medium">
                                                Revoke
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="py-8 text-center text-xs text-[#736657]">
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