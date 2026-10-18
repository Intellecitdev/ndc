@php $details ??= false; @endphp
<div class="table-responsive">
    <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
        <thead><tr>@foreach ($columns as $c)<th>{{ $c }}</th>@endforeach @if ($details)<th>Action</th>@endif</tr></thead>
        <tbody>
        @forelse ($rows as $i => $row)
            <tr>
                @foreach (array_values($row) as $j => $cell)
                    <td @class(['text-bs-success' => $cell === 'In Stock', 'text-bs-danger' => in_array($cell, ['Damage', 'Expired', 'Declined'], true)])>{{ $cell }}</td>
                @endforeach
                @if ($details)
                    <td><button type="button" title="Item Details" class="btn btn-sm btn-secondary" @click="view = details[{{ $i }}]; $dispatch('open-modal', 'viewModal')"><i class="fa-solid fa-eye"></i></button></td>
                @endif
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
</div>
