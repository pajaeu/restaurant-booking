<x-layouts.app>
    <x-slot name="title">{{ $table->name }}</x-slot>

    <div class="card">
        @include('admin.tables.form', [
            'action' => route('admin.tables.update', ['table' => $table]),
            'method' => 'PUT',
            'table' => $table,
        ])
    </div>
</x-layouts.app>