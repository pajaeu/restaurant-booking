<header class="header">
    <div class="header__inner">
        <div class="header__logo">Rezervační Systém</div>
        {{ $slot }}
        <div class="header__actions">
            <a href="{{ route('booking.form') }}" class="action__link">Rezervovat stůl</a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.tables.index') }}" class="action__link">Správa stolů</a>
                @endif
                <a href="{{ route('profile.show') }}" class="action__link">Můj profil</a>
            @else
                <a href="{{ route('auth.login') }}" class="action__link">Přihlásit se</a>
                <a href="{{ route('auth.register') }}" class="action__link">Zaregistrovat se</a>
            @endauth
        </div>
    </div>
</header>