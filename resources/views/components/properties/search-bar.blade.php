{{-- [Component: properties/search-bar] Property search form placeholder with filters --}}
<section id="properties-search-bar" class="py-16 px-6 bg-brand-white">
    <div class="max-w-7xl mx-auto rounded-3xl bg-complementary p-8">
        <form class="grid gap-4 md:grid-cols-3">
            <input type="text" placeholder="{{-- Search input placeholder --}}"
                class="w-full rounded-2xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black" />
            <div class="rounded-2xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black">
                {{-- Filter placeholder --}}</div>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-2xl bg-primary px-6 py-3 text-sm font-semibold text-brand-black">{{-- Search button placeholder --}}</button>
        </form>
    </div>
</section>
