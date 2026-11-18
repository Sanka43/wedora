<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal — Wedora Sri Lanka' }}</title>

    @include('layouts.head-meta')
</head>
<body class="min-h-full bg-surface text-on-surface font-body-md antialiased flex flex-col justify-between selection:bg-primary-fixed selection:text-on-primary-fixed">

    <!-- Top Navigation Bar -->
    <x-top-navbar />

    <!-- Flash Alerts -->
    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full -mb-20">
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm my-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-xs">✕</button>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-[#8c6d23] text-sm font-semibold flex items-center justify-between shadow-sm my-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-600">info</span>
                    <span>{{ session('info') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-amber-500 hover:text-[#8c6d23] text-xs">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm my-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600">warning</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 text-xs">✕</button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28 flex-1 w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-outline-variant/30 bg-surface-container-lowest py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-on-surface-variant">
            <div class="flex items-center gap-2">
                <span class="font-serif-luxury font-bold text-on-surface">Wedora Sri Lanka</span>
                <span>•</span>
                <span>Nuptial Enterprise OS</span>
            </div>
            <div>
                &copy; {{ date('Y') }} Wedora Platform. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
