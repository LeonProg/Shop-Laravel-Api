<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = $this->products;

        return [
            'product_id' => $this->product_id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image_url' => $product->productImages()->get('image_path'),
        ];
    }
}
