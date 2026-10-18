@props(['p', 'update', 'edit' => null, 'view' => null, 'delete' => true, 'viewIcon' => 'fa-regular fa-eye'])
{{-- View / Edit / Delete buttons of a list row, shown per role permission.
     Expects edit/deleteUrl in the surrounding Alpine scope. --}}
<div class="flex justify-center gap-1">
    @if ($view)
        <a href="{{ $view }}" title="View" class="btn btn-sm btn-info"><i class="{{ $viewIcon }}"></i></a>
    @endif
    @if ($edit !== null)
        @canmenu($p, 'edit')
            <button title="Edit" class="btn btn-sm btn-warning" @click="edit = @js(['url' => $update] + $edit); $dispatch('open-modal', 'editModal')"><i class="fa-solid fa-pen-to-square"></i></button>
        @endcanmenu
    @endif
    {{ $slot }}
    @if ($delete)
        @canmenu($p, 'delete')
            <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js($update); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
        @endcanmenu
    @endif
</div>
