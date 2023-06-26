<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class gitHubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }
    public function callBackGitHub()
    {
        try {
            $github_user = Socialite::driver('github')->user();
            $user = User::where('github_auth_code', $github_user->id)->first();
            if (!$user) {
                $new_user = User::create([
                    'name' => $github_user->getName(),
                    'email' => $github_user->getEmail(),
                    'github_auth_code' => $github_user->id,
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
