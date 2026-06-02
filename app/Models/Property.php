<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'category', 'type', 'price', 'location', 'status',
        'bedrooms', 'bathrooms', 'land_size', 'parking', 'features', 'is_featured', 'media',
    ];

    protected $casts = [
        'is_featured' => 'bool',
        'features' => 'array',
        'media' => 'array',
    ];
}
