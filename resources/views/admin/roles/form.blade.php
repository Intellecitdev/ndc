@php
    use App\Support\Menu;
    $editing = $role->exists;
    $selected = collect($map)->flatMap(fn ($abilities, $path) => collect($abilities)->map(fn ($a) => "$path|$a"))->values();
    $keys = fn ($pages) => collect($pages)->flatMap(fn ($p) => collect($p['abilities'])->map(fn ($a) => $p['path'].'|'.$a))->values();
@endphp
<x-layouts.app title="Roles" module="admin">
    <div class="card mb-2" x-data="permTree(@js($selected))">
        <div class="card-header">
            <h3 class="card-title">{{ $editing ? 'Edit Role' : 'Create New Role' }}</h3>
            <div class="ml-auto flex gap-2">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
        </div>
        <form x-data="ajaxForm" @submit.prevent="submit"
              action="{{ $editing ? route('admin.roles.update', $role) : route('admin.roles.store') }}"
              data-method="{{ $editing ? 'PUT' : 'POST' }}">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <x-form.input label="Role Name" name="name" id="name" maxlength="50" required value="{{ $role->name }}"
                                  x-on:input="if (! {{ $editing ? 'true' : 'false' }}) $refs.slug.value = $event.target.value.toLowerCase().trim().replace(/[\s-]+/g, '').replace(/[^a-z0-9-]/g, '')" />
                    <div class="mb-2">
                        <label for="slug" class="form-label">Slug</label>
                        <input readonly class="form-control" id="slug" x-ref="slug" placeholder="Role Slug" name="slug" type="text" value="{{ $role->slug }}">
                    </div>
                </div>
                <hr class="my-4 border-black/25">

                <div class="mb-2">
                    <label class="form-label font-bold">
                        Access Details
                        ( <span class="text-green"><i class="fa-solid fa-cube"></i> Modules</span>
                        &rAarr; <span class="text-darkblue"><i class="fa-solid fa-clone"></i> Menus</span> <span class="text-secondary">[Permissions]</span>
                        &rAarr;&rAarr; <span class="text-dark"><i class="fa-solid fa-square-check"></i> Childmenus</span> <span class="text-secondary">[Permissions]</span> )
                    </label>
                    <div class="card p-2">
                        @foreach (Menu::tree() as $module => $groups)
                            @php $moduleKeys = $keys($groups->flatten(1)); @endphp
                            <div class="text-green mb-2 rounded border border-bs-border p-2">
                                <label class="cursor-pointer">
                                    <input type="checkbox" :checked="any(@js($moduleKeys))" @change="setAll(@js($moduleKeys), $event.target.checked)">
                                    {{ Menu::moduleTitle($module) }}
                                </label>
                                @foreach ($groups as $group => $pages)
                                    @if ($group !== '')
                                        @php $groupKeys = $keys($pages); @endphp
                                        <div class="text-darkblue mb-2 pl-6">
                                            &rAarr;&nbsp;<label class="cursor-pointer"><input type="checkbox" :checked="any(@js($groupKeys))" @change="setAll(@js($groupKeys), $event.target.checked)"> {{ $group }}</label>
                                            <div class="grid grid-cols-1 pt-1 pl-6 text-bs-dark md:grid-cols-2">
                                                @foreach ($pages as $page)
                                                    @include('admin.roles._permission_row', ['page' => $page, 'pageKeys' => $keys([$page]), 'menuClass' => 'pl-6'])
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($pages as $page)
                                            <div class="text-darkblue mb-2 pl-6">
                                                &rAarr;&nbsp;@include('admin.roles._permission_row', ['page' => $page, 'pageKeys' => $keys([$page]), 'menuClass' => 'inline'])
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer flex justify-end gap-2 !py-2">
                @if ($editing)
                    <button type="submit" class="btn btn-warning" :disabled="busy"><i class="fa-regular fa-floppy-disk"></i> Update</button>
                @else
                    <button type="submit" class="btn btn-success" :disabled="busy"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                @endif
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
