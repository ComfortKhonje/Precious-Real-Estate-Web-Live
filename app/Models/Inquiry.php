<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'type', 'message', 'property_id', 'viewed_at'];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Get the property this inquiry is about
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Unread until a staff member opens its detail page — see
     * InquiriesController::show().
     */
    public function getIsNewAttribute(): bool
    {
        return $this->viewed_at === null;
    }
}
