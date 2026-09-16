@extends('layouts.cms')

@section('title', 'Contact Information | PREC CMS')
@section('page_title', 'Contact Information')
@section('page_subtitle', 'Update office details, contacts, social links, and map settings.')

@section('content')
    {{-- Result now shows as a global toast (bottom-right) and the session
         success/error banner in layouts/cms.blade.php — this page used to
         also render its own success box and a raw $errors->any() dump on
         top of that, so a save showed the same "updated successfully"
         message twice. --}}

    <form method="POST" action="{{ route('cms.contact.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Office Details -->
        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Office Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Primary office contact information.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Name</label>
                    <input type="text" name="office_name" placeholder="Precious Real Estate Consulting"
                        value="{{ old('office_name', $settings['office_name'] ?? '') }}" class="cms-input">
                    @error('office_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Working Hours</label>
                    <input type="text" name="working_hours" placeholder="Mon-Fri, 08:00-17:00"
                        value="{{ old('working_hours', $settings['working_hours'] ?? '') }}" class="cms-input">
                    @error('working_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Lilongwe Office Address</label>
                    <textarea name="office_address_lilongwe" placeholder="Area 47/S3, GPH House, Lilongwe" rows="2" class="cms-input">{{ old('office_address_lilongwe', $settings['office_address_lilongwe'] ?? '') }}</textarea>
                    @error('office_address_lilongwe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Blantyre Office Address</label>
                    <textarea name="office_address_blantyre" placeholder="Haji Latif Pavilion, Room 35, Blantyre" rows="2" class="cms-input">{{ old('office_address_blantyre', $settings['office_address_blantyre'] ?? '') }}</textarea>
                    @error('office_address_blantyre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Postal Address</label>
                    <textarea name="postal_address" placeholder="Enter postal address" rows="2" class="cms-input">{{ old('postal_address', $settings['postal_address'] ?? '') }}</textarea>
                    @error('postal_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Contact Methods -->
        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Contact Methods</h3>
            <p class="text-sm text-brand-black/60 mb-6">Phone, email, and messaging contact details.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Phone</label>
                    <input type="tel" name="office_phone" placeholder="+265 1 2345 6789"
                        value="{{ old('office_phone', $settings['office_phone'] ?? '') }}" class="cms-input">
                    @error('office_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Phone (Second Line)</label>
                    <input type="tel" name="office_phone_secondary" placeholder="+265 1 2345 6789"
                        value="{{ old('office_phone_secondary', $settings['office_phone_secondary'] ?? '') }}" class="cms-input">
                    @error('office_phone_secondary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Email</label>
                    <input type="email" name="office_email" placeholder="info@preciousrealestate.mw"
                        value="{{ old('office_email', $settings['office_email'] ?? '') }}" class="cms-input">
                    @error('office_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">WhatsApp Number</label>
                    <input type="tel" name="whatsapp_number" placeholder="+265 9 12 34 56 78"
                        value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" class="cms-input">
                    @error('whatsapp_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Location</h3>
            <p class="text-sm text-brand-black/60 mb-6">GPS coordinates for map integration.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Latitude</label>
                    <input type="number" name="latitude" placeholder="-13.9626" step="0.0001"
                        value="{{ old('latitude', $settings['latitude'] ?? '') }}" class="cms-input">
                    @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Longitude</label>
                    <input type="number" name="longitude" placeholder="33.7741" step="0.0001"
                        value="{{ old('longitude', $settings['longitude'] ?? '') }}" class="cms-input">
                    @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Social Links -->
        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Social Media</h3>
            <p class="text-sm text-brand-black/60 mb-6">Links to social media profiles.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Facebook URL</label>
                    <input type="url" name="facebook_url" placeholder="https://facebook.com/..."
                        value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="cms-input">
                    @error('facebook_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Instagram URL</label>
                    <input type="url" name="instagram_url" placeholder="https://instagram.com/..."
                        value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="cms-input">
                    @error('instagram_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">LinkedIn URL</label>
                    <input type="url" name="linkedin_url" placeholder="https://linkedin.com/..."
                        value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" class="cms-input">
                    @error('linkedin_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">TikTok URL</label>
                    <input type="url" name="tiktok_url" placeholder="https://tiktok.com/@..."
                        value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}" class="cms-input">
                    @error('tiktok_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3">
            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                <i data-lucide="check" class="w-5 h-5"></i>
                Save Changes
            </button>
            <a href="{{ route('cms.dashboard') }}" class="btn-secondary">
                Cancel
            </a>
        </div>
    </form>
@endsection
