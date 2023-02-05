<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'quantity',
    ];

    /**
     * Get product images
     *
     * @return HasMany
     */
    public  function productImages() : HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }

    public function hasRating() : bool
    {
        return $this->ratings()->where("user_id", Auth::id())->exists();
    }

}
