<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthenticateUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController
{

    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(AuthenticateUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (auth()->attempt($data)) {
            return to_route('booking.form')
                ->with('success', 'Přihlášení proběhlo úspěšně');
        }

        return back()->withErrors([
            'email' => 'Neplatné přihlašovací údaje'
        ]);
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = \App\Models\User::create($data);

        auth()->login($user);

        return to_route('booking.form');
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        return to_route('auth.login');
    }
}