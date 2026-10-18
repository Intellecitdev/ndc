<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Models\Capacity;
use App\Models\Category;
use App\Models\Layer;
use App\Models\Port;
use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Inventory > Configuration > Models, plus the Ports / Layers / Capacities
 * managed from a model's detail page.
 */
class ProductModelController extends CrudController
{
    protected string $model = ProductModel::class;
    protected string $view = 'inventory.configuration.models';
    protected string $label = 'Model';

    /** attribute type => [model class, label] */
    private const ATTRIBUTES = [
        'port' => [Port::class, 'Port'],
        'layer' => [Layer::class, 'Layer'],
        'capacity' => [Capacity::class, 'Capacity'],
    ];

    protected function query(Request $request): Builder
    {
        return ProductModel::with(['brand', 'category'])
            ->when($request->filled('Model'), fn ($q) => $q->where('name', 'like', "%{$request->Model}%"))
            ->when($request->filled('Brand'), fn ($q) => $q->whereHas('brand', fn ($q) => $q->where('name', 'like', "%{$request->Brand}%")))
            ->when($request->filled('Category'), fn ($q) => $q->whereHas('category', fn ($q) => $q->where('name', 'like', "%{$request->Category}%")))
            ->latest('id');
    }

    protected function viewData(): array
    {
        return ['categories' => Category::active()->orderBy('name')->pluck('name', 'id')];
    }

    public function show(string $id): View
    {
        $model = ProductModel::findOrFail($id);
        $model->load(['brand', 'category', 'ports', 'layers', 'capacities']);

        return view('inventory.configuration.model-show', ['record' => $model]);
    }

    protected function rules(Request $request, ?Model $record): array
    {
        return [
            'CategoryID' => ['required', 'exists:categories,id'],
            'BrandID' => ['required', Rule::exists('brands', 'id')->where('category_id', $request->input('CategoryID'))],
            'Model' => ['required', 'string', 'max:20'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    protected function attributes(): array
    {
        return ['CategoryID' => 'Category', 'BrandID' => 'Brand', 'C4S' => 'Status'];
    }

    protected function payload(array $d): array
    {
        return ['category_id' => $d['CategoryID'], 'brand_id' => $d['BrandID'], 'name' => $d['Model'], 'status' => $this->yn($d['C4S'])];
    }

    // ---- Ports / Layers / Capacities ----

    public function storeAttribute(Request $request, ProductModel $model, string $type): JsonResponse
    {
        [$class, $label] = self::ATTRIBUTES[$type] ?? abort(404);
        $data = $this->check($request, ['Name' => ['required', 'string', 'max:50'], 'C4S' => ['required', 'in:Y,N']], ['Name' => $label, 'C4S' => 'Status']);

        $class::create(['category_id' => $model->category_id, 'product_model_id' => $model->id, 'name' => $data['Name'], 'status' => $this->yn($data['C4S'])]);

        return $this->ok("$label added successfully.");
    }

    public function updateAttribute(Request $request, string $type, int $id): JsonResponse
    {
        [$class, $label] = self::ATTRIBUTES[$type] ?? abort(404);
        $data = $this->check($request, ['Name' => ['required', 'string', 'max:50'], 'C4S' => ['required', 'in:Y,N']], ['Name' => $label, 'C4S' => 'Status']);

        $class::findOrFail($id)->update(['name' => $data['Name'], 'status' => $this->yn($data['C4S'])]);

        return $this->ok("$label updated successfully.");
    }

    public function destroyAttribute(string $type, int $id): JsonResponse
    {
        [$class, $label] = self::ATTRIBUTES[$type] ?? abort(404);
        try {
            $class::findOrFail($id)->delete();
        } catch (QueryException) {
            return $this->fail("This $label is in use and can not be deleted.");
        }

        return $this->ok("$label deleted successfully.");
    }
}
