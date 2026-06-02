<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Modern Family Home in Area 47',
                'location' => 'Area 47, Lilongwe',
                'price' => 1500000.00,
                'status' => 'For Rent',
                'type' => 'House',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'land_size' => '0.5 Acres',
                'parking_spaces' => 2,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 3.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Prime Commercial Space Blantyre',
                'location' => 'Blantyre CBD',
                'price' => 45000000.00,
                'status' => 'For Sale',
                'type' => 'Commercial',
                'bedrooms' => null,
                'bathrooms' => 2,
                'land_size' => '200 sqm',
                'parking_spaces' => 5,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 2.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Luxury Apartment in Area 10',
                'location' => 'Area 10, Lilongwe',
                'price' => 2500000.00,
                'status' => 'For Rent',
                'type' => 'Apartment',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'land_size' => 'N/A',
                'parking_spaces' => 2,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 1.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Spacious Villa in Area 12',
                'location' => 'Area 12, Lilongwe',
                'price' => 1800000.00,
                'status' => 'For Rent',
                'type' => 'House',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'land_size' => '0.7 Acres',
                'parking_spaces' => 3,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 1.png',
                'is_featured' => false,
            ],
            [
                'title' => 'Executive Office Suite',
                'location' => 'Limbe, Blantyre',
                'price' => 55000000.00,
                'status' => 'For Sale',
                'type' => 'Commercial',
                'bedrooms' => null,
                'bathrooms' => 1,
                'land_size' => '150 sqm',
                'parking_spaces' => 2,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 2.png',
                'is_featured' => false,
            ],
            [
                'title' => 'Residential Plot in Mandala',
                'location' => 'Mandala, Blantyre',
                'price' => 35000000.00,
                'status' => 'For Sale',
                'type' => 'Plot',
                'bedrooms' => null,
                'bathrooms' => null,
                'land_size' => '0.2 Acres',
                'parking_spaces' => null,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 3.png',
                'is_featured' => false,
            ],
            [
                'title' => 'Cozy Cottage Mzuzu',
                'location' => 'Mzuzu CBD',
                'price' => 800000.00,
                'status' => 'For Rent',
                'type' => 'House',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'land_size' => '0.3 Acres',
                'parking_spaces' => 1,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 1.png',
                'is_featured' => false,
            ],
            [
                'title' => 'Industrial Warehouse Kanengo',
                'location' => 'Kanengo, Lilongwe',
                'price' => 120000000.00,
                'status' => 'For Sale',
                'type' => 'Industrial',
                'bedrooms' => null,
                'bathrooms' => 2,
                'land_size' => '1 Acre',
                'parking_spaces' => 10,
                'featured_image' => 'brand-assets/4 Properties Page/Property image 2.png',
                'is_featured' => false,
            ],
        ];

        foreach ($properties as $property) {
            Property::create(array_merge($property, [
                'slug' => Str::slug($property['title']),
                'description' => 'This is a premium property offering from Precious Real Estate Consulting. Located in the heart of ' . $property['location'] . ', this ' . strtolower($property['type']) . ' provides excellent value and high-quality finishes. Contact us for more details and to schedule a viewing.',
                'gallery' => [
                    'brand-assets/4 Properties Page/Property image 1.png',
                    'brand-assets/4 Properties Page/Property image 2.png',
                    'brand-assets/4 Properties Page/Property image 3.png',
                ],
            ]));
        }
    }
}
