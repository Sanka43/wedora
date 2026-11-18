<!-- Header Navigation Component matching Home Page Design -->
<header class="fixed top-0 left-0 right-0 z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-surface-container/60">
    <div class="h-20 max-w-[1440px] mx-auto px-4 sm:px-8 lg:px-margin flex items-center justify-between gap-space-lg">
        <!-- Brand Logo -->
        <div class="flex items-center gap-space-xl">
            <a class="flex items-center gap-2 sm:gap-space-sm group focus:outline-none" href="{{ route('home') }}">
                <img alt="Wedora Brand Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/ALJJyrDV7FsWCcfDEHeiPW7MvHAp6nWSnVFP5kdtZAQqu_9iK5WoqSmSq1CmmXs-h976EKUVgcE1euMglusBY5jPFKdNUu2PMJaXr7jDdYKjWkYboA-QUQp2eWfF0S9g1-G7niIYl-1EDydQjovM0ph7YqFd9aCgwSW9ZXZVBsl0KEn5ahOPLqP0IvWRg9glp646dQUO89D4_YXPw7UcUWpJ_BhiPl7_36kH_alP8DlrJVPF" onerror="this.onerror=null; this.style.display='none'; document.getElementById('brand-text-logo').classList.remove('hidden');">
                <span id="brand-text-logo" class="hidden font-headline-md text-headline-md text-primary font-bold tracking-tight">
                    Wedora<span class="text-tertiary">.</span>
                </span>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-space-lg" data-active-classes="text-primary font-semibold relative after:content-[''] after:absolute after:-bottom-2 after:left-0 after:right-0 after:h-0.5 after:bg-primary">
                <a class="font-title-sm text-title-sm transition-colors py-1 {{ request()->routeIs('home') && !request()->has('workspace') ? 'text-primary font-semibold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:right-0 after:h-0.5 after:bg-primary' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ route('home') }}#marketplace-anchor">Marketplace &amp; Vendors</a>
                <a class="font-title-sm text-title-sm transition-colors py-1 {{ request()->routeIs('workspace.*') ? 'text-primary font-semibold relative after:content-[\'\'] after:absolute after:-bottom-2 after:left-0 after:right-0 after:h-0.5 after:bg-primary' : 'text-on-surface-variant hover:text-on-surface' }}" href="{{ Auth::check() ? route('workspace.dashboard') : route('home') . '#workspace-preview' }}">Planning Workspace</a>
                <a class="font-title-sm text-title-sm text-on-surface-variant hover:text-on-surface transition-colors py-1" href="{{ route('home') }}#nekath-preview">Nekath &amp; Timeline</a>
                <a class="font-title-sm text-title-sm text-on-surface-variant hover:text-on-surface transition-colors py-1" href="{{ route('home') }}#budget-preview">Budget &amp; Expenses</a>
                <a class="font-title-sm text-title-sm text-on-surface-variant hover:text-on-surface transition-colors py-1" href="{{ route('home') }}#rsvp-preview">RSVP &amp; Guests</a>
                <a class="font-title-sm text-title-sm text-on-surface-variant hover:text-on-surface transition-colors py-1" href="{{ route('home') }}#pricing-preview">Membership</a>
            </nav>
        </div>

        <!-- Header Actions -->
        <div class="flex items-center gap-space-sm">
            @auth
                @php
                    $portalRoute = route('workspace.dashboard');
                    $portalLabel = 'My Workspace';
                    $portalIcon = 'spa';
                    $u = auth()->user();
                    if ($u->isSuperAdmin()) {
                        $portalRoute = route('admin.dashboard');
                        $portalLabel = 'Control Center';
                        $portalIcon = 'admin_panel_settings';
                    } elseif ($u->isVendor()) {
                        $portalRoute = route('vendor.dashboard');
                        $portalLabel = 'Vendor Portal';
                        $portalIcon = 'storefront';
                    } elseif ($u->isPlanner()) {
                        $portalRoute = route('planner.dashboard');
                        $portalLabel = 'Planner Studio';
                        $portalIcon = 'event_note';
                    }
                @endphp
                <a class="hidden sm:inline-flex items-center justify-center gap-space-xs px-3.5 py-2 text-on-surface-variant hover:text-on-surface font-title-sm text-title-sm transition-colors" href="{{ route('profile.show') }}">
                    <span class="material-symbols-outlined text-[18px]">account_circle</span>
                    <span>{{ Str::limit(auth()->user()->name, 14) }}</span>
                </a>
                <a class="inline-flex items-center justify-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm font-title-sm text-title-sm" href="{{ $portalRoute }}">
                    <span class="material-symbols-outlined text-[18px]">{{ $portalIcon }}</span>
                    <span>{{ $portalLabel }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hidden sm:inline-flex items-center justify-center p-2 rounded-lg text-on-surface-variant hover:text-error transition-colors" title="Logout">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                    </button>
                </form>
            @else
                <a class="hidden sm:inline-flex items-center justify-center px-space-md py-2 text-on-surface-variant hover:text-on-surface font-title-sm text-title-sm transition-colors" href="{{ route('login') }}">
                    Log In
                </a>
                <a class="inline-flex items-center justify-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-primary text-on-primary hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm font-title-sm text-title-sm" href="{{ route('register') }}">
                    <span class="material-symbols-outlined text-[18px]">spa</span>
                    <span>Sign Up Free</span>
                </a>
            @endauth

            <!-- Mobile Menu Button -->
            <button type="button" onclick="document.getElementById('mobile-drawer')?.classList.toggle('hidden')" class="lg:hidden p-2 rounded-lg text-on-surface-variant hover:bg-surface-container transition-colors focus:outline-none" aria-label="Toggle navigation menu">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>
        </div>
    </div>

    <!-- Optional Workspace Sub-Navigation Slot -->
    @if(isset($subnav) && $subnav)
        <div class="border-t border-outline-variant/30 bg-surface-container-lowest/95 backdrop-blur-md">
            {{ $subnav }}
        </div>
    @endif

    <!-- Mobile Drawer Navigation -->
    <div id="mobile-drawer" class="hidden lg:hidden border-t border-outline-variant/40 bg-surface-container-lowest px-4 py-4 space-y-3 shadow-lg">
        <a class="block py-2 {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }} text-title-sm" href="{{ route('home') }}#marketplace-anchor">Marketplace &amp; Vendors</a>
        <a class="block py-2 {{ request()->routeIs('workspace.*') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }} text-title-sm" href="{{ Auth::check() ? route('workspace.dashboard') : route('home') . '#workspace-preview' }}">Planning Workspace</a>
        <a class="block py-2 text-on-surface-variant hover:text-on-surface text-title-sm" href="{{ route('home') }}#nekath-preview">Nekath &amp; Timeline</a>
        <a class="block py-2 text-on-surface-variant hover:text-on-surface text-title-sm" href="{{ route('home') }}#budget-preview">Budget &amp; Expenses</a>
        <a class="block py-2 text-on-surface-variant hover:text-on-surface text-title-sm" href="{{ route('home') }}#rsvp-preview">RSVP &amp; Guests</a>
        <a class="block py-2 text-on-surface-variant hover:text-on-surface text-title-sm" href="{{ route('home') }}#pricing-preview">Membership</a>
        <div class="pt-3 border-t border-outline-variant/30 flex items-center justify-between">
            @auth
                @php
                    $drawerRoute = route('workspace.dashboard');
                    $drawerLabel = 'My Workspace';
                    $drawerIcon = 'spa';
                    $du = auth()->user();
                    if ($du->isSuperAdmin()) {
                        $drawerRoute = route('admin.dashboard');
                        $drawerLabel = 'Control Center';
                    } elseif ($du->isVendor()) {
                        $drawerRoute = route('vendor.dashboard');
                        $drawerLabel = 'Vendor Portal';
                    } elseif ($du->isPlanner()) {
                        $drawerRoute = route('planner.dashboard');
                        $drawerLabel = 'Planner Studio';
                    }
                @endphp
                <a href="{{ $drawerRoute }}" class="font-title-sm text-primary font-semibold">{{ $drawerLabel }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-error font-semibold">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="font-title-sm text-on-surface-variant font-semibold">Sign In</a>
                <a href="{{ route('register') }}" class="font-title-sm text-primary font-bold">Register Nuptials</a>
            @endauth
        </div>
    </div>
</header>
