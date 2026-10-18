@props(['action', 'fields'])
{{-- Several search boxes in one input-group (e.g. Brand + Category), like the reference. --}}
<form method="GET" action="{{ $action }}" class="mb-2">
    <div class="flex flex-wrap md:flex-nowrap [&>*]:!rounded-none [&>*:first-child]:!rounded-l-md [&>*:last-child]:!rounded-r-md">
        @foreach ($fields as $name => $placeholder)
            <input type="text" name="{{ $name }}" class="form-control" placeholder="{{ $placeholder }}" value="{{ request($name) }}">
        @endforeach
        {{ $slot }}
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>
