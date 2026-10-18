<x-layouts.app title="Dashboard" module="inventory">
    @if ($queue)
        @include('inventory.approvals._panel', $queue)
    @endif
    <div class="grid grid-cols-1 gap-x-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($boxes as [$label, $path, $color, $icon, $tile, $count])
            @continue($path && ! auth()->user()->canMenu($path))
            <a href="{{ $path ? url($path) : 'javascript:void(0)' }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon"><span class="info-box-tile" style="--tile: {{ $tile }}"><i class="{{ $icon }}"></i></span></span>
                    <div class="info-box-content {{ $color }}">
                        <span class="info-box-text">{{ $label }}</span>
                        <span class="info-box-number">{{ $count }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-layouts.app>
