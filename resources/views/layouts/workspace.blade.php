<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Workspace — Wedora' }}</title>

    @include('layouts.head-meta')
</head>
<body class="min-h-screen bg-surface text-on-surface font-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed flex flex-col justify-between">

    <!-- Top Workspace Navbar with Home Design -->
    <x-top-navbar>
        @if(isset($currentWedding) && $currentWedding)
            <x-slot:subnav>
                <div class="max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin">
                    <div class="flex items-center justify-between py-2 border-t border-outline-variant/20 overflow-x-auto no-scrollbar gap-4 text-xs font-bold">
                        <!-- Active Wedding Context Indicator -->
                        <div class="hidden sm:flex items-center gap-2 px-3 py-1 rounded-full bg-primary-fixed/30 border border-primary-fixed text-primary shrink-0">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-bold">{{ Str::limit($currentWedding->title, 28) }}</span>
                            <span class="text-primary/50">•</span>
                            <span class="font-medium text-on-surface-variant">{{ $currentWedding->district }}</span>
                        </div>

                        <!-- Workspace Tabs -->
                        <nav class="flex items-center gap-4 sm:gap-6 -mb-px shrink-0">
                            <a href="{{ route('workspace.dashboard') }}" class="py-1.5 border-b-2 {{ request()->routeIs('workspace.dashboard') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface' }} flex items-center gap-1.5 transition-colors">
                                <span>📊</span> Overview
                            </a>
                            <a href="{{ route('workspace.collaborators.index') }}" class="py-1.5 border-b-2 {{ request()->routeIs('workspace.collaborators*') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface' }} flex items-center gap-1.5 transition-colors">
                                <span>👥</span> Partner &amp; Team
                            </a>
                            <a href="{{ route('home') }}#nekath-preview" class="py-1.5 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface flex items-center gap-1.5 transition-colors">
                                <span>✅</span> Cultural Checklist
                            </a>
                            <a href="{{ route('home') }}#budget-preview" class="py-1.5 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface flex items-center gap-1.5 transition-colors">
                                <span>💰</span> LKR Budget
                            </a>
                            <a href="{{ route('home') }}#rsvp-preview" class="py-1.5 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface flex items-center gap-1.5 transition-colors">
                                <span>💌</span> Guest Lists &amp; RSVP
                            </a>
                            <a href="{{ route('home') }}#marketplace-anchor" class="py-1.5 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface flex items-center gap-1.5 transition-colors">
                                <span>🏛️</span> Vendor Directory
                            </a>
                        </nav>
                    </div>
                </div>
            </x-slot:subnav>
        @endif
    </x-top-navbar>

    <!-- Main Workspace Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 {{ isset($currentWedding) && $currentWedding ? 'pt-36 sm:pt-40' : 'pt-28' }} w-full">
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
    <footer class="py-6 border-t border-outline-variant/30 text-center text-xs text-on-surface-variant bg-surface-container-low">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Connecting couples &amp; verified artisans.
    </footer>

</body>
</html>
