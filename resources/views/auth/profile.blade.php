<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} — Profile Management | Wedora</title>

    @include('layouts.head-meta')
</head>
<body class="min-h-screen bg-surface text-on-surface font-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed flex flex-col justify-between">

    <!-- Top Navigation Bar matching Home Page -->
    <x-top-navbar />

    <!-- Main Profile Content Shell -->
    <main class="flex-grow max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28 w-full">
        <!-- Toast Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-sm flex items-center justify-between gap-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <div class="font-medium">{{ session('success') }}</div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 text-xs font-bold">✕</button>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-300 text-[#8c6d23] text-sm flex items-center justify-between gap-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-amber-600">info</span>
                    <div class="font-medium">{{ session('info') }}</div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-amber-600 hover:text-[#8c6d23] text-xs font-bold">✕</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm shadow-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600 text-[18px]">warning</span>
                    <span>Please review and correct the following items:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-800 pl-1 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Hero Header -->
        <div class="mb-8 bg-surface-container-lowest border border-outline-variant/30 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-primary-fixed/20 blur-[80px] rounded-full pointer-events-none"></div>

            <div class="relative z-10 flex items-center gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl gold-gradient-bg border border-amber-300 text-[#1a140a] flex items-center justify-center font-serif-luxury text-2xl sm:text-3xl font-bold shadow-md shrink-0">
                    @if($user->profile?->avatar_url)
                        <img src="{{ $user->profile->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-2xl" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span style="display:none;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @else
                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="font-headline-sm text-2xl sm:text-3xl font-bold text-on-surface">
                            {{ $user->name }}
                        </h1>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $user->isSuperAdmin() ? 'bg-purple-100 text-purple-900 border border-purple-200' :
                               ($user->isVendor() ? 'bg-amber-100 text-amber-900 border border-amber-300' :
                               ($user->isPlanner() ? 'bg-indigo-100 text-indigo-900 border border-indigo-200' :
                               'bg-emerald-100 text-emerald-900 border border-emerald-200')) }}">
                            @if($user->isSuperAdmin()) 🛡️ Super Admin
                            @elseif($user->isVendor()) 🏛️ Verified Artisan Vendor
                            @elseif($user->isPlanner()) 📋 Professional Wedding Planner
                            @else 💍 Couple Co-Planner
                            @endif
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-on-surface-variant flex items-center gap-2">
                        <span>{{ $user->email }}</span>
                        @if($user->phone)
                            <span>•</span>
                            <span>{{ $user->phone }}</span>
                        @endif
                        <span>•</span>
                        <span class="text-primary font-semibold">Active Member</span>
                    </p>
                </div>
            </div>

            <!-- Role Dashboard Action -->
            <div class="relative z-10 flex items-center gap-3">
                @if($user->isSuperAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        <span>Control Center</span>
                    </a>
                @elseif($user->isVendor())
                    <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl gold-gradient-bg border border-amber-300 text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-sm hover:brightness-105 transition-all">
                        <span class="material-symbols-outlined text-[18px]">storefront</span>
                        <span>Atelier Studio</span>
                    </a>
                @elseif($user->isPlanner())
                    <a href="{{ route('planner.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">event_note</span>
                        <span>Planner Studio</span>
                    </a>
                @else
                    <a href="{{ route('workspace.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl gold-gradient-bg border border-amber-300 text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-sm hover:brightness-105 transition-all">
                        <span class="material-symbols-outlined text-[18px]">spa</span>
                        <span>My Workspace</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Role-Specific Profile View Dispatcher -->
        @if($user->isVendor())
            @include('auth.partials.vendor-profile')
        @elseif($user->isPlanner())
            @include('auth.partials.planner-profile')
        @elseif($user->isCouple())
            @include('auth.partials.couple-profile')
        @else
            @include('auth.partials.admin-profile')
        @endif
    </main>

    <!-- Footer -->
    <footer class="py-6 border-t border-outline-variant/30 text-center text-xs text-on-surface-variant bg-surface-container-low mt-16">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Connecting couples &amp; verified artisans across Sri Lanka.
    </footer>

</body>
</html>
