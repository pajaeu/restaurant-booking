<form action="{{ $action }}" class="form" method="post">
    @isset($method)
        @method($method)
    @endisset
    <div class="form__group">
        <label for="name" class="form__label">Název</label>
        <input type="text" class="form__input" id="name" name="name" value="{{ old('name', $table?->name) }}">
        @error('name')
            <div class="form__error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form__group">
        <label for="capacity" class="form__label">Počet míst</label>
        <input type="number" class="form__input" id="capacity" name="capacity" value="{{ old('capacity', $table?->capacity) }}">
        @error('capacity')
            <div class="form__error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form__group">
        @csrf
        <button type="submit" class="button button--primary button--block">Uložit stůl</button>
    </div>
</form>