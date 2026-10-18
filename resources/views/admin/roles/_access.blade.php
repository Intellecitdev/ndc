{{-- Read-only "Access Details" tree. Expects $map = ['path' => [abilities]] or $all = true (Super Admin). --}}
@php
    $all ??= false;
    $has = fn ($page) => $all ? $page['abilities'] : array_values(array_intersect($page['abilities'], $map[$page['path']] ?? []));
@endphp
<div class="mb-2">
    <label class="form-label font-bold">
        Access Details
        ( <span class="text-green"><i class="fa-solid fa-cube"></i> Modules</span>
        &rAarr; <span class="text-darkblue"><i class="fa-solid fa-clone"></i> Menus</span> <span class="text-secondary">[Permissions]</span>
        &rAarr;&rAarr; <span class="text-dark"><i class="fa-solid fa-square-check"></i> Childmenus</span> <span class="text-secondary">[Permissions]</span> )
    </label>
    <div class="card p-2">
        @foreach (\App\Support\Menu::tree() as $module => $groups)
            @php
                $visible = $groups->map(fn ($pages) => $pages->filter(fn ($p) => $has($p)))->filter(fn ($pages) => $pages->isNotEmpty());
            @endphp
            @continue($visible->isEmpty())
            <div class="mb-2 rounded border border-bs-border p-2">
                <h6 class="text-green mb-2 font-bold"><i class="fa-solid fa-cube"></i> {{ \App\Support\Menu::moduleTitle($module) }}</h6>
                @foreach ($visible as $group => $pages)
                    @if ($group !== '')
                        <div class="text-darkblue mb-2 pl-6">
                            <i class="fa-solid fa-clone"></i> {{ $group }}
                            <div class="grid grid-cols-1 pt-1 pl-6 text-bs-dark sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                @foreach ($pages as $page)
                                    <div><i class="fa-solid fa-square-check"></i> {{ $page['title'] }} <span class="text-secondary">[{{ implode(', ', $has($page)) }}]</span></div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @foreach ($pages as $page)
                            <div class="text-darkblue mb-2 pl-6"><i class="fa-solid fa-clone"></i> {{ $page['title'] }} <span class="text-secondary">[{{ implode(', ', $has($page)) }}]</span></div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>
