<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('settings')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'language' => 'required|string|in:es,en',
            'theme' => 'required|string|in:light,dark',
        ]);

        // For now, we'll just store these in session or user preferences
        // In a real app, you might want to add these fields to the users table
        session([
            'language' => $request->language,
            'theme' => $request->theme,
        ]);

        return redirect()->route('settings')->with('success', 'Preferencias actualizadas correctamente.');
    }
}