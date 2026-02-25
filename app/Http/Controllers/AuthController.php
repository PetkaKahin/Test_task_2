<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function show() {
        return Inertia::render('Login');
    }

    public function login(LoginRequest $request) {
        if (Auth::attempt($request->only('name', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('feedbacks.show'));
        }

        return back()->withErrors([
            'password' => 'Не верный логин или пароль',
        ])->onlyInput('name');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }
}
