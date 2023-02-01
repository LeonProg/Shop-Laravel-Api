<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdutImage>
 */
class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "product_id" => Product::get()->random()->id,
            "image_path" => fake()->imageUrl(),

        ];
    }
}
