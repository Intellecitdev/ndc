@php
    $editing = $item->exists;
    $initial = [
        'ParentCatID' => (string) $item->parent_category_id, 'CategoryID' => (string) $item->category_id,
        'BrandID' => (string) $item->brand_id, 'ModelID' => (string) $item->product_model_id,
        'PortID' => (string) $item->port_id, 'LayerID' => (string) $item->layer_id, 'CapacityID' => (string) $item->capacity_id,
    ];
    $yesNo = ['1' => 'Yes', '0' => 'No'];
@endphp
<x-layouts.app title="Items" module="inventory">
    <div class="card" x-data="cascade(@js(url('inventory')), @js(array_filter($initial)))">
        <div class="card-header">
            <h3 class="card-title">{{ $editing ? 'Item Edit' : 'Item Create' }}</h3>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('inventory.configuration.items.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
        </div>
        <form x-data="ajaxForm" @submit.prevent="submit"
              action="{{ $editing ? route('inventory.configuration.items.update', $item) : route('inventory.configuration.items.store') }}"
              data-method="{{ $editing ? 'PUT' : 'POST' }}">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <div>
                        <x-form.select label="Parent Category" name="ParentCatID" :options="$parents" placeholder="Select One" required
                                       x-model="sel.ParentCatID" x-on:change="changed('ParentCatID')" />
                        <x-form.cascade-select label="Category" name="CategoryID" list="categories" required />
                        <x-form.cascade-select label="Brand" name="BrandID" list="brands" />
                        <x-form.cascade-select label="Model" name="ModelID" list="models" />
                        <x-form.cascade-select label="Port" name="PortID" list="ports" />
                        <x-form.cascade-select label="Layer" name="LayerID" list="layers" />
                        <x-form.cascade-select label="Capacity" name="CapacityID" list="capacities" />
                    </div>
                    <div>
                        <x-form.select label="Unit" name="UnitID" :options="$units" placeholder="Select One" :selected="$item->item_unit_id" required />
                        <x-form.input label="Item Code" name="Code" maxlength="30" required value="{{ $item->code }}" />
                        <x-form.input label="Item Name" name="Name" maxlength="200" required value="{{ $item->name }}" />
                        <x-form.input label="Description" name="Description" type="textarea" maxlength="500" rows="4">{{ $item->description }}</x-form.input>
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                            <x-form.select label="Has Warranty?" name="Warranty" :options="$yesNo" :selected="(int) $item->has_warranty" required />
                            <x-form.select label="License Item?" name="License" :options="$yesNo" :selected="(int) $item->is_license" required />
                            <x-form.select label="Consumable Item?" name="Consumable" :options="$yesNo" :selected="(int) $item->is_consumable" required />
                            <x-form.select label="Status" name="C4S" :options="['Y' => 'Active', 'N' => 'In Active']" :selected="$item->status ? 'Y' : 'N'" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer flex justify-end gap-2 !py-2">
                @if ($editing)
                    <button type="submit" class="btn btn-warning" :disabled="busy"><i class="fa-regular fa-floppy-disk"></i> Update</button>
                @else
                    <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                @endif
                <a href="{{ route('inventory.configuration.items.index') }}" class="btn btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
