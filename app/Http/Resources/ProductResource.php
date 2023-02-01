<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'rating' => $this->rating,
            'price' => $this->price,
            // 'images_path' => ($this->productImages()->get('image_path')),
            'image_url' => array_map(function($images) {
                $array = [];
                foreach($images as $image) {
                    $array[] = $image['image_url'];
                }
                return $array;

            },[$this->productImages()->get('image_path')]),
        ];
    }
}
