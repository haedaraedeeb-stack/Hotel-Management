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
    /**
     * Redirect the user to the spacified social authentication provider.
     * Summary of redirectToProvider
     * @param mixed $provider
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        // return "ssdsa";
        return Socialite::driver($provider)->redirect();
    }

    /**
     * retrieves the user information from the provider,
     * creates or updates the local user record, logs the user in, and redirects to the dashboard.
     * Summary of handleProviderCallback
     * @param mixed $provider
     * @return \Illuminate\Http\RedirectResponse
     */
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
