<x-layouts.app title="Purchase Order Receive" module="inventory">
    <div class="card mb-2"
         x-data="{
            po: null, lines: [], total: 0, submits: 0,
            get anySerial() { return this.lines.some(l => ! l.consumable); },
            get anyWarranty() { return this.lines.some(l => l.warranty); },
            async loadPo(id) {
                this.po = null; this.lines = [];
                if (! id) return;
                const { data } = await axios.get(@js(url('inventory/getpurchasedetails')) + '/' + id);
                this.po = data.data;
                this.lines = data.items.filter(l => l.due_qty > 0).map(l => ({ ...l, qty: '', serials: [], type: '', startdate: '', duration: '', dtype: '', terms: '' }));
            },
            qtyChanged(l) {
                const q = Math.min(parseInt(l.qty) || 0, l.due_qty);
                if (! l.consumable) l.serials = Array.from({ length: q < 100 ? q : 0 }, (_, i) => l.serials[i] || '');
                this.total = this.lines.reduce((s, x) => s + (parseInt(x.qty) || 0), 0);
            },
            async checkSerial(value) {
                if (! value || value.length < 3) return;
                // Typing the last serial then clicking Save fires this check alongside the save: once a save
                // has started, its answer is stale (it may see the serial just saved); the save checks it itself.
                const submits = this.submits;
                const { data } = await axios.get(@js(url('inventory/serialnochecking')), { params: { Type: 1, RID: 0, SerialNo: value } });
                if (! data.success && submits === this.submits) toast('error', data.message, 'Error Alert');
            },
         }">
        <div class="card-header">
            <h3 class="card-title">Receive Purchase Order</h3>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('inventory.purchase.purchaseorderreceive.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
        </div>
        <form x-data="ajaxForm" @submit.prevent="submits++; if (total !== Number($refs.rq.value)) { $refs.rq.classList.add('is-invalid'); toast('error', 'Received Qty must equal the total receiving quantity.', 'Error Alert'); } else { $refs.rq.classList.remove('is-invalid'); submit($event) }"
              action="{{ route('inventory.purchase.purchaseorderreceive.store') }}">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-[10px] p-[5px] md:grid-cols-2">
                    <div class="p-[5px]">
                        <x-form.input label="Date" name="Date" required readonly value="{{ now()->format('Y-m-d') }}" x-datepicker />
                        <x-form.input label="Invoice No" name="InvoiceNo" maxlength="100" placeholder="Invoice No" required />
                        <div class="mb-2">
                            <label class="form-label">Received Qty</label>
                            <input class="form-control" name="ReceivedQty" type="number" placeholder="Received Qty" x-ref="rq" :value="po ? total : ''" :disabled="! po" required min="1">
                        </div>
                    </div>
                    <div class="p-[5px]">
                        <div class="mb-2">
                            <label class="form-label">Purchase Order No List</label>
                            <select class="form-select" name="POID" required @change="loadPo($event.target.value)">
                                <option value="">Select One</option>
                                @foreach ($orders as $id => $no)<option value="{{ $id }}">{{ $no }}</option>@endforeach
                            </select>
                        </div>
                        <div class="mb-2"><label class="form-label">Supplier Name</label><input class="form-control" disabled placeholder="Supplier Name" :value="po?.supplier ?? ''"></div>
                        <div class="mb-2"><label class="form-label">Financial Year</label><input class="form-control" disabled placeholder="Financial Year" :value="po?.fin_year ?? ''"></div>
                    </div>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table table-bordered [&_td]:text-center [&_td]:align-top">
                        <thead>
                        <tr class="font-bold">
                            <td class="w-[4%]">SL</td><td class="w-[12%]">Product Code</td><td class="w-[15%]">Product Name</td><td class="w-[8%]">Order Qty</td>
                            <td class="w-[8%]">Previously<br>Rcvd Qty</td><td class="w-[8%]">Due Qty</td><td class="w-[8%]">Receiving Qty</td>
                            <td class="w-[13%]" x-show="anySerial">Serial No's</td><td class="w-[20%]" x-show="anyWarranty">Warranty Info</td><td class="w-[4%]">Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <template x-for="(l, i) in lines" :key="l.id">
                            <tr>
                                <td x-text="i + 1"></td><td x-text="l.code"></td><td x-text="l.name"></td>
                                <td x-text="l.order_qty"></td><td x-text="l.received_qty"></td><td x-text="l.due_qty"></td>
                                <td>
                                    <input type="hidden" :name="`items[${i}][id]`" :value="l.id">
                                    <input type="number" class="form-control" :name="`items[${i}][qty]`" min="0" :max="l.due_qty" x-model="l.qty" @input="qtyChanged(l)">
                                </td>
                                <td x-show="anySerial">
                                    <template x-for="(s, j) in l.serials" :key="j">
                                        <input type="text" class="form-control mb-[5px]" :name="`items[${i}][serial][${j}]`" required minlength="3" maxlength="100"
                                               :placeholder="`Serial ${j + 1}`" x-model="l.serials[j]" @change="checkSerial($event.target.value)">
                                    </template>
                                </td>
                                <td x-show="anyWarranty">
                                    <template x-if="l.warranty">
                                        <div class="grid grid-cols-2 gap-1">
                                            <select class="form-select" :name="`items[${i}][type]`" x-model="l.type">
                                                <option value="">Warranty Type</option><option value="Warranty">Warranty</option><option value="Service">Service</option>
                                            </select>
                                            <select class="form-select" :name="`items[${i}][dtype]`" x-model="l.dtype" :required="!! l.type">
                                                <option value="">Duration Type</option><option>Days</option><option>Months</option><option>Years</option>
                                            </select>
                                            <input class="form-control" placeholder="Start Date" :name="`items[${i}][startdate]`" x-model="l.startdate" :required="!! l.type" x-datepicker>
                                            <input class="form-control" type="number" min="1" placeholder="Duration" :name="`items[${i}][duration]`" x-model="l.duration" :required="!! l.type">
                                            <textarea class="form-control col-span-2" rows="1" placeholder="Terms" :name="`items[${i}][terms]`" x-model="l.terms"></textarea>
                                        </div>
                                    </template>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger" title="Remove" @click="lines.splice(i, 1); total = lines.reduce((s, x) => s + (parseInt(x.qty) || 0), 0)"><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </template>
                        <tr x-show="po && ! lines.length"><td colspan="10">Nothing is due on this purchase order.</td></tr>
                        </tbody>
                    </table>
                    <p class="text-warning text-right">Make sure to entry unique Serial No, Minimum 3 digit</p>
                </div>
            </div>
            <div class="card-footer !p-[5px] text-right">
                <button type="submit" class="btn btn-success" :disabled="busy || ! po"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </div>
        </form>
    </div>
</x-layouts.app>
