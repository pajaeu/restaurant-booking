<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{

    public function show(): View
    {
        $user = auth()->user();
        $bookings = $user->bookings()
            ->where('reserved_time', '>', now())
            ->with('table')
            ->orderBy('reserved_time', 'desc')
            ->get();

        return view('profile.show', compact('user', 'bookings'));
    }

    public function edit(): View
    {
        return view('profile.edit');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();

        auth()->user()->update($data);

        return back()->with('success', 'Profil byl úspěšně aktualizován');
    }
}
