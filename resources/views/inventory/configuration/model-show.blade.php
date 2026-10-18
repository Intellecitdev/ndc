@php
    $p = 'inventory/configuration/models';
    $status = ['Y' => 'Active', 'N' => 'In Active'];
    $sections = ['port' => ['Ports', 'Port', $record->ports], 'layer' => ['Layers', 'Layer', $record->layers], 'capacity' => ['Capacities', 'Capacity', $record->capacities]];
@endphp
<x-layouts.app title="Models" module="inventory">
    <div x-data="{ edit: {}, add: {}, deleteUrl: '' }">
        <x-card title="Model Details" :back="url($p)" class="mb-2">
            <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Model</th><th>Brand</th><th>Category</th><th>Status</th></tr></thead>
                <tbody><tr>
                    <td>{{ $record->id }}</td><td>{{ $record->name }}</td><td>{{ $record->brand?->name }}</td>
                    <td>{{ $record->category?->name }}</td><td>{{ $record->status ? 'Active' : 'InActive' }}</td>
                </tr></tbody>
            </table>
        </x-card>

        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
            @foreach ($sections as $type => [$title, $label, $rows])
                <x-card :title="$title" class="mb-2">
                    <x-slot:actions>
                        @canmenu($p, 'edit')
                            <button class="btn btn-sm btn-primary" title="Add {{ $label }}"
                                    @click="add = @js(['url' => route('inventory.configuration.models.attribute.store', [$record->id, $type]), 'label' => $label]); $dispatch('open-modal', 'addAttrModal')">
                                <i class="fa-solid fa-plus"></i>&nbsp; {{ $label }}
                            </button>
                        @endcanmenu
                    </x-slot:actions>
                    <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
                        <thead><tr><th>SL</th><th>{{ $label }}</th><th>Status</th><th class="w-20">Action</th></tr></thead>
                        <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td><td>{{ $row->name }}</td><td>{{ $row->status ? 'Active' : 'InActive' }}</td>
                                <td>
                                    @canmenu($p, 'edit')
                                        <div class="flex justify-center gap-1">
                                            <button title="Edit" class="btn btn-sm btn-warning"
                                                    @click="edit = @js(['url' => route('inventory.configuration.models.attribute.update', [$type, $row->id]), 'label' => $label, 'Name' => $row->name, 'C4S' => $row->status ? 'Y' : 'N']); $dispatch('open-modal', 'editAttrModal')">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button title="Delete" class="btn btn-sm btn-danger"
                                                    @click="deleteUrl = @js(route('inventory.configuration.models.attribute.destroy', [$type, $row->id])); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    @endcanmenu
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">No items found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </x-card>
            @endforeach
        </div>

        <x-modal name="addAttrModal">
            <form x-data="ajaxForm" :action="add.url" @submit.prevent="submit">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add <span x-text="add.label"></span></h5>
                    <button type="button" class="btn-close" @click="show = false">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label" x-text="add.label"></label><input name="Name" class="form-control" maxlength="50" required :placeholder="add.label"></div>
                    <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                    <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
                </div>
            </form>
        </x-modal>

        <x-modal name="editAttrModal">
            <form x-data="ajaxForm" :action="edit.url" data-method="PATCH" @submit.prevent="submit">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit <span x-text="edit.label"></span></h5>
                    <button type="button" class="btn-close" @click="show = false">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label" x-text="edit.label"></label><input name="Name" class="form-control" maxlength="50" required x-model="edit.Name"></div>
                    <x-form.select label="Status" name="C4S" :options="$status" required x-model="edit.C4S" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" :disabled="busy"><i class="fa-regular fa-floppy-disk"></i> Update</button>
                    <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
                </div>
            </form>
        </x-modal>

        <x-delete-modal entity="record" />
    </div>
</x-layouts.app>
