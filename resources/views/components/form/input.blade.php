@props(['label', 'name', 'type' => 'text', 'id' => null, 'wrapper' => 'mb-2'])
@php
    $id ??= $name.'_'.\Illuminate\Support\Str::random(4);
    $placeholder = $type === 'file' ? null : $attributes->get('placeholder', $label);
    $attributes = $attributes->except('placeholder');
@endphp
<div class="{{ $wrapper }}">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @if ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}" rows="2" {{ $attributes->merge(['class' => 'form-control']) }}>{{ $slot }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" @if ($placeholder !== null) placeholder="{{ $placeholder }}" @endif {{ $attributes->merge(['class' => 'form-control']) }}>
    @endif
</div>
