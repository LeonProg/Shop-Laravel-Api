<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add to cart
     * 
     * @param Product $product
     * @return JsonResponse
     */
    public function add(Product $product) : JsonResponse
    {
        $user = Auth::user();

        $items = $user->cart;

        // if ($items->has($product->id)) {
        //     return response()->Json([
        //         'success' => false,
        //         'message' => 'This product cannot be added to the cart because it is already there',
        //     ]);;
        // } 

        $user->cart()->create([
            'product_id' => $product->id,
        ]);

        return response()->Json([
            'success' => true
        ], 201);
    }

    /**
     * Get cart
     * 
     * @return JsonResponse
     */
    public function show() : JsonResponse
    {
        $items = Auth::user()->cart;
        $totalPrice = 0;

        foreach ($items as $item) {
            $totalPrice += $item->products->price;
        }

        return response()->json([
            'totalPrice' => $totalPrice,
            'data' => CartResource::collection(Auth::user()->cart)
        ]);
    }

    /**
     * Delete from cart
     * 
     * @param Cart $cart
     */
    public function delete(Cart $cart) 
    {
        if (Auth::id() !== $cart->user_id) {
            return response()->json([
                'error' => [
                    'success' => false,
                    'message' => 'Forbidden for you',
                ],
            ], 403);
        }
        
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted from cart'
        ]);
    }
}
