<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
        // Si usas API stateless (SPA), podrías usar ->stateless()
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();
        // Datos típicos: id, email, name, avatar

        // 1) intentamos por provider+id
        $user = User::where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        // 2) si no existe, look up por email (para enlazar cuenta)
        if (!$user && $googleUser->getEmail()) {
            $user = User::where('email', $googleUser->getEmail())->first();
        }

        if (!$user) {
            // crear nuevo user (password nullable)
            $user = new User();
            $user->name = $googleUser->getName() ?: $googleUser->getNickname() ?: 'Usuario';
            $user->email = $googleUser->getEmail();
            $user->email_verified_at = now();
            $user->password = null; // social-only
        }

        // enlazar proveedor e info
        $user->provider = 'google';
        $user->provider_id = $googleUser->getId();
        $user->avatar = $googleUser->getAvatar();
        $user->save();

        Auth::login($user, remember: true);

        return redirect()->route('dashboard');
    }
}
