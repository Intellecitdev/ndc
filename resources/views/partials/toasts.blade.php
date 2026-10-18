{{-- toastr-like notifications (top-right), fed by session flashes and window.toast() --}}
<div x-data class="pointer-events-none fixed top-3 right-3 z-[60] flex w-[300px] flex-col gap-2 no-print">
    <template x-for="t in $store.toasts.items" :key="t.id">
        <div x-show="t.visible" x-transition.opacity.duration.300ms @click="t.url ? (window.location.href = t.url) : $store.toasts.remove(t.id)"
             class="pointer-events-auto flex cursor-pointer gap-3 rounded-[3px] px-4 py-[15px] text-white opacity-90 shadow-[0_0_12px_#999] hover:opacity-100 hover:shadow-[0_0_12px_#000]"
             :class="{
                'bg-[#51a351]': t.type === 'success',
                'bg-[#bd362f]': t.type === 'error',
                'bg-[#2f96b4]': t.type === 'info',
                'bg-[#f89406]': t.type === 'warning',
             }">
            <i class="fa-solid mt-0.5 text-xl" :class="{
                'fa-circle-check': t.type === 'success',
                'fa-circle-xmark': t.type === 'error',
                'fa-circle-info': t.type === 'info',
                'fa-triangle-exclamation': t.type === 'warning',
             }"></i>
            <div class="min-w-0 flex-1">
                <div class="font-bold" x-text="t.title" x-show="t.title"></div>
                <div class="break-words text-sm" x-text="t.message"></div>
            </div>
        </div>
    </template>
</div>
@php
    $flashes = collect(['success' => 'Success Alert', 'error' => 'Error Alert', 'warning' => 'Warning Alert', 'info' => 'Info Alert'])
        ->filter(fn ($t, $type) => session()->has($type))
        ->map(fn ($t, $type) => ['type' => $type, 'message' => session($type), 'title' => $t])
        ->values();
    foreach ((isset($errors) ? $errors->all() : []) as $message) { // $errors is missing on error pages outside the web group
        $flashes->push(['type' => 'error', 'message' => $message, 'title' => 'Error Alert']);
    }
@endphp
@if ($flashes->isNotEmpty())
    <script>
        document.addEventListener('alpine:initialized', () => {
            @json($flashes).forEach(f => window.toast(f.type, f.message, f.title));
        });
    </script>
@endif
