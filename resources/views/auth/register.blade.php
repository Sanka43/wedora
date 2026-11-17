<x-auth-layout>
    <x-slot:title>Create Your Account — Wedora Sri Lanka</x-slot:title>

    <div class="bg-white border border-[#ebd9c2] rounded-3xl p-8 sm:p-10 shadow-xl shadow-amber-900/5">
        @if(isset($invitation) && $invitation)
            <!-- Invitation Banner -->
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-300 text-[#8c6d23] text-xs">
                <div class="font-bold text-sm text-[#8c6d23] mb-1 flex items-center gap-2">
                    <span>💍</span> You're Invited to Plan Together!
                </div>
                <p class="leading-relaxed">
                    <strong>{{ $invitation->invitedBy?->name ?? 'Your partner' }}</strong> has invited you to co-plan
                    <strong>{{ $invitation->wedding?->title ?? 'their wedding' }}</strong> on Wedora. Complete your registration below to join the workspace.
                </p>
            </div>
        @endif

        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl gold-gradient-bg mx-auto mb-3 flex items-center justify-center text-[#1a140a] shadow-md border border-amber-300">
                <span class="text-xl">🪷</span>
            </div>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#241f1a] mb-2">
                Begin Your Journey
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50]">
                Create your Wedora account to plan seamlessly across Sri Lanka.
            </p>
        </div>

        @if(!isset($invitation) || !$invitation)
            <!-- Role Toggle Pills -->
            <div class="flex p-1 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl mb-6 text-xs font-bold">
                <button type="button" id="tab-couple" onclick="switchRole('couple')" class="flex-1 py-2 rounded-lg gold-gradient-bg text-[#1a140a] border border-amber-300 shadow-sm transition-all text-center">
                    💍 Couple
                </button>
                <button type="button" id="tab-vendor" onclick="switchRole('vendor')" class="flex-1 py-2 rounded-lg text-[#665c50] hover:text-[#241f1a] transition-all text-center">
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
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Your Full Name
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="e.g. Kasun Perera / Priyadharshini">
            </div>

            <!-- Vendor Fields (Hidden by default) -->
            <div id="vendor-fields" class="{{ old('role') === 'vendor' ? '' : 'hidden' }} space-y-4">
                <div>
                    <label for="business_name" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Business / Brand Name
                    </label>
                    <input id="business_name" type="text" name="business_name" value="{{ old('business_name') }}"
                           class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                           placeholder="e.g. Ceylon Grand Moments Photography">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Category
                        </label>
                        <select id="category_id" name="category_id" class="w-full px-3 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-xs transition">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="district" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                            Primary District
                        </label>
                        <select id="district" name="district" class="w-full px-3 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] focus:outline-none focus:border-[#b8860b] focus:bg-white text-xs transition">
                            @foreach($districts as $d)
                                <option value="{{ $d }}" {{ old('district', 'Colombo') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $invitation->email ?? '') }}" required
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Mobile Phone (Sri Lanka)
                </label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="+94 77 123 4567">
            </div>

            <!-- Password Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                           placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                        Confirm
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full mt-2 py-3.5 px-4 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                {{ isset($invitation) ? 'Join Wedding Planning' : 'Create Account & Continue' }}
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-[#ebd9c2] text-center text-xs text-[#665c50]">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#8c6d23] font-bold hover:underline ml-1">Sign in here</a>
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
                tabVendor.className = 'flex-1 py-2 rounded-lg gold-gradient-bg text-[#1a140a] border border-amber-300 shadow-sm transition-all text-center';
                tabCouple.className = 'flex-1 py-2 rounded-lg text-[#665c50] hover:text-[#241f1a] transition-all text-center';
            } else {
                vendorFields.classList.add('hidden');
                tabCouple.className = 'flex-1 py-2 rounded-lg gold-gradient-bg text-[#1a140a] border border-amber-300 shadow-sm transition-all text-center';
                tabVendor.className = 'flex-1 py-2 rounded-lg text-[#665c50] hover:text-[#241f1a] transition-all text-center';
            }
        }
    </script>
</x-auth-layout>