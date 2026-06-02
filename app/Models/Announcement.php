<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'content', 'cover_image', 'status', 'published_at', 'is_featured'];

    protected $casts = ['published_at' => 'datetime', 'is_featured' => 'bool'];
}
