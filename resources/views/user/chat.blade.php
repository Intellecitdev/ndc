<x-layouts.app title="Chat">
    <div class="grid grid-cols-1 gap-x-6 md:grid-cols-12">
        <div class="md:col-span-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">User List</h3></div>
                <div class="card-body max-h-[500px] min-h-[300px] overflow-x-auto">
                    <x-search-form :action="route('user.chat.index')" />
                    <table class="table table-bordered table-striped">
                        <thead><tr><th>Name</th></tr></thead>
                        <tbody>
                        @foreach ($contacts as $c)
                            <tr>
                                <td>
                                    <a href="{{ route('user.chat.show', $c) }}" title="Chat Details"
                                       @class(['block no-underline', 'font-semibold !text-[#1676fb]' => $partner?->is($c), '!text-bs-body' => ! $partner?->is($c)])>
                                        {{ $c->full_name }}
                                        @if ($c->unread)<span class="badge text-bg-danger float-right">{{ $c->unread }}</span>@endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="md:col-span-8">
            @if (! $partner)
                <x-card title="Chat Details" :back="route('welcome')">
                    <div class="min-h-[300px]"><p class="text-primary">Select an user to preview chat details...</p></div>
                </x-card>
            @else
                <div class="card mb-2"
                     x-data="{ async poll() { try { const { data } = await axios.get(@js(route('user.chat.show', [$partner, 'partial' => 1, 'fullchat' => request('fullchat')]))); $refs.rows.innerHTML = data.html; } catch (e) {} } }"
                     x-init="setInterval(() => poll(), 10000)">
                    <div class="card-header">
                        <h3 class="card-title">chat with <strong>{{ $partner->full_name }}</strong></h3>
                        <div class="ml-auto flex gap-2">
                            <a href="{{ route('user.chat.show', [$partner, 'fullchat' => 'true']) }}" class="btn btn-outline-info"><i class="fa-regular fa-eye"></i>&nbsp; Full Chat</a>
                            <a href="{{ route('user.chat.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
                        </div>
                    </div>
                    <div class="card-body max-h-[500px] min-h-[300px] overflow-x-auto">
                        <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                            <thead>
                            <tr><th class="w-[12%]">From</th><th class="w-[18%]">Priority</th><th class="w-[60%]">Message</th><th class="w-[10%]">Status</th></tr>
                            <tr class="align-top">
                                <td></td>
                                <td colspan="3" class="!p-0">
                                    <form x-data="ajaxForm" action="{{ route('user.chat.store', $partner) }}" @submit.prevent="submit" class="flex gap-1 p-1">
                                        <select required class="form-select w-[22%]" name="priority">
                                            <option value="">Priority</option>
                                            @foreach (\App\Models\Chat::PRIORITIES as $k => $v)
                                                <option value="{{ $k }}" @selected($k === 'N')>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        <input required class="form-control flex-1" placeholder="Message" name="message" type="text" maxlength="2000" autofocus>
                                        <button type="submit" class="btn btn-success" :disabled="busy">Sent</button>
                                    </form>
                                </td>
                            </tr>
                            </thead>
                            <tbody x-ref="rows">
                            @include('user._chat_rows', ['chats' => $chats, 'me' => auth()->user()])
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
