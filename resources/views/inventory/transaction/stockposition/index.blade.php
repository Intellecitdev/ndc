@php $p = 'inventory/transaction/stockposition'; @endphp
<x-layouts.app title="Stock Position" module="inventory">
    <div x-data="{ view: {}, deploy: {}, deleteUrl: '' }">
        <x-card title="Stock Position" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <a href="{{ route('inventory.transaction.stockposition.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp; Issue Voucher</a>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['Serial' => 'Product Serial', 'Name' => 'Product Name']">
                <select class="form-select" name="CategoryID">
                    <option value="">Select Category</option>
                    @foreach ($categories as $id => $name)<option value="{{ $id }}" @selected(request('CategoryID') == $id)>{{ $name }}</option>@endforeach
                </select>
                <select class="form-select" name="TypeID">
                    <option value="">Select Type </option>
                    @foreach (\App\Models\Stock::TYPES as $id => $name)<option value="{{ $id }}" @selected(request('TypeID') == $id)>{{ $name }}</option>@endforeach
                </select>
            </x-filter-form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Product Serial</th><th>Product Name</th><th>Product Category</th><th>Quantity</th><th>Unit</th><th>Coverage</th><th>Date(From)</th><th>Date(To)</th><th>Registered By</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($stocks as $s)
                        <tr>
                            <td>{{ $s->id }}</td><td>{{ $s->label() }}</td><td>{{ $s->item->name }}</td><td>{{ $s->item->category?->name }}</td>
                            <td>{{ $s->quantity }}</td><td>{{ $s->item->unit?->name }}</td><td>{{ $s->coverage_type }}</td>
                            <td>{{ $s->coverage_start?->format('d-m-Y') }}</td><td>{{ $s->coverage_end?->format('d-m-Y') }}</td>
                            <td>{{ $s->creator?->full_name }}</td>
                            <td><span class="badge {{ $s->statusBadge() }}">{{ $s->status }}</span></td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    <button title="Item Details" class="btn btn-sm btn-info" @click="view = @js($s->details()); $dispatch('open-modal', 'viewModal')"><i class="fa-solid fa-eye"></i></button>
                                    @if ($s->status === \App\Models\Stock::IN_STOCK)
                                        @if ($s->canDeploy())
                                        @canmenu($p, 'edit')
                                            <button title="Deploy" class="btn btn-sm btn-success"
                                                    @click="deploy = @js(['url' => route('inventory.transaction.stockposition.update', $s), 'name' => $s->item->name, 'serial' => $s->label(), 'quantity' => $s->quantity, 'unit' => $s->item->unit?->name, 'license' => $s->item->is_license]); $dispatch('open-modal', 'deployModal')">
                                                <i class="fa-solid fa-check-double"></i>
                                            </button>
                                        @endcanmenu
                                        @endif
                                        @canmenu($p, 'delete')
                                            <button title="Item Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('inventory.transaction.stockposition.destroy', $s)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                        @endcanmenu
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $stocks->links() }}</x-slot:footer>
        </x-card>

        @include('inventory.transaction._stock-details-modal')

        <x-modal-form name="deployModal" title="Stock Deployment" icon="fa-solid fa-check-double" bind-action="deploy.url" method="PATCH"
                      submit="Save Deploy" submit-class="btn-primary" submit-icon="fa-solid fa-check-double" size="max-w-[800px]">
            <div class="grid grid-cols-1 gap-x-4 md:grid-cols-2">
                <div class="mb-2"><label class="form-label">Item Name</label><input disabled class="form-control" placeholder="Item Name" :value="deploy.name"></div>
                <div class="mb-2"><label class="form-label">Item Serial Number</label><input disabled class="form-control" placeholder="Item Serial Number" :value="deploy.serial"></div>
                <div class="mb-2"><label class="form-label">Item Stock</label><input disabled class="form-control" placeholder="Item Stock" :value="deploy.quantity + ' ' + (deploy.unit ?? '')"></div>
                <div class="mb-2"><label class="form-label">Deploy Quantity</label><input required min="1" :max="deploy.quantity" class="form-control" name="Quantity" type="number" placeholder="Deploy Quantity"></div>
                <x-form.select label="Unit Name" name="Unit" :options="$units" placeholder="Select One" required />
                <x-form.input label="Deploy Date" name="DeployDate" value="{{ now()->format('Y-m-d') }}" x-datepicker required />
                <x-form.input label="Assigned Personnel" name="Personnel" maxlength="150" required />
                <x-form.input label="Comments" name="Comments" type="textarea" maxlength="250" />
            </div>
            <template x-if="deploy.license">
                <div class="grid grid-cols-1 gap-x-4 border-t border-bs-border pt-2 md:grid-cols-2">
                    <x-form.input label="Product Key" name="ProductKey" maxlength="100" required />
                    <x-form.input label="Manufacturer Name" name="ManufacturerName" maxlength="100" required />
                    <x-form.input label="Licensed To Name" name="LicensedToName" maxlength="100" required />
                    <x-form.input label="Licensed To Email" name="LicensedToEmail" type="email" maxlength="100" required />
                    <x-form.select label="Renewable ?" name="ReAssignable" :options="['0' => 'No', '1' => 'Yes']" selected="0" required />
                    <x-form.input label="Purchase Date" name="PurchaseDate" value="{{ now()->format('Y-m-d') }}" x-datepicker required />
                    <x-form.input label="Expiration Date" name="ExpirationDate" value="{{ now()->format('Y-m-d') }}" x-datepicker required />
                    <x-form.input label="Note" name="Note" type="textarea" maxlength="250" />
                </div>
            </template>
        </x-modal-form>

        <x-confirm-modal name="deleteModal" bind-action="deleteUrl" method="DELETE" message="Are you sure you want to delete this item from stock?"
                         submit="Delete" submit-class="btn-danger" submit-icon="fa-solid fa-trash" />
    </div>
</x-layouts.app>
