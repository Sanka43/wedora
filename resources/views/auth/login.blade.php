<x-auth-layout>
    <x-slot:title>Sign In — Wedora Sri Lanka</x-slot:title>

    <div class="bg-[#14161f] border border-white/10 rounded-2xl p-8 shadow-2xl gold-border-glow">
        <div class="text-center mb-8">
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mb-2">
                Welcome Back
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
                Sign in to access your wedding workspace or vendor portal.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Password
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-[#d4af37] hover:underline font-medium">
                        Forgot Password?
                    </a>
                </div>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-3 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-300">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-[#0c0d12] text-amber-500 focus:ring-amber-400">
                    <span>Keep me signed in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                Sign In to Wedora
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-white/5 text-center text-xs text-slate-400">
            Planning your wedding?
            <a href="{{ route('register') }}" class="text-[#d4af37] font-semibold hover:underline ml-1">Start planning free</a>
        </div>
    </div>
</x-auth-layout>
