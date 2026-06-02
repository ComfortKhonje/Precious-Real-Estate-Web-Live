@extends('layouts.app')

@section('title', $property->title . ' - Precious Real Estate')

@section('content')
@php
    $allImages = array_merge([$property->featured_image], $property->gallery ?? []);
@endphp

<div x-data="{
        isOpen: false,
        currentIndex: 0,
        images: {{ json_encode(array_map(fn($img) => asset($img), $allImages)) }},
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
    <section class="bg-white min-h-screen relative overflow-hidden">
        {{-- Background Grid --}}
        <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="" class="fixed inset-0 w-full h-full object-cover opacity-5 pointer-events-none">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-24 relative z-10">

        {{-- Back Button --}}
        <div class="mb-12">
            <a href="{{ route('properties') }}" class="inline-flex items-center text-gray-400 hover:text-brand-black transition-colors group">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-4 group-hover:bg-primary transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest">Back to Listings</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-12">
            {{-- Main Large Image --}}
            <div class="lg:col-span-8 rounded-[2rem] overflow-hidden shadow-lg border border-gray-100 aspect-[16/9] cursor-pointer group"
                @click="openModal(0)">
                <img src="{{ asset($property->featured_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>

            {{-- Thumbnail Grid --}}
            <div class="lg:col-span-4 grid grid-cols-2 gap-4">
                @php
                    $gallery = $property->gallery ?? [];
                    $displayThumbnails = array_slice($gallery, 0, 4);
                    $remainingCount = count($gallery) - 4;
                @endphp

                @foreach($displayThumbnails as $index => $image)
                    <div class="relative rounded-[1.5rem] overflow-hidden shadow-sm border border-gray-100 aspect-square group cursor-pointer"
                        @click="openModal({{ $index + 1 }})">
                        <img src="{{ asset($image) }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                <div class="mb-8">
                    <span class="inline-block bg-primary text-brand-black px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                        For {{ $property->status === 'For Sale' ? 'Sale' : 'Rent' }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-heading text-brand-black mb-6 uppercase tracking-tight">{{ $property->title }}</h1>

                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $property->location }}
                        </div>
                        @if($property->bedrooms)
                        <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            {{ $property->bedrooms }} Bedrooms
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-12">
                    <p class="text-gray-600 leading-relaxed text-lg">
                        {{ $property->description }}
                    </p>
                </div>

                {{-- Property Features --}}
                <div class="mb-12">
                    <h3 class="text-2xl font-heading text-brand-black mb-6 uppercase tracking-tight">Property <span class="text-primary">Features</span></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $features = [
                                'Master bedroom with ensuite', 'Built-in wardrobes',
                                'Modern fitted kitchen', 'Dining area',
                                'Guest bathroom', 'Tiled floors',
                                'Backup water system', 'Secure perimeter wall',
                                'Electric gate access', 'Paved driveway'
                            ];
                        @endphp
                        @foreach($features as $feature)
                            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-2xl border border-gray-100 group hover:border-primary/30 transition-colors">
                                <div class="w-6 h-6 rounded-full bg-brand-black flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Location Details --}}
                <div class="mb-12">
                    <h3 class="text-2xl font-heading text-brand-black mb-2 uppercase tracking-tight">Location <span class="text-primary">Details</span></h3>
                    <p class="text-gray-500 mb-6">Located in one of Lilongwe's established residential areas, the property offers easy access to:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $locations = ['Schools', 'Shopping centers', 'Restaurants', 'Health facilities', 'Main road networks'];
                        @endphp
                        @foreach($locations as $loc)
                            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50 rounded-2xl border border-gray-100 group hover:border-primary/30 transition-colors">
                                <div class="w-6 h-6 rounded-full bg-brand-black flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $loc }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Contact Us Buttons --}}
                <div>
                    <h3 class="text-xl font-heading text-brand-black mb-4 uppercase tracking-tight">Contact Us</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="tel:+265884366756" class="flex items-center gap-4 px-6 py-4 bg-brand-black text-white rounded-[1.5rem] hover:scale-[1.02] transition-transform shadow-lg">
                            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-brand-black shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16.44v3.53a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.12 2H6.65a2 2 0 0 1 2 1.72 12.81 12.81 0 0 0 .62 2.81 2 2 0 0 1-.45 2.11L7.33 10.13a16 16 0 0 0 6 6l1.47-1.47a2 2 0 0 1 2.11-.45 12.81 12.81 0 0 0 2.81.62 2 2 0 0 1 1.72 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Phone</p>
                                <p class="text-sm font-bold text-primary">+265 884 366 756</p>
                            </div>
                        </a>
                        <a href="mailto:info@preciousrealestate.mw" class="flex items-center gap-4 px-6 py-4 bg-brand-black text-white rounded-[1.5rem] hover:scale-[1.02] transition-transform shadow-lg">
                            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-brand-black shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Email</p>
                                <p class="text-sm font-bold text-primary">info@preciousrealestate.mw</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right: Sidebar --}}
            <div class="lg:col-span-4">
                <div class="sticky top-32 space-y-8">
                    {{-- Price Block --}}
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Price:</span>
                            <span class="text-3xl font-bold text-brand-black">{{ $property->formatted_price }}</span>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-400 mb-6">Property Details:</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">{{ $property->bedrooms ?? 0 }} Bedrooms</div>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">{{ $property->bathrooms ?? 0 }} Bathrooms</div>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">2 Lounges</div>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">Modern Kitchen</div>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">Parking Space</div>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest">Secure Compound</div>
                            </div>
                        </div>
                    </div>

                    {{-- Inquiry Form Block --}}
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-gray-100">
                        <div class="badge-yellow mb-4">Interested in This Property?</div>
                        <h4 class="text-2xl font-heading text-brand-black mb-6 uppercase tracking-tight">Request More Information</h4>

                        <form action="#" class="space-y-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Full Name</label>
                                <input type="text" placeholder="e.g., John Doe" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Phone Number</label>
                                <input type="tel" placeholder="+265 999 123 456" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email Address</label>
                                <input type="email" placeholder="email@example.com" class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Message</label>
                                <textarea rows="4" placeholder="Write your message here..." class="w-full bg-gray-50 border-none rounded-xl py-4 px-5 text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full btn-black py-4 text-xs tracking-widest mt-4">SEND INQUIRY</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Properties --}}
@if(count($relatedProperties) > 0)
<section class="bg-white py-24 md:py-32 border-t border-gray-100 relative overflow-hidden">
    {{-- Background Grid --}}
    <img src="{{ asset('brand-assets/website-pages/grid-background.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-10 pointer-events-none">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-16">
            <div class="badge-yellow mb-4">Related Listings</div>
            <h2 class="text-4xl md:text-5xl font-heading text-brand-black uppercase tracking-tight">You May <br><span class="text-gray-400">Also Like</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($relatedProperties as $related)
                <x-shared.property-card
                    :image="asset($related->featured_image)"
                    :title="$related->title"
                    :location="$related->location"
                    :price="$related->formatted_price . ($related->status === 'For Rent' ? ' / month' : '')"
                    :type="$related->status === 'For Sale' ? 'Sale' : 'Rent'"
                    :slug="$related->slug"
                    :description="$related->description"
                />
            @endforeach
        </div>
    </div>
</section>
@endif

<x-home.cta
    badge="Get Started"
    title="Need Professional Property Assistance?"
    description="Our team is ready to support you with trusted real estate solutions."
/>

{{-- Contact Info Bar (Yellow) --}}
<x-shared.contact-info :overlap="false" />

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
            <img :src="images[currentIndex]"
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
                    <img :src="img" class="w-full h-full object-cover">
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
