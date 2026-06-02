<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $properties = [
            [
                'title' => 'Riverfront Retreat',
                'slug' => 'riverfront-retreat',
                'description' => 'A tranquil riverfront property with modern finishes, open living spaces and lush outdoor areas.',
                'category' => 'Residential',
                'type' => 'House',
                'price' => 185000,
                'location' => 'Lilongwe',
                'status' => 'For Sale',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'land_size' => '400 sqm',
                'parking' => '2 cars',
                'features' => ['river view', 'garden', 'secure parking'],
                'is_featured' => true,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 3.png',
                    'brand-assets/4 Properties Page/Property image 2.png',
                    'brand-assets/4 Properties Page/Property image 1.png',
                ],
            ],
            [
                'title' => 'Blantyre CBD Office Suite',
                'slug' => 'blantyre-cbd-office-suite',
                'description' => 'A central commercial suite ideal for professional offices, with easy access to transport and amenities.',
                'category' => 'Commercial',
                'type' => 'Office',
                'price' => 450000,
                'location' => 'Blantyre CBD',
                'status' => 'For Sale',
                'bedrooms' => 0,
                'bathrooms' => 2,
                'land_size' => '220 sqm',
                'parking' => 'On-site',
                'features' => ['central location', 'open plan', 'secure access'],
                'is_featured' => true,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 2.png',
                ],
            ],
            [
                'title' => 'Lilongwe Urban Apartment',
                'slug' => 'lilongwe-urban-apartment',
                'description' => 'A contemporary apartment in a vibrant neighbourhood, featuring a bright living room and balcony.',
                'category' => 'Residential',
                'type' => 'Apartment',
                'price' => 150000,
                'location' => 'Area 10, Lilongwe',
                'status' => 'For Rent',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'land_size' => '180 sqm',
                'parking' => '1 car',
                'features' => ['balcony', 'city views', 'security'],
                'is_featured' => true,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 1.png',
                ],
            ],
            [
                'title' => 'Mandala Family Home',
                'slug' => 'mandala-family-home',
                'description' => 'A spacious family home with landscaped gardens and easy access to schools and shopping.',
                'category' => 'Residential',
                'type' => 'House',
                'price' => 135000,
                'location' => 'Mandala, Blantyre',
                'status' => 'For Sale',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'land_size' => '500 sqm',
                'parking' => '3 cars',
                'features' => ['garden', 'storage', 'quiet street'],
                'is_featured' => false,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 1.png',
                ],
            ],
            [
                'title' => 'Estate View Townhouse',
                'slug' => 'estate-view-townhouse',
                'description' => 'Modern townhouse with private courtyard and secure community amenities.',
                'category' => 'Residential',
                'type' => 'Townhouse',
                'price' => 175000,
                'location' => 'Area 12, Lilongwe',
                'status' => 'For Rent',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'land_size' => '210 sqm',
                'parking' => '2 cars',
                'features' => ['courtyard', 'modern finishes', 'secure estate'],
                'is_featured' => false,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 2.png',
                ],
            ],
            [
                'title' => 'Southern Hills Retreat',
                'slug' => 'southern-hills-retreat',
                'description' => 'A serene property with a large garden and sunlit interiors, perfect for family living.',
                'category' => 'Residential',
                'type' => 'House',
                'price' => 205000,
                'location' => 'Area 47, Lilongwe',
                'status' => 'For Sale',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'land_size' => '650 sqm',
                'parking' => 'Garage',
                'features' => ['garden', 'spacious layout', 'panoramic views'],
                'is_featured' => false,
                'media' => [
                    'brand-assets/4 Properties Page/Property image 3.png',
                ],
            ],
        ];

        foreach ($properties as $property) {
            Property::updateOrCreate(
                ['slug' => $property['slug']],
                $property
            );
        }
    }
}
