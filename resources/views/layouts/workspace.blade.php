<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#faf8f5]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Workspace — Wedora' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#faf8f5] text-[#241f1a] antialiased selection:bg-[#d8b467] selection:text-[#1a140a] flex flex-col justify-between">

    <!-- Top Workspace Navbar -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/90 border-b border-[#ebd9c2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Left: Brand & Active Wedding Context -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('workspace.dashboard') }}" class="flex items-center gap-3.5 group">
                        <div class="w-10 h-10 rounded-xl gold-gradient-bg flex items-center justify-center text-[#1a140a] shadow-md shadow-[#c5a059]/20 group-hover:scale-105 transition-transform border border-amber-300">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2C11.5 3.5 10 5.5 10 7.5c0 1.38.9 2.5 2 2.5s2-1.12 2-2.5C14 5.5 12.5 3.5 12 2z" />
                                <path d="M12 11c-3.31 0-6 2.69-6 6v1h12v-1c0-3.31-2.69-6-6-6zm-4 5c.55-1.74 2.14-3 4-3s3.45 1.26 4 3H8z" />
                                <path d="M7 19h10v2H7z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-serif-luxury text-xl font-bold tracking-tight text-[#241f1a] flex items-center gap-1">
                                Wedora<span class="text-[#b8860b]">.</span>
                            </span>
                        </div>
                    </a>

                    <!-- Wedding Workspace Switcher / Badge -->
                    @if(isset($currentWedding))
                        <div class="hidden sm:flex items-center gap-3 pl-6 border-l border-[#ebd9c2]">
                            <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-300 text-[#8c6d23] text-xs font-bold">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="font-bold">{{ $currentWedding->title }}</span>
                                <span class="text-amber-300">•</span>
                                <span class="text-[#665c50] font-medium">{{ $currentWedding->district }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Collaboration indicator & User Menu -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('workspace.collaborators.index') }}" class="hidden md:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-[#ebd9c2] hover:border-[#b8860b] bg-white hover:bg-amber-50/50 text-xs font-bold text-[#52483d] transition-all shadow-sm">
                        <span class="text-[#8c6d23]">👥</span>
                        <span>Partner & Team</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-4 border-l border-[#ebd9c2]">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 group">
                            <div class="w-9 h-9 rounded-full gold-gradient-bg text-[#1a140a] border border-amber-300 flex items-center justify-center text-xs font-bold uppercase group-hover:scale-105 transition-transform shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden lg:block text-left">
                                <div class="text-xs font-bold text-[#241f1a] group-hover:text-[#8c6d23] transition-colors">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-[#736657] capitalize font-medium">{{ Auth::user()->role->label() }}</div>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Sign Out" class="p-2 rounded-xl text-[#736657] hover:text-rose-700 hover:bg-rose-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Workspace Sub-navigation Tabs -->
            @if(isset($currentWedding))
                <nav class="flex items-center gap-6 -mb-px text-xs font-bold overflow-x-auto no-scrollbar border-t border-[#ebd9c2]/60 pt-2">
                    <a href="{{ route('workspace.dashboard') }}" class="pb-3 border-b-2 {{ request()->routeIs('workspace.dashboard') ? 'border-[#b8860b] text-[#8c6d23]' : 'border-transparent text-[#736657] hover:text-[#241f1a]' }} flex items-center gap-1.5 transition-colors">
                        <span>📊</span> Overview
                    </a>
                    <a href="{{ route('workspace.collaborators.index') }}" class="pb-3 border-b-2 {{ request()->routeIs('workspace.collaborators*') ? 'border-[#b8860b] text-[#8c6d23]' : 'border-transparent text-[#736657] hover:text-[#241f1a]' }} flex items-center gap-1.5 transition-colors">
                        <span>👥</span> Partner & Team
                    </a>
                    <a href="#checklist" class="pb-3 border-b-2 border-transparent text-[#736657] hover:text-[#241f1a] flex items-center gap-1.5 transition-colors">
                        <span>✅</span> Cultural Checklist
                    </a>
                    <a href="#budget" class="pb-3 border-b-2 border-transparent text-[#736657] hover:text-[#241f1a] flex items-center gap-1.5 transition-colors">
                        <span>💰</span> LKR Budget
                    </a>
                    <a href="#guests" class="pb-3 border-b-2 border-transparent text-[#736657] hover:text-[#241f1a] flex items-center gap-1.5 transition-colors">
                        <span>💌</span> Guest Lists & RSVP
                    </a>
                    <a href="{{ route('home') }}#marketplace" class="pb-3 border-b-2 border-transparent text-[#736657] hover:text-[#241f1a] flex items-center gap-1.5 transition-colors">
                        <span>🏛️</span> Vendor Directory
                    </a>
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Workspace Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <!-- Toast Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-300 text-[#8c6d23] text-sm flex items-center justify-between gap-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-amber-600 text-lg">✨</span>
                    <div class="font-medium">{{ session('success') }}</div>
                </div>
                @if(session('invite_url'))
                    <div class="flex items-center gap-2">
                        <button onclick="navigator.clipboard.writeText('{{ session('invite_url') }}'); alert('Invite link copied to clipboard!');" class="text-xs gold-gradient-bg text-[#1a140a] font-bold px-3 py-1.5 rounded-lg border border-amber-300 transition shadow-sm">
                            📋 Copy Invite Link
                        </button>
                    </div>
                @endif
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-sm flex items-center gap-3 shadow-sm">
                <span class="text-blue-600 text-lg">ℹ️</span>
                <div class="font-medium">{{ session('info') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm shadow-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <span>⚠️</span> Please resolve the following issues:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-800 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#ebd9c2] bg-[#f5f0e8] py-6 text-center text-xs text-[#736657]">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Luxury Wedding Planning & Verified Vendor Network.
    </footer>

</body>
</html>