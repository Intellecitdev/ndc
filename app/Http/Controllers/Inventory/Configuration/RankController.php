<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Rank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RankController extends CrudController
{
    protected string $model = Rank::class;
    protected string $view = 'inventory.configuration.ranks';
    protected string $label = 'Rank';

    protected function query(Request $request): Builder
    {
        return Rank::query()
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q
                ->where('short', 'like', "%{$request->search}%")
                ->orWhere('name', 'like', "%{$request->search}%")))
            ->orderBy('order');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'Code' => ['required', 'string', 'max:50'],
            'Rank' => ['required', 'string', 'max:150', Rule::unique('ranks', 'name')->ignore($record)],
            'RankOrder' => ['required', 'integer', 'min:0'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['Code' => 'Short', 'RankOrder' => 'Rank Order', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['short' => $d['Code'], 'name' => $d['Rank'], 'order' => $d['RankOrder'], 'status' => $this->yn($d['C4S'])];
    }
}
