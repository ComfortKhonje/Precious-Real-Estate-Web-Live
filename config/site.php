<?php

/*
|--------------------------------------------------------------------------
| Site / SEO metadata
|--------------------------------------------------------------------------
|
| Single source of truth for the business details that appear in <head>
| meta tags, Open Graph / Twitter cards, and schema.org structured data.
| Added 2026-09-03 — before this the layout had a bare <title> and nothing
| else, so links shared over WhatsApp and Facebook rendered with no preview
| image, no description, and no business name.
|
*/

return [

    'name' => 'Precious Real Estate Consulting',

    'short_name' => 'PREC',

    'tagline' => 'Property valuation, management and sales in Malawi',

    'description' => 'Precious Real Estate Consulting is a registered Malawian real estate firm offering RICS Red Book and IVS compliant property valuation, property management, development, sales and letting, and title deed processing in Lilongwe and Blantyre.',

    'locale' => 'en_MW',

    // Relative to public/. Used as the default Open Graph / Twitter image.
    'og_image' => 'brand-assets/1. Logo Suite/2. Primary Logo Lockup/PNG/primary-logo-yellow-bg.png',

    'founded' => '2016',

    'phones' => ['+265884366756', '+265997943049'],

    'email' => 'info@preciousrealestate.mw',

    'social' => [
        'https://www.facebook.com/p/Precious-Real-Estate-Consulting-100052172436707',
    ],

    'offices' => [
        [
            'name' => 'Lilongwe',
            'street' => 'Area 47/S3, GPH House',
            'city' => 'Lilongwe',
            'country' => 'MW',
        ],
        [
            'name' => 'Blantyre',
            'street' => 'Haji Latif Pavilion, Room 35',
            'city' => 'Blantyre',
            'country' => 'MW',
        ],
    ],

];
