{{-- Bulk barcode print: scan (Enter / paste / fast scanner input) or search, pick products, print all labels at once. --}}
<x-layouts.app title="Bar Codes" module="inventory">
    <div x-data="{
        selected: [], results: [], term: '', searching: false, scanning: false, copies: 1, timer: null, firstKeyAt: 0,
        url: @js(route('inventory.transaction.barcodes.search')),
        has(id) { return this.selected.some(r => r.id === id); },
        add(row, quiet = false) {
            if (this.has(row.id)) return quiet || toast('error', 'Already Added!', 'Error Alert');
            this.selected.push(row);
        },
        typed(input) {
            clearTimeout(this.timer);
            const len = input.value.trim().length;
            if (len <= 1) this.firstKeyAt = Date.now();
            if (len < 3) return;
            if ((Date.now() - this.firstKeyAt) / (len - 1) < 40) this.timer = setTimeout(() => this.scan(input), 250);
        },
        async scan(input) {
            clearTimeout(this.timer);
            const code = input.value.trim();
            if (!code || this.scanning) return;
            this.scanning = true;
            try {
                const { data } = await window.axios.get(this.url, { params: { code } });
                const row = data.rows?.[0];
                if (!row) toast('error', `No product found for &quot;${code}&quot;.`, 'Error Alert');
                else if (!this.has(row.id)) { this.add(row); toast('success', `${row.serial} added to the list.`, 'Success Alert'); }
                else toast('error', 'Already Added!', 'Error Alert');
            } catch (e) {
                toast('error', 'Something went wrong! Try again.', 'Error Alert');
            } finally {
                input.value = '';
                input.focus();
                this.scanning = false;
            }
        },
        async search() {
            if (!this.term.trim()) return (this.results = []);
            this.searching = true;
            try {
                const { data } = await window.axios.get(this.url, { params: { q: this.term.trim() } });
                this.results = data.rows || [];
                if (!this.results.length) toast('error', 'No product found.', 'Error Alert');
            } catch (e) {
                toast('error', 'Something went wrong! Try again.', 'Error Alert');
            } finally {
                this.searching = false;
            }
        },
        addAll() { this.results.forEach(r => this.add(r, true)); },
    }">
        <x-card title="Bar Codes >> Bulk Print" :back="route('inventory.transaction.barcodes.index')" class="mb-2">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div>
                    <label class="form-label" for="ScanBox"><i class="fa-solid fa-barcode"></i>&nbsp; Scan</label>
                    <input id="ScanBox" type="text" class="form-control" autofocus autocomplete="off" placeholder="Scan Barcode or Product Serial"
                           @keydown.enter.prevent="scan($event.target)" @paste="setTimeout(() => scan($event.target), 0)" @input="typed($event.target)">
                </div>
                <div>
                    <label class="form-label" for="SearchBox"><i class="fa-solid fa-magnifying-glass"></i>&nbsp; Search</label>
                    <form class="flex" @submit.prevent="search">
                        <input id="SearchBox" type="text" class="form-control !rounded-r-none" autocomplete="off" placeholder="Product Serial, Item Code or Product Name" x-model="term">
                        <button type="submit" class="btn btn-primary !rounded-l-none" :disabled="searching">Search</button>
                    </form>
                </div>
            </div>

            <template x-if="results.length">
                <div class="mt-3">
                    <div class="mb-2 flex items-center justify-between">
                        <b>Search Results (<span x-text="results.length"></span>)</b>
                        <div class="flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" @click="addAll()">Add All <i class="fa-solid fa-angles-down"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" @click="results = []">Clear</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                            <thead><tr><th>#</th><th>Product Serial</th><th>Product Name</th><th>Product Category</th><th>Supplier</th><th>Status</th><th class="w-[120px]">Action</th></tr></thead>
                            <tbody>
                            <template x-for="(r, i) in results" :key="r.id">
                                <tr>
                                    <td x-text="i + 1"></td><td x-text="r.serial"></td><td x-text="r.name"></td><td x-text="r.category"></td><td x-text="r.supplier"></td><td x-text="r.status"></td>
                                    <td>
                                        <button type="button" class="btn btn-sm" :class="has(r.id) ? 'btn-success' : 'btn-primary'" :disabled="has(r.id)" @click="add(r)">
                                            <span x-text="has(r.id) ? 'Added' : 'Add to List'"></span>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </x-card>

        <x-card title="Selected for Print">
            <x-slot:actions>
                <label class="flex items-center gap-2 whitespace-nowrap">Copies
                    <input type="number" min="1" max="50" class="form-control w-20" x-model.number="copies">
                </label>
                <button type="button" class="btn btn-outline-danger" :disabled="!selected.length" @click="selected = []"><i class="fa-solid fa-trash"></i>&nbsp; Clear</button>
                <button type="button" class="btn btn-success" :disabled="!selected.length" @click="printBarcodes(selected.map(r => r.id), copies || 1)">
                    <i class="fa-solid fa-print"></i>&nbsp; Print (<span x-text="selected.length"></span>)
                </button>
            </x-slot:actions>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Product Serial</th><th>Product Name</th><th>Product Category</th><th>Supplier</th><th class="w-[80px]">Action</th></tr></thead>
                    <tbody>
                    <template x-for="(r, i) in selected" :key="r.id">
                        <tr>
                            <td x-text="i + 1"></td><td x-text="r.serial"></td><td x-text="r.name"></td><td x-text="r.category"></td><td x-text="r.supplier"></td>
                            <td><button type="button" class="btn btn-sm btn-danger" title="Remove" @click="selected.splice(i, 1)"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </template>
                    <tr x-show="!selected.length"><td colspan="6">Scan or search products to add them here.</td></tr>
                    </tbody>
                </table>
            </div>
        </x-card>
        @include('inventory.transaction._barcode-print-frame')
    </div>
</x-layouts.app>
