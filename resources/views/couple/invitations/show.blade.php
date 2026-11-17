<x-auth-layout>
    <x-slot:title>Wedding Planning Invitation — Wedora</x-slot:title>

    <div class="bg-[#14161f] border border-amber-500/20 rounded-3xl p-8 sm:p-10 shadow-2xl gold-border-glow text-center relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-amber-500/10 blur-[90px] rounded-full pointer-events-none"></div>

        <!-- Crest Icon -->
        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl gold-gradient-bg flex items-center justify-center text-slate-950 shadow-xl shadow-amber-500/20">
            <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" opacity=".2"/>
                <path d="M12 4.5c-4.14 0-7.5 3.36-7.5 7.5s3.36 7.5 7.5 7.5 7.5-3.36 7.5-7.5-3.36-7.5-7.5-7.5zm0 13c-3.03 0-5.5-2.47-5.5-5.5S8.97 6.5 12 6.5s5.5 2.47 5.5 5.5-2.47 5.5-5.5 5.5z"/>
                <path d="M12 8a4 4 0 100 8 4 4 0 000-8zm0 6a2 2 0 110-4 2 2 0 010 4z"/>
            </svg>
        </div>

        @if($isPending)
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-semibold mb-4">
                ✨ Official Collaboration Invitation
            </div>

            <h1 class="font-serif-luxury text-2xl sm:text-4xl font-bold text-white mb-2 leading-tight">
                Plan With Love
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 max-w-sm mx-auto mb-6">
                <strong class="text-white">{{ $inviter?->name ?? 'A couple' }}</strong> has invited you to co-plan
                <span class="gold-gradient-text font-serif-luxury font-bold text-base block my-1.5">{{ $wedding->title }}</span>
                as their <strong class="text-amber-300">{{ $invitation->role->label() }}</strong>.
            </p>

            <!-- Wedding Key Highlights -->
            <div class="p-4 rounded-2xl bg-[#0c0d12] border border-white/5 mb-8 text-left space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-400">
                    <span>Celebration Date:</span>
                    <span class="font-semibold text-white">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('F j, Y') }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-400">
                    <span>Tradition / Style:</span>
                    <span class="font-semibold text-white">{{ $wedding->wedding_type->label() }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-400">
                    <span>District / Location:</span>
                    <span class="font-semibold text-white">{{ $wedding->district }}</span>
                </div>
            </div>

            @if($currentUser)
                <!-- Authenticated: Accept or Decline -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('invitations.accept', ['token' => $invitation->token]) }}">
                        @csrf
                        <button type="submit" class="w-full py-4 px-6 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                            ✨ Accept & Join Workspace
                        </button>
                    </form>

                    <form method="POST" action="{{ route('invitations.decline', ['token' => $invitation->token]) }}">
                        @csrf
                        <button type="submit" class="w-full py-3 px-6 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white font-semibold text-xs tracking-wider transition">
                            Decline Invitation
                        </button>
                    </form>
                </div>
            @else
                <!-- Guest: Sign In or Register to Accept -->
                <div class="space-y-3">
                    <a href="{{ route('register', ['invite' => $invitation->token]) }}" class="block w-full py-4 px-6 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:brightness-110 active:scale-[0.99] transition-all">
                        ✨ Create Account & Join Workspace
                    </a>

                    <a href="{{ route('login', ['redirect' => route('invitations.show', ['token' => $invitation->token])]) }}" class="block w-full py-3 px-6 rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:text-white font-semibold text-xs tracking-wider transition">
                        Sign In with Existing Account
                    </a>
                </div>
            @endif

        @else
            <!-- Expired or Invalid Banner -->
            <div class="text-rose-400 mb-4 text-3xl">⚠️</div>
            <h2 class="font-serif-luxury text-2xl font-bold text-white mb-2">
                Invitation Not Available
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-sm mx-auto mb-6">
                This invitation is {{ $invitation->status->label() }} or has expired. Please ask {{ $inviter?->name ?? 'the couple' }} to dispatch a fresh invite link.
            </p>
            <a href="{{ route('home') }}" class="inline-block py-3 px-6 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider shadow hover:brightness-110 transition">
                Return to Wedora Home
            </a>
        @endif
    </div>
</x-auth-layout>
