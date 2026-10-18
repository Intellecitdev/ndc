<x-layouts.app title="Stock Position" module="inventory">
    {{-- A barcode scanner types the code + Enter into the serial box: the matching in-stock row goes straight into the list. --}}
    <div x-data="{
        list: [], scanning: false, timer: null, firstKeyAt: 0,
        // Scanners without an Enter suffix: characters arrive a few ms apart, then stop.
        typed(input) {
            clearTimeout(this.timer);
            const len = input.value.trim().length;
            if (len <= 1) this.firstKeyAt = Date.now();
            if (len < 3) return;
            const perChar = (Date.now() - this.firstKeyAt) / (len - 1);
            if (perChar < 40) this.timer = setTimeout(() => this.scan(input), 250);
        },
        add(row) { if (this.list.some(r => r.rid === row.rid)) return toast('error', 'Already Added!', 'Error Alert'); this.list.push({ ...row, unitid: '' }); return true; },
        async scan(input) {
            clearTimeout(this.timer);
            const code = input.value.trim();
            if (!code || this.scanning) return;
            this.scanning = true;
            try {
                const { data: res } = await window.axios.get(@js(route('inventory.transaction.stockposition.scan')), { params: { code, except: this.list.map(r => r.rid) } });
                if (res.success && this.add(res.row)) toast('success', res.message, 'Success Alert');
                else if (!res.success) toast('error', this.list.some(r => r.serial === code) ? 'Already Added!' : res.message, 'Error Alert');
            } catch (e) {
                toast('error', 'Something went wrong! Try again.', 'Error Alert');
            } finally {
                input.value = '';
                input.focus();
                this.scanning = false;
            }
        },
    }">
        <x-card title="Stock Position >> Issue Voucher" :back="route('inventory.transaction.stockposition.index')" class="mb-2">
            <form method="GET" action="{{ route('inventory.transaction.stockposition.create') }}" class="mb-2">
                <div class="flex flex-wrap md:flex-nowrap [&>*]:!rounded-none [&>*:first-child]:!rounded-l-md [&>*:last-child]:!rounded-r-md">
                    <input type="text" name="Serial" class="form-control" autofocus autocomplete="off" value="{{ request('Serial') }}"
                           placeholder="Scan Barcode or Product Serial" title="Scan or paste a barcode, or type a serial and press Enter, to add it to the list; click Search to filter the table"
                           @keydown.enter.prevent="scan($event.target)" @paste="setTimeout(() => scan($event.target), 0)" @input="typed($event.target)">
                    <input type="text" name="Name" class="form-control" placeholder="Product Name" value="{{ request('Name') }}">
                    <select class="form-select" name="CategoryID">
                        <option value="">Select Category</option>
                        @foreach ($categories as $id => $name)<option value="{{ $id }}" @selected(request('CategoryID') == $id)>{{ $name }}</option>@endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Product Serial</th><th>Product Name</th><th>Product Category</th><th>Quantity</th><th>A/U</th><th class="w-[100px]">Status</th><th class="w-[120px]">Action</th></tr></thead>
                    <tbody>
                    @forelse ($stocks as $s)
                        <tr>
                            <td>{{ $s->id }}</td><td>{{ $s->label() }}</td><td>{{ $s->item->name }}</td><td>{{ $s->item->category?->name }}</td>
                            <td>{{ $s->quantity }}</td><td>{{ $s->item->unit?->name }}</td>
                            <td><span class="badge {{ $s->statusBadge() }}">{{ $s->status }}</span></td>
                            <td>
                                <button type="button" title="Add to List" class="btn btn-sm btn-primary"
                                        @click="add(@js(['rid' => $s->id, 'serial' => $s->label(), 'name' => $s->item->name, 'category' => $s->item->category?->name, 'quantity' => $s->quantity, 'unit' => $s->item->unit?->name]))">
                                    Add to List <i class="fa-solid fa-angles-down"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $stocks->links() }}</x-slot:footer>
        </x-card>

        <div class="card">
            <form x-data="ajaxForm" @submit.prevent="submit" action="{{ route('inventory.transaction.stockposition.store') }}">
                <div class="card-header">
                    <h3 class="card-title">List of Direct Issue</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                        <thead><tr><th class="w-[5%]">#</th><th class="w-[15%]">Product Serial</th><th class="w-[18%]">Product Name</th><th class="w-[17%]">Product Category</th><th class="w-[10%]">Quantity</th><th class="w-[10%]">A/U</th><th class="w-[20%]">To Wing</th><th class="w-[5%]">Action</th></tr></thead>
                        <tbody>
                        <template x-for="(r, i) in list" :key="r.rid">
                            <tr>
                                <td x-text="i + 1"></td><td x-text="r.serial"></td><td x-text="r.name"></td><td x-text="r.category"></td><td x-text="r.quantity"></td><td x-text="r.unit"></td>
                                <td>
                                    <select :name="`items[${i}][unitid]`" class="form-select" required x-model="r.unitid">
                                        <option value="">Select One</option>
                                        @foreach ($wings as $id => $name)<option value="{{ $id }}">{{ $name }}</option>@endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" :name="`items[${i}][rid]`" :value="r.rid">
                                    <button type="button" class="btn btn-sm btn-danger" @click="list.splice(i, 1)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer !p-[5px] text-right">
                    <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-plus"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
