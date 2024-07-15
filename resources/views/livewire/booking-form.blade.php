<div class="booking-form">
    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
            <div class="alert alert--{{ $type }}">{{ session($type) }}</div>
        @endif
    @endforeach
    <form wire:submit.prevent="submit" class="form">
        <div class="form__group">
            <label for="guests" class="form__label">Počet hostů</label>
            <input type="number" id="guests" wire:model="guests" wire:change="onGuestsChange()" class="form__input" min="1">
            @error('guests')
                <div class="form__error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form__group">
            <label for="date" class="form__label">Datum</label>
            <input type="date" id="date" wire:model="date" wire:change="onDateChange()" class="form__input" min="{{ now()->format('Y-m-d') }}">
            @error('date')
                <div class="form__error">{{ $message }}</div>
            @enderror
        </div>
        @if($hours and $hours->isNotEmpty())
            <div class="form__group">
                <h3 class="form-group__title">Vyberte čas</h3>
                <div class="hours">
                    @foreach($hours as $hour)
                        <div>
                            <input type="radio" id="hour-{{ $hour }}" value="{{ $hour }}" wire:model="time" wire:change="onTimeChange()">
                            <label class="hour" for="hour-{{ $hour }}">{{ $hour }}</label>
                        </div>
                    @endforeach
                </div>
                @error('time')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </div>
        @endif
        @if($tables)
            <div class="form__group">
                <h3 class="form-group__title">Vyberte stůl</h3>
                <div class="tables">
                    @if($tables->isEmpty())
                        <div class="tables__empty">
                            <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" fill-rule="evenodd" d="M14.543 2.598a2.821 2.821 0 0 0-5.086 0L1.341 18.563C.37 20.469 1.597 23 3.883 23h16.233c2.287 0 3.512-2.53 2.543-4.437L14.543 2.598ZM12 8a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1Zm0 8.5a1 1 0 0 1 1 1v.5a1 1 0 1 1-2 0v-.5a1 1 0 0 1 1-1Z" clip-rule="evenodd"/></g></svg></svg>
                            Pro Vaše zvolené možnosti již nejsou žádné stoly k dispozici.
                        </div>
                    @else
                        @foreach($tables as $table)
                            <div>
                                <input type="radio" id="table-{{ $table->id }}" value="{{ $table->id }}" wire:model="tableId" wire:change="$refresh">
                                <label for="table-{{ $table->id }}" class="table">
                                    <span class="table__name">{{ $table->name }}</span>
                                    <span class="table__capacity">
                                        <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M12 3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5Zm-4 9.5A3.75 3.75 0 0 0 4.25 17v1.188c0 .754.546 1.396 1.29 1.517c4.278.699 8.642.699 12.92 0a1.537 1.537 0 0 0 1.29-1.517V17A3.75 3.75 0 0 0 16 13.25h-.34c-.185 0-.369.03-.544.086l-.866.283a7.251 7.251 0 0 1-4.5 0l-.866-.283a1.752 1.752 0 0 0-.543-.086H8Z"/></g></svg></svg>
                                        {{ $table->capacity }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
                @error('tableId')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </div>
        @endif
        @error('error')
            <div class="form__error form__error--large" style="margin-bottom: 20px">{{ $message }}</div>
        @enderror
        @auth
            <button type="submit" class="button button--primary button--block" @if($errors->any()) disabled @endif>Rezervovat</button>
        @else
            <a href="{{ route('auth.login') }}" class="button button--secondary button--block">Pro uskutečnění rezervace je třeba se přihlásit</a>
        @endauth
    </form>
</div>
