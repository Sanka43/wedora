@php
    $vendor = $user->vendor;
@endphp

<div class="space-y-8">
    <!-- Atelier Status Ribbon -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl gold-gradient-bg border border-amber-300 flex items-center justify-center text-primary shadow-sm font-bold text-lg">
                <span class="material-symbols-outlined text-[24px]">storefront</span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">
                        {{ $vendor->business_name ?? 'Your Artisan Atelier Listing' }}
                    </h3>
                    @if($vendor)
                        @if($vendor->verification_status->value === 'verified')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[12px]">verified</span> Verified Artisan
                            </span>
                        @elseif($vendor->verification_status->value === 'pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[12px]">hourglass_top</span> Verification Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">
                                Unverified
                            </span>
                        @endif
                    @endif
                </div>
                <p class="text-xs text-on-surface-variant mt-0.5">
                    {{ $vendor?->category?->name ?? 'Select your matrimonial category' }} • {{ $vendor?->district ?? 'Operating across Sri Lanka' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($vendor && $vendor->slug)
                <a href="{{ route('vendors.show', $vendor->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 text-xs font-bold text-on-surface transition-colors shadow-xs">
                    <span class="material-symbols-outlined text-[16px] text-primary">visibility</span>
                    <span>View Public Directory Listing</span>
                </a>
            @endif
            <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl gold-gradient-bg border border-amber-300 text-xs font-bold text-[#1a140a] hover:brightness-105 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                <span>Atelier Studio</span>
            </a>
        </div>
    </div>

    <!-- Vendor Management Form -->
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Section 1: Business Representative Account -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-primary-fixed/40 text-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">badge</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Representative Account &amp; Access</h3>
                    <p class="text-xs text-on-surface-variant">Your login credentials and account point of contact.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Representative Full Name <span class="text-error">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Login Account Email <span class="text-error">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Direct Mobile Phone
                    </label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="+94 77 123 4567">
                </div>

                <div>
                    <label for="avatar_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Avatar Image URL
                    </label>
                    <input id="avatar_url" type="url" name="avatar_url" value="{{ old('avatar_url', $user->profile?->avatar_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://example.com/avatar.jpg">
                </div>
            </div>
        </div>

        <!-- Section 2: Atelier Brand & Directory Profile -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-primary-fixed/40 text-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Atelier Brand &amp; Marketplace Details</h3>
                    <p class="text-xs text-on-surface-variant">Information shown to prospective couples on Wedora Sri Lanka.</p>
                </div>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="business_name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Business / Brand Name <span class="text-error">*</span>
                        </label>
                        <input id="business_name" type="text" name="business_name" value="{{ old('business_name', $vendor?->business_name) }}" required
                               class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                               placeholder="e.g. Dhanushka Senanayake Fine Art &amp; Cinema">
                    </div>

                    <div>
                        <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Primary Wedding Discipline <span class="text-error">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $vendor?->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="district" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Operating District <span class="text-error">*</span>
                        </label>
                        <select id="district" name="district" required
                                class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition">
                            <option value="">-- Select District --</option>
                            @foreach($districts as $d)
                                <option value="{{ $d }}" {{ old('district', $vendor?->district) == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="starting_price" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                            Base Starting Price (LKR ₨)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-xs font-bold text-on-surface-variant">LKR</span>
                            <input id="starting_price" type="number" step="1000" name="starting_price" value="{{ old('starting_price', $vendor?->starting_price) }}"
                                   class="w-full pl-12 pr-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition font-semibold"
                                   placeholder="250000">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Studio / Atelier Physical Address <span class="text-error">*</span>
                    </label>
                    <input id="address" type="text" name="address" value="{{ old('address', $vendor?->address) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="No. 42, Ward Place, Colombo 07">
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Atelier Narrative &amp; Artistic Philosophy <span class="text-error">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                              placeholder="Describe your craft, equipment, Sri Lankan cultural Poruwa experience, and why couples love collaborating with your studio...">{{ old('description', $vendor?->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Inquiries, Website & Social Channels -->
        <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/20">
                <span class="w-8 h-8 rounded-lg bg-primary-fixed/40 text-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                </span>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Inquiry Routing &amp; Digital Channels</h3>
                    <p class="text-xs text-on-surface-variant">Where quotation requests and couple inquiries will be directed.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="vendor_phone" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Inquiry / WhatsApp Hotline
                    </label>
                    <input id="vendor_phone" type="text" name="vendor_phone" value="{{ old('vendor_phone', $vendor?->phone) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="+94 77 789 0123">
                </div>

                <div>
                    <label for="vendor_email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Public Inquiry Email
                    </label>
                    <input id="vendor_email" type="email" name="vendor_email" value="{{ old('vendor_email', $vendor?->email) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="studio@dhanushkafineart.lk">
                </div>

                <div>
                    <label for="website" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Official Website
                    </label>
                    <input id="website" type="url" name="website" value="{{ old('website', $vendor?->website) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://www.dhanushkasenanayake.com">
                </div>

                <div>
                    <label for="instagram_handle" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Instagram Handle
                    </label>
                    <input id="instagram_handle" type="text" name="instagram_handle" value="{{ old('instagram_handle', $vendor?->instagram_handle) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="@dhanushka_fineart">
                </div>

                <div class="sm:col-span-2">
                    <label for="facebook_url" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                        Facebook Page URL
                    </label>
                    <input id="facebook_url" type="url" name="facebook_url" value="{{ old('facebook_url', $vendor?->facebook_url) }}"
                           class="w-full px-4 py-2.5 bg-surface border border-outline-variant/40 rounded-xl text-on-surface focus:outline-none focus:border-primary focus:bg-surface-container-lowest text-sm transition"
                           placeholder="https://facebook.com/dhanushkacinema">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-2">
            <span class="text-xs text-on-surface-variant">Changes will immediately update your Wedora Ceylon Nuptials directory presence.</span>
            <button type="submit" class="inline-flex items-center gap-2 py-3 px-8 rounded-xl gold-gradient-bg text-[#1a140a] font-bold text-xs uppercase tracking-wider shadow-md hover:brightness-105 active:scale-[0.99] transition-all border border-amber-300">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Save Atelier Profile</span>
            </button>
        </div>
    </form>
</div>
