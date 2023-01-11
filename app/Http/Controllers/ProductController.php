<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get Product
     *
     * 
     */
    public function show()
    {
        return ProductResource::collection(Product::all());
    }

}
