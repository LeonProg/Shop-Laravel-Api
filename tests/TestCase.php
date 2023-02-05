<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $seed = true;


    protected function userCreate(bool $isAdmin = false)
    {
        return User::factory()->create([
            "name" => "UserOne",
            "email" => "user@gmail.com",
            "password" => Hash::make("123456"),
            "is_admin" => $isAdmin,
        ]);
    }

    protected function getUserToken(bool $isAdmin = false)
    {
        $user = $this->userCreate($isAdmin);
        return $user->createToken("test")->plainTextToken;
    }
}
