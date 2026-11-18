@php
    $profile = $user->profile;
    $notifs = is_array($profile?->notification_preferences) ? $profile->notification_preferences : [];
@endphp

<div class="space-y-8">
    @if(isset($activeWedding) && $activeWedding)
        <!-- Wedding Workspace Snapshot Ribbon -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl gold-gradient-bg border border-amber-300 flex items-center justify-center text-primary shadow-sm font-bold text-lg">
                    <span>🪷</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-headline-sm text-lg font-bold text-on-surface">
                            {{ $activeWedding->title }}
                        </h3>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100 text-[#8c6d23] text-[10px] font-bold uppercase tracking-wider">
                            {{ $activeWedding->wedding_type->label() }}
                        </span>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-0.5">
                        {{ \Carbon\Carbon::parse($activeWedding->wedding_date)->format('F j, Y') }} • {{ $activeWedding->district }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('workspace.collaborators.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 text-xs font-bold text-on-surface transition-colors shadow-xs">
                    <span class="material-symbols-outlined text-[16px] text-primary">group</span>
                    <span>Partner &amp; Team</span>
                </a>
                <a href="{{ route('workspace.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl gold-gradient-bg border border-amber-300 text-xs font-bold text-[#1a140a] hover:brightness-105 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">spa</span>
                    <span>Couple Workspace</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Couple Profile Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-primary-fixed/40 text-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Account & Partner Profile</h3>
                    <p class="text-xs text-on-surface-variant">Personal details and Nuptial Co-Planning Identity.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Your Full Name <span class="text-error">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Account Email Address <span class="text-error">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Contact Mobile Phone
                    </label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="+94 77 123 4567">
                </div>

                <div>
                    <label for="partner_name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Partner / Spouse Name
                    </label>
                    <input id="partner_name" type="text" name="partner_name" value="{{ old('partner_name', $profile?->partner_name) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="Spouse or partner name">
                </div>

                <div>
                    <label for="preferred_locale" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Preferred Language
                    </label>
                    <select id="preferred_locale" name="preferred_locale"
                            class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                        <option value="en" {{ old('preferred_locale', $profile?->preferred_locale) === 'en' ? 'selected' : '' }}>English (Sri Lanka)</option>
                        <option value="si" {{ old('preferred_locale', $profile?->preferred_locale) === 'si' ? 'selected' : '' }}>සිංහල (Sinhala)</option>
                        <option value="ta" {{ old('preferred_locale', $profile?->preferred_locale) === 'ta' ? 'selected' : '' }}>தமிழ் (Tamil)</option>
                    </select>
                </div>

                <div>
                    <label for="avatar_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Avatar Image URL
                    </label>
                    <input id="avatar_url" type="url" name="avatar_url" value="{{ old('avatar_url', $profile?->avatar_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://example.com/couple-avatar.jpg">
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-outline-variant/20">
                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-3">
                    Notification &amp; Alert Preferences
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/30 hover:border-primary bg-surface cursor-pointer text-xs transition">
                        <input type="checkbox" name="notification_preferences[email_quotes]" value="1"
                               {{ !empty($notifs['email_quotes']) ? 'checked' : 'checked' }}
                               class="rounded text-primary focus:ring-primary w-4 h-4">
                        <span class="font-medium text-on-surface">Email Quotation Alerts</span>
                    </label>

                    <label class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/30 hover:border-primary bg-surface cursor-pointer text-xs transition">
                        <input type="checkbox" name="notification_preferences[sms_nekath]" value="1"
                               {{ !empty($notifs['sms_nekath']) ? 'checked' : 'checked' }}
                               class="rounded text-primary focus:ring-primary w-4 h-4">
                        <span class="font-medium text-on-surface">SMS Nekath Reminders</span>
                    </label>

                    <label class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/30 hover:border-primary bg-surface cursor-pointer text-xs transition">
                        <input type="checkbox" name="notification_preferences[whatsapp_updates]" value="1"
                               {{ !empty($notifs['whatsapp_updates']) ? 'checked' : 'checked' }}
                               class="rounded text-primary focus:ring-primary w-4 h-4">
                        <span class="font-medium text-on-surface">WhatsApp Messages</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-2">
            <span class="text-xs text-on-surface-variant">Changes will sync across both partner planning devices.</span>
            <button type="submit" class="inline-flex items-center gap-2 py-3 px-8 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Save Nuptial Profile</span>
            </button>
        </div>
    </form>
</div>
