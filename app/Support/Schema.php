<?php

namespace App\Support;

use App\Models\Property;

/**
 * schema.org structured data builders.
 *
 * Added 2026-09-03. The site previously emitted none at all, which for a
 * real-estate business means Google has no machine-readable record of the
 * offices, phone numbers, or individual listings — and listing pages can
 * never qualify for rich results.
 */
class Schema
{
    /**
     * RealEstateAgent (a subtype of LocalBusiness) describing PREC itself.
     * Rendered on every page from the main layout.
     */
    public static function organization(): array
    {
        $offices = collect(config('site.offices'))->map(fn (array $office) => [
            '@type' => 'PostalAddress',
            'streetAddress' => $office['street'],
            'addressLocality' => $office['city'],
            'addressCountry' => $office['country'],
        ])->all();

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateAgent',
            'name' => config('site.name'),
            'alternateName' => config('site.short_name'),
            'description' => config('site.description'),
            'url' => url('/'),
            'logo' => asset(config('site.og_image')),
            'image' => asset(config('site.og_image')),
            'email' => config('site.email'),
            'telephone' => config('site.phones')[0] ?? null,
            'foundingDate' => config('site.founded'),
            'areaServed' => ['@type' => 'Country', 'name' => 'Malawi'],
            'address' => $offices,
            'sameAs' => config('site.social'),
        ]);
    }

    /**
     * A single listing, for the property detail page.
     */
    public static function property(Property $property): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => $property->title,
            'description' => str($property->description)->stripTags()->limit(300)->toString(),
            'url' => route('property.view', $property->slug),
            'image' => $property->featuredImageUrl('large'),
            'datePosted' => optional($property->created_at)->toAtomString(),
            'offers' => array_filter([
                '@type' => 'Offer',
                'price' => (string) $property->price,
                'priceCurrency' => $property->currency,
                'availability' => $property->is_available
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'businessFunction' => $property->status === 'For Rent'
                    ? 'https://schema.org/LeaseOut'
                    : 'https://schema.org/Sell',
            ]),
            'about' => array_filter([
                '@type' => 'Residence',
                'name' => $property->title,
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $property->location,
                    'addressCountry' => 'MW',
                ],
                'numberOfBedrooms' => $property->bedrooms,
                'numberOfBathroomsTotal' => $property->bathrooms,
            ], fn ($value) => $value !== null && $value !== ''),
        ]);
    }
}
