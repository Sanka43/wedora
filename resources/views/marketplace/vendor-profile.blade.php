<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ $vendor->business_name }} — Wedora Ceylon Nuptials</title>

    @include('layouts.head-meta')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-fixed selection:text-on-primary-fixed pb-24 lg:pb-0">

    <!-- Top Navigation Bar -->
    <x-top-navbar />

    <!-- Success Flash Banner -->
    @if(session('success'))
        <div id="flash-banner" class="fixed top-20 left-4 right-4 sm:left-1/2 sm:-translate-x-1/2 sm:w-auto z-50 bg-tertiary text-on-tertiary px-5 py-3 rounded-xl shadow-xl flex items-center justify-between gap-3 transition-all animate-bounce">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] shrink-0">check_circle</span>
                <span class="font-title-sm text-xs sm:text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('flash-banner').remove()" class="text-white/80 hover:text-white font-bold text-lg p-1">&times;</button>
        </div>
    @endif

    <!-- Dynamic Toast Notification -->
    <div id="dynamic-toast" class="fixed bottom-24 lg:bottom-6 right-4 sm:right-6 left-4 sm:left-auto z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-on-background text-surface px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-primary/20 max-w-md ml-auto">
            <span id="toast-icon" class="material-symbols-outlined text-[20px] text-primary-fixed shrink-0">info</span>
            <span id="toast-message" class="font-body-sm text-xs sm:text-sm">Notification message</span>
        </div>
    </div>

    <!-- Main Content Container -->
    <main class="w-full pt-20 bg-surface min-h-[calc(100vh-80px)]">
        <div class="flex flex-col w-full">
            <div class="max-w-[1440px] w-full mx-auto px-4 sm:px-6 lg:px-margin py-4 sm:py-space-lg lg:py-space-xl">

                <!-- Breadcrumb (Hidden on extra small screens to save space) -->
                <nav class="hidden sm:flex items-center gap-space-sm text-body-sm font-body-sm text-on-surface-variant mb-4 lg:mb-space-lg">
                    <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Marketplace</a>
                    <span>/</span>
                    <a class="hover:text-primary transition-colors" href="#">{{ $vendor->category?->name ?? 'Photographers & Cinema' }}</a>
                    <span>/</span>
                    <span class="text-on-surface font-medium truncate">{{ $vendor->business_name }}</span>
                </nav>

                <!-- Atelier Verification Banner (Mobile Optimized) -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 sm:p-space-md rounded-xl bg-surface-container-low mb-4 lg:mb-space-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-[20px] sm:text-[22px]">verified</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="font-label-caps text-label-caps uppercase tracking-wider text-primary font-bold">Wedora Verified Atelier</span>
                                <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
                                <span class="font-label-caps text-label-caps uppercase tracking-wider text-tertiary font-bold">2025 Gold Awardee</span>
                            </div>
                            <p class="font-body-sm text-[11px] sm:text-body-sm text-on-surface-variant mt-0.5">Vetted under Wedora Nuptial Quality Charter • Escrow Insured up to LKR 1,500,000</p>
                        </div>
                    </div>
                    <!-- Desktop Action Buttons -->
                    <div class="hidden sm:flex items-center gap-space-sm">
                        <form id="favorite-form" action="{{ route('vendors.favorite.toggle', $vendor->slug) }}" method="POST" class="inline">
                            @csrf
                            <button id="favorite-button" class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded-full bg-surface-container-lowest text-on-surface text-label-lg font-label-lg shadow-sm hover:bg-surface-container transition-colors" type="button" onclick="toggleShortlist()">
                                <span id="favorite-icon" class="material-symbols-outlined text-[18px] text-error" style="font-variation-settings: 'FILL' {{ $isFavorited ? '1' : '0' }};">favorite</span>
                                <span id="favorite-text">{{ $isFavorited ? 'Shortlisted' : 'Shortlist' }}</span>
                            </button>
                        </form>
                        <button class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded-full bg-surface-container-lowest text-on-surface text-label-lg font-label-lg shadow-sm hover:bg-surface-container transition-colors" type="button" onclick="shareProfile()">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                            <span>Share Profile</span>
                        </button>
                    </div>
                </div>

                <!-- Editorial Gallery (Mobile-First Hero + Desktop 12-Col Mosaic) -->
                @php
                    $coverMedia = $vendor->media->firstWhere('is_cover', true) ?? $vendor->media->first();
                    $thumbnails = $vendor->media->where('is_cover', false)->values();
                    $totalPhotosCount = 186;
                @endphp

                <!-- Mobile View Hero Image (< lg) -->
                <div class="lg:hidden relative rounded-2xl overflow-hidden shadow-md mb-4 bg-surface-container aspect-[4/3] sm:aspect-[16/9] cursor-pointer" onclick="openLightbox(0)">
                    <img class="w-full h-full object-cover" 
                         src="{{ $coverMedia?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdvX8u-VF5Q7cuJP2MmIjK2PpdtiXP7RSQx8LRum5ToF1fUCSTrVdmJtTdFLvIiJV7sZfDh7VSUi8R8pH08PiMoJ1FLqhGpQoTC7rgQtUSQojY5_EecSY0lhJiR-0siXeMyu5RfErQ_GMWFm6sklRUvxfKfJ2Lb26Jwp3ZOWXZ6n1jWEaGKTrFoKlhb68umzoexUYOF_mmAe9VcD-1WZpzhfR9rPUMurqhM9AicD2B' }}" 
                         alt="{{ $coverMedia?->caption ?? 'Cover Feature' }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-on-background/80 via-black/20 to-transparent flex flex-col justify-end p-4">
                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md w-fit mb-1 shadow-sm">
                            <span class="material-symbols-outlined text-[14px] text-primary">auto_awesome</span>
                            <span class="font-label-caps text-[10px] text-on-surface uppercase tracking-wider">{{ $coverMedia?->caption ?? 'Galle Fort Nuptials' }}</span>
                        </div>
                        <p class="font-headline-md text-base sm:text-lg text-surface font-semibold line-clamp-1">"Sacred heirlooms preserved with modern cinematic reverence."</p>
                    </div>
                    <!-- Mobile Floating Photo Count Pill -->
                    <button class="absolute bottom-3 right-3 px-3 py-1 rounded-full bg-on-background/70 hover:bg-on-background/90 text-surface backdrop-blur-md text-xs font-semibold flex items-center gap-1.5 shadow-lg tap-highlight-none" type="button" onclick="event.stopPropagation(); openLightbox(0);">
                        <span class="material-symbols-outlined text-[16px]">photo_camera</span>
                        <span>1/4 • All ({{ $totalPhotosCount }}+)</span>
                    </button>
                </div>

                <!-- Desktop View 12-Col Mosaic (>= lg) -->
                <div class="hidden lg:grid grid-cols-12 gap-space-sm mb-space-xl rounded-xl overflow-hidden shadow-md">
                    <div class="col-span-8 relative group overflow-hidden min-h-[520px] cursor-pointer" onclick="openLightbox(0)">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                             src="{{ $coverMedia?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdvX8u-VF5Q7cuJP2MmIjK2PpdtiXP7RSQx8LRum5ToF1fUCSTrVdmJtTdFLvIiJV7sZfDh7VSUi8R8pH08PiMoJ1FLqhGpQoTC7rgQtUSQojY5_EecSY0lhJiR-0siXeMyu5RfErQ_GMWFm6sklRUvxfKfJ2Lb26Jwp3ZOWXZ6n1jWEaGKTrFoKlhb68umzoexUYOF_mmAe9VcD-1WZpzhfR9rPUMurqhM9AicD2B' }}" 
                             alt="{{ $coverMedia?->caption ?? 'Cover Feature' }}"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-on-background/80 via-transparent to-transparent flex flex-col justify-end p-space-xl">
                            <div class="inline-flex items-center gap-space-xs px-space-sm py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md w-fit mb-space-xs">
                                <span class="material-symbols-outlined text-[16px] text-primary">auto_awesome</span>
                                <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider">{{ $coverMedia?->caption ?? 'Cover Feature • Galle Fort Nuptials' }}</span>
                            </div>
                            <p class="font-headline-md text-headline-md text-surface max-w-xl">"Sacred heirlooms preserved with modern cinematic reverence."</p>
                        </div>
                    </div>
                    <div class="col-span-4 grid grid-cols-1 gap-space-sm">
                        <div class="relative group overflow-hidden h-[168px] rounded-lg cursor-pointer" onclick="openLightbox(1)">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                                 src="{{ $thumbnails[0]?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCVjheqc1ty7w6BhPZa4MH5HSI9dxXzNPQMl6Y8rILb5nqFjZiJn1tC57VSfaM_xX9RpPKd_Cd4-Ckuoe_eYnUTtcVXrN88hKTOM6L_HlZIjUAMbfjl7HrhqK5d0xG9gNtbXfQM4hS7ri5qaBZZvPSkEhYK_Z1oZV4RZhzgqUONfyqLCFJvFWWoz6bDSa_XgxQhATDKERdupspGSahrzftFPwQlIM07Lxw1vw0QPROR' }}" 
                                 alt="Rituals & Nuool"/>
                            <div class="absolute inset-0 bg-on-background/20 group-hover:bg-transparent transition-colors"></div>
                            <span class="absolute bottom-2 left-2 px-space-xs py-0.5 rounded bg-surface-container-lowest/80 backdrop-blur text-label-caps font-label-caps text-on-surface">{{ $thumbnails[0]?->caption ?? 'Rituals & Nuool' }}</span>
                        </div>
                        <div class="relative group overflow-hidden h-[168px] rounded-lg cursor-pointer" onclick="openLightbox(2)">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                                 src="{{ $thumbnails[1]?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuB7XYUZCwAZZsTpnTBfr1Yb9x7gn2tXphB81xNA8QJW3rDmCB8LptEplS_AjLVpj1MraNotkI-Mpvm5oVCml52h7qwfAff85kPXUfa1QpDWzQ--FXDvBhwZitL5raMgGOxEwFD5j-uEHydUGK7v4cq9mFXIg9qQ7r_ZuTs7F09UUuJRTI7oViKgg68jJtz0_Bq1kmN1XVQaEfLvBsBZf9-7l9erYeDgnVvc5DA7MSov' }}" 
                                 alt="Aerial & Estate Venues"/>
                            <div class="absolute inset-0 bg-on-background/20 group-hover:bg-transparent transition-colors"></div>
                            <span class="absolute bottom-2 left-2 px-space-xs py-0.5 rounded bg-surface-container-lowest/80 backdrop-blur text-label-caps font-label-caps text-on-surface">{{ $thumbnails[1]?->caption ?? 'Aerial & Estate Venues' }}</span>
                        </div>
                        <div class="relative group overflow-hidden h-[168px] rounded-lg cursor-pointer" onclick="openLightbox(3)">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" 
                                 src="{{ $thumbnails[2]?->file_path ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcHK2gEp4Aslx-zEN_lDw7xKewgyiG-x5n1nH3J6qf2cC2eEK7-0yVsP1gG2ig0nDdABu7JpxRxNu5SJr4UMdaYPTGU2Gi76iadsq2FCQTTio4FfGrlo8R4BgecDM5O8LaSuZJc87BCSEx0MAjsCk5XQJ6b9UcMX1v13IZ2cmPxV7B-zlf5c0wygFfE34jwVegsiPJCTfBYWCn0wIZGeMmnjsPZeYfz2CIhawhdJtT' }}" 
                                 alt="Grand ballroom works"/>
                            <div class="absolute inset-0 bg-on-background/40 flex items-center justify-center group-hover:bg-on-background/50 transition-colors">
                                <div class="flex items-center gap-space-xs text-surface font-title-sm text-title-sm">
                                    <span class="material-symbols-outlined text-[22px]">photo_library</span>
                                    <span>+186 Portfolio Works</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendor Identity & Metadata Strip (Mobile Friendly Bento) -->
                <div class="p-4 sm:p-space-lg lg:p-space-xl rounded-2xl bg-surface-container-lowest shadow-sm mb-4 lg:mb-space-2xl border border-surface-container/60">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-space-lg">
                        <div class="flex flex-col gap-1 sm:gap-space-xs">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h1 class="font-headline-lg text-2xl sm:text-3xl lg:text-headline-lg text-on-surface font-bold">{{ $vendor->business_name }}</h1>
                                <span class="px-2.5 py-0.5 rounded-full bg-primary-fixed/40 text-on-primary-fixed-variant font-label-caps text-[10px] uppercase tracking-wider font-semibold">Fine Art Photography &amp; Cinema</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 sm:gap-space-md text-on-surface-variant font-body-sm text-xs sm:text-body-sm mt-1">
                                <!-- Star Rating -->
                                <div class="flex items-center gap-1">
                                    <div class="flex text-primary">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                        @endfor
                                    </div>
                                    <span class="font-bold text-on-surface ml-0.5">{{ number_format($vendor->rating_avg, 2) }}</span>
                                    <span>({{ $vendor->reviews_count }})</span>
                                    <span class="text-tertiary font-semibold ml-1 hidden sm:inline">• 98% Recommended</span>
                                </div>
                                <span class="hidden sm:inline">•</span>
                                <!-- Location -->
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                                    <span class="text-on-surface">{{ $vendor->address ?: 'Colombo 07, Western Province' }}</span>
                                    <span class="text-on-surface-variant text-[11px] hidden sm:inline">(Islandwide &amp; Overseas)</span>
                                </div>
                            </div>

                            <!-- Specialization Tags (Mobile Touch Carousel) -->
                            <div class="flex items-center gap-1.5 mt-2.5 overflow-x-auto no-scrollbar pb-1">
                                <span class="shrink-0 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">Poruwa Rituals</span>
                                <span class="shrink-0 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">Candid Storytelling</span>
                                <span class="shrink-0 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">Dual Sony FX3</span>
                                <span class="shrink-0 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">Drone 4K</span>
                                <span class="shrink-0 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-caps text-[10px]">Destination Weddings</span>
                            </div>
                        </div>

                        <!-- Quick Stats Bento (Mobile Compact 3-Column) -->
                        <div class="grid grid-cols-3 gap-1 sm:gap-space-md p-2.5 sm:p-space-md rounded-xl bg-surface-container-low shrink-0 text-center border border-outline-variant/20">
                            <div class="px-1 sm:px-space-sm">
                                <span class="block font-headline-sm text-lg sm:text-headline-sm text-primary font-bold">12+</span>
                                <span class="font-label-caps text-[9px] sm:text-label-caps text-on-surface-variant uppercase">Years Craft</span>
                            </div>
                            <div class="px-1 sm:px-space-sm border-x border-outline-variant/30">
                                <span class="block font-headline-sm text-lg sm:text-headline-sm text-primary font-bold">480+</span>
                                <span class="font-label-caps text-[9px] sm:text-label-caps text-on-surface-variant uppercase">Weddings</span>
                            </div>
                            <div class="px-1 sm:px-space-sm">
                                <span class="block font-headline-sm text-lg sm:text-headline-sm text-tertiary font-bold">14 Days</span>
                                <span class="font-label-caps text-[9px] sm:text-label-caps text-on-surface-variant uppercase">Teaser Film</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2-Column Split: Content Tabs vs Sticky RFQ Booking Box -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-space-xl items-start">

                    <!-- Left Column (8 cols) -->
                    <div class="lg:col-span-8 flex flex-col gap-6 lg:gap-space-2xl">

                        <!-- Sticky Touch Navigation Tabs -->
                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 sticky top-16 lg:top-20 z-40 bg-surface/95 py-2.5 backdrop-blur -mx-4 px-4 sm:mx-0 sm:px-0">
                            <button id="tab-btn-overview" onclick="switchTab('overview')" class="tab-btn shrink-0 px-3.5 py-2 rounded-lg bg-on-background text-surface font-title-sm text-xs sm:text-title-sm whitespace-nowrap shadow-sm transition-all tap-highlight-none" type="button">
                                Overview
                            </button>
                            <button id="tab-btn-packages" onclick="switchTab('packages')" class="tab-btn shrink-0 px-3.5 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-title-sm text-xs sm:text-title-sm whitespace-nowrap transition-colors tap-highlight-none" type="button">
                                Packages &amp; Pricing
                            </button>
                            <button id="tab-btn-portfolio" onclick="switchTab('portfolio')" class="tab-btn shrink-0 px-3.5 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-title-sm text-xs sm:text-title-sm whitespace-nowrap transition-colors tap-highlight-none" type="button">
                                Portfolio (186+)
                            </button>
                            <button id="tab-btn-reviews" onclick="switchTab('reviews')" class="tab-btn shrink-0 px-3.5 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-title-sm text-xs sm:text-title-sm whitespace-nowrap transition-colors tap-highlight-none" type="button">
                                Reviews ({{ number_format($vendor->rating_avg, 1) }} ★)
                            </button>
                            <button id="tab-btn-nekath" onclick="switchTab('nekath')" class="tab-btn shrink-0 px-3.5 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-title-sm text-xs sm:text-title-sm whitespace-nowrap transition-colors tap-highlight-none" type="button">
                                Nekath Guarantee
                            </button>
                        </div>

                        <!-- Section 1: Philosophy & Cultural Mastery -->
                        <div id="section-overview" class="p-4 sm:p-space-lg lg:p-space-xl rounded-2xl bg-surface-container-lowest shadow-sm flex flex-col gap-4 sm:gap-space-lg scroll-mt-32 border border-surface-container/60">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-primary uppercase tracking-widest font-bold">Artistic Philosophy</span>
                                <span class="font-label-caps text-label-caps text-on-surface-variant">Est. 2013 • Sri Lanka</span>
                            </div>
                            <h2 class="font-headline-md text-xl sm:text-headline-md text-on-surface leading-snug">
                                Crafting timeless family heirlooms that honor the sanctity of Ceylon tradition with modern European editorial poise.
                            </h2>
                            <p class="font-body-md text-sm sm:text-body-lg text-on-surface-variant leading-relaxed">
                                {{ $vendor->description }}
                            </p>

                            <!-- Nuptial Mastery Points -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                <div class="p-3.5 rounded-xl bg-surface-container-low flex flex-col gap-1 border border-outline-variant/15">
                                    <div class="flex items-center gap-1.5 text-primary">
                                        <span class="material-symbols-outlined text-[18px]">temple_buddhist</span>
                                        <span class="font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">Unobtrusive Poruwa Discipline</span>
                                    </div>
                                    <p class="font-body-sm text-xs text-on-surface-variant">
                                        Trained specifically to shoot without stepping inside the consecrated Poruwa perimeter or disrupting the Ashtaka reciter's sacred verses.
                                    </p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-surface-container-low flex flex-col gap-1 border border-outline-variant/15">
                                    <div class="flex items-center gap-1.5 text-tertiary">
                                        <span class="material-symbols-outlined text-[18px]">shutter_speed</span>
                                        <span class="font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">Nekath Precision Burst</span>
                                    </div>
                                    <p class="font-body-sm text-xs text-on-surface-variant">
                                        Synchronized dual cameras timed to capture the split-second split of the coconut (Pol Geseema) and the sanctified water libation (Pen Wedeema).
                                    </p>
                                </div>
                            </div>

                            <!-- Studio Equipment & Archive Standards -->
                            <div class="mt-2 pt-4 border-t border-surface-container">
                                <h3 class="font-title-md text-sm sm:text-title-md text-on-surface mb-3 font-semibold">Studio Equipment &amp; Archive Standards</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-space-md">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">videocam</span>
                                        <span class="font-body-sm text-xs text-on-surface">Dual Sony FX3 Rig</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">photo_camera</span>
                                        <span class="font-body-sm text-xs text-on-surface">Sony A1 (50MP Raw)</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">flight</span>
                                        <span class="font-body-sm text-xs text-on-surface">DJI Inspire 3 4K</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">menu_book</span>
                                        <span class="font-body-sm text-xs text-on-surface">Italian Leather Album</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">cloud_download</span>
                                        <span class="font-body-sm text-xs text-on-surface">10-Yr Cloud Vault</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0">hard_drive</span>
                                        <span class="font-body-sm text-xs text-on-surface">1TB Raw Master HDD</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Packages & Pricing (Mobile First Cards) -->
                        <div id="section-packages" class="flex flex-col gap-4 lg:gap-space-lg scroll-mt-32">
                            <div class="flex flex-col">
                                <span class="font-label-caps text-label-caps text-primary uppercase tracking-widest font-bold">Nuptial Investment</span>
                                <h2 class="font-headline-md text-xl sm:text-headline-md text-on-surface">Curated Wedding Packages</h2>
                                <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">All investments quoted in Sri Lankan Rupees (LKR) with no hidden surcharges.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-space-md">
                                @forelse($vendor->packages as $index => $pkg)
                                    @php
                                        $isPopular = ($index === 1 || str_contains(strtolower($pkg->name), 'royal'));
                                    @endphp
                                    <div class="p-4 sm:p-space-lg rounded-2xl bg-surface-container-lowest {{ $isPopular ? 'shadow-md relative ring-2 ring-primary-container' : 'shadow-sm hover:shadow-md' }} flex flex-col justify-between transition-all border border-surface-container/60" data-package-id="{{ $pkg->id }}">
                                        @if($isPopular)
                                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-primary-container text-on-primary-container font-label-caps text-[10px] uppercase tracking-wider font-bold shadow-sm whitespace-nowrap">
                                                Most Requested by Couples
                                            </div>
                                        @endif

                                        <div class="flex flex-col gap-2">
                                            <span class="font-label-caps text-label-caps {{ $isPopular ? 'text-primary font-bold' : 'text-on-surface-variant' }} uppercase">
                                                {{ $index === 0 ? 'Single Event' : ($index === 1 ? 'Wedding & Homecoming' : 'Destination & Multi-Day') }}
                                            </span>
                                            <h3 class="font-title-lg text-base sm:text-title-lg text-on-surface font-bold">{{ $pkg->name }}</h3>
                                            <div class="my-1">
                                                <span class="font-label-caps text-label-caps text-primary font-bold">LKR</span>
                                                <span class="font-headline-md text-2xl sm:text-headline-md text-on-surface font-semibold ml-1">{{ number_format($pkg->price) }}</span>
                                            </div>
                                            <p class="font-body-sm text-xs sm:text-body-sm text-on-surface-variant leading-relaxed">{{ $pkg->description }}</p>

                                            <div class="w-full h-[1px] bg-surface-container my-2"></div>

                                            <ul class="flex flex-col gap-2 font-body-sm text-xs sm:text-body-sm text-on-surface">
                                                @if(is_array($pkg->features))
                                                    @foreach($pkg->features as $feature)
                                                        <li class="flex items-center gap-2">
                                                            <span class="material-symbols-outlined text-[16px] text-primary shrink-0">check_circle</span>
                                                            <span>{{ $feature }}</span>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>

                                        <button class="mt-4 sm:mt-space-lg w-full py-2.5 sm:py-2 rounded-xl {{ $isPopular ? 'bg-primary text-on-primary hover:bg-on-background shadow-sm' : 'bg-surface-container-low hover:bg-surface-container text-on-surface' }} font-title-sm text-xs sm:text-title-sm transition-all package-select-btn tap-highlight-none font-semibold flex items-center justify-center gap-1.5" 
                                                type="button" 
                                                onclick="selectPackage({{ $pkg->id }}, '{{ addslashes($pkg->name) }}', {{ $pkg->price }})">
                                            <span class="material-symbols-outlined text-[16px]">touch_app</span>
                                            <span>Select Package</span>
                                        </button>
                                    </div>
                                @empty
                                    <div class="col-span-3 p-6 text-center bg-surface-container-lowest rounded-xl">
                                        <p class="text-on-surface-variant">Custom package quotation available upon request.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Section 3: Verified Client Review Showcase -->
                        <div id="section-reviews" class="p-4 sm:p-space-lg lg:p-space-xl rounded-2xl bg-surface-container-lowest shadow-sm flex flex-col gap-4 sm:gap-space-lg scroll-mt-32 border border-surface-container/60">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div>
                                    <span class="font-label-caps text-label-caps text-tertiary uppercase tracking-widest font-bold">Nuptial Testimonials</span>
                                    <h2 class="font-headline-sm text-xl sm:text-headline-sm text-on-surface">Words from Wedora Couples</h2>
                                </div>
                                <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-surface-container text-xs font-semibold">
                                    <span class="material-symbols-outlined text-[16px] text-primary">verified_user</span>
                                    <span>100% Verified Couples</span>
                                </div>
                            </div>

                            @forelse($vendor->reviews as $review)
                                <div class="p-4 rounded-xl bg-surface-container-low flex flex-col gap-3 relative border border-outline-variant/15">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-on-primary-fixed text-xs">
                                                {{ strtoupper(substr($review->user?->name ?? 'SW', 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-title-sm text-xs sm:text-title-sm text-on-surface font-semibold">{{ $review->user?->name ?? 'Shenali & Raveen Wickremasinghe' }}</h4>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">
                                                    {{ $review->wedding?->title ?? 'Poruwa Nuptials at Shangri-La Colombo' }} • {{ $review->created_at->format('M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex text-primary">
                                            @for($i = 1; $i <= $review->rating; $i++)
                                                <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="font-body-md text-xs sm:text-sm text-on-surface italic leading-relaxed">
                                        "{{ $review->comment }}"
                                    </p>
                                </div>
                            @empty
                                <div class="p-6 rounded-xl bg-surface-container-low text-center">
                                    <span class="material-symbols-outlined text-3xl text-on-surface-variant/40 mb-2">reviews</span>
                                    <p class="font-body-md text-xs sm:text-sm text-on-surface-variant">No client reviews submitted for this atelier yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Section 4: Nekath Readiness & Cultural Astrological Assurance -->
                        <div id="section-nekath" class="p-4 sm:p-space-lg lg:p-space-xl rounded-2xl bg-surface-container-lowest shadow-sm flex flex-col gap-3 sm:gap-space-md scroll-mt-32 border border-surface-container/60">
                            <div class="flex items-center gap-1.5 text-tertiary">
                                <span class="material-symbols-outlined text-[18px]">schedule</span>
                                <span class="font-label-caps text-label-caps uppercase tracking-wider font-bold">Wedora Astrological Synchrony</span>
                            </div>
                            <h2 class="font-headline-sm text-xl sm:text-headline-sm text-on-surface">Nekath Readiness Guarantee</h2>
                            <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant leading-relaxed">
                                In Sinhala and Tamil nuptials, auspicious timings (Nekath) are non-negotiable. Our studio adheres to a strict protocol: crew arrival 90 minutes prior to the Nekath window, pre-calibrated ambient lighting sensors, and direct coordination with your designated Poruwa Ashtaka conductor.
                            </p>
                            <div class="flex flex-col sm:flex-row flex-wrap gap-2.5 pt-2 text-xs sm:text-body-sm text-on-surface">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">task_alt</span>
                                    <span>Arrival: 90 mins prior to Nekath</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">task_alt</span>
                                    <span>Dual Audio Mics for Ashtaka &amp; Gatha</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">task_alt</span>
                                    <span>Backup camera bodies on-site</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Booking & RFQ Box (Desktop Sticky / Mobile In-Flow) -->
                    <div class="lg:col-span-4 lg:sticky lg:top-24 flex flex-col gap-4" id="booking-card">
                        
                        <!-- Main RFQ Form Card -->
                        <div class="p-4 sm:p-space-xl rounded-2xl bg-surface-container-lowest shadow-md flex flex-col gap-4 sm:gap-space-lg border border-surface-container">
                            
                            <!-- Price & Payment Terms Summary -->
                            <div class="flex flex-col gap-1 pb-3 border-b border-surface-container">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase" id="investment-label">Starting Investment</span>
                                    <span class="text-[11px] text-tertiary font-semibold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">shield</span> Insured
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="font-label-caps text-label-caps text-primary font-bold">LKR</span>
                                    <span class="font-headline-lg text-2xl sm:text-headline-lg text-on-surface font-semibold" id="dynamic-display-price">{{ number_format($vendor->starting_price ?? 280000) }}</span>
                                    <span class="font-body-sm text-xs text-on-surface-variant" id="dynamic-price-suffix">onwards</span>
                                </div>
                                <div id="selected-package-badge" class="hidden items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary-fixed/40 text-on-primary-fixed-variant text-xs font-semibold w-fit mt-1">
                                    <span class="material-symbols-outlined text-[14px] text-primary">bookmark</span>
                                    <span id="selected-package-badge-name">The Royal Sovereign Experience</span>
                                    <button type="button" onclick="clearSelectedPackage()" class="ml-1 text-on-primary-fixed-variant/70 hover:text-on-primary-fixed-variant font-bold text-sm leading-none">&times;</button>
                                </div>
                                <div class="flex items-center gap-1.5 mt-1 text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[15px] text-tertiary">payments</span>
                                    <span>Structured Tranches: 30% • 50% • 20%</span>
                                </div>
                            </div>

                            <!-- Date Selector & Real-Time Availability Widget (Mobile Native Calendar) -->
                            <div class="flex flex-col gap-1">
                                <label class="font-label-caps text-label-caps uppercase tracking-wider text-on-surface font-semibold text-xs" for="event-date-input">
                                    Select Your Nuptial Date
                                </label>
                                <div class="relative">
                                    <input type="date" name="event_date_picker" id="event-date-input" value="2025-12-18" 
                                           class="w-full px-3 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-title-sm text-sm focus:outline-none border border-outline-variant/30 cursor-pointer" 
                                           onchange="updateDateDisplay(this.value)">
                                </div>
                                <!-- Dynamic Availability Pill -->
                                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed/40 text-on-tertiary-fixed-variant mt-1">
                                    <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse shrink-0"></span>
                                    <span class="font-label-caps text-[10px] uppercase font-bold tracking-wider" id="availability-status-text">Date Available for Nuptial Booking</span>
                                </div>
                            </div>

                            <!-- Interactive Request for Quotation (RFQ) Form -->
                            <form id="rfq-form" action="{{ route('vendors.rfq.store', $vendor->slug) }}" method="POST" class="flex flex-col gap-3.5" onsubmit="handleRfqSubmit(event)">
                                @csrf
                                <input type="hidden" name="package_id" id="form-package-id" value="">
                                <input type="hidden" name="event_date" id="hidden-event-date" value="2025-12-18">

                                <!-- Ceremony Type -->
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-caps text-label-caps text-on-surface uppercase font-semibold text-xs">Ceremony Style</label>
                                    <select name="ceremony_style" class="w-full px-3 py-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-sm text-xs sm:text-sm focus:outline-none focus:bg-surface-container border border-outline-variant/30">
                                        <option value="Traditional Poruwa + Western Reception" selected>Traditional Poruwa + Western Reception</option>
                                        <option value="Poruwa Only (Morning Ceremony)">Poruwa Only (Morning Ceremony)</option>
                                        <option value="Destination Coastal Wedding (Bentota / Galle)">Destination Coastal Wedding (Bentota / Galle)</option>
                                        <option value="Highland Estate Nuptials (Kandy / Nuwara Eliya)">Highland Estate Nuptials (Kandy / Nuwara Eliya)</option>
                                        <option value="Multi-Day Nuptial + Homecoming Celebration">Multi-Day Nuptial + Homecoming Celebration</option>
                                    </select>
                                </div>

                                <!-- District & Venue -->
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-caps text-label-caps text-on-surface uppercase font-semibold text-xs">District &amp; Venue</label>
                                    <div class="flex items-center px-3 py-2 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant mr-2 shrink-0">apartment</span>
                                        <input name="venue_location" class="bg-transparent w-full text-on-surface font-body-sm text-xs sm:text-sm focus:outline-none" type="text" value="Colombo • Cinnamon Grand (Oak Room)"/>
                                    </div>
                                </div>

                                <!-- Guest Count -->
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-caps text-label-caps text-on-surface uppercase font-semibold text-xs">Estimated Guest Count</label>
                                    <div class="flex items-center px-3 py-2 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant mr-2 shrink-0">groups</span>
                                        <input name="guest_count" class="bg-transparent w-full text-on-surface font-body-sm text-xs sm:text-sm focus:outline-none" type="number" min="1" max="5000" value="350"/>
                                    </div>
                                </div>

                                <!-- Touch-Friendly Coverage Checklist (Interactive Chips) -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="font-label-caps text-label-caps text-on-surface uppercase font-semibold text-xs">Services Required (Tap to Toggle)</label>
                                    <div class="grid grid-cols-2 gap-2 pt-1" id="service-chips-container">
                                        <!-- Chip 1: Stills -->
                                        <label class="service-chip flex items-center gap-2 p-2.5 rounded-xl border border-primary bg-primary-fixed/30 text-on-surface text-xs font-semibold cursor-pointer transition-all select-none min-h-[44px]">
                                            <input name="services[]" value="Stills Photography" checked class="hidden" type="checkbox" onchange="toggleChipStyle(this)"/>
                                            <span class="material-symbols-outlined text-[16px] text-primary chip-icon">check_circle</span>
                                            <span class="truncate">Stills Photo</span>
                                        </label>
                                        <!-- Chip 2: Cinema -->
                                        <label class="service-chip flex items-center gap-2 p-2.5 rounded-xl border border-primary bg-primary-fixed/30 text-on-surface text-xs font-semibold cursor-pointer transition-all select-none min-h-[44px]">
                                            <input name="services[]" value="4K Cinematography" checked class="hidden" type="checkbox" onchange="toggleChipStyle(this)"/>
                                            <span class="material-symbols-outlined text-[16px] text-primary chip-icon">check_circle</span>
                                            <span class="truncate">4K Cinema</span>
                                        </label>
                                        <!-- Chip 3: Pre-Shoot -->
                                        <label class="service-chip flex items-center gap-2 p-2.5 rounded-xl border border-primary bg-primary-fixed/30 text-on-surface text-xs font-semibold cursor-pointer transition-all select-none min-h-[44px]">
                                            <input name="services[]" value="Pre-Shoot Story" checked class="hidden" type="checkbox" onchange="toggleChipStyle(this)"/>
                                            <span class="material-symbols-outlined text-[16px] text-primary chip-icon">check_circle</span>
                                            <span class="truncate">Pre-Shoot</span>
                                        </label>
                                        <!-- Chip 4: 4K Drone -->
                                        <label class="service-chip flex items-center gap-2 p-2.5 rounded-xl border border-primary bg-primary-fixed/30 text-on-surface text-xs font-semibold cursor-pointer transition-all select-none min-h-[44px]">
                                            <input name="services[]" value="4K Drone Aerial" checked class="hidden" type="checkbox" onchange="toggleChipStyle(this)"/>
                                            <span class="material-symbols-outlined text-[16px] text-primary chip-icon">check_circle</span>
                                            <span class="truncate">4K Drone</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Auspicious Nekath / Special Notes -->
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-caps text-label-caps text-on-surface uppercase font-semibold text-xs">Auspicious Nekath / Special Notes</label>
                                    <textarea name="couple_message" placeholder="Provide auspicious Nekath timings, preferred packages, or special cultural requests..." class="w-full p-2.5 rounded-xl bg-surface-container-low text-on-surface font-body-sm text-xs sm:text-sm focus:outline-none focus:bg-surface-container resize-none border border-outline-variant/30 leading-relaxed" rows="3">{{ old('couple_message') }}</textarea>
                                </div>

                                @guest
                                    <!-- Guest Contact Details (Unauthenticated) -->
                                    <div class="p-3 rounded-xl bg-primary-fixed/20 border border-primary/20 flex flex-col gap-2">
                                        <span class="font-label-caps text-label-caps text-primary uppercase font-bold text-xs">Your Contact Details</span>
                                        <input name="guest_name" type="text" placeholder="Your Name (e.g. Kasun & Dilini)" class="px-3 py-2 rounded-lg bg-surface-container-lowest text-xs focus:outline-none border border-outline-variant/30" required value="{{ old('guest_name') }}">
                                        <input name="guest_email" type="email" placeholder="Email Address" class="px-3 py-2 rounded-lg bg-surface-container-lowest text-xs focus:outline-none border border-outline-variant/30" required value="{{ old('guest_email') }}">
                                        <input name="guest_phone" type="tel" placeholder="WhatsApp / Phone (+94)" class="px-3 py-2 rounded-lg bg-surface-container-lowest text-xs focus:outline-none border border-outline-variant/30" required value="{{ old('guest_phone') }}">
                                    </div>
                                @endguest

                                <!-- Primary Submit Button -->
                                <button id="rfq-submit-btn" class="w-full py-3.5 rounded-xl bg-on-background text-surface hover:bg-inverse-surface font-title-sm text-sm sm:text-title-sm transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer group tap-highlight-none font-semibold min-h-[48px]" type="submit">
                                    <span class="material-symbols-outlined text-[20px] text-primary-fixed group-hover:scale-110 transition-transform">send</span>
                                    <span id="rfq-submit-btn-text">Request Customized Quotation (RFQ)</span>
                                </button>

                                <!-- Secondary Consultation Trigger -->
                                <button class="w-full py-2.5 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-title-sm text-xs sm:text-title-sm transition-colors flex items-center justify-center gap-2 cursor-pointer tap-highlight-none font-medium min-h-[44px]" type="button" onclick="openConsultationModal()">
                                    <span class="material-symbols-outlined text-[18px] text-primary">videocam</span>
                                    <span>Schedule 15-Min Video Consultation</span>
                                </button>
                            </form>

                            <!-- Micro-copy -->
                            <div class="flex items-center gap-1.5 text-xs text-on-surface-variant pt-2 border-t border-surface-container">
                                <span class="material-symbols-outlined text-[15px] text-tertiary">bolt</span>
                                <span>Vendor receives instant SMS &amp; WhatsApp dispatch</span>
                            </div>

                        </div>

                        <!-- Trust Credentials (Mobile Compact) -->
                        <div class="p-3.5 rounded-2xl bg-surface-container-low flex flex-col gap-2.5 border border-outline-variant/20">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[18px] text-primary shrink-0">format_image_left</span>
                                <div class="flex flex-col">
                                    <span class="font-title-sm text-xs text-on-surface font-semibold">Wedora Nuptial Guarantee</span>
                                    <span class="font-body-sm text-[11px] text-on-surface-variant">Escrow hold until final album delivery</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[18px] text-primary shrink-0">description</span>
                                <div class="flex flex-col">
                                    <span class="font-title-sm text-xs text-on-surface font-semibold">Digitally Signed SLA Contract</span>
                                    <span class="font-body-sm text-[11px] text-on-surface-variant">Enforceable under Sri Lankan law</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[18px] text-primary shrink-0">event_repeat</span>
                                <div class="flex flex-col">
                                    <span class="font-title-sm text-xs text-on-surface font-semibold">Flexible Rescheduling</span>
                                    <span class="font-body-sm text-[11px] text-on-surface-variant">Complimentary date shift up to 90 days</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- PERSISTENT MOBILE STICKY BOTTOM BOOKING BAR (< lg) -->
    <aside class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-xl border-t border-surface-container p-3 flex items-center justify-between shadow-[0_-4px_20px_rgba(0,0,0,0.08)] lg:hidden">
        <div class="flex flex-col">
            <span class="font-label-caps text-[9px] text-on-surface-variant uppercase font-semibold" id="mobile-bar-label">Starting From</span>
            <div class="flex items-baseline gap-1">
                <span class="font-label-caps text-[10px] text-primary font-bold">LKR</span>
                <span class="font-headline-sm text-lg text-on-surface font-bold" id="mobile-bar-price">{{ number_format($vendor->starting_price ?? 280000) }}</span>
            </div>
            <span class="text-[10px] text-tertiary font-semibold flex items-center gap-0.5">
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Available Dec 2025
            </span>
        </div>

        <div class="flex items-center gap-2">
            <!-- 15-min Consult icon button -->
            <button onclick="openConsultationModal()" class="w-10 h-10 rounded-xl bg-surface-container-low hover:bg-surface-container text-primary flex items-center justify-center transition-colors tap-highlight-none border border-outline-variant/30" aria-label="Book Video Consult" title="Book Consultation">
                <span class="material-symbols-outlined text-[20px]">videocam</span>
            </button>
            <!-- Primary Action Button -->
            <button onclick="scrollToRfqForm()" class="px-5 py-2.5 rounded-xl bg-on-background text-surface font-title-sm text-xs font-semibold shadow-md flex items-center gap-1.5 tap-highlight-none">
                <span class="material-symbols-outlined text-[16px] text-primary-fixed">send</span>
                <span id="mobile-cta-btn-text">Request Quote</span>
            </button>
        </div>
    </aside>

    <!-- Footer -->
    <footer class="w-full bg-surface-container-low mt-8 lg:mt-space-2xl">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-margin py-8 lg:py-space-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-space-xl mb-6 lg:mb-space-2xl">
                <div class="lg:col-span-2 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <span class="font-headline-md text-xl lg:text-headline-md text-primary font-bold">Wedora</span>
                        <span class="font-label-caps text-[10px] text-tertiary px-2 py-0.5 rounded-full bg-tertiary-fixed/40 font-semibold">Island Atelier</span>
                    </div>
                    <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant max-w-md leading-relaxed">
                        Honoring Sri Lankan matrimonial heritage through refined editorial technology. Orchestrating Poruwa ceremonies, Nekath timings, and elite vendors across Colombo, Kandy, Galle, and beyond.
                    </p>
                    <div class="flex items-center gap-1 text-on-surface-variant font-body-sm text-xs">
                        <span class="material-symbols-outlined text-[16px] text-primary">spa</span>
                        <span>Curated for high-profile nuptials &amp; destination weddings</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Nuptial Workspace</span>
                    <ul class="flex flex-col gap-1.5 font-body-md text-xs sm:text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="#nekath">Nekath Ritual Chronology</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#packages">LKR Budget &amp; Cash Flow</a></li>
                        <li class="hover:text-primary transition-colors"><a href="#reviews">Guest Seating &amp; Dietary RSVP</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ Auth::check() ? route('workspace.dashboard') : route('login') }}">Vendor Quotations &amp; Contracts</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Vendor Atelier</span>
                    <ul class="flex flex-col gap-1.5 font-body-md text-xs sm:text-body-md text-on-surface-variant">
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Ballrooms &amp; Estate Venues</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Traditional Poruwa Designers</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Kandyan Bridal &amp; Groom Attire</a></li>
                        <li class="hover:text-primary transition-colors"><a href="{{ route('home') }}">Island Photographers</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2.5">
                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-widest font-bold">Private Concierge</span>
                    <p class="font-body-sm text-xs text-on-surface-variant">Bespoke assistance for island estate bookings and heritage rituals.</p>
                    <div class="flex flex-col gap-1 font-title-sm text-xs text-primary">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">call</span>
                            <span>+94 (11) 782 9900</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                            <span>concierge@wedora.lk</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-outline-variant/20 text-center sm:text-left">
                <span class="font-label-caps text-[10px] text-on-surface-variant">© {{ date('Y') }} Wedora Technologies Pvt Ltd. All rights reserved.</span>
                <div class="flex items-center gap-4 font-label-caps text-[10px] text-on-surface-variant">
                    <a class="hover:text-on-surface transition-colors" href="#">Privacy</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Terms</a>
                    <a class="hover:text-on-surface transition-colors" href="#">Cultural Guidelines</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Fullscreen Touch Lightbox Modal -->
    <div id="lightbox-modal" class="fixed inset-0 z-50 bg-black/95 hidden flex-col justify-between p-3 sm:p-6 backdrop-blur-md">
        <div class="flex items-center justify-between text-white pb-2">
            <div class="flex items-center gap-2">
                <span class="font-headline-sm text-sm sm:text-base text-primary-fixed truncate max-w-[200px] sm:max-w-none">{{ $vendor->business_name }}</span>
                <span id="lightbox-counter" class="text-[10px] uppercase bg-white/10 px-2 py-0.5 rounded-full text-white/80">1 / 4</span>
            </div>
            <button onclick="closeLightbox()" class="w-10 h-10 rounded-full bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition-colors tap-highlight-none" aria-label="Close">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <div class="relative flex items-center justify-center my-auto w-full max-h-[75vh]">
            <button onclick="prevLightboxImage()" class="absolute left-1 sm:left-4 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center transition-colors tap-highlight-none">
                <span class="material-symbols-outlined text-[24px] sm:text-[28px]">chevron_left</span>
            </button>
            <img id="lightbox-img" src="" alt="Portfolio Showcase" class="max-h-[70vh] max-w-full object-contain rounded-xl shadow-2xl transition-opacity duration-200">
            <button onclick="nextLightboxImage()" class="absolute right-1 sm:right-4 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center transition-colors tap-highlight-none">
                <span class="material-symbols-outlined text-[24px] sm:text-[28px]">chevron_right</span>
            </button>
        </div>

        <div class="text-center text-white/90 pt-2">
            <p id="lightbox-caption" class="font-headline-sm text-xs sm:text-sm text-primary-fixed"></p>
            <p class="text-[10px] text-white/60 mt-0.5">Wedora Verified Fine Art Archive • Islandwide Nuptial Coverage</p>
        </div>
    </div>

    <!-- 15-Minute Video Consultation Modal -->
    <div id="consultation-modal" class="fixed inset-0 z-50 bg-black/70 hidden items-center justify-center p-3 sm:p-4 backdrop-blur-sm">
        <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl flex flex-col gap-3.5 border border-surface-container max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-surface-container pb-2.5">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-[22px]">videocam</span>
                    <h3 class="font-headline-sm text-base sm:text-xl text-on-surface font-semibold">Schedule 15-Min Consultation</h3>
                </div>
                <button onclick="closeConsultationModal()" class="text-on-surface-variant hover:text-on-surface font-bold text-2xl p-1 leading-none">&times;</button>
            </div>
            <p class="font-body-sm text-xs sm:text-body-sm text-on-surface-variant leading-relaxed">
                Connect directly with {{ $vendor->business_name }}'s creative team via Google Meet to discuss your Poruwa Nekath times and photography desires.
            </p>
            <form id="consultation-form" action="{{ route('vendors.consultation.schedule', $vendor->slug) }}" method="POST" onsubmit="handleConsultationSubmit(event)" class="flex flex-col gap-3">
                @csrf
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Preferred Date</label>
                    <input type="date" name="consultation_date" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs sm:text-sm focus:outline-none border border-outline-variant/30" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                </div>
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Preferred Time Slot (SL Time)</label>
                    <select name="preferred_time" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs sm:text-sm focus:outline-none border border-outline-variant/30" required>
                        <option value="10:00 AM - 10:15 AM">10:00 AM - 10:15 AM (Morning)</option>
                        <option value="02:30 PM - 02:45 PM">02:30 PM - 02:45 PM (Afternoon)</option>
                        <option value="06:00 PM - 06:15 PM" selected>06:00 PM - 06:15 PM (Evening Golden Hour)</option>
                        <option value="08:00 PM - 08:15 PM">08:00 PM - 08:15 PM (Night)</option>
                    </select>
                </div>
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Contact WhatsApp / Mobile</label>
                    <input type="tel" name="contact_phone" class="w-full mt-1 px-3 py-2 rounded-xl bg-surface-container-low text-on-surface text-xs sm:text-sm focus:outline-none border border-outline-variant/30" placeholder="+94 77 123 4567" value="+94 77 123 4567" required>
                </div>
                <div>
                    <label class="font-label-caps text-on-surface uppercase font-semibold text-xs">Topics for Discussion</label>
                    <textarea name="consultation_notes" rows="2" class="w-full mt-1 p-2 rounded-xl bg-surface-container-low text-on-surface text-xs sm:text-sm focus:outline-none resize-none border border-outline-variant/30" placeholder="E.g. Poruwa Nekath window, Galle Fort shoot permissions"></textarea>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-primary text-on-primary font-title-sm text-xs sm:text-sm hover:bg-on-background transition-colors flex items-center justify-center gap-2 mt-1 min-h-[44px] font-semibold">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>Confirm Video Consultation</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts (Mobile Touch & UX Logic) -->
    <script>
        const galleryImages = [
            @if(isset($coverMedia))
                { src: '{{ $coverMedia->file_path }}', caption: '{{ addslashes($coverMedia->caption) }}' },
            @else
                { src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdvX8u-VF5Q7cuJP2MmIjK2PpdtiXP7RSQx8LRum5ToF1fUCSTrVdmJtTdFLvIiJV7sZfDh7VSUi8R8pH08PiMoJ1FLqhGpQoTC7rgQtUSQojY5_EecSY0lhJiR-0siXeMyu5RfErQ_GMWFm6sklRUvxfKfJ2Lb26Jwp3ZOWXZ6n1jWEaGKTrFoKlhb68umzoexUYOF_mmAe9VcD-1WZpzhfR9rPUMurqhM9AicD2B', caption: 'Cover Feature • Galle Fort Nuptials' },
            @endif
            @if(isset($thumbnails) && $thumbnails->count() > 0)
                @foreach($thumbnails as $thumb)
                    { src: '{{ $thumb->file_path }}', caption: '{{ addslashes($thumb->caption) }}' },
                @endforeach
            @else
                { src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCVjheqc1ty7w6BhPZa4MH5HSI9dxXzNPQMl6Y8rILb5nqFjZiJn1tC57VSfaM_xX9RpPKd_Cd4-Ckuoe_eYnUTtcVXrN88hKTOM6L_HlZIjUAMbfjl7HrhqK5d0xG9gNtbXfQM4hS7ri5qaBZZvPSkEhYK_Z1oZV4RZhzgqUONfyqLCFJvFWWoz6bDSa_XgxQhATDKERdupspGSahrzftFPwQlIM07Lxw1vw0QPROR', caption: 'Rituals & Nuool' },
                { src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB7XYUZCwAZZsTpnTBfr1Yb9x7gn2tXphB81xNA8QJW3rDmCB8LptEplS_AjLVpj1MraNotkI-Mpvm5oVCml52h7qwfAff85kPXUfa1QpDWzQ--FXDvBhwZitL5raMgGOxEwFD5j-uEHydUGK7v4cq9mFXIg9qQ7r_ZuTs7F09UUuJRTI7oViKgg68jJtz0_Bq1kmN1XVQaEfLvBsBZf9-7l9erYeDgnVvc5DA7MSov', caption: 'Aerial & Estate Venues' },
                { src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcHK2gEp4Aslx-zEN_lDw7xKewgyiG-x5n1nH3J6qf2cC2eEK7-0yVsP1gG2ig0nDdABu7JpxRxNu5SJr4UMdaYPTGU2Gi76iadsq2FCQTTio4FfGrlo8R4BgecDM5O8LaSuZJc87BCSEx0MAjsCk5XQJ6b9UcMX1v13IZ2cmPxV7B-zlf5c0wygFfE34jwVegsiPJCTfBYWCn0wIZGeMmnjsPZeYfz2CIhawhdJtT', caption: '+186 Portfolio Works' }
            @endif
        ];

        let currentLightboxIndex = 0;

        function openLightbox(index) {
            currentLightboxIndex = index % galleryImages.length;
            updateLightboxView();
            const modal = document.getElementById('lightbox-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const modal = document.getElementById('lightbox-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function updateLightboxView() {
            const img = document.getElementById('lightbox-img');
            const caption = document.getElementById('lightbox-caption');
            const counter = document.getElementById('lightbox-counter');
            img.src = galleryImages[currentLightboxIndex].src;
            caption.textContent = galleryImages[currentLightboxIndex].caption;
            counter.textContent = (currentLightboxIndex + 1) + ' / ' + galleryImages.length;
        }

        function prevLightboxImage() {
            currentLightboxIndex = (currentLightboxIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightboxView();
        }

        function nextLightboxImage() {
            currentLightboxIndex = (currentLightboxIndex + 1) % galleryImages.length;
            updateLightboxView();
        }

        // Keyboard handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
                closeConsultationModal();
            } else if (e.key === 'ArrowLeft') {
                prevLightboxImage();
            } else if (e.key === 'ArrowRight') {
                nextLightboxImage();
            }
        });

        // Touch swipe support for lightbox on mobile
        let touchstartX = 0;
        let touchendX = 0;
        const lightboxEl = document.getElementById('lightbox-modal');
        lightboxEl.addEventListener('touchstart', e => {
            touchstartX = e.changedTouches[0].screenX;
        }, { passive: true });
        lightboxEl.addEventListener('touchend', e => {
            touchendX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            if (touchendX < touchstartX - 50) nextLightboxImage();
            if (touchendX > touchstartX + 50) prevLightboxImage();
        }

        // Tab switching
        function switchTab(tabId) {
            const tabs = ['overview', 'packages', 'portfolio', 'reviews', 'nekath'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab-btn-' + t);
                if (btn) {
                    if (t === tabId) {
                        btn.classList.remove('bg-surface-container', 'text-on-surface-variant');
                        btn.classList.add('bg-on-background', 'text-surface');
                    } else {
                        btn.classList.add('bg-surface-container', 'text-on-surface-variant');
                        btn.classList.remove('bg-on-background', 'text-surface');
                    }
                }
            });

            if (tabId === 'portfolio') {
                openLightbox(0);
                return;
            }

            const targetSection = document.getElementById('section-' + tabId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Interactive Service Chip Toggle
        function toggleChipStyle(checkbox) {
            const chip = checkbox.closest('.service-chip');
            const icon = chip.querySelector('.chip-icon');
            if (checkbox.checked) {
                chip.classList.add('border-primary', 'bg-primary-fixed/30');
                chip.classList.remove('border-outline-variant/30', 'bg-surface-container-low', 'opacity-60');
                icon.textContent = 'check_circle';
                icon.classList.add('text-primary');
            } else {
                chip.classList.remove('border-primary', 'bg-primary-fixed/30');
                chip.classList.add('border-outline-variant/30', 'bg-surface-container-low', 'opacity-60');
                icon.textContent = 'radio_button_unchecked';
                icon.classList.remove('text-primary');
            }
        }

        // Package selection
        function selectPackage(pkgId, pkgName, pkgPrice) {
            document.getElementById('form-package-id').value = pkgId;
            const formattedPrice = Number(pkgPrice).toLocaleString('en-US');
            
            // Update desktop card
            document.getElementById('dynamic-display-price').textContent = formattedPrice;
            document.getElementById('investment-label').textContent = 'Selected Package';
            document.getElementById('dynamic-price-suffix').textContent = 'fixed quote';
            
            const badge = document.getElementById('selected-package-badge');
            document.getElementById('selected-package-badge-name').textContent = pkgName;
            badge.classList.remove('hidden');
            badge.classList.add('inline-flex');

            document.getElementById('rfq-submit-btn-text').textContent = 'Book ' + pkgName;

            // Update mobile sticky bottom bar
            document.getElementById('mobile-bar-price').textContent = formattedPrice;
            document.getElementById('mobile-bar-label').textContent = 'Package: ' + pkgName;
            document.getElementById('mobile-cta-btn-text').textContent = 'Book Package';

            showToast('Package "' + pkgName + '" selected.');
            scrollToRfqForm();
        }

        function clearSelectedPackage() {
            document.getElementById('form-package-id').value = '';
            const defaultPrice = '{{ number_format($vendor->starting_price ?? 280000) }}';
            document.getElementById('dynamic-display-price').textContent = defaultPrice;
            document.getElementById('investment-label').textContent = 'Starting Investment';
            document.getElementById('dynamic-price-suffix').textContent = 'onwards';
            
            const badge = document.getElementById('selected-package-badge');
            badge.classList.add('hidden');
            badge.classList.remove('inline-flex');

            document.getElementById('rfq-submit-btn-text').textContent = 'Request Customized Quotation (RFQ)';

            // Update mobile bar
            document.getElementById('mobile-bar-price').textContent = defaultPrice;
            document.getElementById('mobile-bar-label').textContent = 'Starting From';
            document.getElementById('mobile-cta-btn-text').textContent = 'Request Quote';
        }

        // Mobile smooth scroll to booking card
        function scrollToRfqForm() {
            const bookingCard = document.getElementById('booking-card');
            if (bookingCard) {
                bookingCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Date selector
        function updateDateDisplay(val) {
            if (!val) return;
            document.getElementById('hidden-event-date').value = val;
            const dateObj = new Date(val);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            showToast('Nuptial date updated to ' + dateObj.toLocaleDateString('en-US', options));
        }

        // Shortlist toggle
        async function toggleShortlist() {
            const form = document.getElementById('favorite-form');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    const iconDesktop = document.getElementById('favorite-icon');
                    const textDesktop = document.getElementById('favorite-text');
                    const iconMobile = document.getElementById('mobile-favorite-icon');

                    const fillState = data.is_favorited ? "'FILL' 1" : "'FILL' 0";
                    if (iconDesktop) iconDesktop.style.fontVariationSettings = fillState;
                    if (iconMobile) iconMobile.style.fontVariationSettings = fillState;
                    if (textDesktop) textDesktop.textContent = data.is_favorited ? 'Shortlisted' : 'Shortlist';

                    showToast(data.message);
                }
            } catch (err) {
                form.submit();
            }
        }

        // Share profile
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($vendor->business_name) }} — Wedora',
                    text: 'Explore {{ addslashes($vendor->business_name) }} fine art and cinema on Wedora.',
                    url: window.location.href,
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href);
                showToast('Vendor profile link copied to clipboard!');
            }
        }

        // Video consultation modal
        function openConsultationModal() {
            const modal = document.getElementById('consultation-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeConsultationModal() {
            const modal = document.getElementById('consultation-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        async function handleConsultationSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                closeConsultationModal();
                showToast(data.message || '15-Minute video consultation scheduled successfully!');
            } catch (err) {
                form.submit();
            }
        }

        // RFQ submission
        async function handleRfqSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('rfq-submit-btn');
            const originalText = document.getElementById('rfq-submit-btn-text').textContent;
            
            document.getElementById('rfq-submit-btn-text').textContent = 'Dispatching to Artisan...';
            btn.disabled = true;

            const formData = new FormData(form);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                if (data.success) {
                    showToast(data.message);
                    form.reset();
                    clearSelectedPackage();
                } else {
                    showToast(data.message || 'Error submitting RFQ. Please check the fields.', 'error');
                }
            } catch (err) {
                form.submit();
                return;
            } finally {
                btn.disabled = false;
                document.getElementById('rfq-submit-btn-text').textContent = originalText;
            }
        }

        // Toast helper
        function showToast(message, type = 'info') {
            const toast = document.getElementById('dynamic-toast');
            const msgEl = document.getElementById('toast-message');
            const iconEl = document.getElementById('toast-icon');

            msgEl.textContent = message;
            if (type === 'error') {
                iconEl.textContent = 'error';
                iconEl.classList.remove('text-primary-fixed');
                iconEl.classList.add('text-error');
            } else {
                iconEl.textContent = 'check_circle';
                iconEl.classList.add('text-primary-fixed');
                iconEl.classList.remove('text-error');
            }

            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 4500);
        }
    </script>
</body>
</html>
