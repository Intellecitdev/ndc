@props(['label', 'name', 'options' => [], 'placeholder' => null, 'id' => null, 'wrapper' => 'mb-2', 'selected' => null])
{{-- options: [value => label] --}}
@php $id ??= $name.'_'.\Illuminate\Support\Str::random(4); @endphp
<div class="{{ $wrapper }}">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>
        @if ($placeholder !== null)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $text }}</option>
        @endforeach
        {{ $slot }}
    </select>
</div>
