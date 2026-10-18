@props(['title', 'back' => null, 'footer' => null, 'actions' => null, 'after' => null])
<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-header">
        <h3 class="card-title">{!! $title !!}</h3>
        <div class="ml-auto flex flex-wrap justify-end gap-2">
            {{ $actions }}
            @if ($back)
                <a href="{{ $back }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if ($footer)
        <div class="card-footer">{{ $footer }}</div>
    @endif
    {{ $after }}
</div>
