<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function add(Product $product)
    {
        $user = Auth::user()->hasCartProduct($product->id);

        if (!$user)
        {
            Auth::user()->cart()->create([
                'product_id' => $product->id,
                'count' => 1,
            ]);

            return response()->Json([
                'success' => true
            ], 201);
        }
        return  response()->json([
            'message' => 'Product already added'
        ]);
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
