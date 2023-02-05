<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductTest extends TestCase

{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_products_show()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

    public function test_products_show_product()
    {
        $response = $this->getJson('/api/products/1');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll('id', 'name','description','status','quantity','rating','price','image_url')
        );

    }

    public function t1est_add_product_user()
    {
        $token = $this->getUserToken();

        $product = [
            "name" => "fasdfasdfasdfsad",
            "description" => "loremf,lds,lf,lasd,lfsadfasfsad",
            "price" => 1500,
            "status" => "publish",
            "quantity" => "10",
            "image_file[]" => Storage::files('test.jpg')
        ];


        $response = $this->withToken($token)->postJson("/api/products", $product);

        $response->assertStatus(403);

    }

    public function test_add_product_admin()
    {
        $token = $this->getUserToken(true);

        $product = [
            "name" => "fasdfasdfasdfsad",
            "description" => "loremf,lds,lf,lasd,lfsadfasfsad",
            "price" => 1500,
            "status" => "publish",
            "quantity" => "10",
            "image_file[]" => Storage::files('test')
        ];

        $response = $this->withToken($token)->postJson("/api/products", $product);

        $response->assertStatus(204);
    }
}
