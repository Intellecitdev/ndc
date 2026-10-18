@props(['icon', 'title', 'tile' => '#475569', 'badge' => null, 'badgeClass' => 'text-bg-info', 'live' => null])
{{-- "live" = key in $store.live.counts; the badge then updates in real time. "tile" = icon tile colour. --}}
<li class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
    <a href="javascript:void(0)" @click="open = !open" class="relative flex h-11 items-center px-1.5" title="{{ $title }}">
        <span class="header-tile" style="--tile: {{ $tile }}"><i class="{{ $icon }}"></i></span>
        @if ($live)
            <span class="header-badge badge {{ $badgeClass }}" x-show="$store.live.counts.{{ $live }} > 0" x-text="$store.live.counts.{{ $live }}" @if (! $badge) x-cloak @endif>{{ $badge }}</span>
        @elseif ($badge)
            <span class="header-badge badge {{ $badgeClass }}">{{ $badge }}</span>
        @endif
    </a>
    <div x-show="open" x-cloak x-transition.origin.top.right class="dropdown-menu">
        {{ $slot }}
    </div>
</li>
