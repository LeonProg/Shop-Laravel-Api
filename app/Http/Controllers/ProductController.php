<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Get products
     *
     * @return AnonymousResourceCollection
     */
    public function show(Request $request)
    {
        $product = ProductResource::collection(Product::query()->select(['id', 'name', 'quantity', 'price', 'category_id'])->paginate(12))->withQueryString();

//       Refactoring !!!!!

        if ($request->has('category_id') || $request->has('sortByDESC') || $request->has('sortByASC')) {

            if ($request->has('category_id') && $request->has('sortByDESC')) {

                return ProductResource::collection(Product::query()
                    ->select(['id', 'name', 'quantity', 'price', 'category_id'])
                    ->where('category_id', $request->category_id)
                    ->orderBy($request->sortByDESC, 'DESC')
                    ->paginate(12))
                    ->withQueryString();
            }

            if ($request->has('category_id') && $request->has('sortByASC')) {
                return ProductResource::collection(Product::query()
                    ->select(['id', 'name', 'quantity', 'price', 'category_id'])
                    ->where('category_id', $request->category_id)
                    ->orderBy($request->sortByASC, 'ASC')
                    ->paginate(12))
                    ->withQueryString();
            }

            if ($request->has('category_id')) {
                return ProductResource::collection(Product::query()
                    ->select(['id', 'name', 'quantity', 'price', 'category_id'])
                    ->where('category_id', $request->category_id)
                    ->paginate(12))
                    ->withQueryString();
            }

            if ($request->has('sortByDESC')) {
                return ProductResource::collection(Product::query()
                    ->select(['id', 'name', 'quantity', 'price', 'category_id'])
                    ->orderBy($request->sortByDESC, 'DESC')
                    ->paginate(12))
                    ->withQueryString();
            }

            if ($request->has('sortByASC')) {
                return ProductResource::collection(Product::query()
                    ->select(['id', 'name', 'quantity', 'price', 'category_id'])
                    ->orderBy($request->sortByASC, 'ASC')
                    ->paginate(12))
                    ->withQueryString();
            }
        }

        return $product;
    }

    /**
     * Get one Product
     *
     * @param Product $product
     * @return ProductResource
     */
    public function getOne(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Get comments
     *
     * @param Product $product
     * @return AnonymousResourceCollection
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
    public function addComment(Product $product, CommentRequest $request): Response
    {
        $data = [
            'user_id' => Auth::user()->id,
            'product_id' => $product->id
        ];

        $comment = Comment::query()->create($data + $request->validated());

        return response()->noContent();
    }

    public function setRating(Product $product, RatingRequest $request)
    {
        if (!$product->hasRating()) {
            $product->ratings()->create([
                    'user_id' => Auth::id(),
                ] + $request->validated());

            return response()->noContent();
        }

        $product->ratings()->update([
                'user_id' => Auth::id(),
            ] + $request->validated());

        return response()->noContent();
    }

}
