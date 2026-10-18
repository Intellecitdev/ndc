{{-- "Show Stock Details" modal; expects `view` in the Alpine scope (see stockDetails()). --}}
<x-modal name="viewModal">
    <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-info"></i> Show Stock Details</h5>
        <button type="button" class="btn-close" @click="show = false">&times;</button>
    </div>
    <div class="modal-body">
        <table class="table table-bordered [&_td:first-child]:w-[30%]">
            <tr><td>1. Product Category</td><td x-text="view.category"></td></tr>
            <tr><td>2. Product Name</td><td x-text="view.name"></td></tr>
            <tr><td>3. Product Model</td><td x-text="view.model"></td></tr>
            <tr><td>4. Product Serial No</td><td x-text="view.serial"></td></tr>
            <tr><td>5. Entry Date</td><td x-text="view.date"></td></tr>
            <tr><td>6. Warranty Type</td><td x-text="view.type"></td></tr>
            <tr><td>7. Warranty/Service Info</td><td x-text="view.info"></td></tr>
            <tr><td>8. Bar code</td><td><img :src="view.barcode" alt="barcode"><br><span x-text="view.serial"></span></td></tr>
        </table>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-dark" @click="show = false">Close</button></div>
</x-modal>
