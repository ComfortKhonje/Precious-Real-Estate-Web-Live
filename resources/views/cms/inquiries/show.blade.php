@extends('layouts.cms')

@section('title', 'Inquiry Details | PREC CMS')
@section('page_title', 'Inquiry Details')
@section('page_subtitle', 'Review and manage the selected inquiry.')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-[350px_1fr] gap-6">
        <!-- Left Sidebar -->
        <div class="space-y-6">
            <!-- Inquiry Info Card -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-primary/20 border-2 border-primary text-yellow-800 flex items-center justify-center font-bold text-lg">
                        {{ substr($inquiry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading text-2xl leading-tight">{{ $inquiry->name }}</h3>
                        <p class="text-xs text-brand-black/60 mt-1">{{ $inquiry->created_at->format('M j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-2 text-brand-black/80">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        <a href="mailto:{{ $inquiry->email }}" class="text-yellow-900 hover:underline">{{ $inquiry->email }}</a>
                    </div>
                    <div class="flex items-center gap-2 text-brand-black/80">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                        <a href="tel:{{ $inquiry->phone }}" class="text-yellow-900 hover:underline">{{ $inquiry->phone ?? '—' }}</a>
                    </div>
                    @if ($inquiry->property_id)
                        <div class="flex items-center gap-2 text-brand-black/80">
                            <i data-lucide="home" class="w-5 h-5"></i>
                            <a href="{{ route('cms.properties.edit', $inquiry->property) }}" class="text-yellow-900 hover:underline">
                                {{ optional($inquiry->property)->title ?? 'Unknown property' }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <span class="inline-block px-3 py-1 rounded-full bg-primary text-black text-xs font-semibold capitalize">
                        {{ $inquiry->type ?? 'General' }}
                    </span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <h4 class="font-semibold text-lg mb-4">Actions</h4>
                <div class="space-y-2">
                    <a href="{{ route('cms.inquiries.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-brand-black hover:bg-gray-200 transition text-sm font-semibold">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Inquiries
                    </a>
                    <a href="mailto:{{ $inquiry->email }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-sm font-semibold">
                        <i data-lucide="mail" class="w-4 h-4"></i> Reply via Email
                    </a>
                    <form id="delete-inquiry-form-{{ $inquiry->id }}" method="POST" action="{{ route('cms.inquiries.destroy', $inquiry) }}" class="pt-2 border-t border-gray-100">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            @click="confirmFormId = 'delete-inquiry-form-{{ $inquiry->id }}'; confirmMessage = 'Are you sure? This cannot be undone.'; confirmModalOpen = true"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-semibold w-full justify-center">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="space-y-6">
            <!-- Message Content -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <h4 class="font-heading text-2xl mb-4">Message</h4>
                
                @php
                    // Try to parse the message as JSON (service-specific fields)
                    $messageData = null;
                    $isJsonMessage = false;
                    try {
                        $decoded = json_decode($inquiry->message, true);
                        if (is_array($decoded) && isset($decoded['service'])) {
                            $messageData = $decoded;
                            $isJsonMessage = true;
                        }
                    } catch (\Exception $e) {
                        // Not JSON
                    }
                @endphp

                @if ($isJsonMessage && $messageData)
                    <!-- Structured Service Inquiry -->
                    <div class="space-y-5">
                        <!-- Service Section -->
                        <div class="pb-5 border-b border-gray-100">
                            <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Service Type</h5>
                            <p class="text-lg font-semibold text-brand-black capitalize">{{ $messageData['service'] ?? 'Not specified' }}</p>
                        </div>

                        <!-- Service-Specific Fields -->
                        @switch($messageData['service'] ?? null)
                            @case('valuation')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pb-5 border-b border-gray-100">
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Property Type</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['propertyType'] ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Valuation Date</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['valuationDate'] ?? '—' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Additional Details</h5>
                                        <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['additionalDetails'] ?? '—' }}</p>
                                    </div>
                                </div>
                                @break

                            @case('management')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pb-5 border-b border-gray-100">
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Property Type</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['propertyType'] ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Units Count</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['unitsCount'] ?? '—' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Concerns</h5>
                                        <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['concerns'] ?? '—' }}</p>
                                    </div>
                                </div>
                                @break

                            @case('sales-letting')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pb-5 border-b border-gray-100">
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Type</h5>
                                        <p class="font-semibold text-brand-black">{{ ucfirst($messageData['saleLettingType'] ?? 'Not specified') }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Property Type</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['propertyType'] ?? '—' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Description</h5>
                                        <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['description'] ?? '—' }}</p>
                                    </div>
                                </div>
                                @break

                            @case('development')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pb-5 border-b border-gray-100">
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Project Type</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['projectType'] ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Timeline</h5>
                                        <p class="font-semibold text-brand-black">{{ $messageData['timeline'] ?? '—' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Project Details</h5>
                                        <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['projectDetails'] ?? '—' }}</p>
                                    </div>
                                </div>
                                @break

                            @default
                                <div>
                                    <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Additional Information</h5>
                                    <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['additionalDetails'] ?? $messageData['message'] ?? '—' }}</p>
                                </div>
                        @endswitch

                        <!-- Contact Preference -->
                        @if (isset($messageData['contactMethod']))
                            <div class="pt-5 border-t border-gray-100">
                                <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Preferred Contact Method</h5>
                                <p class="font-semibold text-brand-black capitalize">{{ $messageData['contactMethod'] ?? '—' }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Plain Text Message -->
                    <p class="text-brand-black/80 whitespace-pre-line leading-relaxed">{{ $inquiry->message }}</p>
                @endif
            </div>

            <!-- Related Information -->
            @if ($inquiry->property_id && $inquiry->property)
                <div class="bg-blue-50 border border-blue-200 rounded-3xl p-6">
                    <h4 class="font-heading text-xl mb-4 text-blue-900">Related Property</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <h5 class="text-xs uppercase tracking-widest text-blue-700 mb-2">Title</h5>
                            <p class="font-semibold text-brand-black">{{ $inquiry->property->title }}</p>
                        </div>
                        <div>
                            <h5 class="text-xs uppercase tracking-widest text-blue-700 mb-2">Location</h5>
                            <p class="font-semibold text-brand-black">{{ $inquiry->property->location ?? '—' }}</p>
                        </div>
                        <div>
                            <a href="{{ route('cms.properties.edit', $inquiry->property) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition text-sm font-semibold">
                                View Property <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
