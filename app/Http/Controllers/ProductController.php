<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Get Products
     *
     */
    public function show()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Get one Product
     * 
     * @param Product $product
     */
    public function getOne(Product $product) 
    {
        return ProductResource::make($product);
    }

    /**
     * Get comments 
     * 
     * @param Product $product
     */
    public function getComments(Product $product)
    {
        return CommentResource::collection($product->comments);
        
    }

    /**
     * Add comment
     * 
     * @param CommentRequest request
     * @return Response
     */
    public function addComment(Product $product, CommentRequest $request) : Response
    {
        $data = [
            'user_id' => Auth::user()->id,
            'product_id' => $product->id
        ];

        $comment = Comment::query()->create($data + $request->validated());

        return response()->noContent();
    }

}
