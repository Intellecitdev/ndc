<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\ProductModel;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

/**
 * Cascading dropdown data: Parent Category > Category > Brand > Model > Port/Layer/Capacity,
 * plus item search/details (same endpoints as the reference).
 */
class LookupController extends Controller implements HasMiddleware
{
    /** These routes sit outside the menu guard: only users with some Inventory permission may use them. */
    public static function middleware(): array
    {
        return [
            new Middleware(function (Request $request, Closure $next) {
                abort_unless($request->user()?->canModule('inventory'), 403);

                return $next($request);
            }),
        ];
    }

    public function categories(int $parent): JsonResponse
    {
        return $this->list(Category::active()->where('parent_category_id', $parent)->orderBy('name')->get(['id', 'name']));
    }

    public function brands(int $category): JsonResponse
    {
        return $this->list(Brand::active()->where('category_id', $category)->orderBy('name')->get(['id', 'name']));
    }

    public function models(int $brand): JsonResponse
    {
        return $this->list(ProductModel::active()->where('brand_id', $brand)->orderBy('name')->get(['id', 'name']));
    }

    public function modelDetails(int $model): JsonResponse
    {
        $m = ProductModel::with([
            'ports' => fn ($q) => $q->active(), 'layers' => fn ($q) => $q->active(), 'capacities' => fn ($q) => $q->active(),
        ])->findOrFail($model);

        return response()->json([
            'success' => true,
            'port' => $m->ports->map->only(['id', 'name']),
            'layer' => $m->layers->map->only(['id', 'name']),
            'capacity' => $m->capacities->map->only(['id', 'name']),
        ]);
    }

    /** Items filtered by any of the cascade levels. */
    public function items(Request $request): JsonResponse
    {
        $items = Item::active()
            ->when($request->filled('ParentCatID'), fn ($q) => $q->where('parent_category_id', $request->ParentCatID))
            ->when($request->filled('CategoryID'), fn ($q) => $q->where('category_id', $request->CategoryID))
            ->when($request->filled('BrandID'), fn ($q) => $q->where('brand_id', $request->BrandID))
            ->when($request->filled('ModelID'), fn ($q) => $q->where('product_model_id', $request->ModelID))
            ->when($request->filled('PortID'), fn ($q) => $q->where('port_id', $request->PortID))
            ->when($request->filled('LayerID'), fn ($q) => $q->where('layer_id', $request->LayerID))
            ->when($request->filled('CapacityID'), fn ($q) => $q->where('capacity_id', $request->CapacityID))
            ->orderBy('name')
            ->get(['id', 'code', 'name']);

        return $this->list($items->map(fn ($i) => ['id' => $i->id, 'name' => "{$i->code} - {$i->name}"]));
    }

    public function itemDetails(Item $item): JsonResponse
    {
        $item->load(['category', 'unit']);

        return response()->json(['success' => true, 'data' => [
            'id' => $item->id, 'code' => $item->code, 'name' => $item->name, 'category' => $item->category?->name,
            'description' => $item->description, 'unit' => $item->unit?->name, 'stock' => Item::stockFor([$item->id])[$item->id] ?? 0,
            'warranty' => $item->has_warranty, 'license' => $item->is_license, 'consumable' => $item->is_consumable,
        ]]);
    }

    private function list($rows): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $rows->values()]);
    }
}
