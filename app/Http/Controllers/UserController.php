<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * get user profile
     * 
     * @return array
     */
    public function profile() : array
    {
        $user = $this->user();

        return [
            'id' => $user->id, 
            'name' => $user->name, 
            'email' => $user->email,
        ];
    }

    /**
     * 
     * @param ProfileRequest $request
     * @return 
     */
    public function update(ProfileRequest $request) 
    {
        $password = $request->get('password') 
        ? Hash::make($request->get('password')) 
        : $this->user()->password;

        $this->user()->update(['password' => $password] + $request->validated());
        return response()->noContent();
    }

    /**
     * Get auth user
     * 
     * @return Authenticatable|null
     */
    private function user() : Authenticatable|null
    {
        return Auth::user();
    }
}
