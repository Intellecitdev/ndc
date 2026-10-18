{{-- printBarcodes(ids, copies): prints the labels straight away from a hidden frame, without leaving the page. --}}
<script>
    window.printBarcodes = function (ids, copies = 1) {
        if (!ids.length) return window.toast('error', 'Select at least one product.', 'Error Alert');
        const params = new URLSearchParams({ copies });
        ids.forEach(id => params.append('ids[]', id));
        document.getElementById('barcodePrintFrame')?.remove();
        const frame = Object.assign(document.createElement('iframe'), { id: 'barcodePrintFrame', src: @js(route('inventory.transaction.barcodes.print')) + '?' + params });
        frame.style.cssText = 'position:fixed;width:0;height:0;border:0;right:0;bottom:0;';
        document.body.appendChild(frame);
    };
</script>
