<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pdfTitle }}</title>
    <style>
        @page { margin: 20px 30px 70px 30px; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #000; }
        .head { text-align: center; position: relative; padding-bottom: 6px; border-bottom: 1px solid #000; }
        .head img { position: absolute; left: 0; top: 0; width: 70px; }
        .head h1 { font-family: 'Times New Roman', serif; font-size: 26px; margin: 8px 0 4px; }
        .head p { margin: 0; font-size: 11px; }
        .title { text-align: center; font-family: 'Times New Roman', serif; font-weight: bold; font-size: 16px; padding: 6px 0; border-bottom: 1px solid #000; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; }
        table.grid th, table.grid td { border: 1px solid #333; padding: 4px 5px; text-align: left; vertical-align: top; }
        table.grid th { background: #fff; text-align: center; }
        table.kv th { width: 15%; background: none; text-align: left; }
        .center { text-align: center !important; }
        .right { text-align: right !important; }
        footer { position: fixed; bottom: -55px; left: 0; font-size: 10px; }
        footer u { font-weight: bold; }
    </style>
    @stack('pdf-styles')
</head>
<body>
<div class="head">
    <img src="{{ public_path('images/logo.png') }}" alt="">
    <h1>{{ config('organization.name') }}</h1>
    <p>{{ config('organization.address') }}</p>
    <p>Phone: {{ config('organization.phone') }} | Email: {{ config('organization.email') }}</p>
</div>
<div class="title">{{ strtoupper($pdfTitle) }}</div>

@yield('content')

<footer>
    <u>Printed By</u><br>
    {{ auth()->user()?->name }}<br>
    {{ auth()->user()?->full_name }}<br>
    {{ now()->format('d M Y, h:i A') }}
</footer>
</body>
</html>
