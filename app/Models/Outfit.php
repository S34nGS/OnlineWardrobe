<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'clothing_ids'];

    protected $casts = [
        'clothing_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clothings()
    {
        return $this->belongsToMany(Clothing::class, 'clothing_outfit');
    }
}