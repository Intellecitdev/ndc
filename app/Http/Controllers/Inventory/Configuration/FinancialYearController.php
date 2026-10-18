<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\FinancialYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinancialYearController extends CrudController
{
    protected string $model = FinancialYear::class;
    protected string $view = 'inventory.configuration.financialyears';
    protected string $label = 'Fin. Year';

    protected function query(Request $request): Builder
    {
        return FinancialYear::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest('id');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'Name' => ['required', 'string', 'max:50', Rule::unique('financial_years', 'name')->ignore($record)],
            'Current' => ['required', 'in:Y,N'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['name' => $d['Name'], 'is_current' => $this->yn($d['Current']), 'status' => $this->yn($d['C4S'])];
    }

    /** Only one financial year can be current. */
    protected function saved(Model $record): void
    {
        if ($record->is_current) {
            FinancialYear::whereKeyNot($record->id)->update(['is_current' => false]);
        }
    }
}
