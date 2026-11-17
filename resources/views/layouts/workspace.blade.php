<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0c0d12]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Workspace — Wedora' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-luxury { font-family: 'Playfair Display', Georgia, serif; }
        .gold-gradient-text {
            background: linear-gradient(135deg, #d4af37 0%, #f3e5ab 50%, #aa771c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-gradient-bg {
            background: linear-gradient(135deg, #c5a059 0%, #d4af37 50%, #996515 100%);
        }
        .gold-border-glow {
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="min-h-screen text-slate-100 antialiased selection:bg-[#d4af37] selection:text-black flex flex-col justify-between">

    <!-- Top Workspace Navbar -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-[#0c0d12]/90 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Left: Brand & Active Wedding Context -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('workspace.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl gold-gradient-bg flex items-center justify-center text-slate-950 shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" opacity=".2"/>
                                <path d="M12 4.5c-4.14 0-7.5 3.36-7.5 7.5s3.36 7.5 7.5 7.5 7.5-3.36 7.5-7.5-3.36-7.5-7.5-7.5zm0 13c-3.03 0-5.5-2.47-5.5-5.5S8.97 6.5 12 6.5s5.5 2.47 5.5 5.5-2.47 5.5-5.5 5.5z"/>
                                <path d="M12 8a4 4 0 100 8 4 4 0 000-8zm0 6a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-serif-luxury text-xl font-bold tracking-tight text-white flex items-center gap-1">
                                Wedora<span class="text-[#d4af37]">.</span>
                            </span>
                        </div>
                    </a>

                    <!-- Wedding Workspace Switcher / Badge -->
                    @if(isset($currentWedding))
                        <div class="hidden sm:flex items-center gap-3 pl-6 border-l border-white/10">
                            <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-200 text-xs font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="font-semibold">{{ $currentWedding->title }}</span>
                                <span class="text-amber-400/60">•</span>
                                <span class="text-slate-400">{{ $currentWedding->district }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Collaboration indicator & User Menu -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('workspace.collaborators.index') }}" class="hidden md:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-white/10 hover:border-amber-500/40 bg-white/5 hover:bg-white/10 text-xs font-medium text-slate-300 transition-colors">
                        <span class="text-amber-400">👥</span>
                        <span>Partner & Team</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-4 border-l border-white/10">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 group">
                            <div class="w-9 h-9 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 flex items-center justify-center text-xs font-bold uppercase group-hover:scale-105 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden lg:block text-left">
                                <div class="text-xs font-semibold text-slate-200 group-hover:text-amber-300 transition-colors">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role->label() }}</div>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Sign Out" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-colors">
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
                <nav class="flex items-center gap-6 -mb-px text-xs font-medium overflow-x-auto no-scrollbar border-t border-white/5 pt-2">
                    <a href="{{ route('workspace.dashboard') }}" class="pb-3 border-b-2 {{ request()->routeIs('workspace.dashboard') ? 'border-[#d4af37] text-white font-semibold' : 'border-transparent text-slate-400 hover:text-slate-200' }} flex items-center gap-1.5 transition-colors">
                        <span>📊</span> Overview
                    </a>
                    <a href="{{ route('workspace.collaborators.index') }}" class="pb-3 border-b-2 {{ request()->routeIs('workspace.collaborators*') ? 'border-[#d4af37] text-white font-semibold' : 'border-transparent text-slate-400 hover:text-slate-200' }} flex items-center gap-1.5 transition-colors">
                        <span>👥</span> Partner & Team
                    </a>
                    <a href="#checklist" class="pb-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-1.5 transition-colors">
                        <span>✅</span> Checklist
                    </a>
                    <a href="#budget" class="pb-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-1.5 transition-colors">
                        <span>💰</span> Budget & Expenses
                    </a>
                    <a href="#guests" class="pb-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-1.5 transition-colors">
                        <span>💌</span> Guest List & RSVP
                    </a>
                    <a href="{{ route('home') }}#marketplace" class="pb-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-1.5 transition-colors">
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
            <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-sm flex items-center justify-between gap-3 shadow-lg shadow-amber-500/5">
                <div class="flex items-center gap-3">
                    <span class="text-amber-400 text-lg">✨</span>
                    <div>{{ session('success') }}</div>
                </div>
                @if(session('invite_url'))
                    <div class="flex items-center gap-2">
                        <button onclick="navigator.clipboard.writeText('{{ session('invite_url') }}'); alert('Invite link copied to clipboard!');" class="text-xs bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 font-semibold px-3 py-1.5 rounded-lg border border-amber-500/30 transition">
                            📋 Copy Invite Link
                        </button>
                    </div>
                @endif
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-200 text-sm flex items-center gap-3">
                <span class="text-blue-400 text-lg">ℹ️</span>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-200 text-sm">
                <div class="font-semibold mb-1 flex items-center gap-2">
                    <span>⚠️</span> Please resolve the following issues:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-300/90 pl-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Luxury Wedding Planning & Verified Vendor Network.
    </footer>

</body>
</html>
