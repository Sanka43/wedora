<x-auth-layout>
    <x-slot:title>Sign In — Wedora Sri Lanka</x-slot:title>

    <div class="bg-white border border-[#ebd9c2] rounded-3xl p-8 sm:p-10 shadow-xl shadow-amber-900/5">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl gold-gradient-bg mx-auto mb-4 flex items-center justify-center text-[#1a140a] shadow-md border border-amber-300">
                <span class="text-xl">🪷</span>
            </div>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#241f1a] mb-2">
                Welcome Back
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50]">
                Sign in to manage your wedding workspace or vendor portal.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-2">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#52483d]">
                        Password
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-[#8c6d23] hover:underline font-semibold">
                        Forgot Password?
                    </a>
                </div>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-3 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-[#52483d] font-medium">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#ebd9c2] bg-[#faf8f5] text-[#b8860b] focus:ring-[#c5a059]">
                    <span>Keep me signed in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                Sign In to Wedora
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#ebd9c2] text-center text-xs text-[#665c50]">
            Planning your wedding?
            <a href="{{ route('register') }}" class="text-[#8c6d23] font-bold hover:underline ml-1">Start planning free</a>
        </div>
    </div>
</x-auth-layout>