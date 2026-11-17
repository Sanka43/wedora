<x-auth-layout>
    <x-slot:title>Setup Your Wedding Workspace — Wedora</x-slot:title>

    <div class="max-w-2xl mx-auto bg-white border border-[#ebd9c2] rounded-3xl p-6 sm:p-10 shadow-xl shadow-amber-900/5">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-50 border border-amber-300 text-[#8c6d23] text-xs font-bold mb-4">
                ✨ Step 1 of 1: Sacred Celebration Setup
            </div>
            <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-[#241f1a] mb-2">
                Create Your Wedding Workspace
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50] max-w-lg mx-auto leading-relaxed">
                Tell us about your celebration. We'll automatically seed culturally tailored Sri Lankan checklist milestones and prepare your shared planning dashboard.
            </p>
        </div>

        <form method="POST" action="{{ route('workspace.onboarding.store') }}" class="space-y-6">
            @csrf

            <!-- Partners Section -->
            <div class="p-5 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] space-y-4">
                <div class="text-xs font-bold text-[#8c6d23] uppercase tracking-wider flex items-center gap-2">
                    <span>💍</span> The Couple
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="partner1_name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Partner 1 Name (You)
                        </label>
                        <input id="partner1_name" type="text" name="partner1_name" value="{{ old('partner1_name', $user->name) }}" required
                               class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                    </div>

                    <div>
                        <label for="partner2_name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Partner 2 Name (Fiancé / Fiancée)
                        </label>
                        <input id="partner2_name" type="text" name="partner2_name" value="{{ old('partner2_name', $user->profile?->partner_name) }}" required
                               class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                               placeholder="e.g. Amaya">
                    </div>
                </div>
            </div>

            <!-- Date & Cultural Type -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="wedding_date" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Wedding Date
                    </label>
                    <input id="wedding_date" type="date" name="wedding_date" value="{{ old('wedding_date') }}" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                </div>

                <div>
                    <label for="wedding_type" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Wedding Tradition / Type
                    </label>
                    <select id="wedding_type" name="wedding_type" required class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                        @foreach($weddingTypes as $type)
                            <option value="{{ $type->value }}" {{ old('wedding_type') == $type->value ? 'selected' : '' }}>
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- District & Location -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="district" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Sri Lankan District
                    </label>
                    <select id="district" name="district" required class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                        @foreach($districts as $d)
                            <option value="{{ $d }}" {{ old('district', 'Colombo') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="location" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Preferred Venue / City (Optional)
                    </label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                           placeholder="e.g. Cinnamon Grand Colombo / Earl's Regency Kandy">
                </div>
            </div>

            <!-- Financials & Scope -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="total_budget" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Estimated Budget (LKR)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-xs text-[#8c6d23] font-bold">Rs.</span>
                        <input id="total_budget" type="number" step="1000" name="total_budget" value="{{ old('total_budget', '3500000') }}" required
                               class="w-full pl-11 pr-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                    </div>
                </div>

                <div>
                    <label for="estimated_guest_count" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Estimated Guest Count
                    </label>
                    <input id="estimated_guest_count" type="number" name="estimated_guest_count" value="{{ old('estimated_guest_count', '250') }}" required
                           class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition">
                </div>
            </div>

            <!-- Style Theme -->
            <div>
                <label for="style_theme" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Wedding Aesthetic / Style Theme (Optional)
                </label>
                <input id="style_theme" type="text" name="style_theme" value="{{ old('style_theme') }}"
                       class="w-full px-4 py-2.5 bg-white border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="e.g. Royal Traditional Elegance, Grand Floral Splendour, Seaside Minimalist">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-4 px-6 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                ✨ Initialize Wedding Workspace
            </button>
        </form>
    </div>
</x-auth-layout>