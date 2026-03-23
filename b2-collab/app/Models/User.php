<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
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

    public function isAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin'], true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function canAccessModeration(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'moderator'], true);
    }

    public function roleDisplay(): string
    {
        return match($this->role) {
            'superadmin' => 'Superadministrateur',
            'admin' => 'Administrateur',
            'moderator' => 'Modérateur',
            default => 'Utilisateur',
        };
    }

    /**
     * Get the resources created by this user.
     */
    public function ressources()
    {
        return $this->hasMany(Ressources::class, 'user_id', 'id');
    }
}
