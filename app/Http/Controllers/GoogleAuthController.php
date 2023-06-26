<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callBackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_auth_code', $google_user->id)->first();
            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->name,
                    'email' => $google_user->email,
                    'google_auth_code' => $google_user->id,
                ]);
                Auth::login($new_user);
                return redirect()->intended('/');
            } else {
                Auth::login($user);
                return redirect()->intended('/');
            }
        } catch (\Throwable $th) {
            dd('somethin is went wrong!', $th->getMessage());
        }
    }
}
