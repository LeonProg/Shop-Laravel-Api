<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'count',
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
