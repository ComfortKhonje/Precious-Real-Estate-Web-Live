<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Single read-side source of truth for contact details shown on the public
 * site. Added 2026-09-04.
 *
 * Before this, `Cms\ContactController` already wrote real values to the
 * `Setting` table via the "Contact Information" CMS tab, but nothing on the
 * public site ever read them back — phone, email, address and social links
 * were hardcoded independently in several blade files, so editing the
 * dashboard changed nothing a visitor saw.
 *
 * Each getter checks the `Setting` row first, then falls back to
 * `config('site.*')` — the values already established 2026-09-03 as the
 * canonical defaults for SEO/schema.org output — so this ships with zero
 * visual change until Comfort actually saves something in the CMS.
 */
class ContactInfo
{
    /** @var array<string, string>|null request-level cache, avoids one query per field */
    protected static ?array $settings = null;

    protected static function all(): array
    {
        return static::$settings ??= Setting::query()->pluck('value', 'key')->all();
    }

    protected static function setting(string $key, ?string $default = null): ?string
    {
        $value = static::all()[$key] ?? null;

        return ($value !== null && $value !== '') ? $value : $default;
    }

    public static function phone(): ?string
    {
        return static::setting('office_phone', config('site.phones.0'));
    }

    public static function phoneSecondary(): ?string
    {
        return static::setting('office_phone_secondary', config('site.phones.1'));
    }

    public static function whatsapp(): ?string
    {
        return static::setting('whatsapp_number', config('site.phones.1'));
    }

    public static function email(): ?string
    {
        return static::setting('office_email', config('site.email'));
    }

    public static function workingHours(): ?string
    {
        return static::setting('working_hours', 'Mon - Fri, 08:00 - 17:00');
    }

    public static function addressLilongwe(): ?string
    {
        return static::setting('office_address_lilongwe', static::configOfficeAddress('Lilongwe'));
    }

    public static function addressBlantyre(): ?string
    {
        return static::setting('office_address_blantyre', static::configOfficeAddress('Blantyre'));
    }

    protected static function configOfficeAddress(string $officeName): ?string
    {
        $office = collect(config('site.offices', []))->firstWhere('name', $officeName);

        return $office ? "{$office['street']}, {$office['city']}" : null;
    }

    public static function facebookUrl(): ?string
    {
        return static::setting('facebook_url', config('site.social.0'));
    }

    public static function instagramUrl(): ?string
    {
        return static::setting('instagram_url');
    }

    public static function linkedinUrl(): ?string
    {
        return static::setting('linkedin_url');
    }

    public static function tiktokUrl(): ?string
    {
        return static::setting('tiktok_url', config('site.social.1'));
    }
}
