<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * User registration
     * 
     * @param RegistrationRequest request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request) : JsonResponse
    {
        $user = User::query()->create([
            'password' => Hash::make($request->password)
            ] + $request->validated());

        return response()->json([
            'success' => true
        ], 201);
    }   

    /**
     * 
     * @param LoginRequest $request
     * @return array|JsonResponse
     */
    public function login(LoginRequest $request) : array|JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            return [
                'success' => true,
                'token' => $request->user()->createToken('api')->plainTextToken
            ];
        }

        return response()->json([
            'success' => false,
            'errors' => 'inccorect login or password'
        ], 422);
    }

    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request) : Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
