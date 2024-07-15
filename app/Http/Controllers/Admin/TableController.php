<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Table\StoreUpdateTableRequest;
use App\Models\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tables = Table::select('id', 'name', 'capacity')
            ->paginate(24);

        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.tables.create');
    }

    public function store(StoreUpdateTableRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Table::create($data);

        return to_route('admin.tables.index')
            ->with('success', 'Stůl byl úspěšně vytvořen');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table): View
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateTableRequest $request, Table $table): RedirectResponse
    {
        $data = $request->validated();

        $table->update($data);

        return to_route('admin.tables.index')
            ->with('success', 'Stůl byl úspěšně upraven');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();

        return to_route('admin.tables.index')
            ->with('success', 'Stůl byl úspěšně smazán');
    }
}
