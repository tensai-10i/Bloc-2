<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        $role = $this->getRelationValue('role') ?? $this->role()->first();
        return $role && $role->name === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        $role = $this->getRelationValue('role') ?? $this->role()->first();
        return $role && in_array($role->name, ['super_admin', 'admin']);
    }

    /**
     * Check if user is moderator
     */
    public function isModerator(): bool
    {
        $role = $this->getRelationValue('role') ?? $this->role()->first();
        return $role && in_array($role->name, ['super_admin', 'admin', 'moderator']);
    }

    /**
     * Check if user is normal user
     */
    public function isNormalUser(): bool
    {
        $role = $this->getRelationValue('role') ?? $this->role()->first();
        return $role && $role->name === 'user';
    }

    /**
     * Get the role name
     */
    public function getRoleDisplayAttribute(): string
    {
        $role = $this->getRelationValue('role') ?? $this->role()->first();
        if (!$role) {
            return 'Aucun rôle';
        }

        return match($role->name) {
            'user' => 'Utilisateur normal',
            'moderator' => 'Modérateur',
            'admin' => 'Administrateur',
            'super_admin' => 'Super Administrateur',
            default => ucfirst(str_replace('_', ' ', $role->name))
        };
    }
}
