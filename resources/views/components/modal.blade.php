@props(['name', 'size' => 'max-w-[500px]'])
{{-- Bootstrap-style modal driven by Alpine. Open with $dispatch('open-modal', '{{ $name }}'). --}}
<div x-data="{ show: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}' || $event.detail === '*') show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show" x-cloak
     class="fixed inset-0 z-50 overflow-y-auto">
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-black/45 backdrop-blur-[2px]" @click="show = false"></div>
    <div x-show="show" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="-translate-y-12 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition duration-150" x-transition:leave-end="opacity-0"
         class="relative mx-auto my-7 w-[calc(100%-1rem)] {{ $size }}" x-trap.noscroll="show">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
