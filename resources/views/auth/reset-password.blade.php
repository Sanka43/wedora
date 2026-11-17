<x-auth-layout>
    <x-slot:title>Update Password — Wedora Sri Lanka</x-slot:title>

    <div class="bg-[#14161f] border border-white/10 rounded-2xl p-8 shadow-2xl gold-border-glow">
        <div class="text-center mb-6">
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mb-2">
                Choose New Password
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
                Please enter your new password to regain access to your account.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    New Password
                </label>
                <input id="password" type="password" name="password" required autofocus
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Confirm New Password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 bg-[#0c0d12] border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-[#d4af37] focus:ring-1 focus:ring-[#d4af37] text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                Update Password & Sign In
            </button>
        </form>
    </div>
</x-auth-layout>
