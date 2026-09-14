@extends('layouts.cms')

@section('title', 'Inquiry Details | PREC CMS')
@section('page_title', 'Inquiry Details')
@section('page_subtitle', 'Review and manage the selected inquiry.')

@section('content')
    @php
        // Structured inquiries (from the /inquiry multi-step form or the property
        // page's quick form) store their message as JSON — see
        // Api\InquiriesController::storePublic(). Field names read here now match
        // what that method actually writes (fixed 2026-09-02 — the old version here
        // switched on values like 'valuation'/'sales-letting' and read fields like
        // 'valuationDate'/'concerns' that were never what got stored, so every real
        // inquiry silently fell through to the generic fallback regardless of
        // service type). Decoded once up top since both the sidebar (preferred
        // contact method) and the main panel (everything else) need it.
        $messageData = json_decode($inquiry->message ?? '', true);
        $isJsonMessage = is_array($messageData) && isset($messageData['service']);
        $serviceFields = $isJsonMessage ? array_filter($messageData['serviceFields'] ?? []) : [];
        $preferredContact = $isJsonMessage ? ($messageData['contactMethod'] ?? null) : null;

        $fieldLabels = [
            'propertyType' => 'Property Type',
            'purposeOfValuation' => 'Purpose of Valuation',
            'estimatedPropertySize' => 'Estimated Size',
            'managementNeeds' => 'Management Needs',
            'numberOfProperties' => 'Number of Properties',
            'inquiryType' => 'Inquiry Type',
            'budgetAskingPrice' => 'Budget / Asking Price',
            'projectType' => 'Project Type',
            'projectStage' => 'Project Stage',
            'currentStatus' => 'Current Status',
            'inquiryTopic' => 'Inquiry Topic',
            'preferredService' => 'Preferred Service',
        ];
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-[350px_1fr] gap-6">
        <!-- Left Sidebar -->
        <div class="space-y-6">
            <!-- Inquiry Info Card -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-primary/20 border-2 border-primary text-yellow-800 flex items-center justify-center font-bold text-lg shrink-0">
                        {{ substr($inquiry->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading text-2xl leading-tight">{{ $inquiry->name }}</h3>
                        <p class="text-xs text-brand-black/60 mt-1">{{ $inquiry->created_at->format('M j, Y \a\t g:i A') }}</p>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-2 text-brand-black/80">
                        <i data-lucide="mail" class="w-5 h-5 shrink-0"></i>
                        <a href="mailto:{{ $inquiry->email }}" class="text-yellow-900 hover:underline truncate">{{ $inquiry->email }}</a>
                        @if($preferredContact === 'Email')
                            <span class="ml-auto px-2 py-0.5 rounded-full bg-primary/20 text-brand-black text-[10px] font-bold uppercase tracking-wide shrink-0">Preferred</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-brand-black/80">
                        <i data-lucide="phone" class="w-5 h-5 shrink-0"></i>
                        <a href="tel:{{ $inquiry->phone }}" class="text-yellow-900 hover:underline">{{ $inquiry->phone ?? '—' }}</a>
                        @if(in_array($preferredContact, ['Phone', 'WhatsApp'], true))
                            <span class="ml-auto px-2 py-0.5 rounded-full bg-primary/20 text-brand-black text-[10px] font-bold uppercase tracking-wide shrink-0">{{ $preferredContact === 'WhatsApp' ? 'Prefers WhatsApp' : 'Preferred' }}</span>
                        @endif
                    </div>
                    @if ($inquiry->property_id)
                        <div class="flex items-start gap-2 text-brand-black/80">
                            <i data-lucide="home" class="w-5 h-5 shrink-0 mt-0.5"></i>
                            <div class="min-w-0">
                                <a href="{{ route('cms.properties.edit', $inquiry->property) }}" class="text-yellow-900 hover:underline">
                                    {{ optional($inquiry->property)->title ?? 'Unknown property' }}
                                </a>
                                @if (optional($inquiry->property)->location)
                                    <div class="text-xs text-brand-black/50">{{ $inquiry->property->location }}</div>
                                @endif
                            </div>
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
                    @if ($inquiry->property_id && $inquiry->property)
                        <a href="{{ route('cms.properties.edit', $inquiry->property) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-sm font-semibold">
                            <i data-lucide="home" class="w-4 h-4"></i> Edit Property
                        </a>
                    @endif
                    @if(auth()->user()->hasRoleAtLeast('admin'))
                    <form id="delete-inquiry-form-{{ $inquiry->id }}" method="POST" action="{{ route('cms.inquiries.destroy', $inquiry) }}" class="pt-2 border-t border-gray-100">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            @click="confirmFormId = 'delete-inquiry-form-{{ $inquiry->id }}'; confirmMessage = 'Are you sure? This cannot be undone.'; confirmModalOpen = true"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-100 text-red-700 hover:bg-red-200 transition text-sm font-semibold w-full justify-center">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete Inquiry
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h4 class="font-heading text-2xl mb-4">Inquiry Details</h4>

            @if ($isJsonMessage)
                {{-- Service type is already the badge in the sidebar, and preferred
                     contact method is now flagged directly on the matching email/
                     phone row above — neither needs repeating here. --}}
                <div class="space-y-5">
                    @if ($messageData['location'] ?? null)
                        <div class="pb-5 border-b border-gray-100">
                            <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Location</h5>
                            <p class="font-semibold text-brand-black">{{ $messageData['location'] }}</p>
                        </div>
                    @endif

                    @if (!empty($serviceFields))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pb-5 border-b border-gray-100">
                            @foreach ($serviceFields as $key => $value)
                                <div>
                                    <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">{{ $fieldLabels[$key] ?? \Illuminate\Support\Str::headline($key) }}</h5>
                                    <p class="font-semibold text-brand-black">{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <h5 class="text-xs uppercase tracking-widest text-brand-black/50 mb-2">Additional Details</h5>
                        <p class="text-brand-black/80 whitespace-pre-line">{{ $messageData['additionalDetails'] ?? '—' }}</p>
                    </div>
                </div>
            @else
                <!-- Plain Text Message -->
                <p class="text-brand-black/80 whitespace-pre-line leading-relaxed">{{ $inquiry->message }}</p>
            @endif
        </div>
    </div>
@endsection
