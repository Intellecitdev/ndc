@props(['columns'])
{{-- Two-column "Label : value" header of a details page (web view), as in the reference. --}}
<div class="mb-3 grid grid-cols-1 border-b border-bs-border pb-2 md:grid-cols-2">
    @foreach ($columns as $col)
        <table class="table table-borderless [&_th]:text-left">
            @foreach ($col as $k => $v)
                <tr><th class="w-[150px]">{{ $k }}</th><th class="w-[1%]">:</th><td>{{ $v }}</td></tr>
            @endforeach
        </table>
    @endforeach
</div>
