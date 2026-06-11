<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Property> */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'category' => 'Residential',
            'type' => 'House',
            'price' => fake()->numberBetween(50000, 500000),
            'location' => fake()->city(),
            'status' => 'available',
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 3),
            'land_size' => fake()->randomNumber(3),
            'parking' => 'Yes',
            'features' => ['garden', 'balcony'],
            'is_featured' => fake()->boolean(20),
            'media' => [],
        ];
    }
}
