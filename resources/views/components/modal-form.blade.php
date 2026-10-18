@props(['name', 'title', 'icon' => 'fa-solid fa-plus', 'action' => null, 'bindAction' => null, 'method' => 'POST', 'submit' => 'Save', 'submitClass' => 'btn-success', 'submitIcon' => 'fa-solid fa-floppy-disk', 'size' => 'max-w-[500px]', 'files' => false])
{{-- Bootstrap-style modal wrapping an AJAX form (see ajaxForm in app.js). --}}
<x-modal :name="$name" :size="$size">
    <form x-data="ajaxForm" @submit.prevent="submit" data-method="{{ $method }}"
          @if ($action) action="{{ $action }}" @endif
          @if ($bindAction) :action="{{ $bindAction }}" @endif
          @if ($files) enctype="multipart/form-data" @endif>
        <div class="modal-header">
            <h5 class="modal-title"><i class="{{ $icon }}"></i> {{ $title }}</h5>
            <button type="button" class="btn-close" @click="show = false" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn {{ $submitClass }}" :disabled="busy"><i class="{{ $submitIcon }}"></i> {{ $submit }}</button>
            <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
        </div>
    </form>
</x-modal>
