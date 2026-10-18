<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\ParentCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParentCategoryController extends CrudController
{
    protected string $model = ParentCategory::class;
    protected string $view = 'inventory.configuration.parentcategories';
    protected string $label = 'Parent Category';

    protected function query(Request $request): Builder
    {
        return ParentCategory::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest('id');
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'PCategory' => ['required', 'string', 'max:50', Rule::unique('parent_categories', 'name')->ignore($record)],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['PCategory' => 'Parent Category', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['name' => $d['PCategory'], 'status' => $this->yn($d['C4S'])];
    }
}
