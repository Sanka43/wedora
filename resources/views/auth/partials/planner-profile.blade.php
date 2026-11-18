@php
    $profile = $user->profile;
    $specializations = is_array($profile?->specializations) ? $profile->specializations : [];
    $operatingDistricts = is_array($profile?->operating_districts) ? $profile->operating_districts : [];
@endphp

<div class="space-y-8">
    <!-- Planner Studio Ribbon -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-700 shadow-sm font-bold text-lg">
                <span class="material-symbols-outlined text-[24px]">event_note</span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">
                        {{ $profile?->company_name ?? 'Professional Wedding Planner Studio' }}
                    </h3>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-[10px] font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[12px]">verified</span> Certified Planner
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mt-0.5">
                    {{ $profile?->designation ?? 'Lead Nuptial Coordinator' }} • {{ $managedWeddingsCount }} Active Client Nuptial Workspaces
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('planner.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                <span>Planner Concierge Studio</span>
            </a>
        </div>
    </div>

    <!-- Planner Management Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Section 1: Lead Planner Personal Details -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">account_circle</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Lead Planner Credentials</h3>
                    <p class="text-xs text-on-surface-variant">Your personal contact and authentication profile.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Lead Planner Name <span class="text-error">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Account Email Address <span class="text-error">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Direct Phone / Hotline
                    </label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="+94 77 987 6543">
                </div>

                <div>
                    <label for="avatar_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Profile Image URL
                    </label>
                    <input id="avatar_url" type="url" name="avatar_url" value="{{ old('avatar_url', $profile?->avatar_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://example.com/planner-avatar.jpg">
                </div>
            </div>
        </div>

        <!-- Section 2: Planning Agency & Experience -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">corporate_fare</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Agency Practice &amp; Professional Background</h3>
                    <p class="text-xs text-on-surface-variant">Details regarding your wedding planning business in Sri Lanka.</p>
                </div>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-2">
                        <label for="company_name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Agency / Brand Name <span class="text-error">*</span>
                        </label>
                        <input id="company_name" type="text" name="company_name" value="{{ old('company_name', $profile?->company_name) }}" required
                               class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                               placeholder="e.g. Ceylon Nuptial Couturiers &amp; Event Planners">
                    </div>

                    <div>
                        <label for="designation" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Designation / Role
                        </label>
                        <input id="designation" type="text" name="designation" value="{{ old('designation', $profile?->designation) }}"
                               class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                               placeholder="e.g. Creative Director">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="experience_years" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Years of Nuptial Experience
                        </label>
                        <input id="experience_years" type="number" min="0" max="60" name="experience_years" value="{{ old('experience_years', $profile?->experience_years) }}"
                               class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition font-semibold"
                               placeholder="8">
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Studio / Office Address
                        </label>
                        <input id="address" type="text" name="address" value="{{ old('address', $profile?->address) }}"
                               class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                               placeholder="Alfred House Gardens, Colombo 03">
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Planning Philosophy &amp; Experience Overview
                    </label>
                    <textarea id="bio" name="bio" rows="4"
                              class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                              placeholder="Describe your coordination style, auspicious Nekath precision, and how you assist couples throughout the months leading up to their Poruwa or Western reception...">{{ old('bio', $profile?->bio) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Cultural Specializations & Operating Districts -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Ceremonial Expertise &amp; Coverage</h3>
                    <p class="text-xs text-on-surface-variant">Select traditions and districts in which you provide wedding coordination.</p>
                </div>
            </div>

            <!-- Specializations Grid -->
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2.5">
                    Ceremonial &amp; Cultural Specializations
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                    @foreach($plannerSpecializations as $spec)
                        <label class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/30 hover:border-indigo-500 bg-surface cursor-pointer text-xs transition">
                            <input type="checkbox" name="specializations[]" value="{{ $spec }}"
                                   {{ in_array($spec, old('specializations', $specializations)) ? 'checked' : '' }}
                                   class="rounded text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                            <span class="font-medium text-on-surface">{{ $spec }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Operating Districts Grid -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2.5">
                    Operating Geographic Districts (Multi-select)
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                    @foreach($districts as $d)
                        <label class="flex items-center gap-2 p-2 rounded-lg border border-outline-variant/30 hover:border-indigo-500 bg-surface cursor-pointer text-xs transition">
                            <input type="checkbox" name="operating_districts[]" value="{{ $d }}"
                                   {{ in_array($d, old('operating_districts', $operatingDistricts)) ? 'checked' : '' }}
                                   class="rounded text-indigo-600 focus:ring-indigo-500 w-3.5 h-3.5">
                            <span class="text-on-surface">{{ $d }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 4: Web & Social Portfolio -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">public</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Portfolio &amp; Social Presences</h3>
                    <p class="text-xs text-on-surface-variant">Channels where clients review your past productions.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="website" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Agency Website
                    </label>
                    <input id="website" type="url" name="website" value="{{ old('website', $profile?->website) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://ananyaweddings.lk">
                </div>

                <div>
                    <label for="instagram_handle" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Instagram
                    </label>
                    <input id="instagram_handle" type="text" name="instagram_handle" value="{{ old('instagram_handle', $profile?->instagram_handle) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="@ananya_nuptials">
                </div>

                <div>
                    <label for="facebook_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Facebook Page
                    </label>
                    <input id="facebook_url" type="url" name="facebook_url" value="{{ old('facebook_url', $profile?->facebook_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-indigo-600 focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://facebook.com/ananyaweddings">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-2">
            <span class="text-xs text-on-surface-variant">Your studio details will be linked to client nuptials coordinated in Wedora.</span>
            <button type="submit" class="inline-flex items-center gap-2 py-3 px-8 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Save Planner Profile</span>
            </button>
        </div>
    </form>
</div>
