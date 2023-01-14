<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    
    /**
     * Get a product
     *
     * @return HasOne
     */
    public function products() : HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
