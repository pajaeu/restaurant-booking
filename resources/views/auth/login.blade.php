<x-layouts.app>
    <x-slot name="title">Přihlášení</x-slot>

    <div class="login-register">
        <form action="{{ route('auth.authenticate') }}" method="post" class="form">
            <div class="form__group">
                <label for="email" class="form__label">E-mail</label>
                <input type="email" id="email" name="email" class="form__input" value="{{ old('email') }}">
                @error('email')
                <div class="form__error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__group">
                <label for="password" class="form__label">Heslo</label>
                <input type="password" id="password" name="password" class="form__input">
                @error('password')
                <div class="form__error">{{ $message }}</div>
                @enderror
            </div>
            @csrf
            <button type="submit" class="button button--primary button--block">Přihlásit se</button>
            <a href="{{ route('auth.register') }}" class="next-link">Zaregistrujte se</a>
        </form>
    </div>
</x-layouts.app>