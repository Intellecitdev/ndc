@props([
    'title' => null,
    'module' => null,
    'contentHeader' => true,
])
@php
    $menu = $module ? config("menu.$module") : null;

    // Heading + breadcrumb are derived from the URL, like the reference app.
    $segments = collect(request()->segments())->reject(fn ($s) => is_numeric($s))->values();
    $heading = ucfirst($segments->first() ?? '');
    $crumbs = $segments->map(fn ($s, $i) => [
        'label' => ucfirst($s),
        'url' => url($segments->take($i + 1)->implode('/')),
    ]);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' | ' : '' }}{{ $menu['title'] ?? 'NDC INV' }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body x-data="layout" :class="{ 'sidebar-collapsed': collapsed }" class="min-h-screen">
<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('partials.sidebar', ['menu' => $menu])

    {{-- Mobile overlay --}}
    <div x-show="mobileOpen" x-cloak x-transition.opacity @click="mobileOpen = false"
         class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>

    {{-- Margin is set server-side so the page doesn't slide in on load; it only animates on toggle. --}}
    <div class="flex min-w-0 flex-1 flex-col lg:ml-[250px]"
         :class="{ 'lg:ml-[4.6rem]!': collapsed, 'transition-[margin] duration-300': ready }">

        @include('partials.header')

        <main class="flex-1">
            @if ($contentHeader)
                <div class="px-2 py-1">
                    <div class="flex flex-col px-3 sm:flex-row sm:items-start sm:justify-between">
                        <h3 class="mb-0">
                            {{ $heading }}&nbsp;
                            <small class="text-[.875em]"><button type="button" class="btn btn-sm btn-warning align-middle" @click="$dispatch('open-bookmark')"
                                    title="Add to Bookmark this link"><i class="fa-regular fa-star"></i> Bookmark</button></small>
                        </h3>
                        <ol class="breadcrumb m-0 leading-8">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            @foreach ($crumbs as $crumb)
                                @if ($loop->last)
                                    <li class="breadcrumb-item active" aria-current="page">{{ $crumb['label'] }}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
                @include('partials.bookmark-modal', ['bookmarkTitle' => $title ?? $heading])
            @endif

            <div class="px-2">
                <div class="px-3 pt-4">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <footer class="border-t border-bs-border bg-white p-2 text-[rgba(33,37,41,.75)]">
            Powered by <a href="javascript:void(0)">NDC</a>
        </footer>
    </div>
</div>

@include('partials.toasts')
@stack('scripts')
</body>
</html>
