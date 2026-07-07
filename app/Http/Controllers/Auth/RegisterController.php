<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

// Ei controller new user registration handle kore
class RegisterController extends Controller
{
    // Registration form dekhano hoy
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Form submit korle new user create kora hoy
    public function register(Request $request)
    {
        // Validation rules - proper error message dekhabe
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        // Password hash kore save kora hocche, role default 'user'
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // Register korar por auto login kore dashboard e pathano hocche
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to KickMaster.');
    }
}