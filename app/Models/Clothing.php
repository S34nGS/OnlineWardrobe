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
        'name',       // Name of the clothing item
        'color',      // Color of the clothing item
        'category_id', // Foreign key for category
        'user_id',    // Foreign key for the user (when a user adds clothing)
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
    
    /**
     * Relationship with User model for clothing items stored in the user's wardrobe.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_clothing');
    }
}
