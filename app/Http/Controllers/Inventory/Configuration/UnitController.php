<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Shown as "Wings". */
class UnitController extends CrudController
{
    protected string $model = Unit::class;
    protected string $view = 'inventory.configuration.units';
    protected string $label = 'Wing';

    protected function query(Request $request): Builder
    {
        return Unit::query()
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('code', 'like', "%{$request->search}%")
                ->orWhere('name', 'like', "%{$request->search}%")
                ->orWhere('address', 'like', "%{$request->search}%")))
            ->orderByDesc('order');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'Code' => ['required', 'string', 'max:50', Rule::unique('units', 'code')->ignore($record)],
            'Unit' => ['required', 'string', 'max:250'],
            'Address' => ['nullable', 'string', 'max:250'],
            'Type' => ['required', Rule::in(['Wing', 'Unit', 'Division'])],
            'Order' => ['required', 'integer', 'min:0'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['Unit' => 'Unit Name', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['code' => $d['Code'], 'name' => $d['Unit'], 'address' => $d['Address'] ?? null, 'type' => $d['Type'], 'order' => $d['Order'], 'status' => $this->yn($d['C4S'])];
    }
}
