<x-layouts.app>
    <x-slot name="title">Profil</x-slot>

    <div class="profile">
        <div class="container">
            <div class="profile__content">
                <div class="profile__sidebar">
                    <div class="profile__info">
                        <div class="profile__email">{{ $user->email }}</div>
                        <div class="profile__date">{{ $user->created_at->format('d. m. Y') }}</div>
                        <form action="{{ route('auth.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="button button--primary button--small button--block">Odhlásit se</button>
                        </form>
                    </div>
                </div>
                <div class="profile__main">
                    <h2 class="profile__title">Moje aktivní rezervace</h2>
                    @if($bookings->isEmpty())
                        <div class="profile__empty">Nemáte žádné rezervace.</div>
                    @else
                        <div class="profile__bookings">
                            @foreach($bookings as $booking)
                                <div class="booking">
                                    <div class="booking__info">
                                        <div class="booking__date">{{ $booking->reserved_time->format('d. m. Y H:i') }}</div>
                                        <div class="booking__guests">Počet hostů: <b>{{ $booking->guests }}</b></div>
                                    </div>
                                    <div class="booking__table">Stůl: <b>{{ $booking->table->name }}</b></div>
                                </div>
                            @endforeach
                            <div class="booking__pagination">{{ $bookings->links('pagination.default') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>