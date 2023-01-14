<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'status',
        'quantity',
        'rating'
    ];

    /**
     * Get product images
     * 
     * @return HasMany
     */
    public function productImages() : HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }
}
