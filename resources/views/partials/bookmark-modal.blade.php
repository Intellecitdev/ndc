<div x-on:open-bookmark.window="$dispatch('open-modal', 'addQuikLinkModal')">
    <x-modal name="addQuikLinkModal">
        <form x-data="ajaxForm('{{ route('user.quicklink.store') }}')" @submit.prevent="submit">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-regular fa-star"></i> Add to Bookmark</h5>
                <button type="button" class="btn-close" @click="show = false" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Title" class="form-label">Title</label>
                    <input required class="form-control" id="Title" maxlength="50" placeholder="Title" name="title" type="text" value="{{ $bookmarkTitle }}">
                </div>
                <div class="mb-3">
                    <label for="Links" class="form-label">Links</label>
                    <input readonly class="form-control" id="Links" maxlength="250" placeholder="Links" name="link" type="text" value="{{ url()->current() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-plus"></i> Add</button>
                <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
            </div>
        </form>
    </x-modal>
</div>
