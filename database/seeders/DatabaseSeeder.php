<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(15)->create();
        Category::factory(10)->create();
        Product::factory(20)->create();
        ProductImage::factory(25)->create();
        Comment::factory(5)->create();
        Cart::factory(15)->create();
        Rating::factory(50)->create();
    }
}
