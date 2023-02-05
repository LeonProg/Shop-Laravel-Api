<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
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
        Product::factory(5)->create();
        ProductImage::factory(25)->create();
        Comment::factory(5)->create();
        Cart::factory(15)->create();
        Rating::factory(100)->create();
    }
}
