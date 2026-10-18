<?php

namespace App\Http\Controllers\Inventory\Configuration;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\ParentCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    use JsonResponses;

    private const RELATIONS = ['parentCategory', 'category', 'brand', 'productModel', 'port', 'layer', 'capacity', 'unit'];

    public function index(Request $request): View
    {
        $like = fn ($rel, $field) => fn ($q) => $q->whereHas($rel, fn ($q) => $q->where('name', 'like', '%'.$request->input($field).'%'));

        $items = Item::with(self::RELATIONS)
            ->when($request->filled('code'), fn ($q) => $q->where('code', 'like', "%{$request->code}%"))
            ->when($request->filled('name'), fn ($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->filled('category'), $like('category', 'category'))
            ->when($request->filled('parent'), $like('parentCategory', 'parent'))
            ->when($request->filled('brand'), $like('brand', 'brand'))
            ->when($request->filled('model'), $like('productModel', 'model'))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.configuration.items.index', [
            'items' => $items,
            'stock' => Item::stockFor($items->pluck('id')->all()),
        ]);
    }

    public function create(): View
    {
        return view('inventory.configuration.items.form', ['item' => new Item(['status' => true])] + $this->options());
    }

    public function store(Request $request): JsonResponse
    {
        $item = Item::create($this->payload($this->check($request, $this->rules(), $this->attributes())));

        return $this->ok($item->isPending() ? 'Item submitted for QM approval.' : 'Item created successfully.', ['redirect' => route('inventory.configuration.items.show', $item)]);
    }

    public function show(Item $item): View
    {
        $item->load(self::RELATIONS);

        return view('inventory.configuration.items.show', ['item' => $item, 'stats' => $item->statistics()]);
    }

    public function edit(Item $item): View
    {
        return view('inventory.configuration.items.form', ['item' => $item] + $this->options());
    }

    public function update(Request $request, Item $item): JsonResponse
    {
        $item->update($this->payload($this->check($request, $this->rules($item), $this->attributes())));

        return $this->ok('Item updated successfully.', ['redirect' => route('inventory.configuration.items.show', $item)]);
    }

    public function destroy(Item $item): JsonResponse
    {
        try {
            $item->delete();
        } catch (QueryException) {
            return $this->fail('This Item is in use and can not be deleted.');
        }

        return $this->ok('Item deleted successfully.', ['id' => $item->id]);
    }

    private function options(): array
    {
        return [
            'parents' => ParentCategory::active()->orderBy('name')->pluck('name', 'id'),
            'units' => ItemUnit::active()->orderBy('name')->pluck('name', 'id'),
        ];
    }

    private function rules(?Item $item = null): array
    {
        $req = request();

        return [
            'ParentCatID' => ['required', 'exists:parent_categories,id'],
            'CategoryID' => ['required', Rule::exists('categories', 'id')->where('parent_category_id', $req->input('ParentCatID'))],
            'BrandID' => ['nullable', Rule::exists('brands', 'id')->where('category_id', $req->input('CategoryID'))],
            'ModelID' => ['nullable', Rule::exists('product_models', 'id')->where('brand_id', $req->input('BrandID'))],
            'PortID' => ['nullable', Rule::exists('ports', 'id')->where('product_model_id', $req->input('ModelID'))],
            'LayerID' => ['nullable', Rule::exists('layers', 'id')->where('product_model_id', $req->input('ModelID'))],
            'CapacityID' => ['nullable', Rule::exists('capacities', 'id')->where('product_model_id', $req->input('ModelID'))],
            'UnitID' => ['required', 'exists:item_units,id'],
            'Code' => ['required', 'string', 'max:30', Rule::unique('items', 'code')->ignore($item)],
            'Name' => ['required', 'string', 'max:200'],
            'Description' => ['nullable', 'string', 'max:500'],
            'Warranty' => ['required', 'boolean'],
            'Consumable' => ['required', 'boolean'],
            'License' => ['required', 'boolean'],
            'C4S' => ['required', 'in:Y,N'],
        ];
    }

    private function attributes(): array
    {
        return [
            'ParentCatID' => 'Parent Category', 'CategoryID' => 'Category', 'BrandID' => 'Brand', 'ModelID' => 'Model',
            'PortID' => 'Port', 'LayerID' => 'Layer', 'CapacityID' => 'Capacity', 'UnitID' => 'Unit',
            'Code' => 'Item Code', 'Name' => 'Item Name', 'Warranty' => 'Has Warranty?', 'Consumable' => 'Consumable Item?',
            'License' => 'License Item?', 'C4S' => 'Status',
        ];
    }

    private function payload(array $d): array
    {
        return [
            'parent_category_id' => $d['ParentCatID'], 'category_id' => $d['CategoryID'],
            'brand_id' => $d['BrandID'] ?? null, 'product_model_id' => $d['ModelID'] ?? null,
            'port_id' => $d['PortID'] ?? null, 'layer_id' => $d['LayerID'] ?? null, 'capacity_id' => $d['CapacityID'] ?? null,
            'item_unit_id' => $d['UnitID'], 'code' => $d['Code'], 'name' => $d['Name'], 'description' => $d['Description'] ?? null,
            'has_warranty' => (bool) $d['Warranty'], 'is_consumable' => (bool) $d['Consumable'], 'is_license' => (bool) $d['License'],
            'status' => $d['C4S'] === 'Y',
        ];
    }
}
