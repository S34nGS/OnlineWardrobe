<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_path',
        'name',       // Naam van kledingstuk
        'color',      // Kleur van kledingstuk
        'category_id', // Foreign key voor categorie
        'user_id',    // Foreign key voor gebruiker
    ];

    /**
     * Relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the Category model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship with the Outfit model through outfit_details table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_details');
    }

