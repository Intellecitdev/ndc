@php $p = 'inventory/configuration/models'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Models" module="inventory">
    {{-- brands[] is loaded for the chosen category (add and edit share it). --}}
    <div x-data="{
            edit: {}, deleteUrl: '', brands: [],
            async loadBrands(cat) { this.brands = cat ? (await axios.get(@js(url('inventory/getbrandlist')) + '/' + cat)).data.data : []; },
         }">
        <x-card title="Models" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="brands = []; $dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Model</button>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['Model' => 'Model...', 'Brand' => 'Brand...', 'Category' => 'Category...']" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Model</th><th>Brand</th><th>Category</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->name }}</td><td>{{ $r->brand?->name }}</td><td>{{ $r->category?->name }}</td><td>{{ $r->status ? 'Active' : 'InActive' }} <x-approval-badge :record="$r" /></td>
                        <td>
                            <div class="flex justify-center gap-1">
                                <a href="{{ url($p.'/'.$r->id) }}" title="View" class="btn btn-sm btn-info"><i class="fa-solid fa-plus"></i></a>
                                @canmenu($p, 'edit')
                                    <button title="Edit" class="btn btn-sm btn-warning"
                                            @click="edit = @js(['url' => url($p.'/'.$r->id), 'CategoryID' => (string) $r->category_id, 'BrandID' => (string) $r->brand_id, 'Model' => $r->name, 'C4S' => $r->status ? 'Y' : 'N']);
                                                    await loadBrands(edit.CategoryID); $dispatch('open-modal', 'editModal'); $nextTick(() => edit.BrandID = @js((string) $r->brand_id))">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcanmenu
                                @canmenu($p, 'delete')
                                    <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(url($p.'/'.$r->id)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                @endcanmenu
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Model'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.select label="Category" name="CategoryID" :options="$categories" placeholder="Select One" required
                               :x-model="$bind ? 'edit.CategoryID' : null" x-on:change="loadBrands($event.target.value)" />
                <div class="mb-2">
                    <label class="form-label">Brand</label>
                    <select name="BrandID" class="form-select" required @if ($bind) x-model="edit.BrandID" @endif>
                        <option value="">Select One</option>
                        <template x-for="b in brands" :key="b.id"><option :value="String(b.id)" x-text="b.name"></option></template>
                    </select>
                </div>
                <x-form.input label="Model" name="Model" maxlength="20" required :x-model="$bind ? 'edit.Model' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Model" />
    </div>
</x-layouts.app>
