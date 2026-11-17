<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#faf8f5]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Wedora — Sri Lankan Wedding Planning' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-[#241f1a] bg-[#faf8f5] antialiased selection:bg-[#d8b467] selection:text-[#1a140a] flex flex-col justify-between">

    <!-- Top Announcement -->
    <div class="bg-gradient-to-r from-[#8c6d23] via-[#b8860b] to-[#8c6d23] text-white py-1.5 text-center text-xs tracking-wide font-medium px-4 shadow-sm">
        ✨ Welcome to Wedora — Sri Lanka's Premier Wedding Planning Platform
    </div>

    <!-- Navigation Header -->
    <header class="py-5 border-b border-[#ebd9c2] bg-white/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
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
                    <span class="block text-[9px] tracking-widest uppercase text-[#8c6d23] font-bold -mt-1">Sri Lanka</span>
                </div>
            </a>

            <div class="text-xs text-[#665c50]">
                @if(request()->routeIs('login'))
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-[#8c6d23] hover:underline font-bold ml-1">Create Account</a>
                @elseif(request()->routeIs('register'))
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#8c6d23] hover:underline font-bold ml-1">Sign In</a>
                @else
                    <a href="{{ route('home') }}" class="text-[#665c50] hover:text-[#241f1a] transition font-semibold">← Back to Homepage</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 relative overflow-hidden">
        <!-- Soft Warm Ambient Orbs -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[550px] h-[350px] bg-amber-200/40 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-300 text-[#8c6d23] text-sm flex items-start gap-3 shadow-sm">
                    <span class="text-amber-600 text-lg">✨</span>
                    <div class="font-medium">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-sm flex items-start gap-3 shadow-sm">
                    <span class="text-blue-600 text-lg">ℹ️</span>
                    <div class="font-medium">{{ session('info') }}</div>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-sm">
                    <span class="text-emerald-600 text-lg">✓</span>
                    <div class="font-medium">{{ session('status') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-sm shadow-sm">
                    <div class="font-bold mb-1 flex items-center gap-2">
                        <span>⚠️</span> Please correct the following:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-800 pl-1">
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
    <footer class="py-6 border-t border-[#ebd9c2] text-center text-xs text-[#736657] bg-[#f5f0e8]">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Connecting couples & verified artisans.
    </footer>

</body>
</html>