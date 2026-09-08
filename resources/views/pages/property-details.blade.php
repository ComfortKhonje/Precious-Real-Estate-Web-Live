@extends('layouts.app')

@section('title', $property->title . ' - Precious Real Estate')
@section('meta_description', Str::limit(strip_tags($property->description), 155))
@section('meta_image', $property->featuredImageUrl('large'))
@section('meta_type', 'article')

@push('schema')
<script type="application/ld+json">@json(\App\Support\Schema::property($property), JSON_UNESCAPED_SLASHES)</script>
@endpush

@section('content')
@php
    $galleryImageUrls = $property->images->where('is_featured', false)->map(fn ($img) => $img->url('large'))->values()->all();
    $allImages = array_merge([$property->featuredImageUrl('large')], $galleryImageUrls);
@endphp

<div x-data="{
        isOpen: false,
        currentIndex: 0,
        images: {{ json_encode($allImages) }},
        openModal(index) {
            this.currentIndex = index;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
    }"
    @keydown.escape.window="closeModal()"
    @keydown.left.window="prev()"
    @keydown.right.window="next()"
>
    <section class="min-h-screen relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-8 relative z-10">

            {{-- Back Button --}}
            <div class="mb-2 md:mb-4">
                <a href="{{ route('properties') }}" class="inline-flex w-full md:w-fit justify-center items-center rounded-full text-gray-400 hover:text-brand-black border-2 border-gray-400 hover:bg-primary hover:border-primary transition-all duration-300 group">
                    <div class="w-5 h-10 rounded-full flex items-center justify-center mx-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest mr-6">Back to Listings</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-12">
                {{-- Main Large Image --}}
                <div class="lg:col-span-8 rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-lg border border-gray-100 aspect-[16/9] cursor-pointer group h-full"
                     @click="openModal(0)">
                    <img loading="lazy" decoding="async" src="{{ $property->featuredImageUrl('large') }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>

                {{-- Thumbnail Grid --}}
                <div class="lg:col-span-4 grid grid-cols-4 md:grid-cols-2 gap-2 md:gap-4">
                    @php
                        $displayThumbnails = array_slice($galleryImageUrls, 0, 4);
                        $remainingCount = count($galleryImageUrls) - 4;
                    @endphp

                    @foreach($displayThumbnails as $index => $image)
                        <div class="relative rounded-[1rem] md:rounded-[1.5rem] overflow-hidden shadow-sm border border-gray-100 aspect-square group cursor-pointer"
                            @click="openModal({{ $index + 1 }})">
                            <img loading="lazy" decoding="async" src="{{ $image }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @if($index === 3 && $remainingCount > 0)
                                <div class="absolute inset-0 bg-brand-black/60 flex items-center justify-center text-white text-2xl font-bold backdrop-blur-[2px]">
                                    +{{ $remainingCount }}
                                </div>
                            @endif
                        </div>
                    @endforeach

                    {{-- Fill empty slots if less than 4 gallery images --}}
                    @for($i = count($displayThumbnails); $i < 4; $i++)
                        <div class="rounded-[1.5rem] bg-gray-50 border border-gray-100 aspect-square flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

                {{-- Left: Content --}}
                <div class="lg:col-span-8">
                    {{-- Title & Badges --}}
                    <div>
                        <span class="inline-block {{ $property->status === 'For Sale' ? 'bg-brand-black text-white' : 'bg-primary text-brand-black' }} px-4 py-1.5 rounded-full text-[1rem] tracking-widest mb-2">
                            {{ $property->status }}
                        </span>
                        <h1 class="text-4xl md:text-5xl font-heading text-brand-black mb-4 uppercase tracking-tight">{{ $property->title }}</h1>

                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-brand-black uppercase tracking-wider">
                                <svg class="w-4 h-4 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $property->location }}
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-brand-black uppercase tracking-wider">
                                <svg class="w-4 h-4 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ $property->type }}
                            </div>
                            {{-- Category (Residential/Commercial) was collected in the CMS's
                                 property form but never shown anywhere on this page. Added
                                 2026-09-08. --}}
                            @if ($property->category)
                                <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-brand-black uppercase tracking-wider">
                                    <svg class="w-4 h-4 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M19 21H5m0 0H3m4-14h2m-2 4h2m4-4h2m-2 4h2m-6 8v-4a1 1 0 011-1h0a1 1 0 011 1v4"></path></svg>
                                    {{ $property->category }}
                                </div>
                            @endif
                            {{-- The checkmark icon here used to be hardcoded regardless of
                                 $property->is_available — an unavailable listing showed a
                                 green-style checkmark next to the word "Unavailable". Now
                                 swaps to an X to match. Fixed 2026-09-08. --}}
                            <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-brand-black uppercase tracking-wider">
                                @if ($property->is_available)
                                    <svg class="w-4 h-4 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <svg class="w-4 h-4 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                                {{ $property->is_available ? 'Available' : 'Unavailable' }}
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-200 my-4"></div>

                    {{-- Description --}}
                    <div class="mb-8">
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $property->description }}
                        </p>
                    </div>

                    {{-- Property Highlights --}}
                    {{-- Used to re-list bedrooms/bathrooms/land/parking/status/type here —
                         all of which the sidebar already shows, so this section added zero
                         new information. $property->features (a real CMS field — "Solar
                         backup", "Borehole", "Servant quarters", etc.) was collected on
                         every listing and never displayed anywhere. Now shows that instead.
                         Fixed 2026-09-08. --}}
                    @if (!empty($property->features))
                    <div class="mb-8">
                        <h3 class="text-3xl font-heading text-brand-black mb-2 tracking-tight">Property Highlights</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($property->features as $feature)
                                <div class="flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-xl border border-gray-100 group hover:border-primary/30 transition-colors">
                                    <div class="w-6 h-6 rounded-full bg-brand-black flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Location Details --}}
                    {{-- 2026-09-04: was 100% hardcoded — every property showed the same
                         fake paragraph and the same fixed five-item list regardless of
                         its real location. Now driven by $property->nearby_amenities
                         (staff-entered, CMS create/edit form), and hides entirely rather
                         than showing a blank/fake section when nothing's been entered. --}}
                    @if(!empty($property->nearby_amenities))
                    <div class="mb-2">
                        <h3 class="text-3xl font-heading text-brand-black mb-2 tracking-tight">Location Details</h3>
                        <p class="text-gray-500 mb-2">Located near {{ $property->location }}, this property offers easy access to:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($property->nearby_amenities as $amenity)
                                <div class="flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-2xl border border-gray-100 group hover:border-primary/30 transition-colors">
                                    <div class="w-6 h-6 rounded-full bg-brand-black flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">{{ $amenity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-200 my-4"></div>
                    @endif

                    {{-- Contact Us Buttons --}}
                    <div>
                        <h3 class="text-3xl font-heading text-brand-black mb-2 tracking-tight">Contact Us</h3>
                        <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full">
                            <a href="tel:{{ \App\Support\ContactInfo::phone() }}" class="w-full flex items-center gap-4 p-4 bg-brand-black text-white rounded-[1rem] hover:scale-[1.02] transition-transform shadow-lg">
                                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-brand-black shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16.44v3.53a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.12 2H6.65a2 2 0 0 1 2 1.72 12.81 12.81 0 0 0 .62 2.81 2 2 0 0 1-.45 2.11L7.33 10.13a16 16 0 0 0 6 6l1.47-1.47a2 2 0 0 1 2.11-.45 12.81 12.81 0 0 0 2.81.62 2 2 0 0 1 1.72 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-primary uppercase font-bold tracking-widest">Phone</p>
                                    <p class="text-sm font-bold text-primary">{{ \App\Support\ContactInfo::phone() }}</p>
                                </div>
                            </a>
                            <a href="mailto:{{ \App\Support\ContactInfo::email() }}" class="w-full flex items-center gap-4 p-4 bg-brand-black text-white rounded-[1rem] hover:scale-[1.02] transition-transform shadow-lg">
                                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-brand-black shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-primary uppercase font-bold tracking-widest">Email</p>
                                    <p class="text-sm font-bold text-primary">{{ \App\Support\ContactInfo::email() }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right: Sidebar --}}
                <div class="lg:col-span-4">
                    <div class="sticky top-32 space-y-8">
                        {{-- Price Block --}}
                        <div class="bg-white rounded-[2rem] p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-md text-gray-400 tracking-widest">Price:</span>
                                <span class="text-3xl font-bold font-heading text-brand-black">{{ $property->formatted_price }}</span>
                            </div>

                            <div>
                                <h4 class="text-xl font-bold text-brand-black mb-6">Property Details:</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->bedrooms ?? 0 }} Bedrooms</div>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->bathrooms ?? 0 }} Bathrooms</div>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->type }}</div>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->land_size ?? 'Land size N/A' }}</div>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->parking_spaces ?? 0 }} Parking</div>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg text-sm font-bold text-gray-400 text-center tracking-widest">{{ $property->is_available ? 'Available' : 'Unavailable' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Inquiry Form Block --}}
                        {{-- 2026-09-02: was a dead form (action="#", no name attrs, no submit
                             handler) — every "Interested in This Property?" submission on the
                             whole site silently did nothing. Now a real form posting straight
                             to /api/inquiries/public, same endpoint the full multi-step
                             /inquiry flow uses, with property_id set so it shows up correctly
                             tagged in the CMS inquiries list. --}}
                        <div class="bg-white rounded-[2rem] p-6 border border-gray-200"
                             x-data="{
                                submitting: false,
                                sent: false,
                                error: null,
                                form: { name: '', phone: '', email: '', message: '' },
                                async submit() {
                                    if (this.submitting) return; // guards a fast double-click, not just the disabled attribute
                                    this.submitting = true;
                                    this.error = null;
                                    try {
                                        const website = document.querySelector('input[name="website"]')?.value || '';
                                        const res = await fetch('/api/inquiries/public', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            },
                                            body: JSON.stringify({
                                                service: 'Property Inquiry',
                                                contactMethod: 'Phone',
                                                property_id: {{ $property->id }},
                                                name: this.form.name,
                                                phone: this.form.phone,
                                                email: this.form.email,
                                                additionalDetails: this.form.message,
                                                website,
                                            }),
                                        });
                                        if (!res.ok) {
                                            const body = await res.json().catch(() => ({}));
                                            throw new Error(body.message || 'Something went wrong — please try again or call us directly.');
                                        }
                                        this.sent = true;
                                    } catch (e) {
                                        this.error = e.message;
                                        window.showToast('error', e.message);
                                    } finally {
                                        this.submitting = false;
                                    }
                                }
                             }">
                            <template x-if="!sent">
                                <div>
                                    <div class="badge-yellow">Interested in This Property?</div>
                                    <h4 class="text-2xl font-heading text-brand-black mb-4 uppercase tracking-tight">Request More Information</h4>

                                    <form @submit.prevent="submit" class="space-y-2">
                                        <x-shared.honeypot />
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Full Name</label>
                                            <input type="text" x-model="form.name" required placeholder="e.g., John Doe" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Phone Number</label>
                                            <input type="tel" x-model="form.phone" required placeholder="+265 999 123 456" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email Address</label>
                                            <input type="email" x-model="form.email" required placeholder="email@example.com" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Message</label>
                                            <textarea rows="4" x-model="form.message" placeholder="Write your message here..." class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                                        </div>
                                        <p x-show="error" x-text="error" class="text-red-600 text-xs font-semibold"></p>
                                        <button type="submit" :disabled="submitting" class="w-full btn-primary py-4 text-xs tracking-widest mt-4 disabled:opacity-50">
                                            <span x-text="submitting ? 'SENDING...' : 'SEND INQUIRY'"></span>
                                        </button>
                                    </form>
                                </div>
                            </template>
                            <template x-if="sent">
                                <div class="text-center py-6">
                                    <div class="w-14 h-14 mx-auto rounded-full bg-primary flex items-center justify-center mb-4">
                                        <svg class="w-7 h-7 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h4 class="text-xl font-heading text-brand-black uppercase tracking-tight mb-2">Inquiry Sent</h4>
                                    <p class="text-sm text-gray-500">Our team will get back to you within 24 working hours.</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- Related Properties --}}
@if(count($relatedProperties) > 0)
<section class="py-12 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-8">
            <div class="badge-yellow mb-2">Related Listings</div>
            <h2 class="text-4xl font-heading text-brand-black tracking-tight">You May Also Like</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($relatedProperties as $related)
                <x-shared.property-card
                    :image="$related->featuredImageUrl('medium')"
                    :title="$related->title"
                    :location="$related->location"
                    :price="$related->formatted_price"
                    :type="$related->status === 'For Sale' ? 'Sale' : 'Rent'"
                    :slug="$related->slug"
                    :description="$related->description"
                />
            @endforeach
        </div>
        <div class="text-center  mt-8">
            <a href="{{ route('properties') }}" class="btn-primary px-12 py-5 text-sm tracking-[0.2em] font-bold shadow-xl hover:scale-105 active:scale-95 transition-all duration-300">BROWSE MORE PROPERTIES</a>
        </div>
    </div>
</section>
@endif

<x-home.cta
    badge="Get Started"
    title="Need Professional Property Assistance?"
    description="Our team is ready to support you with trusted real estate solutions."
/>

{{-- Lightbox Modal --}}
<div x-show="isOpen"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6"
    x-cloak
>
    {{-- Overlay --}}
    <div x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="absolute inset-0 bg-brand-black/80 backdrop-blur-sm"
    ></div>

    {{-- Modal Content --}}
    <div x-show="isOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative w-full max-w-5xl bg-brand-black rounded-[2rem] overflow-hidden shadow-2xl border border-white/10 flex flex-col"
        @click.away="closeModal()"
    >
        {{-- Header --}}
        <div class="absolute top-0 inset-x-0 p-6 flex items-center justify-between z-10 bg-gradient-to-b from-brand-black/80 to-transparent">
            <div class="flex flex-col">
                <p class="text-white text-xs font-bold uppercase tracking-[0.2em] mb-1">{{ $property->title }}</p>
                <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest">
                    Image <span x-text="currentIndex + 1"></span> of <span x-text="images.length"></span>
                </p>
            </div>
            <button @click="closeModal()" class="p-2 text-white/50 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Image Display --}}
        <div class="relative aspect-[16/10] md:aspect-auto md:h-[70vh] w-full bg-brand-black flex items-center justify-center overflow-hidden">
            {{-- Navigation Buttons --}}
            <button @click="prev()" class="absolute left-4 z-20 p-4 text-white/30 hover:text-white hover:bg-white/10 rounded-2xl transition-all hidden md:block">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="next()" class="absolute right-4 z-20 p-4 text-white/30 hover:text-white hover:bg-white/10 rounded-2xl transition-all hidden md:block">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            {{-- Main Image --}}
            <img loading="lazy" decoding="async" :src="images[currentIndex]" alt="{{ $property->title }}"
                class="max-w-full max-h-full object-contain select-none"
                alt="Property View"
            >
        </div>

        {{-- Thumbnails Tray (Optional but nice for a modal) --}}
        <div class="p-4 bg-brand-black/50 border-t border-white/5 overflow-x-auto hidden md:flex gap-3 justify-center">
            <template x-for="(img, index) in images" :key="index">
                <button @click="currentIndex = index"
                    class="w-16 h-12 rounded-lg overflow-hidden border-2 transition-all shrink-0"
                    :class="currentIndex === index ? 'border-primary opacity-100' : 'border-transparent opacity-40 hover:opacity-70'"
                >
                    <img loading="lazy" decoding="async" :src="img" :alt="`{{ $property->title }} photo ${index + 1}`" class="w-full h-full object-cover">
                </button>
            </template>
        </div>

        {{-- Mobile Swipe Areas --}}
        <div class="absolute inset-y-0 left-0 w-20 z-10 md:hidden" @click="prev()"></div>
        <div class="absolute inset-y-0 right-0 w-20 z-10 md:hidden" @click="next()"></div>
    </div>
</div>
</div>
@endsection
