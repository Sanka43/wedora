<x-auth-layout>
    <x-slot:title>Forgot Password — Wedora Sri Lanka</x-slot:title>

    <div class="bg-white border border-[#ebd9c2] rounded-3xl p-8 sm:p-10 shadow-xl shadow-amber-900/5">
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl gold-gradient-bg mx-auto mb-3 flex items-center justify-center text-[#1a140a] shadow-md border border-amber-300">
                <span class="text-xl">🔐</span>
            </div>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#241f1a] mb-2">
                Reset Password
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50]">
                Enter your registered email address and we'll send you a secure link to reset your password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-2">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white focus:ring-2 focus:ring-[#c5a059]/20 text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                Send Reset Link
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-[#ebd9c2] text-center text-xs text-[#665c50]">
            Remember your credentials?
            <a href="{{ route('login') }}" class="text-[#8c6d23] font-bold hover:underline ml-1">Back to login</a>
        </div>
    </div>
</x-auth-layout>