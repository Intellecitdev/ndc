@php $serialStocks = $receive->stocks->whereNotNull('serial_no')->values(); @endphp
<x-layouts.app title="Purchase Order Receive" module="inventory">
    <div x-data="{ w: {} }">
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">Edit Receive Purchase Order</h3>
                <div class="ml-auto flex gap-2">
                    <a href="{{ route('inventory.purchase.purchaseorderreceive.show', $receive) }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
                </div>
            </div>
            <form x-data="ajaxForm" @submit.prevent="submit" action="{{ route('inventory.purchase.purchaseorderreceive.update', $receive) }}" data-method="PATCH">
                <input type="hidden" name="formNo" value="1">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-x-4 md:grid-cols-3">
                        <x-form.input label="Date" name="Date" required value="{{ $receive->date->format('Y-m-d') }}" x-datepicker />
                        <x-form.input label="Invoice No" name="InvoiceNo" maxlength="100" required value="{{ $receive->invoice_no }}" />
                        <x-form.input label="Received Qty" name="ReceivedQty" disabled value="{{ $receive->received_qty }}" />
                        <x-form.input label="Purchase Order" name="po" disabled value="{{ $receive->purchaseOrder?->po_no }}" />
                        <x-form.input label="Supplier" name="sup" disabled value="{{ $receive->supplier?->name }}" />
                        <x-form.input label="Financial Year" name="fy" disabled value="{{ $receive->financialYear?->name }}" />
                    </div>
                    <table class="table table-bordered mt-2 [&_td]:text-center [&_th]:text-center">
                        <thead><tr><th>SL</th><th>Product Code</th><th>Product Name</th><th>Category</th><th>Quantity</th><th>Serial No's</th></tr></thead>
                        <tbody>
                        @foreach ($receive->items as $line)
                            <tr>
                                <td>{{ $loop->iteration }}</td><td>{{ $line->item->code }}</td><td>{{ $line->item->name }}</td>
                                <td>{{ $line->item->category?->name }}</td><td>{{ $line->quantity }}</td>
                                <td>
                                    @foreach ($serialStocks->where('purchase_receive_item_id', $line->id) as $s)
                                        @php $k = $serialStocks->search($s); @endphp
                                        <input type="hidden" name="items[{{ $k }}][rid]" value="{{ $s->id }}">
                                        <input type="text" class="form-control mb-1" name="items[{{ $k }}][serial]" value="{{ $s->serial_no }}" required minlength="3" maxlength="100"
                                               @disabled($s->status !== \App\Models\Stock::IN_STOCK)>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer !p-[5px] text-right">
                    <button type="submit" class="btn btn-warning" :disabled="busy"><i class="fa-regular fa-floppy-disk"></i> Update</button>
                </div>
            </form>
        </div>

        <x-card title="Warranty Information">
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Code</th><th>Name</th><th>Serial No</th><th>Type</th><th>Duration</th><th>Start Date</th><th>End Date</th><th>Terms</th><th>Action</th></tr></thead>
                <tbody>
                @foreach ($receive->stocks->whereNull('parent_id')->filter(fn ($s) => $s->item->has_warranty) as $s)
                    <tr>
                        <td>{{ $s->id }}</td><td>{{ $s->item->code }}</td><td>{{ $s->item->name }}</td><td>{{ $s->label() }}</td>
                        <td>{{ $s->coverage_type }}</td><td>{{ $s->duration }} {{ $s->duration_type }}</td>
                        <td>{{ $s->coverage_start?->format('d-m-Y') }}</td><td>{{ $s->coverage_end?->format('d-m-Y') }}</td><td>{{ $s->coverage_terms }}</td>
                        <td>
                            <button type="button" title="Edit" class="btn btn-sm btn-warning"
                                    @click="w = @js(['wid' => $s->id, 'Type' => $s->coverage_type ?? '', 'StartDate' => $s->coverage_start?->format('Y-m-d') ?? '', 'Duration' => (string) $s->duration, 'DurationType' => $s->duration_type ?? '', 'Terms' => $s->coverage_terms]); $dispatch('open-modal', 'editModal')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-card>

        <x-modal-form name="editModal" title="Edit Warranty Information" icon="fa-solid fa-pen-to-square" :action="route('inventory.purchase.purchaseorderreceive.update', $receive)" method="PATCH"
                      submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
            <input type="hidden" name="formNo" value="2">
            <input type="hidden" name="wid" :value="w.wid">
            <x-form.select label="Type" name="Type" :options="['Warranty' => 'Warranty', 'Service' => 'Service']" placeholder="Select One" x-model="w.Type" required />
            <x-form.input label="Start Date" name="StartDate" x-model="w.StartDate" x-datepicker required />
            <div class="grid grid-cols-2 gap-x-4">
                <x-form.input label="Duration" name="Duration" type="number" min="1" x-model="w.Duration" required />
                <x-form.select label="Duration Type" name="DurationType" :options="['Days' => 'Days', 'Months' => 'Months', 'Years' => 'Years']" placeholder="Select One" x-model="w.DurationType" required />
            </div>
            <x-form.input label="Terms" name="Terms" type="textarea" rows="3" x-model="w.Terms" />
        </x-modal-form>
    </div>
</x-layouts.app>
