<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

/**
 * This controller handles social authentication using Laravel Socialite,
 * including redirecting to providers and handling callbacks.
 * Summary of SocialiteController
 * @package App\Http\Controllers
 */
class SocialiteController extends Controller
{
    
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {
        $user1 = Socialite::driver($provider)->stateless()->user();
        $user = User::updateOrCreate(
            [
                'email' => $user1->getEmail(),
            ],
            [
                'name' => $user1->getName(),
                'password' => encrypt('password')
            ]
        );
        $user->assignRole('client');
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(
            [
                'user' => $user,
                'Access-Token' => $token
            ],
            200
        );
    }
}
