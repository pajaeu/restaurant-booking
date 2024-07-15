<x-layouts.app>
    <x-slot name="title">Registrace</x-slot>

    <div class="login-register">
        <form action="{{ route('auth.store') }}" method="post" class="form">
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
            <div class="form__group">
                <label for="password_confirmation" class="form__label">Potvrzení hesla</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form__input">
                @error('password_confirmation')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </div>
            @csrf
            <button type="submit" class="button button--primary button--block">Zaregistrovat se</button>
            <a href="{{ route('auth.login') }}" class="next-link">Přihlásit se</a>
        </form>
    </div>
</x-layouts.app>