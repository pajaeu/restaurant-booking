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
                <th>Název</th>
                <th>Počet míst</th>
                <th></th>
            </tr>
            @if($tables->isNotEmpty())
                @foreach($tables as $table)
                    <tr>
                        <td>{{ $table->name }}</td>
                        <td>{{ $table->capacity }}</td>
                        <td>
                            <div class="table__actions">
                                <a href="{{ route('admin.tables.edit', ['table' => $table]) }}" class="actions__link">Upravit</a>
                                <form action="{{ route('admin.tables.destroy', ['table' => $table]) }}" method="post">
                                    <button type="submit" class="actions__link actions__link--delete">Odstranit</button>
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