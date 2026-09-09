<section id="contact-form-section" class="relative mt-20">
    <img loading="lazy" decoding="async" src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
    <x-shared.contact-info variant="dark" :overlap="true" />

    {{-- House Image with Yellow Accent --}}
    <div class="absolute hidden md:block bottom-0 left-0 w-full max-w-2xl pointer-events-none z-0">
        <img loading="lazy" decoding="async"
            src="{{ asset('brand-assets/7 Contact Page/hand-holding-house-real-estate-property-model 1.png') }}"
            alt="Hand holding house model"
            class="relative z-10 w-full h-auto object-contain transform -translate-x-12">
    </div>

    <div class="relative max-w-7xl mx-auto pt-12">

        <div>
            <div class="grid grid-cols-1 lg:grid-cols-12 w-full relative z-10">

                {{-- Left Side: Decorative Image & Heading --}}
                <div class="lg:col-span-5 w-full flex flex-col justify-between px-4 md:px-0">
                    <div>
                        <div class="badge-yellow mb-2 md:mb-6">Send an Inquiry</div>
                        <h2 class="text-4xl md:text-5xl font-heading text-white mb-8 uppercase leading-tight">
                            Request Information or Consultation
                        </h2>
                    </div>
                </div>

                {{-- Right Side: The Form --}}
                <div class="lg:col-span-7 px-4 pb-12">
                    <div x-data="contactFormHandler()" class="space-y-4">
                        {{-- Form --}}
                        {{-- Result now shows as a global toast (bottom-right) instead of
                             an inline banner here — see x-shared.toast-container, included
                             once in the layout. Keeps every form on the site consistent
                             instead of each one building its own success/error UI. --}}
                        <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6">
                            <x-shared.honeypot />
                            {{-- Full Name --}}
                            <div class="space-y-2">
                                <label class="text-sm font-md text-brand-white tracking-widest pl-2">Full Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    x-model="formData.name"
                                    placeholder="Enter your full name"
                                    required
                                    class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                            </div>

                            {{-- Phone Number --}}
                            <div class="space-y-2">
                                <label class="text-sm font-md text-brand-white tracking-widest pl-2">Phone Number</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    x-model="formData.phone"
                                    placeholder="Enter your phone number"
                                    required
                                    class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                            </div>

                            {{-- Email Address --}}
                            <div class="space-y-2">
                                <label class="text-sm font-md text-brand-white tracking-widest pl-2">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    x-model="formData.email"
                                    placeholder="Enter your email address"
                                    required
                                    class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                            </div>

                            {{-- Service Needed --}}
                            <div class="space-y-2">
                                <label class="text-sm font-md text-brand-white tracking-widest pl-2">Service Needed</label>
                                <select
                                    name="serviceNeeded"
                                    x-model="formData.serviceNeeded"
                                    required
                                    class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none">
                                    <option value="">Select the service you need</option>
                                    <option value="Property Valuation">Property Valuation</option>
                                    <option value="Property Management">Property Management</option>
                                    <option value="Sales & Letting">Sales & Letting</option>
                                    <option value="Property Development">Property Development</option>
                                    <option value="Title Deed Processing">Title Deed Processing</option>
                                    <option value="General Consultation">General Consultation</option>
                                </select>
                            </div>

                            {{-- Message --}}
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-md text-brand-white tracking-widest pl-2">Message</label>
                                <textarea
                                    name="message"
                                    x-model="formData.message"
                                    rows="4"
                                    placeholder="Tell us briefly how we can assist you..."
                                    required
                                    class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="md:col-span-2 pt-4">
                                <button
                                    type="submit"
                                    :disabled="isSubmitting"
                                    :class="isSubmitting ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary'"
                                    class="bg-white w-full md:w-fit text-brand-black rounded-full py-4 px-12 font-bold text-xs uppercase tracking-widest transition duration-300 shadow-lg">
                                    <span x-show="!isSubmitting">SUBMIT MESSAGE</span>
                                    <span x-show="isSubmitting">SUBMITTING...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    function contactFormHandler() {
        return {
            isSubmitting: false,
            formData: {
                name: '',
                email: '',
                phone: '',
                serviceNeeded: '',
                message: ''
            },

            async submitForm() {
                if (this.isSubmitting) return; // guards a fast double-click, not just the disabled attribute

                try {
                    this.isSubmitting = true;

                    if (!this.formData.name || !this.formData.email || !this.formData.phone ||
                        !this.formData.serviceNeeded || !this.formData.message) {
                        throw new Error('Please fill in all fields');
                    }

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                    // Spam honeypot — see x-shared.honeypot. Read straight off
                    // the DOM rather than tracked in formData, since a bot
                    // filling every visible-ish field is exactly what this
                    // catches; a real user never sees or touches it.
                    const website = document.querySelector('input[name="website"]')?.value || '';

                    const response = await fetch('/api/contact', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ ...this.formData, website })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Failed to submit message');
                    }

                    window.showToast('success', "Thank you! Your message has been received. We'll get back to you within 24 hours.");

                    this.formData = { name: '', email: '', phone: '', serviceNeeded: '', message: '' };

                } catch (error) {
                    window.showToast('error', error.message);
                    console.error('Contact form error:', error);
                } finally {
                    this.isSubmitting = false;
                }
            }
        }
    }
</script>