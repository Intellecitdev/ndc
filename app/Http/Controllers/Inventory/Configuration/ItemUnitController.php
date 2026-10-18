<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\ItemUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemUnitController extends CrudController
{
    protected string $model = ItemUnit::class;
    protected string $view = 'inventory.configuration.itemunits';
    protected string $label = 'Unit';

    protected function query(Request $request): Builder
    {
        return ItemUnit::query()
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('code', 'like', "%{$request->search}%")->orWhere('name', 'like', "%{$request->search}%")))
            ->latest('id');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'Code' => ['required', 'string', 'max:10', Rule::unique('item_units', 'code')->ignore($record)],
            'Unit' => ['required', 'string', 'max:50'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['code' => $d['Code'], 'name' => $d['Unit'], 'status' => $this->yn($d['C4S'])];
    }
}
