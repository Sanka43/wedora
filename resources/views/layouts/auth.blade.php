<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Wedora — Sri Lankan Wedding Planning' }}</title>

    @include('layouts.head-meta')
</head>
<body class="min-h-full bg-surface text-on-surface font-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed flex flex-col justify-between">

    <!-- Top Navigation Bar -->
    <x-top-navbar />

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 pt-28 relative overflow-hidden">
        <!-- Soft Warm Ambient Orbs -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[550px] h-[350px] bg-primary-fixed/30 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="w-full {{ request()->routeIs('workspace.onboarding*') ? 'max-w-2xl' : 'max-w-md' }} relative z-10">
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
    <footer class="py-6 border-t border-outline-variant/30 text-center text-xs text-on-surface-variant bg-surface-container-low">
        &copy; {{ date('Y') }} Wedora Sri Lanka. Connecting couples &amp; verified artisans.
    </footer>

</body>
</html>
