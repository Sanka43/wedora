<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0c0d12]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Wedora — Sri Lankan Wedding Planning' }}</title>

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
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.12);
        }
    </style>
</head>
<body class="h-full text-slate-100 antialiased selection:bg-[#d4af37] selection:text-black flex flex-col justify-between">

    <!-- Top Announcement -->
    <div class="bg-gradient-to-r from-amber-950/60 via-[#1e1507] to-amber-950/60 border-b border-amber-500/20 py-1.5 text-center text-xs tracking-wide text-amber-200/90 font-medium px-4">
        ✨ Wedora — Sri Lanka's First Dedicated Multi-Tenant Wedding Planning & Vendor Marketplace
    </div>

    <!-- Navigation Header -->
    <header class="py-5 border-b border-white/5 bg-[#0c0d12]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl gold-gradient-bg flex items-center justify-center text-slate-950 shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
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
                    <span class="block text-[9px] tracking-widest uppercase text-amber-300/60 font-semibold -mt-1">Sri Lanka</span>
                </div>
            </a>

            <div class="text-xs text-slate-400">
                @if(request()->routeIs('login'))
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-[#d4af37] hover:underline font-semibold ml-1">Create Account</a>
                @elseif(request()->routeIs('register'))
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#d4af37] hover:underline font-semibold ml-1">Sign In</a>
                @else
                    <a href="{{ route('home') }}" class="text-slate-300 hover:text-white transition">← Back to Homepage</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 relative overflow-hidden">
        <!-- Glow Orbs -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[500px] h-[300px] bg-amber-500/10 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-sm flex items-start gap-3">
                    <span class="text-amber-400 text-lg">✨</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-200 text-sm flex items-start gap-3">
                    <span class="text-blue-400 text-lg">ℹ️</span>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 text-sm flex items-start gap-3">
                    <span class="text-emerald-400 text-lg">✓</span>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-200 text-sm">
                    <div class="font-semibold mb-1 flex items-center gap-2">
                        <span>⚠️</span> Please correct the following errors:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-300/90 pl-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 border-t border-white/5 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Designed for unforgettable celebrations.
    </footer>

</body>
</html>
