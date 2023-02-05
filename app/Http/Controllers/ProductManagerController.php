<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductManagerController extends Controller
{

    public function store(ProductRequest $request): Response
    {
        $addProduct = Product::query()->create($request->validated());
        $productImage = new ProductImage();

        if ($request->hasFile('image_file')) {
            foreach ($request->file('image_file') as $image) {
                ProductImage::query()->create([
                    'product_id' => $addProduct->id,
                    'image_path' => ProductImage::uploadImage($image),
                ]);
            }
        }

        return response()->noContent();
    }

    /**
     * Update product
     *
     * @param Product $product, ProductUpdateRequest $request
     * @return Response
    */
    public function update(Product $product, ProductUpdateRequest $request) : Response
    {
        $product->update($request->validated());

        return response()->noContent();

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
