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
            ->paginate(10);

        return view('profile.show', compact('user', 'bookings'));
    }
}
