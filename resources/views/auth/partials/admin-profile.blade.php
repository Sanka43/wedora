<div class="space-y-8">
    <!-- Admin Ribbon -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 flex items-center justify-center text-purple-700 shadow-sm font-bold text-lg">
                <span class="material-symbols-outlined text-[24px]">admin_panel_settings</span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">
                        Super Administrator Access
                    </h3>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 text-[10px] font-bold uppercase tracking-wider">
                        Full Platform Authority
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mt-0.5">
                    Wedora Platform Ecosystem Control Center
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-700 hover:bg-purple-800 text-white text-xs font-bold transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                <span>Control Center</span>
            </a>
        </div>
    </div>

    <!-- Admin Profile Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Administrator Credentials</h3>
                    <p class="text-xs text-on-surface-variant">Update primary administration name and contact.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Administrator Name <span class="text-error">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-purple-600 focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Super Admin Email <span class="text-error">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-purple-600 focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Emergency Hotline
                    </label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-purple-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="+94 11 234 5678">
                </div>

                <div>
                    <label for="avatar_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Avatar Image URL
                    </label>
                    <input id="avatar_url" type="url" name="avatar_url" value="{{ old('avatar_url', $user->profile?->avatar_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-purple-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://example.com/admin-avatar.jpg">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end pt-2">
            <button type="submit" class="inline-flex items-center gap-2 py-3 px-8 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Save Admin Profile</span>
            </button>
        </div>
    </form>
</div>
