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
        $ratings = $this->ratings()->get("rating");
        $array = [];

        foreach ($ratings as $rating)
        {
            $array[] = $rating['rating'];
        }
        $sum = array_sum($array);

        $result = ($sum > 0 ) ?  round($sum / $this->ratings()->count(), PHP_ROUND_HALF_UP) : 0;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'image_url' => ImageResource::collection($this->productImages()->get("image_path")),
            'rating' =>  $result,
        ];
    }
}
