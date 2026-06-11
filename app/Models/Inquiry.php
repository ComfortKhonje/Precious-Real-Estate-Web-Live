<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'type', 'message', 'property_id'];

    /**
     * Get the property this inquiry is about
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
