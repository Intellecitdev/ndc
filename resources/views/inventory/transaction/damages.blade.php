@php $p = 'inventory/transaction/damages'; @endphp
<x-layouts.app title="Damages" module="inventory">
    <div x-data="{ edit: {}, url: '', stocks: @js($stocks), pick: '' }">
        <x-card title="Damages" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="pick = ''; $dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Damage</button>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['Serial' => 'Product Serial', 'Name' => 'Product Name']" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Item Serial No</th><th>Item Name</th><th>Quantity</th><th>Reason</th><th>Date</th><th>Declare By</th><th>Remarks</th><th>Coverage</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($damages as $d)
                        <tr>
                            <td>{{ $d->id }}</td><td>{{ $d->stock->label() }}</td><td>{{ $d->stock->item->name }}</td><td>{{ $d->quantity }}</td>
                            <td class="!text-left">{{ $d->reason }}</td><td>{{ $d->date->format('d-m-Y') }}</td><td>{{ $d->creator?->full_name }}</td>
                            <td class="!text-left">{{ $d->remarks }}</td><td>{{ $d->stock->coverage_type }}</td>
                            <td>
                                <span class="badge {{ ['Pending' => 'text-bg-warning', 'Approved' => 'text-bg-success', 'Declined' => 'text-bg-danger'][$d->status] }}">{{ $d->status }}</span>
                                @if ($d->claim)<br><small>{{ $d->claim->type }}: {{ $d->claim->status }}</small>@endif
                            </td>
                            <td>
                                @canmenu($p, 'edit')
                                    @php $u = route('inventory.transaction.damages.update', $d); @endphp
                                    <div class="flex justify-center gap-1">
                                        @if ($d->status === 'Pending')
                                            <button title="Edit" class="btn btn-sm btn-warning"
                                                    @click="edit = @js(['url' => $u, 'Date' => $d->date->format('Y-m-d'), 'Reason' => $d->reason, 'Actions' => $d->actions, 'Remarks' => $d->remarks]); $dispatch('open-modal', 'editModal')"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button title="Approval Actions" class="btn btn-sm btn-primary" @click="url = @js($u); $dispatch('open-modal', 'approveModal')"><i class="fa-solid fa-user-check"></i></button>
                                        @elseif ($d->status === 'Approved' && ! $d->claim)
                                            @if ($d->stock->coverage_type !== 'Service')
                                                <button title="Claim Warranty" class="btn btn-sm btn-info" @click="url = @js($u); $dispatch('open-modal', 'warrantyModal')"><i class="fa-solid fa-shield-halved"></i></button>
                                            @endif
                                            <button title="Claim Service" class="btn btn-sm btn-secondary" @click="url = @js($u); $dispatch('open-modal', 'serviceModal')"><i class="fa-solid fa-screwdriver-wrench"></i></button>
                                        @endif
                                    </div>
                                @endcanmenu
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $damages->links() }}</x-slot:footer>
        </x-card>

        <x-modal-form name="addModal" title="Add Damage" :action="route('inventory.transaction.damages.store')" size="max-w-[800px]">
            <div class="grid grid-cols-1 gap-x-4 md:grid-cols-2">
                <div class="mb-2 md:col-span-2">
                    <label class="form-label">Item <small class="text-bs-warning">(Serial No | Name)</small></label>
                    <select name="RegLogID" class="form-select" required x-model="pick">
                        <option value="">Select One</option>
                        <template x-for="(s, id) in stocks" :key="id"><option :value="id" x-text="s.label"></option></template>
                    </select>
                </div>
                <div class="mb-2"><label class="form-label">Stock Quantity</label><input class="form-control" placeholder="Stock" disabled :value="stocks[pick] ? stocks[pick].qty + ' ' + (stocks[pick].unit ?? '') : ''"></div>
                <div class="mb-2"><label class="form-label">Damage Quantity</label><input class="form-control" placeholder="Quantity" name="Quantity" type="number" min="1" :max="stocks[pick]?.qty" :value="stocks[pick]?.qty"></div>
            </div>
            <x-form.input label="Reason" name="Reason" type="textarea" required />
            <x-form.input label="Taken Actions" name="Actions" type="textarea" required />
            <x-form.input label="Remarks" name="Remarks" type="textarea" />
        </x-modal-form>

        <x-modal-form name="editModal" title="Edit Damage" icon="fa-solid fa-pen-to-square" bind-action="edit.url" method="PATCH" submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
            <input type="hidden" name="formNo" value="1">
            <x-form.input label="Date" name="Date" x-model="edit.Date" x-datepicker required />
            <x-form.input label="Reason" name="Reason" type="textarea" x-model="edit.Reason" required />
            <x-form.input label="Taken Actions" name="Actions" type="textarea" x-model="edit.Actions" required />
            <x-form.input label="Remarks" name="Remarks" type="textarea" x-model="edit.Remarks" />
        </x-modal-form>

        <x-modal-form name="approveModal" title="Approval Actions" icon="fa-solid fa-user-check" bind-action="url" method="PATCH" submit="Submit" submit-class="btn-primary" submit-icon="fa-solid fa-check">
            <input type="hidden" name="formNo" value="2">
            <x-form.select label="Action" name="Approve" :options="['Approved' => 'Approved', 'Declined' => 'Declined']" placeholder="Select One" required />
        </x-modal-form>

        <x-confirm-modal name="warrantyModal" bind-action="url" method="PATCH" message="Are you sure you want to Claim Warranty for this product?" submit="Claim Warranty" submit-class="btn-info">
            <input type="hidden" name="formNo" value="3">
        </x-confirm-modal>
        <x-confirm-modal name="serviceModal" bind-action="url" method="PATCH" message="Are you sure you want to Claim Service for this product?" submit="Claim Service" submit-class="btn-secondary">
            <input type="hidden" name="formNo" value="4">
        </x-confirm-modal>
    </div>
</x-layouts.app>
