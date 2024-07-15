<x-layouts.app>
    <x-slot name="title">Stoly</x-slot>

    <div class="container">
        @foreach(['success', 'error', 'info'] as $type)
            @if(session($type))
                <div class="alert alert--{{ $type }}">{{ session($type) }}</div>
            @endif
        @endforeach
        <div style="margin-bottom: 20px">
            <a href="{{ route('admin.tables.create') }}" class="button button--primary">Nový stůl</a>
        </div>
        <table class="table">
            <tr>
                <th style="width: 50%">Název</th>
                <th style="width: 20%">Počet míst</th>
                <th></th>
            </tr>
            @if($tables->isNotEmpty())
                @foreach($tables as $table)
                    <tr>
                        <td>{{ $table->name }}</td>
                        <td>{{ $table->capacity }}</td>
                        <td>
                            <div class="table__actions">
                                <a href="{{ route('admin.tables.edit', ['table' => $table]) }}" class="actions__link">
                                    <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><g fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.333 16.048L16.57 3.81a2.56 2.56 0 0 1 3.62 3.619L7.951 19.667a2 2 0 0 1-1.022.547L3 21l.786-3.93a2 2 0 0 1 .547-1.022Z"/><path d="m14.5 6.5l3 3"/></g></g></svg></svg>
                                </a>
                                <form action="{{ route('admin.tables.destroy', ['table' => $table]) }}" method="post">
                                    <button type="submit" class="actions__link actions__link--delete">
                                        <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 4l2.303 14.076a4 4 0 0 0 2.738 3.167l.328.104a12 12 0 0 0 7.262 0l.328-.104a4 4 0 0 0 2.738-3.166L21 4"/><ellipse cx="12" cy="4" rx="9" ry="2"/></g></g></svg></svg>
                                    </button>
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" style="text-align: center">
                        <a href="{{ route('admin.tables.create') }}" class="button button--primary">Nový stůl</a>
                    </td>
                </tr>
            @endif
        </table>
        {{ $tables->links('pagination.default') }}
    </div>
</x-layouts.app>