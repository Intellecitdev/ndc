@props(['label', 'name', 'list', 'required' => false, 'wrapper' => 'mb-2', 'placeholder' => 'Select One'])
{{-- A select inside x-data="cascade(...)": options come from opts[list], value bound to sel[name]. --}}
<div class="{{ $wrapper }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" class="form-select" x-model="sel.{{ $name }}" @change="changed('{{ $name }}')" :disabled="! opts.{{ $list }}.length" @required($required) {{ $attributes }}>
        <option value="">{{ $placeholder }}</option>
        <template x-for="o in opts.{{ $list }}" :key="o.id">
            <option :value="String(o.id)" x-text="o.name" :selected="String(o.id) === String(sel.{{ $name }})"></option>
        </template>
    </select>
</div>
