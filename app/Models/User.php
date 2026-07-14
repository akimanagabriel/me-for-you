<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
     * Get all cars owned by this user.
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'user_id');
    }

    /**
     * Get all houses owned by this user.
     */
    public function houses(): HasMany
    {
        return $this->hasMany(House::class, 'user_id');
    }

    /**
     * Get all events created by this user.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id');
    }
}