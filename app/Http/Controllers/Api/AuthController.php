<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:client')->only(['logout']);
    }



    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // منح دور "client" عبر Spatie
            $user->assignRole('client');

            // إنشاء توكن عبر Sanctum
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                ],
                'token' => $token,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Registration failed',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    // POST /api/client/login
    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate();

            $user = User::where('email', $request->input('email'))->first();

            if (! $user || ! Hash::check($request->input('password'), $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                ],
                'token' => $token,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'error' => 'Login validation failed',
                'messages' => $ve->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Login failed',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    // POST /api/client/logout
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout successful'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Logout failed',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
