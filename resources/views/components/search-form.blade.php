@props(['action', 'placeholder' => 'Search...'])
<form method="GET" action="{{ $action }}" class="mb-2">
    <div class="flex">
        <input type="text" name="search" class="form-control !rounded-r-none" placeholder="{{ $placeholder }}" value="{{ request('search') }}">
        <button class="btn btn-primary !rounded-l-none" type="submit">Search</button>
    </div>
</form>
