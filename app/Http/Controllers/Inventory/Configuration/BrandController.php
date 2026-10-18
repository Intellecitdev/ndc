<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends CrudController
{
    protected string $model = Brand::class;
    protected string $view = 'inventory.configuration.brands';
    protected string $label = 'Brand';

    protected function query(Request $request): Builder
    {
        return Brand::with('category')
            ->when($request->filled('Brand'), fn ($q) => $q->where('name', 'like', "%{$request->Brand}%"))
            ->when($request->filled('Category'), fn ($q) => $q->whereHas('category', fn ($q) => $q->where('name', 'like', "%{$request->Category}%")))
            ->latest('id');
    }

    protected function viewData(): array
    {
        return ['categories' => Category::active()->orderBy('name')->pluck('name', 'id')];
    }

    public function show(string $id): View
    {
        $brand = Brand::findOrFail($id);
        $brand->load(['category', 'models.ports', 'models.layers', 'models.capacities']);

        return view('inventory.configuration.brand-show', compact('brand'));
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'CategoryID' => ['required', 'exists:categories,id'],
            'Brand' => ['required', 'string', 'max:20'],
            'Description' => ['nullable', 'string', 'max:250'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['CategoryID' => 'Category', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['category_id' => $d['CategoryID'], 'name' => $d['Brand'], 'description' => $d['Description'] ?? null, 'status' => $this->yn($d['C4S'])];
    }
}
