<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductManagerController extends Controller
{
     /**
     * Add product
     * 
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $addProduct = Product::query()->create($request->validated());

        if ($request->hasFile('image_file')) {
            foreach ($request->file('image_file') as $image) {
                ProductImage::query()->create([
                    'product_id' => $addProduct->id,
                    'image_path' => $image->store('public/images')
                ]);
            }
        }

        return response()->noContent();
    }

    /**
     * Update product
     * 
     * 
    */
    public function update(Product $product, ProductUpdateRequest $request) 
    {
        $product->update($request->validated());

        return $product;

    }

    /**
     * Delete product
     * 
     * @param Product $product
     * @return Response
     */
    public function delete(Product $product)
    {
        foreach ($product->productImages as $item)  {
            Storage::delete($item->image_path);
            $item->delete();
        }
        $product->delete();

        return response()->noContent();
    }
}
