<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Category;
use App\Models\ParentCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends CrudController
{
    protected string $model = Category::class;
    protected string $view = 'inventory.configuration.categories';
    protected string $label = 'Category';

    protected function query(Request $request): Builder
    {
        return Category::with('parent')
            ->when($request->filled('Category'), fn ($q) => $q->where('name', 'like', "%{$request->Category}%"))
            ->when($request->filled('Parent'), fn ($q) => $q->whereHas('parent', fn ($q) => $q->where('name', 'like', "%{$request->Parent}%")))
            ->latest('id');
    }

    protected function viewData(): array
    {
        return ['parents' => ParentCategory::active()->orderBy('name')->pluck('name', 'id')];
    }

    public function show(string $id): View
    {
        $category = Category::findOrFail($id);
        $category->load(['parent', 'models.brand', 'models.ports', 'models.layers', 'models.capacities', 'brands']);

        return view('inventory.configuration.category-show', compact('category'));
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'ParentCatID' => ['required', 'exists:parent_categories,id'],
            'Category' => ['required', 'string', 'max:50'],
            'Description' => ['nullable', 'string', 'max:250'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['ParentCatID' => 'Parent Category', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['parent_category_id' => $d['ParentCatID'], 'name' => $d['Category'], 'description' => $d['Description'] ?? null, 'status' => $this->yn($d['C4S'])];
    }
}
