@extends('layouts.cms')

@section('title', 'Contact Information | PREC CMS')
@section('page_title', 'Contact Information')
@section('page_subtitle', 'Update office details, contacts, social links, and map settings.')

@section('content')
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-3xl p-6">
            <h3 class="font-semibold text-red-900 mb-3">Errors:</h3>
            <ul class="space-y-2 text-sm text-red-800">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-3xl p-6">
            <h3 class="font-semibold text-green-900 flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}</h3>
        </div>
    @endif

    <form method="POST" action="{{ route('cms.contact.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Office Details -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Office Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Primary office contact information.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Name</label>
                    <input type="text" name="office_name" placeholder="Precious Real Estate Consulting"
                        value="{{ $settings['office_name'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Working Hours</label>
                    <input type="text" name="working_hours" placeholder="Mon-Fri, 08:00-17:00"
                        value="{{ $settings['working_hours'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Lilongwe Office Address</label>
                    <textarea name="office_address_lilongwe" placeholder="Area 47/S3, GPH House, Lilongwe" rows="2"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ $settings['office_address_lilongwe'] ?? '' }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Blantyre Office Address</label>
                    <textarea name="office_address_blantyre" placeholder="Haji Latif Pavilion, Room 35, Blantyre" rows="2"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ $settings['office_address_blantyre'] ?? '' }}</textarea>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Postal Address</label>
                    <textarea name="postal_address" placeholder="Enter postal address" rows="2"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ $settings['postal_address'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Contact Methods -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Contact Methods</h3>
            <p class="text-sm text-brand-black/60 mb-6">Phone, email, and messaging contact details.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Phone</label>
                    <input type="tel" name="office_phone" placeholder="+265 1 2345 6789"
                        value="{{ $settings['office_phone'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Email</label>
                    <input type="email" name="office_email" placeholder="info@preciousrealestate.mw"
                        value="{{ $settings['office_email'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">WhatsApp Number</label>
                    <input type="tel" name="whatsapp_number" placeholder="+265 9 12 34 56 78"
                        value="{{ $settings['whatsapp_number'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Location</h3>
            <p class="text-sm text-brand-black/60 mb-6">GPS coordinates for map integration.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Latitude</label>
                    <input type="number" name="latitude" placeholder="-13.9626" step="0.0001"
                        value="{{ $settings['latitude'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Longitude</label>
                    <input type="number" name="longitude" placeholder="33.7741" step="0.0001"
                        value="{{ $settings['longitude'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
            </div>
        </div>

        <!-- Social Links -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Social Media</h3>
            <p class="text-sm text-brand-black/60 mb-6">Links to social media profiles.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Facebook URL</label>
                    <input type="url" name="facebook_url" placeholder="https://facebook.com/..."
                        value="{{ $settings['facebook_url'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Instagram URL</label>
                    <input type="url" name="instagram_url" placeholder="https://instagram.com/..."
                        value="{{ $settings['instagram_url'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">LinkedIn URL</label>
                    <input type="url" name="linkedin_url" placeholder="https://linkedin.com/..."
                        value="{{ $settings['linkedin_url'] ?? '' }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20" />
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3">
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition">
                <i data-lucide="check" class="w-5 h-5"></i>
                Save Changes
            </button>
            <a href="{{ route('cms.dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-full border border-gray-200 font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
@endsection

