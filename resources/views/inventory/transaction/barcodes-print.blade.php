{{-- Barcode labels only; opens the print dialog on load (loaded in a hidden frame by the Bar Codes pages). --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bar Code Print</title>
    <style>
        @page { margin: 6mm; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #000; background: #fff; }
        .labels { display: flex; flex-wrap: wrap; gap: 3mm; }
        .label { width: 50mm; height: 25mm; padding: 1.5mm 2mm; border: 1px dashed #999; text-align: center; overflow: hidden;
                 display: flex; flex-direction: column; justify-content: center; align-items: center; page-break-inside: avoid; break-inside: avoid; }
        .label .name { font-size: 7.5pt; font-weight: bold; line-height: 1.1; max-height: 2.2em; overflow: hidden; }
        .label img { width: 44mm; height: 10mm; margin: 1mm 0 .5mm; }
        .label .serial { font-size: 9pt; font-weight: bold; letter-spacing: .5px; }
        @media print { .label { border-color: #ccc; } }
    </style>
</head>
<body>
    <div class="labels">
        @foreach ($stocks as $stock)
            @php $uri = $stock->barcodeDataUri(); @endphp
            @for ($i = 0; $i < $copies; $i++)
                <div class="label">
                    <div class="name">{{ $stock->item->name }}</div>
                    <img src="{{ $uri }}" alt="{{ $stock->label() }}">
                    <div class="serial">{{ $stock->label() }}</div>
                </div>
            @endfor
        @endforeach
    </div>
    <script>
        window.addEventListener('load', () => { window.focus(); window.print(); });
    </script>
</body>
</html>
