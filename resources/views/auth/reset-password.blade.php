<x-auth-layout>
    <x-slot:title>Update Password — Wedora Sri Lanka</x-slot:title>

    <div class="bg-white border border-[#ebd9c2] rounded-3xl p-8 sm:p-10 shadow-xl shadow-amber-900/5">
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl gold-gradient-bg mx-auto mb-3 flex items-center justify-center text-[#1a140a] shadow-md border border-amber-300">
                <span class="text-xl">✨</span>
            </div>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#241f1a] mb-2">
                Choose New Password
            </h1>
            <p class="text-xs sm:text-sm text-[#665c50]">
                Please enter your new password to regain access to your wedding account.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    New Password
                </label>
                <input id="password" type="password" name="password" required autofocus
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#52483d] mb-1.5">
                    Confirm New Password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 bg-[#faf8f5] border border-[#ebd9c2] rounded-xl text-[#241f1a] placeholder-[#9c9184] focus:outline-none focus:border-[#b8860b] focus:bg-white text-sm transition"
                       placeholder="••••••••">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                Update Password & Sign In
            </button>
        </form>
    </div>
</x-auth-layout>