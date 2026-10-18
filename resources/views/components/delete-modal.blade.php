@props(['entity'])
{{-- Shared "Are you sure?" dialog. Expects `deleteUrl` in the surrounding Alpine scope. --}}
<x-modal name="deleteModal" size="max-w-[500px]">
    <form x-data="ajaxForm" :action="deleteUrl" data-method="DELETE" @submit.prevent="submit">
        <div class="modal-header">
            <h5 class="modal-title text-warning"><i class="fas fa-warning"></i> Warning</h5>
            <button type="button" class="btn-close" @click="show = false" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this {{ $entity }}?
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger" :disabled="busy"><i class="fa-solid fa-trash"></i> Delete</button>
            <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
        </div>
    </form>
</x-modal>
