<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
     * Relationship with the Clothing model (one-to-many).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clothing()
    {
        return $this->hasMany(Clothing::class);
    }

    /**
     * Many-to-many relationship with the Clothing model for favorites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(Clothing::class, 'favorite_clothing');
    }
    
    /**
     * Relationship with the Outfit model (one-to-many).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outfits()
    {
        return $this->hasMany(Outfit::class);
    }
}
