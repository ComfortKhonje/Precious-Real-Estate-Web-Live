import os

root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
files = {
    'resources/views/pages/home.blade.php': """@extends('layouts.app')
@section('title', 'Home — Precious Real Estate')
@section('content')
    <x-home.hero />
    <x-home.stats />
    <x-home.services-overview />
    <x-home.about-snippet />
    <x-home.available-properties />
    <x-home.advantages />
    <x-shared.cta-get-started />
    <x-shared.contact-info />
@endsection
""",
    'resources/views/pages/about.blade.php': """@extends('layouts.app')
@section('title', 'About Us — Precious Real Estate')
@section('content')
    <x-about.page-hero />
    <x-about.who-we-are />
    <x-about.our-approach />
    <x-about.standards />
    <x-about.our-direction />
    <x-about.core-values />
    <x-about.team-preview />
    <x-shared.cta-work-with-us />
    <x-shared.contact-info />
@endsection
""",
    'resources/views/pages/team.blade.php': """@extends('layouts.app')
@section('title', 'Our Team — Precious Real Estate')
@section('content')
    <x-team.page-hero />
    <x-team.who-we-are />
    <x-team.meet-the-team />
    <x-team.our-commitment />
    <x-shared.cta-work-with-us />
    <x-shared.contact-info />
@endsection
""",
    'resources/views/pages/properties.blade.php': """@extends('layouts.app')
@section('title', 'Properties — Precious Real Estate')
@section('content')
    <x-properties.page-hero />
    <x-properties.search-bar />
    <x-properties.available-properties />
    <x-shared.cta-get-started />
    <x-shared.contact-info />
@endsection
""",
    'resources/views/pages/property-view.blade.php': """@extends('layouts.app')
@section('title', 'Property — Precious Real Estate')
@section('content')
    <x-property-view.property-images />
    <x-property-view.property-info />
    <x-property-view.property-cta />
@endsection
""",
    'resources/views/pages/services.blade.php': """@extends('layouts.app')
@section('title', 'Services — Precious Real Estate')
@section('content')
    <x-services.page-hero />
    <x-services.property-services />
    <x-shared.cta-get-started />
    <x-shared.contact-info />
@endsection
""",
    'resources/views/pages/contact.blade.php': """@extends('layouts.app')
@section('title', 'Contact — Precious Real Estate')
@section('content')
    <x-contact.page-hero />
    <x-contact.contact-form />
    <x-contact.location-map />
    <x-contact.need-assistance-cta />
@endsection
""",
    'resources/views/pages/terms.blade.php': """@extends('layouts.app')
@section('title', 'Terms & Conditions — Precious')
@section('content')
    <x-legal.terms-content />
@endsection
""",
    'resources/views/pages/privacy.blade.php': """@extends('layouts.app')
@section('title', 'Privacy Policy — Precious')
@section('content')
    <x-legal.privacy-content />
@endsection
""",
    'resources/views/pages/credits.blade.php': """@extends('layouts.app')
@section('title', 'Credits — Precious')
@section('content')
    <x-legal.credits-content />
@endsection
""",
    'resources/views/pages/inquiry.blade.php': """@extends('layouts.app')
@section('title', 'Inquiry — Precious Real Estate')
@section('content')
    <x-inquiry.inquiry-form />
@endsection
""",

    'resources/views/components/home/hero.blade.php': """{{-- [Component: home/hero] Homepage hero section with headline, subheading, and primary CTA --}}
<section id=\"home-hero\" class=\"py-16 px-6\">
    <div class=\"max-w-7xl mx-auto\">
        <div class=\"rounded-[2rem] bg-complementary p-12 text-brand-black\">
            <h1 class=\"font-heading text-5xl leading-tight\">{{-- Hero headline placeholder --}}</h1>
            <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- Hero supporting placeholder --}}</p>
            <div class=\"mt-10 flex flex-wrap gap-4\">
                <a href=\"{{ route('properties') }}\" class=\"inline-flex items-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Primary CTA placeholder --}}</a>
                <a href=\"{{ route('contact') }}\" class=\"inline-flex items-center rounded-full border border-secondary bg-white px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Secondary CTA placeholder --}}</a>
            </div>
        </div>
    </div>
</section>
""",
    'resources/views/components/home/stats.blade.php': """{{-- [Component: home/stats] Statistics panel for brand credibility and performance metrics --}}
<section id=\"home-stats\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto grid gap-8 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-complementary p-8\">
            <p class=\"font-heading text-xl\">{{-- Stat label placeholder --}}</p>
            <p class=\"font-body mt-4 text-4xl text-brand-black\">{{-- Stat value placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-complementary p-8\">
            <p class=\"font-heading text-xl\">{{-- Stat label placeholder --}}</p>
            <p class=\"font-body mt-4 text-4xl text-brand-black\">{{-- Stat value placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-complementary p-8\">
            <p class=\"font-heading text-xl\">{{-- Stat label placeholder --}}</p>
            <p class=\"font-body mt-4 text-4xl text-brand-black\">{{-- Stat value placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/home/services-overview.blade.php': """{{-- [Component: home/services-overview] Overview grid of core real estate services --}}
<section id=\"home-services-overview\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto\">
        <div class=\"grid gap-6 md:grid-cols-3\">
            <div class=\"rounded-3xl border border-complementary p-8\">
                <h2 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h2>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service description placeholder --}}</p>
            </div>
            <div class=\"rounded-3xl border border-complementary p-8\">
                <h2 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h2>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service description placeholder --}}</p>
            </div>
            <div class=\"rounded-3xl border border-complementary p-8\">
                <h2 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h2>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service description placeholder --}}</p>
            </div>
        </div>
    </div>
</section>
""",
    'resources/views/components/home/about-snippet.blade.php': """{{-- [Component: home/about-snippet] Brief brand introduction block for the home page --}}
<section id=\"home-about-snippet\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-white p-10 shadow-sm\">
        <h2 class=\"font-heading text-3xl\">{{-- About snippet headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-black/75\">{{-- About snippet description placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/home/available-properties.blade.php': """{{-- [Component: home/available-properties] Featured property cards gallery placeholder --}}
<section id=\"home-available-properties\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto\">
        <div class=\"grid gap-6 md:grid-cols-3\">
            <div class=\"rounded-3xl border border-complementary bg-complementary p-8\">
                <h3 class=\"font-heading text-2xl\">{{-- Property headline placeholder --}}</h3>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property preview placeholder --}}</p>
            </div>
            <div class=\"rounded-3xl border border-complementary bg-complementary p-8\">
                <h3 class=\"font-heading text-2xl\">{{-- Property headline placeholder --}}</h3>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property preview placeholder --}}</p>
            </div>
            <div class=\"rounded-3xl border border-complementary bg-complementary p-8\">
                <h3 class=\"font-heading text-2xl\">{{-- Property headline placeholder --}}</h3>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property preview placeholder --}}</p>
            </div>
        </div>
    </div>
</section>
""",
    'resources/views/components/home/advantages.blade.php': """{{-- [Component: home/advantages] Reasons to choose Precious summarized in cards --}}
<section id=\"home-advantages\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Advantage headline placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Advantage detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Advantage headline placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Advantage detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Advantage headline placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Advantage detail placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/about/page-hero.blade.php': """{{-- [Component: about/page-hero] About page hero with page title and intro copy --}}
<section id=\"about-page-hero\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-complementary p-12\">
        <h1 class=\"font-heading text-4xl\">{{-- About hero headline placeholder --}}</h1>
        <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- About hero description placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/about/who-we-are.blade.php': """{{-- [Component: about/who-we-are] Who we are section with brand story placeholder --}}
<section id=\"about-who-we-are\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-brand-white p-10\">
        <h2 class=\"font-heading text-3xl\">{{-- Who we are headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-black/75\">{{-- Who we are copy placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/about/our-approach.blade.php': """{{-- [Component: about/our-approach] Our approach section describing methodology placeholder --}}
<section id=\"about-our-approach\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto grid gap-10 md:grid-cols-2\">
        <div class=\"space-y-4\">
            <h2 class=\"font-heading text-3xl\">{{-- Our approach headline placeholder --}}</h2>
            <p class=\"font-body text-brand-black/75\">{{-- Our approach copy placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-complementary p-8\">
            <p class=\"font-body text-brand-black/75\">{{-- Approach detail placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/about/standards.blade.php': """{{-- [Component: about/standards] Standards section with quality principles placeholder --}}
<section id=\"about-standards\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Standard label placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Standard detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Standard label placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Standard detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Standard label placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Standard detail placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/about/our-direction.blade.php': """{{-- [Component: about/our-direction] Strategic direction and vision placeholder --}}
<section id=\"about-our-direction\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-10\">
        <h2 class=\"font-heading text-3xl\">{{-- Our direction headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-black/75\">{{-- Vision and direction placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/about/core-values.blade.php': """{{-- [Component: about/core-values] Core values cards placeholder --}}
<section id=\"about-core-values\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Value title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Value detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Value title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Value detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Value title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Value detail placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/about/team-preview.blade.php': """{{-- [Component: about/team-preview] Team preview placeholder with profiles --}}
<section id=\"about-team-preview\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-complementary p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Team member placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Role and note placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-complementary p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Team member placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Role and note placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-complementary p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Team member placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Role and note placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/team/page-hero.blade.php': """{{-- [Component: team/page-hero] Team page hero with headline and team purpose --}}
<section id=\"team-page-hero\" class=\"py-16 px-6 bg-primary text-brand-black\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-white p-12\">
        <h1 class=\"font-heading text-4xl\">{{-- Team hero headline placeholder --}}</h1>
        <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- Team page intro placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/team/who-we-are.blade.php': """{{-- [Component: team/who-we-are] Team page who we are section placeholder --}}
<section id=\"team-who-we-are\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-10\">
        <h2 class=\"font-heading text-3xl\">{{-- Team who-we-are headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-black/75\">{{-- Team who-we-are copy placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/team/meet-the-team.blade.php': """{{-- [Component: team/meet-the-team] Team photo and profile grid placeholder --}}
<section id=\"team-meet-the-team\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <p class=\"font-heading text-2xl\">{{-- Member name placeholder --}}</p>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Member role placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <p class=\"font-heading text-2xl\">{{-- Member name placeholder --}}</p>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Member role placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <p class=\"font-heading text-2xl\">{{-- Member name placeholder --}}</p>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Member role placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/team/our-commitment.blade.php': """{{-- [Component: team/our-commitment] Commitment statement block placeholder --}}
<section id=\"team-our-commitment\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-12\">
        <h2 class=\"font-heading text-3xl\">{{-- Commitment headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-black/75\">{{-- Commitment detail placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/properties/page-hero.blade.php': """{{-- [Component: properties/page-hero] Properties page hero with page overview placeholder --}}
<section id=\"properties-page-hero\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-white p-12\">
        <h1 class=\"font-heading text-4xl\">{{-- Properties hero headline placeholder --}}</h1>
        <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- Properties hero description placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/properties/search-bar.blade.php': """{{-- [Component: properties/search-bar] Property search form placeholder with filters --}}
<section id=\"properties-search-bar\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-8\">
        <form class=\"grid gap-4 md:grid-cols-3\">
            <input type=\"text\" placeholder=\"{{-- Search input placeholder --}}\" class=\"w-full rounded-2xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\" />
            <div class=\"rounded-2xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\">{{-- Filter placeholder --}}</div>
            <button type=\"submit\" class=\"inline-flex items-center justify-center rounded-2xl bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Search button placeholder --}}</button>
        </form>
    </div>
</section>
""",
    'resources/views/components/properties/available-properties.blade.php': """{{-- [Component: properties/available-properties] Properties listing grid placeholder --}}
<section id=\"properties-available-properties\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Property card title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property card details placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Property card title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property card details placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Property card title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Property card details placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/property-view/property-images.blade.php': """{{-- [Component: property-view/property-images] Image gallery placeholder for single property page --}}
<section id=\"property-images\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-8\">
        <div class=\"grid gap-6 md:grid-cols-3\">
            <div class=\"h-60 rounded-3xl bg-brand-black/5\">{{-- Main image placeholder --}}</div>
            <div class=\"space-y-6\">
                <div class=\"h-28 rounded-3xl bg-brand-black/5\">{{-- Secondary image placeholder --}}</div>
                <div class=\"h-28 rounded-3xl bg-brand-black/5\">{{-- Secondary image placeholder --}}</div>
            </div>
        </div>
    </div>
</section>
""",
    'resources/views/components/property-view/property-info.blade.php': """{{-- [Component: property-view/property-info] Property detail block placeholder with metadata --}}
<section id=\"property-info\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-brand-white p-10\">
        <h1 class=\"font-heading text-4xl\">{{-- Property title placeholder --}}</h1>
        <div class=\"mt-6 grid gap-6 md:grid-cols-2\">
            <div class=\"space-y-4\">
                <p class=\"font-body text-brand-black/75\">{{-- Property summary placeholder --}}</p>
                <p class=\"font-body text-sm text-brand-black/70\">{{-- Property metadata placeholder --}}</p>
            </div>
            <div class=\"rounded-3xl border border-complementary bg-complementary p-6\">
                <p class=\"font-heading text-sm uppercase tracking-[0.3em]\">{{-- Pricing placeholder --}}</p>
                <p class=\"font-body mt-4 text-brand-black/75\">{{-- Status placeholder --}}</p>
            </div>
        </div>
    </div>
</section>
""",
    'resources/views/components/property-view/property-cta.blade.php': """{{-- [Component: property-view/property-cta] CTA band for contacting an agent or inquiry --}}
<section id=\"property-cta\" class=\"py-16 px-6 bg-brand-black text-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-black p-12 text-center\">
        <h2 class=\"font-heading text-3xl\">{{-- Property CTA headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-white/80\">{{-- Property CTA description placeholder --}}</p>
        <a href=\"{{ route('contact') }}\" class=\"mt-8 inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- CTA button placeholder --}}</a>
    </div>
</section>
""",
    'resources/views/components/services/page-hero.blade.php': """{{-- [Component: services/page-hero] Services page hero with intro placeholder --}}
<section id=\"services-page-hero\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-complementary p-12\">
        <h1 class=\"font-heading text-4xl\">{{-- Services hero headline placeholder --}}</h1>
        <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- Services hero description placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/services/property-services.blade.php': """{{-- [Component: services/property-services] Services detail cards placeholder --}}
<section id=\"services-property-services\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto grid gap-6 md:grid-cols-3\">
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service detail placeholder --}}</p>
        </div>
        <div class=\"rounded-3xl bg-brand-white p-8\">
            <h3 class=\"font-heading text-2xl\">{{-- Service title placeholder --}}</h3>
            <p class=\"font-body mt-4 text-brand-black/75\">{{-- Service detail placeholder --}}</p>
        </div>
    </div>
</section>
""",
    'resources/views/components/contact/page-hero.blade.php': """{{-- [Component: contact/page-hero] Contact page hero with title and prompt placeholder --}}
<section id=\"contact-page-hero\" class=\"py-16 px-6 bg-primary text-brand-black\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-white p-12\">
        <h1 class=\"font-heading text-4xl\">{{-- Contact hero headline placeholder --}}</h1>
        <p class=\"font-body mt-6 text-lg text-brand-black/75\">{{-- Contact hero description placeholder --}}</p>
    </div>
</section>
""",
    'resources/views/components/contact/contact-form.blade.php': """{{-- [Component: contact/contact-form] Contact form placeholder with fields and submit button --}}
<section id=\"contact-contact-form\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-8\">
        <form class=\"grid gap-6\">
            <input type=\"text\" placeholder=\"{{-- Name placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\" />
            <input type=\"email\" placeholder=\"{{-- Email placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\" />
            <textarea rows=\"5\" placeholder=\"{{-- Message placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\"></textarea>
            <button type=\"submit\" class=\"inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Form submit placeholder --}}</button>
        </form>
    </div>
</section>
""",
    'resources/views/components/contact/location-map.blade.php': """{{-- [Component: contact/location-map] Placeholder for embedded map and address details --}}
<section id=\"contact-location-map\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-brand-white p-8\">
        <div class=\"h-80 rounded-3xl bg-brand-black/5\">{{-- Map placeholder --}}</div>
        <div class=\"mt-8 grid gap-6 md:grid-cols-2\">
            <div class=\"font-body text-brand-black/75\">{{-- Location details placeholder --}}</div>
            <div class=\"font-body text-brand-black/75\">{{-- Office hours placeholder --}}</div>
        </div>
    </div>
</section>
""",
    'resources/views/components/contact/need-assistance-cta.blade.php': """{{-- [Component: contact/need-assistance-cta] Assistance CTA block placeholder --}}
<section id=\"contact-need-assistance-cta\" class=\"py-16 px-6 bg-brand-black text-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-[2rem] bg-brand-black p-12 text-center\">
        <h2 class=\"font-heading text-3xl\">{{-- Need assistance headline placeholder --}}</h2>
        <p class=\"font-body mt-4 text-brand-white/80\">{{-- Assistance copy placeholder --}}</p>
        <a href=\"{{ route('inquiry') }}\" class=\"mt-8 inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Assistance button placeholder --}}</a>
    </div>
</section>
""",
    'resources/views/components/legal/terms-content.blade.php': """{{-- [Component: legal/terms-content] Terms and conditions content placeholder --}}
<section id=\"legal-terms-content\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-10\">
        <h1 class=\"font-heading text-3xl\">{{-- Terms & Conditions headline placeholder --}}</h1>
        <div class=\"mt-6 space-y-6 font-body text-brand-black/75\">{{-- Terms content structure placeholder --}}</div>
    </div>
</section>
""",
    'resources/views/components/legal/privacy-content.blade.php': """{{-- [Component: legal/privacy-content] Privacy policy content placeholder --}}
<section id=\"legal-privacy-content\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-brand-white p-10\">
        <h1 class=\"font-heading text-3xl\">{{-- Privacy Policy headline placeholder --}}</h1>
        <div class=\"mt-6 space-y-6 font-body text-brand-black/75\">{{-- Privacy policy structure placeholder --}}</div>
    </div>
</section>
""",
    'resources/views/components/legal/credits-content.blade.php': """{{-- [Component: legal/credits-content] Credits page content placeholder --}}
<section id=\"legal-credits-content\" class=\"py-16 px-6 bg-brand-white\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-complementary p-10\">
        <h1 class=\"font-heading text-3xl\">{{-- Credits headline placeholder --}}</h1>
        <div class=\"mt-6 space-y-6 font-body text-brand-black/75\">{{-- Credits details placeholder --}}</div>
    </div>
</section>
""",
    'resources/views/components/inquiry/inquiry-form.blade.php': """{{-- [Component: inquiry/inquiry-form] Inquiry form page placeholder with fields and CTA --}}
<section id=\"inquiry-form\" class=\"py-16 px-6 bg-complementary\">
    <div class=\"max-w-7xl mx-auto rounded-3xl bg-brand-white p-10\">
        <h1 class=\"font-heading text-4xl\">{{-- Inquiry form headline placeholder --}}</h1>
        <form class=\"mt-10 grid gap-6\">
            <input type=\"text\" placeholder=\"{{-- Full name placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\" />
            <input type=\"email\" placeholder=\"{{-- Email placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\" />
            <textarea rows=\"5\" placeholder=\"{{-- Inquiry details placeholder --}}\" class=\"w-full rounded-3xl border border-complementary bg-white px-4 py-3 font-body text-sm text-brand-black\"></textarea>
            <button type=\"submit\" class=\"inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-brand-black\">{{-- Submit inquiry placeholder --}}</button>
        </form>
    </div>
</section>
""",
}

for rel_path, content in files.items():
    full_path = os.path.join(root, *rel_path.split('/'))
    os.makedirs(os.path.dirname(full_path), exist_ok=True)
    if os.path.exists(full_path):
        continue
    with open(full_path, 'w', encoding='utf-8', newline='\n') as f:
        f.write(content)
print('created', len(files), 'files')
