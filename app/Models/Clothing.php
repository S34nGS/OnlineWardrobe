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
        'file_path',   // Path to the image file
        'name',        // Name of the clothing item
        'color',       // Color of the clothing item
        'category_id', // Foreign key for category
        'user_id',     // Foreign key for the user (when a user adds clothing)
    ];

    /**
     * Define the relationship between Clothing and User.
     * Each clothing item belongs to a specific user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship between Clothing and Category.
     * Each clothing item belongs to one category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the many-to-many relationship between Clothing and Outfit.
     * This allows a clothing item to be part of many outfits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_details');
    }

    /**
     * Define the many-to-many relationship between Clothing and Users.
     * This relationship tracks which users have saved a clothing item in their wardrobe.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_clothing');
    }
}
