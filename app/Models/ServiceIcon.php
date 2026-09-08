<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceIcon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function blackUrl(): string
    {
        return asset("storage/{$this->path}/black.svg");
    }

    public function yellowUrl(): string
    {
        return asset("storage/{$this->path}/yellow.svg");
    }

    protected static function booted(): void
    {
        static::deleted(function (ServiceIcon $icon) {
            app(MediaService::class)->delete($icon->path);
        });
    }
}
