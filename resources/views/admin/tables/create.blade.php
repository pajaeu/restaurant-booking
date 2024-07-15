<x-layouts.app>
    <x-slot name="title">Nový stůl</x-slot>

    <div class="card">
        @include('admin.tables.form', [
            'action' => route('admin.tables.store'),
            'table' => null
        ])
    </div>
</x-layouts.app>