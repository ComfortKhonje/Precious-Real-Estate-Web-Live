@props(['property_id' => null])

{{-- [Component: inquiry/inquiry-form] Multi-step inquiry flow --}}
<section id="inquiry-form" class="py-6 h-full md:py-12 px-4 md:px-6 min-h-[70vh] flex md:justify-center md:items-center"
    x-data="inquiryFlow({{ $property_id ? $property_id : 'null' }})">
    <div class="w-full max-w-5xl transition-all duration-500"
        :class="step === 5 ?
            'bg-brand-black rounded-[1.5rem] p-8 md:p-12 text-white overflow-hidden relative min-h-[80vh] flex items-center' :
            'bg-brand-white rounded-[1.5rem] p-6 md:p-12 border border-gray-100 flex-grow'">

        {{-- Success Background Image --}}
        <img x-show="step === 5" src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}"
            alt="" class="absolute inset-0 w-full h-full object-cover z-0">

        <div class="w-full relative z-10">
            {{-- Progress Bar (Steps 1-4) --}}
            <template x-if="step < 5">
                <div class="flex gap-1.5 md:gap-2 mb-8 md:mb-12 px-2 md:px-0">
                    <div class="h-1 md:h-1.5 flex-1 rounded-full transition-all duration-500"
                        :class="step >= 1 ? 'bg-primary' : 'bg-gray-200'"></div>
                    <div class="h-1 md:h-1.5 flex-1 rounded-full transition-all duration-500"
                        :class="step >= 2 ? 'bg-primary' : 'bg-gray-200'"></div>
                    <div class="h-1 md:h-1.5 flex-1 rounded-full transition-all duration-500"
                        :class="step >= 3 ? 'bg-primary' : 'bg-gray-200'"></div>
                    <div class="h-1 md:h-1.5 flex-1 rounded-full transition-all duration-500"
                        :class="step >= 4 ? 'bg-primary' : 'bg-gray-200'"></div>
                </div>
            </template>

            <form @submit.prevent="submitForm" class="flex flex-col min-h-full">

                {{-- Step 1: How Can We Assist You? --}}
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <h2
                        class="text-2xl md:text-5xl font-heading text-brand-black mb-6 md:mb-8 uppercase tracking-tight">
                        How Can We Assist You?</h2>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Service
                                Needed</label>
                            <select x-model="formData.service" @change="resetServiceFields"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:20px_20px] bg-[right_1.25rem_center] bg-no-repeat"
                                style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="">Select a service</option>
                                <option value="Property Valuation">Property Valuation</option>
                                <option value="Property Management">Property Management</option>
                                <option value="Sales & Letting">Sales & Letting</option>
                                <option value="Property Development">Property Development</option>
                                <option value="Title Deed Processing">Title Deed Processing</option>
                                <option value="General Consultation">General Consultation</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Tell Us About Yourself --}}
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <h2
                        class="text-3xl md:text-5xl font-heading text-brand-black mb-6 md:mb-8 uppercase tracking-tight">
                        Tell Us About Yourself</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Full Name</label>
                            <input type="text" x-model="formData.name" placeholder="Enter your full name"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Phone
                                Number</label>
                            <input type="tel" x-model="formData.phone" placeholder="Enter your phone number"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Email
                                Address</label>
                            <input type="email" x-model="formData.email" placeholder="Enter your email address"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Contact
                                Method</label>
                            <select x-model="formData.contactMethod"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                <option value="Phone">Phone</option>
                                <option value="Email">Email</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Step 3: Provide Additional Information (Dynamic) --}}
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-3xl md:text-5xl font-heading text-brand-black mb-2 uppercase tracking-tight">
                        Additional Details</h2>
                    <p class="mb-6 md:mb-8 text-sm md:text-lg text-gray-500 uppercase tracking-widest font-bold">
                        Service: <span class="text-primary" x-text="formData.service"></span></p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
                        {{-- Common Fields: Location --}}
                        <div class="space-y-1.5" x-show="formData.service !== 'General Consultation'">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400"
                                x-text="formData.service === 'Property Development' ? 'Project Location' : 'Property Location'"></label>
                            <input type="text" x-model="formData.location" :placeholder="'Enter location'"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                        </div>

                        {{-- Valuation Specific --}}
                        <template x-if="formData.service === 'Property Valuation'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Property
                                        Type</label>
                                    <select x-model="formData.propertyType"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select Type</option>
                                        <option value="Residential">Residential</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Industrial">Industrial</option>
                                        <option value="Agricultural">Agricultural</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Purpose of
                                        Valuation</label>
                                    <select x-model="formData.purposeOfValuation"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select Purpose</option>
                                        <option value="Loan Security">Loan Security</option>
                                        <option value="Selling / Buying">Selling / Buying</option>
                                        <option value="Insurance Purposes">Insurance Purposes</option>
                                        <option value="Accounting Purposes">Accounting Purposes</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Estimated
                                        Size</label>
                                    <input type="text" x-model="formData.estimatedPropertySize"
                                        placeholder="e.g., 2000 sqm"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                                </div>
                            </div>
                        </template>

                        {{-- Management Specific --}}
                        <template x-if="formData.service === 'Property Management'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Management
                                        Needs</label>
                                    <select x-model="formData.managementNeeds"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select need</option>
                                        <option value="Rent Collection">Rent Collection</option>
                                        <option value="Maintenance">Property Maintenance</option>
                                        <option value="Full Management">Full Management</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Number of
                                        Properties</label>
                                    <input type="text" x-model="formData.numberOfProperties"
                                        placeholder="e.g., 1, 5, 10+"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                                </div>
                            </div>
                        </template>

                        {{-- Sales & Letting Specific --}}
                        <template x-if="formData.service === 'Sales & Letting'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Inquiry
                                        Type</label>
                                    <select x-model="formData.inquiryType"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select type</option>
                                        <option value="Sell">Sell Property</option>
                                        <option value="Let">Let Property</option>
                                        <option value="Buy">Buy Property</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Budget /
                                        Price</label>
                                    <input type="text" x-model="formData.budgetAskingPrice"
                                        placeholder="Enter budget/asking price"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                                </div>
                            </div>
                        </template>

                        {{-- Development Specific --}}
                        <template x-if="formData.service === 'Property Development'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Project
                                        Type</label>
                                    <select x-model="formData.projectType"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select type</option>
                                        <option value="Residential">Residential</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Land">Land Development</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Project
                                        Stage</label>
                                    <select x-model="formData.projectStage"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select stage</option>
                                        <option value="Planning">Planning</option>
                                        <option value="Ongoing">Ongoing</option>
                                    </select>
                                </div>
                            </div>
                        </template>

                        {{-- Title Deed Specific --}}
                        <template x-if="formData.service === 'Title Deed Processing'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Current
                                        Status</label>
                                    <input type="text" x-model="formData.currentStatus"
                                        placeholder="e.g., Pending review"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                                </div>
                            </div>
                        </template>

                        {{-- General Consultation Specific --}}
                        <template x-if="formData.service === 'General Consultation'">
                            <div class="space-y-1.5 flex flex-col gap-5 md:contents">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Inquiry
                                        Topic</label>
                                    <input type="text" x-model="formData.inquiryTopic" placeholder="Enter topic"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Preferred
                                        Service</label>
                                    <select x-model="formData.preferredService"
                                        class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none text-base md:text-lg appearance-none bg-[length:18px_18px] bg-[right_1.25rem_center] bg-no-repeat"
                                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23222222%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22m6 9 6 6 6-6%22/></svg>');">
                                        <option value="">Select service</option>
                                        <option value="Valuation">Valuation</option>
                                        <option value="Management">Management</option>
                                    </select>
                                </div>
                            </div>
                        </template>

                        {{-- Common Textarea --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400"
                                x-text="getServiceSpecificLabel()"></label>
                            <textarea x-model="formData.additionalDetails" :placeholder="getServiceSpecificPlaceholder()"
                                class="w-full bg-gray-100 rounded-xl md:rounded-2xl py-4 md:py-5 px-5 md:px-6 text-brand-black font-semibold focus:ring-2 focus:ring-primary focus:bg-white border-none text-base md:text-lg min-h-[120px] md:min-h-[150px]"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Step 4: Review Your Inquiry --}}
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <h2
                        class="text-3xl md:text-5xl font-heading text-brand-black mb-8 md:mb-12 text-center uppercase tracking-tight">
                        Review Inquiry</h2>

                    <div class="space-y-3 md:space-y-4">
                        {{-- Service --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-xl md:rounded-2xl p-4 md:p-6">
                            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-[0.2em] mb-1">Service</p>
                            <p class="text-lg md:text-xl font-bold text-brand-black" x-text="formData.service"></p>
                        </div>

                        {{-- Personal Details --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-xl md:rounded-2xl p-4 md:p-6">
                            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-[0.2em] mb-3 md:mb-4">
                                Personal Details</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase">Name</p>
                                    <p class="font-bold text-brand-black text-sm md:text-base" x-text="formData.name">
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase">Phone</p>
                                    <p class="font-bold text-brand-black text-sm md:text-base"
                                        x-text="formData.phone"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase">Email</p>
                                    <p class="font-bold text-brand-black text-sm md:text-base truncate"
                                        x-text="formData.email"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Inquiry Information --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-xl md:rounded-2xl p-4 md:p-6">
                            <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-[0.2em] mb-3 md:mb-4">
                                Information</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mb-4">
                                <div x-show="formData.service !== 'General Consultation'">
                                    <p class="text-[10px] text-gray-400 uppercase">Location</p>
                                    <p class="font-bold text-brand-black text-sm md:text-base"
                                        x-text="formData.location"></p>
                                </div>

                                {{-- Service Specific Review Items --}}
                                <template x-if="formData.service === 'Property Valuation'">
                                    <div class="contents">
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Type</p>
                                            <p class="font-bold text-brand-black text-sm md:text-base"
                                                x-text="formData.propertyType"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Purpose</p>
                                            <p class="font-bold text-brand-black text-sm md:text-base"
                                                x-text="formData.purposeOfValuation"></p>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="formData.service === 'Property Management'">
                                    <div class="contents">
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Needs</p>
                                            <p class="font-bold text-brand-black text-sm md:text-base"
                                                x-text="formData.managementNeeds"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase">Properties</p>
                                            <p class="font-bold text-brand-black text-sm md:text-base"
                                                x-text="formData.numberOfProperties"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase" x-text="getServiceSpecificLabel()"></p>
                                <p class="font-semibold text-brand-black text-sm md:text-base"
                                    x-text="formData.additionalDetails"></p>
                            </div>
                        </div>
                    </div>

                    <p
                        class="text-center text-gray-400 mt-6 md:mt-8 text-[10px] md:text-xs uppercase tracking-widest font-bold">
                        Securely processed inquiry
                    </p>
                </div>

                {{-- Step 5: Success --}}
                <div x-show="step === 5" class="flex flex-col items-center text-center relative z-10 w-full"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div
                        class="w-20 h-20 md:w-32 md:h-32 bg-primary rounded-full flex items-center justify-center mb-6 md:mb-10 shadow-2xl">
                        <svg class="w-10 h-10 md:w-16 md:h-16 text-brand-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <h2
                        class="text-3xl md:text-6xl font-heading text-white mb-4 md:mb-6 uppercase tracking-tight leading-none">
                        Thank You</h2>
                    <p
                        class="text-gray-300 text-base md:text-xl max-w-2xl mb-8 md:mb-12 leading-relaxed font-medium px-4">
                        Your inquiry has been received. Our team will get back to you within 24 working hours.
                    </p>

                    <div class="flex flex-col md:flex-row justify-center gap-4 md:gap-6 w-full px-6 md:px-0">
                        <a href="{{ route('home') }}"
                            class="w-full md:w-auto inline-flex items-center justify-center px-10 py-4 border-2 border-white text-white rounded-full font-bold uppercase tracking-widest hover:bg-white hover:text-brand-black transition duration-300 text-xs md:text-sm">
                            RETURN HOME
                        </a>
                        <a href="{{ route('properties') }}"
                            class="w-full md:w-auto inline-flex items-center justify-center px-10 py-4 bg-primary text-brand-black rounded-full font-bold uppercase tracking-widest hover:scale-105 active:scale-95 transition duration-300 text-xs md:text-sm">
                            PROPERTIES
                        </a>
                    </div>
                </div>

                {{-- Navigation Buttons (Steps 1-4) --}}
                <div x-show="step < 4" class="flex flex-row justify-end gap-3 md:gap-4 mt-10 md:mt-12">
                    <button type="button" @click="prevStep" x-show="step > 1"
                        class="px-8 md:px-10 py-4 bg-gray-100 text-gray-500 rounded-full font-bold uppercase tracking-widest hover:bg-gray-200 transition duration-300 text-xs">
                        BACK
                    </button>
                    <button type="button" @click="nextStep" :disabled="!canGoNext()"
                        :class="!canGoNext() ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 active:scale-95'"
                        class="px-10 md:px-12 py-4 bg-brand-black text-white rounded-full font-bold uppercase tracking-widest transition duration-300 text-xs">
                        NEXT
                    </button>
                </div>

                {{-- Final Submit Button (Step 4) --}}
                <div x-show="step === 4" class="flex justify-center mt-10 md:mt-12">
                    <button type="submit"
                        class="w-full md:w-auto px-16 py-5 bg-brand-black text-white rounded-full font-bold uppercase tracking-widest hover:scale-105 active:scale-98 transition-all duration-300 shadow-xl text-xs md:text-sm">
                        SUBMIT INQUIRY
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<script>
    function inquiryFlow(propertyId = null) {
        return {
            step: 1,
            isSubmitting: false,
            error: null,
            formData: {
                service: '',
                name: '',
                phone: '',
                email: '',
                contactMethod: 'Phone',
                location: '',
                property_id: propertyId,
                propertyType: '',
                purposeOfValuation: '',
                estimatedPropertySize: '',
                managementNeeds: '',
                numberOfProperties: '',
                inquiryType: '',
                budgetAskingPrice: '',
                projectType: '',
                serviceNeeded: '',
                projectStage: '',
                currentStatus: '',
                inquiryTopic: '',
                preferredService: '',
                message: '',
                additionalDetails: ''
            },

            resetServiceFields() {
                this.formData.propertyType = '';
                this.formData.location = '';
                this.formData.purposeOfValuation = '';
                this.formData.estimatedPropertySize = '';
                this.formData.managementNeeds = '';
                this.formData.numberOfProperties = '';
                this.formData.inquiryType = '';
                this.formData.budgetAskingPrice = '';
                this.formData.projectType = '';
                this.formData.serviceNeeded = '';
                this.formData.projectStage = '';
                this.formData.currentStatus = '';
                this.formData.inquiryTopic = '';
                this.formData.preferredService = '';
                this.formData.message = '';
                this.formData.additionalDetails = '';
            },

            nextStep() {
                if (this.canGoNext()) {
                    this.step++;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },

            prevStep() {
                if (this.step > 1) {
                    this.step--;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },

            canGoNext() {
                if (this.step === 1) return this.formData.service !== '';
                if (this.step === 2) return this.formData.name !== '' && this.formData.email !== '' && this.formData
                    .phone !== '';
                if (this.step === 3) {
                    if (this.formData.service === 'General Consultation') {
                        return this.formData.inquiryTopic !== '';
                    }
                    return this.formData.location !== '';
                }
                return true;
            },

            getServiceSpecificLabel() {
                switch (this.formData.service) {
                    case 'Property Valuation':
                        return 'Purpose of Valuation';
                    case 'Property Management':
                        return 'Management Requirements';
                    case 'Sales & Letting':
                        return 'Sale/Rental Details';
                    case 'Property Development':
                        return 'Development Goals';
                    case 'Title Deed Processing':
                        return 'Deed Information';
                    default:
                        return 'Additional Information';
                }
            },

            getServiceSpecificPlaceholder() {
                switch (this.formData.service) {
                    case 'Property Valuation':
                        return 'e.g., Mortgage, Sale, Insurance...';
                    case 'Property Management':
                        return 'Describe your management needs...';
                    case 'Sales & Letting':
                        return 'Tell us more about the property...';
                    case 'Property Development':
                        return 'Share your vision for the project...';
                    case 'Title Deed Processing':
                        return 'Enter details about the title deed...';
                    default:
                        return 'Enter any additional details here...';
                }
            },

            async submitForm() {
                try {
                    // Show loading state
                    this.isSubmitting = true;
                    this.error = null;

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    // Submit to API
                    const response = await fetch('/api/inquiries/public', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(this.formData)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Failed to submit inquiry');
                    }

                    const data = await response.json();

                    // Success! Show success screen
                    this.step = 5;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    // Optional: Reset form after delay
                    setTimeout(() => {
                        this.step = 1;
                        this.resetForm();
                    }, 5000);

                } catch (error) {
                    this.error = error.message;
                    console.error('Inquiry submission error:', error);
                    // Show error alert
                    alert('Error submitting inquiry: ' + error.message);
                } finally {
                    this.isSubmitting = false;
                }
            },

            resetForm() {
                this.formData = {
                    service: '',
                    name: '',
                    phone: '',
                    email: '',
                    contactMethod: 'Phone',
                    location: '',
                    property_id: this.formData.property_id, // Preserve property_id
                    propertyType: '',
                    purposeOfValuation: '',
                    estimatedPropertySize: '',
                    managementNeeds: '',
                    numberOfProperties: '',
                    inquiryType: '',
                    budgetAskingPrice: '',
                    projectType: '',
                    serviceNeeded: '',
                    projectStage: '',
                    currentStatus: '',
                    inquiryTopic: '',
                    preferredService: '',
                    message: '',
                    additionalDetails: ''
                };
            }
        }
    }
</script>
