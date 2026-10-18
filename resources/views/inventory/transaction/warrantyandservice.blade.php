@php $p = 'inventory/transaction/warrantyandservice'; @endphp
<x-layouts.app title="Warranty & Service" module="inventory">
    <div x-data="{ c: {} }">
        <x-card title="Warranty And Services For Claim" :back="route('inventory.dashboard')">
            <x-filter-form :action="url($p)" :fields="['Serial' => 'Product Serial', 'Name' => 'Product Name']" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Serial No</th><th>Item Name</th><th>Category</th><th>Quantity</th><th>Claim Date</th><th>Claimed Unit</th><th>Claimed By</th><th>Comments</th><th>Coverage</th><th>Date Range</th><th>Supplier</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($claims as $c)
                        @php $data = ['url' => route('inventory.transaction.warrantyandservice.update', $c), 'Comments' => $c->comments, 'ExpReturnDate' => $c->expected_return_date?->format('Y-m-d') ?? '']; @endphp
                        <tr>
                            <td>{{ $c->id }}</td><td>{{ $c->stock->label() }}</td><td>{{ $c->stock->item->name }}</td><td>{{ $c->stock->item->category?->name }}</td>
                            <td>{{ $c->stock->quantity }}</td><td>{{ $c->claim_date?->format('d-m-Y') }}</td><td>{{ $c->unit?->name }}</td><td>{{ $c->claimer?->full_name }}</td>
                            <td class="!text-left">{{ $c->comments }}</td><td>{{ $c->type }}</td><td>{{ $c->stock->coverageInfo() }}</td><td>{{ $c->stock->supplier?->name }}</td>
                            <td><span class="badge {{ ['For Claim' => 'text-bg-warning', 'Claimed' => 'text-bg-info', 'Received' => 'text-bg-success', 'Not Covered' => 'text-bg-danger'][$c->status] }}">{{ $c->status }}</span></td>
                            <td>
                                @canmenu($p, 'edit')
                                    <div class="flex justify-center gap-1">
                                        @if ($c->status === 'For Claim')
                                            <button title="Claim" class="btn btn-sm btn-primary" @click="c = @js($data); $dispatch('open-modal', 'claimModal')"><i class="fa-solid fa-paper-plane"></i></button>
                                        @elseif ($c->status === 'Claimed')
                                            <button title="Edit Claim" class="btn btn-sm btn-warning" @click="c = @js($data); $dispatch('open-modal', 'editModal')"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button title="Receive" class="btn btn-sm btn-success" @click="c = @js($data); $dispatch('open-modal', 'receiveModal')"><i class="fa-solid fa-check"></i></button>
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
            <x-slot:footer>{{ $claims->links() }}</x-slot:footer>
        </x-card>

        @foreach (['claimModal' => [1, 'Claim Warranty/Service', 'Claim'], 'editModal' => [2, 'Edit Claim', 'Update']] as $name => [$form, $title, $submit])
            <x-modal-form :name="$name" :title="$title" icon="fa-solid fa-paper-plane" bind-action="c.url" method="PATCH" :submit="$submit" submit-class="btn-warning">
                <input type="hidden" name="formNo" value="{{ $form }}">
                <x-form.input label="Comments" name="Comments" type="textarea" x-model="c.Comments" required />
                <x-form.input label="Expected Return Date" name="ExpReturnDate" x-model="c.ExpReturnDate" x-datepicker :required="$form === 2" />
                <x-form.select label="Claim Status" name="C4S" :options="['Y' => 'Active']" selected="Y" required />
            </x-modal-form>
        @endforeach

        <x-modal-form name="receiveModal" title="Warranty/Service Receive" icon="fa-solid fa-check" bind-action="c.url" method="PATCH" submit="Receive" submit-class="btn-success">
            <input type="hidden" name="formNo" value="3">
            <x-form.select label="Warranty/Service Status" name="Status" :options="\App\Models\WarrantyClaim::RECEIVE_STATUSES" placeholder="Select One" required />
        </x-modal-form>
    </div>
</x-layouts.app>
