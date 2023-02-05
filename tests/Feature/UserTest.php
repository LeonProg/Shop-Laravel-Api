<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration()
    {
        $user = [
            "name" => "UserOne",
            "email" => "user@gmail.com",
            "password" => "123456",
            "password_confirmation" => "123456",
        ];

        $response = $this->postJson('/api/registration', $user);

        $response->assertStatus(201)->assertExactJson([
            'success' => true
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $user = $this->userCreate();

        $response = $this->postJson('/api/login', [
            "email" => $user->email,
            "password" => "123456",
        ]);

        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    public function test_logout()
    {
        $token = $this->getUserToken();

        $response = $this->withToken($token)->deleteJson("api/logout");

        $response->assertStatus(204);
    }



}
