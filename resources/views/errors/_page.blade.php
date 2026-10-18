@php
    $segment = request()->segment(1);
    $module = array_key_exists((string) $segment, config('menu')) ? $segment : null;
@endphp
@auth
    <x-layouts.app :module="$module" :content-header="false" :title="(string) $code">
        <div class="card">
            <div class="card-body py-10 text-center">
                <i class="{{ $icon }} mb-3 text-5xl text-bs-warning"></i>
                <h3 class="mb-2">{{ $code }}</h3>
                <p class="text-bs-secondary">{{ $message }}</p>
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back to Home</a>
            </div>
        </div>
    </x-layouts.app>
@else
    <!DOCTYPE html>
    <html><head><meta charset="utf-8"><title>{{ $code }}</title></head>
    <body style="font-family: Arial, sans-serif; text-align: center; padding-top: 15vh;">
        <h1>{{ $code }}</h1><p>{{ $message }}</p><a href="{{ url('/login') }}">Login</a>
    </body></html>
@endauth
