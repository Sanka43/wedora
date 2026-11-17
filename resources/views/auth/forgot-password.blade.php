<x-auth-layout>
    <x-slot:title>Forgot Password — Wedora Sri Lanka</x-slot:title>

    <div class="bg-[#14161f] border border-white/10 rounded-2xl p-8 shadow-2xl gold-border-glow">
        <div class="text-center mb-6">
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mb-2">
                Reset Password
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
                Enter your registered email address and we'll send you a secure link to reset your password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="you@example.com">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                Send Reset Link
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-white/5 text-center text-xs text-slate-400">
            Remember your credentials?
            <a href="{{ route('login') }}" class="text-[#d4af37] font-semibold hover:underline ml-1">Back to login</a>
        </div>
    </div>
</x-auth-layout>
