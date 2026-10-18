@php
    $editing = $order->exists;
@endphp
<x-layouts.app title="Purchase Orders" module="inventory">
    <div class="card mb-2"
         x-data="{
            lines: @js($lines), qty: 0, preview: @js($order->attachment && ! str_ends_with($order->attachment, '.pdf') ? route('attachments.purchaseorder', $order) : ''),
            async addLine(sel, opts) {
                if (! sel.ItemID || this.qty <= 0) return toast('error', 'Item and Quantity required!', 'Error Alert');
                if (this.lines.some(l => String(l.pid) === String(sel.ItemID))) return toast('error', 'This item is already added!', 'Error Alert');
                const { data } = await axios.get(@js(url('inventory/getitemdetails')) + '/' + sel.ItemID);
                this.lines.push({ pid: data.data.id, code: data.data.code, name: data.data.name, qty: Number(this.qty), received: 0 });
                sel.ItemID = ''; this.qty = 0;
            },
            fileChanged(e) {
                const f = e.target.files[0];
                if (! f) return (this.preview = '');
                if (! ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'].includes(f.type)) {
                    toast('error', 'Only images(jpg,jpeg,png) or PDFs are allowed.', 'Error Alert'); e.target.value = ''; return (this.preview = '');
                }
                this.preview = f.type === 'application/pdf' ? '' : URL.createObjectURL(f);
            },
         }">
        <div class="card-header">
            <h3 class="card-title">{{ $editing ? 'Edit Purchase Order' : 'Create Purchase Order' }}</h3>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('inventory.purchase.purchaseorders.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
        </div>
        <form x-data="ajaxForm" @submit.prevent="submit" enctype="multipart/form-data"
              action="{{ $editing ? route('inventory.purchase.purchaseorders.update', $order) : route('inventory.purchase.purchaseorders.store') }}"
              data-method="{{ $editing ? 'PUT' : 'POST' }}">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-2 p-[5px] md:grid-cols-2">
                    <div class="p-[5px]">
                        <h6 class="text-primary mb-2">Supplier and PO Info...</h6>
                        <table class="table table-bordered table-striped [&_td:first-child]:w-1/4">
                            <tr><td>Date *</td><td><input required class="form-control" placeholder="Date" name="Date" type="text" value="{{ $order->date?->format('Y-m-d') }}" x-datepicker></td></tr>
                            <tr><td>Supplier *</td><td>
                                <select required class="form-select" name="SupplierID" x-select2>
                                    <option value="">Select One</option>
                                    @foreach ($suppliers as $id => $name)<option value="{{ $id }}" @selected($order->supplier_id == $id)>{{ $name }}</option>@endforeach
                                </select></td></tr>
                            <tr><td>Financial Year *</td><td>
                                <select required class="form-select" name="FinYearID">
                                    <option value="">Select One</option>
                                    @foreach ($finYears as $id => $name)<option value="{{ $id }}" @selected(($order->financial_year_id ?? $currentFinYear) == $id)>{{ $name }}</option>@endforeach
                                </select></td></tr>
                            <tr><td>Reference No *</td><td><input required maxlength="250" class="form-control" placeholder="Reference No" name="ReferenceNo" type="text" value="{{ $order->reference_no }}"></td></tr>
                            <tr><td>Priority Level *</td><td>
                                <select required class="form-select" name="Priority">
                                    <option value="">Select One</option>
                                    @foreach (\App\Models\PurchaseOrder::PRIORITIES as $id => $name)<option value="{{ $id }}" @selected($order->priority == $id)>{{ $name }}</option>@endforeach
                                </select></td></tr>
                            <tr><td>Scan Copy</td><td>
                                <input class="form-control" accept="image/*,application/pdf" name="attchfile" type="file" @change="fileChanged">
                                @if ($order->attachment)<a href="{{ route('attachments.purchaseorder', $order) }}" target="_blank" class="text-sm">Current file</a>@endif
                                <div class="mt-2" x-show="preview"><img :src="preview" class="h-20" alt=""></div>
                            </td></tr>
                            <tr><td>Comments</td><td><textarea maxlength="250" class="form-control" rows="2" placeholder="Comments" name="Comments">{{ $order->comments }}</textarea></td></tr>
                        </table>
                    </div>
                    <div class="p-[5px]" x-data="cascade(@js(url('inventory')), {}, true)">
                        <h6 class="text-primary mb-2">Product Info...</h6>
                        <table class="table table-bordered table-striped [&_td:first-child]:w-1/4 [&_label]:hidden [&_.mb-2]:mb-0">
                            <tr><td>Parent Category *</td><td>
                                <select class="form-select" x-model="sel.ParentCatID" @change="changed('ParentCatID')">
                                    <option value="">Select One</option>
                                    @foreach ($parents as $id => $name)<option value="{{ $id }}">{{ $name }}</option>@endforeach
                                </select></td></tr>
                            <tr><td>Category *</td><td><x-form.cascade-select label="Category" name="CategoryID" list="categories" wrapper="" form="none" /></td></tr>
                            <tr><td>Brand</td><td><x-form.cascade-select label="Brand" name="BrandID" list="brands" wrapper="" form="none" /></td></tr>
                            <tr><td>Model</td><td><x-form.cascade-select label="Model" name="ModelID" list="models" wrapper="" form="none" /></td></tr>
                            <tr><td>Port</td><td><x-form.cascade-select label="Port" name="PortID" list="ports" wrapper="" form="none" /></td></tr>
                            <tr><td>Layer</td><td><x-form.cascade-select label="Layer" name="LayerID" list="layers" wrapper="" form="none" /></td></tr>
                            <tr><td>Capacity</td><td><x-form.cascade-select label="Capacity" name="CapacityID" list="capacities" wrapper="" form="none" /></td></tr>
                            <tr><td>Item *</td><td><x-form.cascade-select label="Item" name="ItemID" list="items" wrapper="" form="none" /></td></tr>
                            <tr><td>Order Quantity *</td><td><input min="0" class="form-control" placeholder="Quantity" type="number" x-model="qty" form="none"></td></tr>
                        </table>
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-primary" @click="addLine(sel, opts)">Add Item</button>
                        </div>
                    </div>
                </div>
                <div class="p-[5px]">
                    <table class="table table-bordered [&_td]:text-center">
                        <thead><tr><td class="w-[10%] font-bold">SL</td><td class="w-[30%] font-bold">Product Code</td><td class="w-[30%] font-bold">Product Name</td><td class="w-[20%] font-bold">Required Qty</td><td class="w-[10%] font-bold">Action</td></tr></thead>
                        <tbody>
                        <template x-for="(l, i) in lines" :key="l.pid">
                            <tr>
                                <td x-text="i + 1"></td>
                                <td x-text="l.code"></td>
                                <td x-text="l.name"></td>
                                <td>
                                    <input type="number" class="form-control" required :min="Math.max(1, l.received || 0)" :name="`items[${i}][qty]`" x-model="l.qty">
                                    <small class="text-bs-secondary" x-show="l.received > 0" x-text="`Received: ${l.received}`"></small>
                                </td>
                                <td>
                                    <input type="hidden" :name="`items[${i}][pid]`" :value="l.pid">
                                    <button type="button" class="btn btn-sm btn-danger" @click="lines.splice(i, 1)" :disabled="l.received > 0"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer !p-[5px] text-right">
                <button type="submit" class="btn {{ $editing ? 'btn-warning' : 'btn-success' }}" :disabled="busy"><i class="fa-solid fa-floppy-disk"></i> {{ $editing ? 'Update Purchase Order' : 'Save Purchase Order' }}</button>
            </div>
        </form>
    </div>
</x-layouts.app>
