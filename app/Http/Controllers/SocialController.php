<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\User;

class SocialController extends Controller
{
    //
    public function redirectProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider) {
        try {
            $user = Socialite::driver($provider)->user();

            $create = User::firstOrCreate([
                'email' => $user->getEmail()
            ], [
                'provider' => $provider,
                'provider_id' => $user->getId(),
                'avatar' => $user->getAvatar(),
                'password' => Hash::make('passdummytest'),
            ]);
    
            auth()->login($create, true);

            return redirect($this->redirectPath());
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}
