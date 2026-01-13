<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        // return "ssdsa";
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user1 = Socialite::driver($provider)->user();
        $user = User::updateOrCreate(
            [
                'email' => $user1->getEmail(),
            ],
            [
                'name' => $user1->getName(),
                'password' => encrypt('password')
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
