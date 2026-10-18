@props(['name', 'message', 'bindAction', 'method' => 'POST', 'submit' => 'Confirm', 'submitClass' => 'btn-warning', 'submitIcon' => 'fa-solid fa-check', 'title' => 'Warning', 'icon' => null])
{{-- "Are you sure?" dialog that posts to a dynamic URL. --}}
<x-modal :name="$name">
    <form x-data="ajaxForm" :action="{{ $bindAction }}" data-method="{{ $method }}" @submit.prevent="submit">
        <div class="modal-header">
            <h5 @class(["modal-title", "text-warning" => ! $icon])><i class="{{ $icon ?? 'fas fa-warning' }}"></i> {{ $title }}</h5>
            <button type="button" class="btn-close" @click="show = false" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">{{ $message }}{{ $slot }}</div>
        <div class="modal-footer">
            <button type="submit" class="btn {{ $submitClass }}" :disabled="busy"><i class="{{ $submitIcon }}"></i> {{ $submit }}</button>
            <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
        </div>
    </form>
</x-modal>
