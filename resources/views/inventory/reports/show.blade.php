<x-layouts.app :title="$title" module="inventory">
    <div x-data="{ view: {}, details: @js($extra['details'] ?? []) }">
        <x-card :title="$title" :back="route('inventory.dashboard')">
            <form method="GET" action="{{ url('inventory/reports/'.$page) }}" class="mb-2">
                <div class="grid grid-cols-1 gap-x-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($filters as $name => $f)
                        @php [$type, $label] = $f; $options = $f[2] ?? []; $placeholder = $f[3] ?? true; $required = $f[4] ?? false; @endphp
                        <div class="mb-2">
                            <label class="form-label" for="{{ $name }}">{{ $label }}</label>
                            @if ($type === 'select')
                                <select class="form-select" id="{{ $name }}" name="{{ $name }}" @required($required) @if (count($options) > 15) x-select2 @endif>
                                    @if ($placeholder)<option value="">Select One</option>@endif
                                    @foreach ($options as $id => $text)
                                        <option value="{{ $id }}" @selected((string) request($name, $name === 'TypeID' && ! $placeholder ? '0' : '') === (string) $id)>{{ $text }}</option>
                                    @endforeach
                                </select>
                            @elseif ($type === 'date')
                                <input class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $label }}" value="{{ request($name) }}" x-datepicker="{{ $name === 'FromDate' ? "'#ToDate'" : '' }}">
                            @else
                                <input class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $label }}" value="{{ request($name) }}">
                            @endif
                        </div>
                    @endforeach
                    <div class="mb-2">
                        <label class="form-label" for="ViewID">View Mode</label>
                        <select required class="form-select" id="ViewID" name="ViewID" x-ref="mode"
                                @change="$el.form.target = $el.value === '1' ? '_blank' : ''">
                            <option value="">Select One</option>
                            @foreach ($views as $id => $text)<option value="{{ $id }}" @selected((string) request('ViewID', '0') === (string) $id)>{{ $text }}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="text-right"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Preview</button></div>
            </form>

            @if ($submitted)
                @if (! $alwaysRun && ! $hasFilter)
                    <p class="text-primary">Give at least one search value to preview the report...</p>
                @else
                    @if (! empty($extra['register']))
                        <h6 class="mb-1 font-bold">Store Register Information:</h6>
                        @include('inventory.reports._table', ['columns' => $extra['register'][0], 'rows' => [$extra['register'][1]], 'sl' => false])
                        <h6 class="mt-3 mb-1 font-bold">Store Log Records:</h6>
                        @include('inventory.reports._table', ['columns' => $extra['summary'][0], 'rows' => [$extra['summary'][1]], 'sl' => false])
                        <h6 class="mt-3 mb-1 font-bold">Transaction Records:</h6>
                    @endif
                    @include('inventory.reports._table', ['columns' => $columns, 'rows' => $rows, 'details' => ! empty($extra['details'])])
                    <p class="mt-1 text-sm text-bs-secondary">Total records: {{ count($rows) }}</p>
                @endif
            @endif
        </x-card>
        @if (! empty($extra['details']))
            @include('inventory.transaction._stock-details-modal')
        @endif
    </div>
</x-layouts.app>
