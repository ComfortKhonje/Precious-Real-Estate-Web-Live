<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'must_change_password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const SUPER_ADMIN = 'super_admin';

    public const ADMIN = 'admin';

    public const EDITOR = 'editor';

    /**
     * Role => rank. A route guarded with `cms.role:admin` admits admin and
     * everything ranked above it.
     */
    public const ROLES = [
        self::EDITOR => 1,
        self::ADMIN => 2,
        self::SUPER_ADMIN => 3,
    ];

    public const ROLE_LABELS = [
        self::SUPER_ADMIN => 'Super Admin',
        self::ADMIN => 'Admin',
        self::EDITOR => 'Editor',
    ];

    public const ROLE_DESCRIPTIONS = [
        self::SUPER_ADMIN => 'Everything, including managing other Super Admins.',
        self::ADMIN => 'All content, inquiries, settings, site status and staff accounts.',
        self::EDITOR => 'Properties, services, updates and team members; can read inquiries.',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    public function hasRoleAtLeast(string $role): bool
    {
        return (self::ROLES[$this->role] ?? 0) >= (self::ROLES[$role] ?? PHP_INT_MAX);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::SUPER_ADMIN;
    }

    public function roleLabel(): string
    {
        return self::ROLE_LABELS[$this->role] ?? ucfirst((string) $this->role);
    }

    /**
     * Admins manage admins and editors; only a Super Admin can touch
     * another Super Admin account.
     */
    public function canManage(User $other): bool
    {
        if (! $this->hasRoleAtLeast(self::ADMIN)) {
            return false;
        }

        return $this->isSuperAdmin() || ! $other->isSuperAdmin();
    }

    /** Roles this user may hand out when creating or editing an account. */
    public function assignableRoles(): array
    {
        return $this->isSuperAdmin()
            ? array_keys(self::ROLES)
            : [self::ADMIN, self::EDITOR];
    }
}
