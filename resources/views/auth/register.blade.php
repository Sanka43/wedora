<x-auth-layout>
    <x-slot:title>Create Your Account — Wedora Sri Lanka</x-slot:title>

    <div class="bg-[#14161f] border border-white/10 rounded-2xl p-8 shadow-2xl gold-border-glow">
        @if(isset($invitation) && $invitation)
            <!-- Invitation Banner -->
            <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-xs">
                <div class="font-bold text-sm text-amber-300 mb-1 flex items-center gap-2">
                    <span>💍</span> You're Invited to Plan Together!
                </div>
                <p>
                    <strong>{{ $invitation->invitedBy?->name ?? 'Your partner' }}</strong> has invited you to co-plan
                    <strong>{{ $invitation->wedding?->title ?? 'their wedding' }}</strong> on Wedora. Complete your registration below to join the workspace.
                </p>
            </div>
        @endif

        <div class="text-center mb-6">
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mb-2">
                Begin Your Journey
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
                Create your Wedora account to plan seamlessly across Sri Lanka.
            </p>
        </div>

        @if(!isset($invitation) || !$invitation)
            <!-- Role Toggle Pills -->
            <div class="flex p-1 bg-[#0c0d12] border border-white/10 rounded-xl mb-6 text-xs font-semibold">
                <button type="button" id="tab-couple" onclick="switchRole('couple')" class="flex-1 py-2 rounded-lg bg-amber-500/20 text-[#d4af37] border border-amber-500/30 transition-all text-center">
                    💍 Couple
                </button>
                <button type="button" id="tab-vendor" onclick="switchRole('vendor')" class="flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all text-center">
                    🏛️ Wedding Vendor
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Hidden Role & Invite Token -->
            <input type="hidden" id="role-input" name="role" value="{{ old('role', isset($invitation) ? 'couple' : 'couple') }}">
            @if(isset($inviteToken) && $inviteToken)
                <input type="hidden" name="invite_token" value="{{ $inviteToken }}">
            @endif

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Your Full Name
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="e.g. Kasun Perera">
            </div>

            <!-- Vendor Fields (Hidden by default) -->
            <div id="vendor-fields" class="{{ old('role') === 'vendor' ? '' : 'hidden' }} space-y-4">
                <div>
                    <label for="business_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Business / Brand Name
                    </label>
                    <input id="business_name" type="text" name="business_name" value="{{ old('business_name') }}"
                           class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                           placeholder="e.g. Ceylon Grand Moments Photography">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Category
                        </label>
                        <select id="category_id" name="category_id" class="w-full px-3 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#d4af37] text-xs transition">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="district" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Primary District
                        </label>
                        <select id="district" name="district" class="w-full px-3 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#d4af37] text-xs transition">
                            @foreach($districts as $d)
                                <option value="{{ $d }}" {{ old('district', 'Colombo') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $invitation->email ?? '') }}" required
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Mobile Phone (Sri Lanka)
                </label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="+94 77 123 4567">
            </div>

            <!-- Password Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                           placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Confirm
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full mt-2 py-3.5 px-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                {{ isset($invitation) ? 'Join Wedding Planning' : 'Create Account & Continue' }}
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-white/5 text-center text-xs text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#d4af37] font-semibold hover:underline ml-1">Sign in here</a>
        </div>
    </div>

    <script>
        function switchRole(role) {
            document.getElementById('role-input').value = role;
            const vendorFields = document.getElementById('vendor-fields');
            const tabCouple = document.getElementById('tab-couple');
            const tabVendor = document.getElementById('tab-vendor');

            if (role === 'vendor') {
                vendorFields.classList.remove('hidden');
                tabVendor.className = 'flex-1 py-2 rounded-lg bg-amber-500/20 text-[#d4af37] border border-amber-500/30 transition-all text-center';
                tabCouple.className = 'flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all text-center';
            } else {
                vendorFields.classList.add('hidden');
                tabCouple.className = 'flex-1 py-2 rounded-lg bg-amber-500/20 text-[#d4af37] border border-amber-500/30 transition-all text-center';
                tabVendor.className = 'flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all text-center';
            }
        }
    </script>
</x-auth-layout>
