<section id="contact-form-section" class="relative mt-20">
    <img src="{{ asset('brand-assets/Backgrounds/Background 2 grain and swirls.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
    <x-shared.contact-info variant="dark" :overlap="true" />

    {{-- House Image with Yellow Accent --}}
    <div class="absolute hidden md:block bottom-0 left-0 w-full max-w-2xl pointer-events-none z-0">
        <img
            src="{{ asset('brand-assets/7 Contact Page/hand-holding-house-real-estate-property-model 1.png') }}"
            alt="Hand holding house model"
            class="relative z-10 w-full h-auto object-contain transform -translate-x-12"
        >
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
                    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6">
                        {{-- Full Name --}}
                        <div class="space-y-2">
                            <label class="text-sm font-md text-brand-white tracking-widest pl-2">Full Name</label>
                            <input type="text" placeholder="Enter your full name" class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                        </div>

                        {{-- Phone Number --}}
                        <div class="space-y-2">
                            <label class="text-sm font-md text-brand-white tracking-widest pl-2">Phone Number</label>
                            <input type="text" placeholder="Enter your phone number" class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                        </div>

                        {{-- Email Address --}}
                        <div class="space-y-2">
                            <label class="text-sm font-md text-brand-white tracking-widest pl-2">Email Address</label>
                            <input type="email" placeholder="Enter your email address" class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500">
                        </div>

                        {{-- Service Needed --}}
                        <div class="space-y-2">
                            <label class="text-sm font-md text-brand-white tracking-widest pl-2">Service Needed</label>
                            <x-ui.select class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white cursor-pointer border-none">
                                <option>Select the service you need</option>
                                <option>Property Valuation</option>
                                <option>Property Management</option>
                                <option>Sales & Letting</option>
                                <option>Property Development</option>
                                <option>Title Deed Processing</option>
                            </x-ui.select>
                        </div>

                        {{-- Message --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-md text-brand-white tracking-widest pl-2">Message</label>
                            <textarea rows="4" placeholder="Tell us briefly how we can assist you..." class="w-full bg-gray-100 rounded-xl py-4 px-4 text-brand-black font-medium focus:ring-2 focus:ring-primary focus:bg-white border-none placeholder:text-gray-500"></textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="md:col-span-2 pt-4">
                            <button type="submit" class="bg-white w-full md:w-fit text-brand-black rounded-full py-4 px-12 font-bold text-xs uppercase tracking-widest hover:bg-primary transition duration-300 shadow-lg">
                                SUBMIT MESSAGE
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
