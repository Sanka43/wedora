<x-workspace-layout>
    <x-slot:title>User Profile & Preferences — Wedora</x-slot:title>

    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="font-serif-luxury text-3xl font-bold text-[#241f1a] mb-1">
                Account & Partner Profile
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50]">
                Manage your personal contact details, partner information, and notification preferences.
            </p>
        </div>

        <div class="bg-white border border-[#ebd9c2] rounded-2xl p-6 sm:p-8 shadow-sm">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-4 pb-6 border-b border-[#ebd9c2]">
                    <div class="w-16 h-16 rounded-full gold-gradient-bg text-[#1a140a] border border-amber-300 flex items-center justify-center text-xl font-bold uppercase shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#241f1a]">{{ $user->name }}</h2>
                        <span class="inline-block mt-0.5 px-3 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-amber-50 text-[#8c6d23] border border-amber-300">
                            {{ $user->role->label() }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Full Name
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Email Address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Contact Phone
                        </label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                               placeholder="+94 77 123 4567">
                    </div>

                    <!-- Partner Name -->
                    <div>
                        <label for="partner_name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Partner / Spouse Name
                        </label>
                        <input id="partner_name" type="text" name="partner_name" value="{{ old('partner_name', $user->profile?->partner_name) }}"
                               class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                               placeholder="e.g. Amaya">
                    </div>

                    <!-- Preferred Locale -->
                    <div>
                        <label for="preferred_locale" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Preferred Language
                        </label>
                        <select id="preferred_locale" name="preferred_locale" class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition">
                            <option value="en" {{ old('preferred_locale', $user->profile?->preferred_locale) === 'en' ? 'selected' : '' }}>English</option>
                            <option value="si" {{ old('preferred_locale', $user->profile?->preferred_locale) === 'si' ? 'selected' : '' }}>සිංහල (Sinhala)</option>
                            <option value="ta" {{ old('preferred_locale', $user->profile?->preferred_locale) === 'ta' ? 'selected' : '' }}>தமிழ் (Tamil)</option>
                        </select>
                    </div>

                    <!-- Avatar URL -->
                    <div>
                        <label for="avatar_url" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Avatar Image URL
                        </label>
                        <input id="avatar_url" type="url" name="avatar_url" value="{{ old('avatar_url', $user->profile?->avatar_url) }}"
                               class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                               placeholder="https://example.com/avatar.jpg">
                    </div>
                </div>

                <div class="pt-5 border-t border-[#ebd9c2] flex items-center justify-end">
                    <button type="submit" class="py-3 px-6 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-workspace-layout>