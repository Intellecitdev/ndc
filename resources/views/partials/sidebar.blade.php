@php
    $isActive = function (array $item): bool {
        $path = trim($item['path'] ?? '', '/');
        if ($path === '') {
            return false;
        }

        return ($item['exact'] ?? false) ? request()->is($path) : request()->is($path, $path.'/*');
    };

    // Only show what the role may view; groups without visible children disappear.
    $user = auth()->user();
    $items = collect($menu['items'] ?? [])->map(function ($item) use ($user) {
        if (! empty($item['children'])) {
            $item['children'] = array_values(array_filter($item['children'], fn ($c) => $user->canMenu($c['path'])));

            return $item['children'] ? $item : null;
        }

        return ($item['exact'] ?? false) || $user->canMenu($item['path']) ? $item : null;
    })->filter();
@endphp
<aside x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
       class="fixed inset-y-0 left-0 z-40 flex w-[250px] -translate-x-full flex-col bg-army-sidebar text-[#c2c7d0] shadow-[0_14px_28px_rgba(0,0,0,.25),0_10px_10px_rgba(0,0,0,.22)] lg:translate-x-0"
       :class="{
           'translate-x-0!': mobileOpen,
           'lg:w-[4.6rem]': collapsed && !hover,
           'transition-all duration-300': ready,
       }">
    {{-- Brand --}}
    <div class="flex h-[3.5rem] shrink-0 items-center justify-center overflow-hidden border-b border-[#495057] px-2 py-[0.8125rem] text-xl whitespace-nowrap">
        <a href="{{ route('welcome') }}" class="flex items-center no-underline">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="max-h-[35px] w-auto opacity-75 shadow-[0_.5rem_1rem_rgba(0,0,0,.15)] rounded-full">
            <span class="ml-2 font-light text-white/80 hover:text-white" x-show="!collapsed || hover">NDC INV</span>
        </a>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden px-2 pt-2 pb-4 mt-2 [scrollbar-width:thin] [scrollbar-color:rgba(255,255,255,.3)_transparent]">
        @if ($menu)
            <ul class="sidebar-menu flex flex-col">
                @foreach ($items as $item)
                    @if (! empty($item['children']))
                        @php $open = collect($item['children'])->contains(fn ($c) => $isActive($c)); @endphp
                        <li x-data="{ open: @js($open) }">
                            <a href="javascript:void(0)" @click="open = !open" class="nav-link" :class="{ 'open-parent': open }">
                                <i class="nav-icon {{ $item['icon'] }}"></i>
                                <p class="flex flex-1 items-center" x-show="!collapsed || hover">
                                    {{ $item['title'] }}
                                    <i class="bi bi-chevron-right ml-auto transition-transform duration-300" :class="{ 'rotate-90': open }"></i>
                                </p>
                            </a>
                            <ul class="nav-treeview" x-show="open && (!collapsed || hover)" x-collapse x-cloak>
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <a href="{{ url($child['path']) }}" @class(['nav-link', 'active' => $isActive($child)])>
                                            <i class="nav-icon {{ $child['icon'] ?? 'bi bi-arrow-return-right' }}"></i>
                                            <p>{{ $child['title'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ url($item['path']) }}" @class(['nav-link', 'active' => $isActive($item)])>
                                <i class="nav-icon {{ $item['icon'] }}"></i>
                                <p x-show="!collapsed || hover">{{ $item['title'] }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </nav>
</aside>
