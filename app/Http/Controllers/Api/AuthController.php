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
        // السماح فقط للـ client باستخدام هذه الدوال
        $this->middleware('role:client')->only(['logout']);
        // register و login مفتوحين للجميع، لذلك لم نقيّدهم
    }
    


    // POST /api/client/register
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
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
            // التحقق ومحاولة تسجيل الدخول (مع RateLimiter)
            $request->authenticate();

            $user = User::where('email', $request->input('email'))->first();

            // تحقق إضافي اختياري
            if (! $user || ! Hash::check($request->input('password'), $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // إنشاء توكن جديد
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
            // أخطاء من authenticate() مثل throttle
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

            // حذف التوكن الحالي فقط
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
