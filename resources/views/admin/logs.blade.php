<x-layouts.app title="Log Activity" module="admin">
    <div x-data="{ log: {} }">
        <x-card title="Activity Logs" :back="route('admin.dashboard')">
            <form method="GET" action="{{ route('admin.logs.index') }}" class="mb-2">
                <div class="flex flex-wrap md:flex-nowrap [&>*]:!rounded-none [&>*:first-child]:!rounded-l-md [&>*:last-child]:!rounded-r-md">
                    <input class="form-control" placeholder="Subject" name="Subject" type="text" value="{{ request('Subject') }}">
                    <input class="form-control" id="StartDate" placeholder="Start Date" name="StartDate" type="text" value="{{ request('StartDate') }}" x-datepicker="'#EndDate'">
                    <input class="form-control" id="EndDate" placeholder="End Date" name="EndDate" type="text" value="{{ request('EndDate') }}" x-datepicker>
                    <select class="form-select" name="UserID">
                        <option value="">User Name</option>
                        @foreach ($users as $id => $name)
                            <option value="{{ $id }}" @selected(request('UserID') == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>SL</th><th>Subject</th><th>URL</th><th>IP Address</th><th>User Name</th><th>Date Time</th><th>Details</th></tr></thead>
                    <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->subject }}</td>
                            <td class="break-all text-bs-success">{{ $log->url }}</td>
                            <td class="text-bs-warning">{{ $log->ip }}</td>
                            <td>{{ $log->user?->name }}</td>
                            <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>
                                <button title="Compare Data" class="btn btn-sm btn-warning"
                                        @click="log = @js([
                                            'id' => $log->id, 'subject' => $log->subject, 'url' => $log->url, 'method' => $log->method,
                                            'ip' => $log->ip, 'agent' => $log->agent, 'username' => $log->user?->name,
                                            'created_at' => (string) $log->created_at, 'old' => $log->old_data, 'new' => $log->new_data,
                                            'pdf' => route('admin.logs.pdf', $log),
                                        ]); $dispatch('open-modal', 'compareModal')">
                                    <i class="fa-solid fa-code-compare"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $logs->links() }}</x-slot:footer>
        </x-card>

        <x-modal name="compareModal" size="max-w-[800px]">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Log Activity Details</h5>
                <button type="button" class="btn-close" @click="show = false">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered [&_th]:w-[16%] [&_th]:text-left">
                    <tr><th>Log ID</th><td x-text="log.id"></td></tr>
                    <tr><th>Method</th><td x-text="log.method"></td></tr>
                    <tr><th>Subject</th><td x-text="log.subject"></td></tr>
                    <tr><th>URL</th><td class="break-all" x-text="log.url"></td></tr>
                    <tr><th>IP Address</th><td x-text="log.ip"></td></tr>
                    <tr><th>User Agent</th><td class="break-all" x-text="log.agent"></td></tr>
                    <tr><th>User Name</th><td x-text="log.username"></td></tr>
                    <tr><th>Created At</th><td x-text="log.created_at"></td></tr>
                </table>
                <table class="table table-bordered mt-2">
                    <thead><tr><th class="w-1/2 !text-center">Old Data</th><th class="w-1/2 !text-center">New Data</th></tr></thead>
                    <tbody>
                    <tr>
                        @foreach (['old', 'new'] as $side)
                            <td class="align-top">
                                <table class="table table-bordered table-sm text-sm">
                                    <template x-for="[k, v] in Object.entries(log.{{ $side }} || {})" :key="k">
                                        <tr><td x-text="k"></td><td class="break-all" x-text="typeof v === 'object' && v !== null ? Object.keys(v).join(', ') : v"></td></tr>
                                    </template>
                                </table>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a :href="log.pdf" target="_blank" class="btn btn-primary"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                <button type="button" class="btn btn-dark" @click="show = false">Close</button>
            </div>
        </x-modal>
    </div>
</x-layouts.app>
