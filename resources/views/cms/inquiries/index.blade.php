@extends('layouts.cms')

@section('title', 'Inquiries | PREC CMS')
@section('page_title', 'Inquiries')
@section('page_subtitle', 'Central inbox for website and service inquiries.')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center gap-3">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="Search by name, email, property, service..." class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                        <svg class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <select class="bg-gray-50 border border-gray-100 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                        <option>All Types</option>
                        <option>General inquiries</option>
                        <option>Service inquiries</option>
                        <option>Property inquiries</option>
                        <option>Appointment requests</option>
                    </select>
                    <select class="bg-gray-50 border border-gray-100 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                        <option>All</option>
                        <option>New</option>
                        <option>Recent</option>
                    </select>
                </div>
            </div>

            <div class="p-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <h3 class="font-heading text-3xl leading-none mb-2">No inquiries yet</h3>
                <p class="text-brand-black/60 max-w-xl mx-auto">When users submit inquiries on the website, they will appear here. New inquiries will be highlighted.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Inquiry Detail</h3>
            <p class="text-sm text-brand-black/60 mb-6">Opens without leaving the page.</p>

            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <p class="text-sm text-brand-black/60">Select an inquiry to view details.</p>
            </div>
        </div>
    </div>
@endsection

