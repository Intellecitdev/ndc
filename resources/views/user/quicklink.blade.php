<x-layouts.app title="Bookmarks">
    <div class="card" x-data="{ edit: {}, deleteUrl: '' }">
        <div class="card-header">
            <h3 class="card-title">Bookmarks</h3>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
        </div>
        <div class="card-body">
            <x-search-form :action="route('user.quicklink.index')" />

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center [&_td]:text-center [&_th]:text-center">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Links</th>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($quickLinks as $quickLink)
                        <tr>
                            <td>{{ $quickLinks->firstItem() + $loop->index }}</td>
                            <td>{{ $quickLink->title }}</td>
                            <td class="break-all"><a href="{{ $quickLink->safeLink() }}">{{ $quickLink->link }}</a></td>
                            <td>{{ $quickLink->user?->full_name }}</td>
                            <td><x-status-badge :active="$quickLink->is_active" /></td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <button type="button" title="Edit" class="btn btn-sm btn-warning"
                                            @click="edit = @js(['url' => route('user.quicklink.update', $quickLink), 'title' => $quickLink->title, 'link' => $quickLink->link, 'is_active' => $quickLink->is_active ? 1 : 0]); $dispatch('open-modal', 'editModal')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" title="Delete" class="btn btn-sm btn-danger"
                                            @click="deleteUrl = @js(route('user.quicklink.destroy', $quickLink)); $dispatch('open-modal', 'deleteModal')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $quickLinks->links() }}
        </div>

        {{-- Edit --}}
        <x-modal name="editModal">
            <form x-data="ajaxForm" :action="edit.url" data-method="PUT" @submit.prevent="submit">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Bookmarks</h5>
                    <button type="button" class="btn-close" @click="show = false">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="editTitle" class="form-label">Title</label>
                        <input required class="form-control" id="editTitle" maxlength="50" placeholder="Title" name="title" type="text" x-model="edit.title">
                    </div>
                    <div class="mb-2">
                        <label for="editLinks" class="form-label">Links</label>
                        <input readonly class="form-control" id="editLinks" maxlength="250" placeholder="Links" type="text" :value="edit.link">
                    </div>
                    <div class="mb-2">
                        <label for="editC4S" class="form-label">Is Active?</label>
                        <select required class="form-select" id="editC4S" name="is_active" x-model="edit.is_active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" :disabled="busy"><i class="fa-regular fa-floppy-disk"></i> Update</button>
                    <button type="button" class="btn btn-dark" @click="show = false">Cancel</button>
                </div>
            </form>
        </x-modal>

        <x-delete-modal entity="Bookmarks" />
    </div>
</x-layouts.app>
