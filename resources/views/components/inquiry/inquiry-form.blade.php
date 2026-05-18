{{-- [Component: inquiry/inquiry-form] Inquiry form placeholder layout --}}
<section id="inquiry-form" class="py-16 px-6 bg-complementary">
    <div class="max-w-5xl mx-auto rounded-[2rem] bg-brand-white p-10">
        <form class="grid gap-6">
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="font-body text-sm text-brand-black/75">{{-- Name label --}}</span>
                    <input type="text"
                        class="mt-2 w-full rounded-3xl border border-brand-black/10 bg-brand-white px-4 py-3 text-sm text-brand-black"
                        disabled>
                </label>
                <label class="block">
                    <span class="font-body text-sm text-brand-black/75">{{-- Email label --}}</span>
                    <input type="email"
                        class="mt-2 w-full rounded-3xl border border-brand-black/10 bg-brand-white px-4 py-3 text-sm text-brand-black"
                        disabled>
                </label>
            </div>
            <label class="block">
                <span class="font-body text-sm text-brand-black/75">{{-- Inquiry type label --}}</span>
                <select
                    class="mt-2 w-full rounded-3xl border border-brand-black/10 bg-brand-white px-4 py-3 text-sm text-brand-black"
                    disabled>
                    <option>{{-- Inquiry type option placeholder --}}</option>
                </select>
            </label>
            <label class="block">
                <span class="font-body text-sm text-brand-black/75">{{-- Details label --}}</span>
                <textarea
                    class="mt-2 h-40 w-full rounded-3xl border border-brand-black/10 bg-brand-white px-4 py-3 text-sm text-brand-black"
                    disabled></textarea>
            </label>
            <button type="button"
                class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black">{{-- Submit button placeholder --}}</button>
        </form>
    </div>
</section>
