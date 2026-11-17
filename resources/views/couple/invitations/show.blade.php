<x-auth-layout>
    <x-slot:title>Wedding Planning Invitation — Wedora</x-slot:title>

    <div class="bg-white border-2 border-[#ebd9c2] rounded-3xl p-8 sm:p-10 shadow-2xl shadow-amber-900/10 text-center relative overflow-hidden ring-4 ring-[#c5a059]/10">
        <!-- Soft Warm Ambient Glow -->
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-amber-100/60 blur-[90px] rounded-full pointer-events-none"></div>

        <!-- Royal Sri Lankan Crest Icon -->
        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl gold-gradient-bg flex items-center justify-center text-[#1a140a] shadow-md shadow-[#c5a059]/30 border border-amber-300">
            <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                <path d="M12 2C11.5 3.5 10 5.5 10 7.5c0 1.38.9 2.5 2 2.5s2-1.12 2-2.5C14 5.5 12.5 3.5 12 2z" />
                <path d="M12 11c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6zm-4 5c.55-1.74 2.14-3 4-3s3.45 1.26 4 3H8z" />
                <path d="M7 19h10v2H7z" />
            </svg>
        </div>

        @if($isPending)
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#8c6d23] text-xs font-bold mb-4">
                ✨ Official Wedding Co-Planning Invitation
            </div>

            <h1 class="font-serif-luxury text-2xl sm:text-4xl font-bold text-[#241f1a] mb-2 leading-tight">
                Plan With Love
            </h1>

            <p class="text-xs sm:text-sm text-[#665c50] max-w-sm mx-auto mb-6">
                <strong class="text-[#241f1a]">{{ $inviter?->name ?? 'A couple' }}</strong> has invited you to co-plan
                <span class="gold-gradient-text font-serif-luxury font-bold text-lg block my-1.5">{{ $wedding->title }}</span>
                as their <strong class="text-[#8c6d23]">{{ $invitation->role->label() }}</strong>.
            </p>

            <!-- Wedding Key Highlights -->
            <div class="p-4 rounded-2xl bg-[#faf8f5] border border-[#ebd9c2] mb-8 text-left space-y-2.5 text-xs">
                <div class="flex items-center justify-between text-[#665c50]">
                    <span>Celebration Date:</span>
                    <span class="font-bold text-[#241f1a]">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('F j, Y') }}</span>
                </div>
                <div class="flex items-center justify-between text-[#665c50]">
                    <span>Tradition / Style:</span>
                    <span class="font-bold text-[#241f1a]">{{ $wedding->wedding_type->label() }}</span>
                </div>
                <div class="flex items-center justify-between text-[#665c50]">
                    <span>District / Location:</span>
                    <span class="font-bold text-[#241f1a]">{{ $wedding->district }}</span>
                </div>
            </div>

            @if($currentUser)
                <!-- Authenticated: Accept or Decline -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('invitations.accept', ['token' => $invitation->token]) }}">
                        @csrf
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                            ✨ Accept & Join Workspace
                        </button>
                    </form>

                    <form method="POST" action="{{ route('invitations.decline', ['token' => $invitation->token]) }}">
                        @csrf
                        <button type="submit" class="w-full py-3 px-6 rounded-xl bg-white border border-[#ebd9c2] text-[#665c50] hover:text-[#241f1a] font-bold text-xs tracking-wider transition">
                            Decline Invitation
                        </button>
                    </form>
                </div>
            @else
                <!-- Guest: Sign In or Register to Accept -->
                <div class="space-y-3">
                    <a href="{{ route('register', ['invite' => $invitation->token]) }}" class="block w-full py-3.5 px-6 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                        ✨ Create Account & Join Workspace
                    </a>

                    <a href="{{ route('login', ['redirect' => route('invitations.show', ['token' => $invitation->token])]) }}" class="block w-full py-3 px-6 rounded-xl bg-white border border-[#ebd9c2] text-[#52483d] hover:text-[#241f1a] font-bold text-xs tracking-wider transition">
                        Sign In with Existing Account
                    </a>
                </div>
            @endif

        @else
            <!-- Expired or Invalid Banner -->
            <div class="text-rose-500 mb-4 text-3xl">⚠️</div>
            <h2 class="font-serif-luxury text-2xl font-bold text-[#241f1a] mb-2">
                Invitation Not Available
            </h2>
            <p class="text-xs sm:text-sm text-[#665c50] max-w-sm mx-auto mb-6">
                This invitation is {{ $invitation->status->label() }} or has expired. Please ask {{ $inviter?->name ?? 'the couple' }} to dispatch a fresh invite link.
            </p>
            <a href="{{ route('home') }}" class="inline-block py-3 px-6 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow hover:brightness-105 transition border border-amber-300">
                Return to Wedora Home
            </a>
        @endif
    </div>
</x-auth-layout>