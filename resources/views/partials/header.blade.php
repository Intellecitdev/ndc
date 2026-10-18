@php
    $user = auth()->user();
    $bookmarks = $user->quickLinks()->where('is_active', true)->latest('id')->get();
    $openTickets = $user->tickets()->where('status', 'Open')->withCount('comments')->latest('id')->limit(5)->get();
    $unreadChats = \App\Models\Chat::with('sender')->where('receiver_id', $user->id)->whereNull('read_at')->oldest('id')->get();
    $unreadNotifications = $user->unreadNotifications;
@endphp
<nav x-data x-init="$store.live.start(@js(route('user.live')), @js(['tickets' => $openTickets->count(), 'messages' => $unreadChats->count(), 'notifications' => $unreadNotifications->count()]))" class="sticky top-0 z-20 flex h-[57px] items-center border-b border-bs-border bg-white px-3 py-2 no-print">
    <ul class="flex items-center">
        <li>
            <a href="javascript:void(0)" @click="toggleSidebar()" class="flex h-10 items-center px-4 text-black/65 no-underline hover:text-black/80" role="button">
                <i class="bi bi-list text-xl"></i>
            </a>
        </li>
        <li class="hidden md:block">
            <a href="{{ route('welcome') }}" class="block px-4 py-2 text-black/65 no-underline hover:text-black/80">Home</a>
        </li>
    </ul>

    <ul class="ml-auto flex items-center gap-0.5 text-black/65">
        {{-- Warnings --}}
        <x-header-dropdown icon="fa-solid fa-triangle-exclamation" tile="#f59e0b" title="Warnings" badge="1" badge-class="text-bg-warning">
            <span class="dropdown-header">1 Warning</span>
            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item">
                <p class="m-0 text-sm">You will be automatically logged out after {{ config('session.lifetime') }} minutes of inactivity...</p>
            </a>
        </x-header-dropdown>

        {{-- Bookmarks --}}
        <x-header-dropdown icon="fa-solid fa-star" tile="#6366f1" title="Bookmarks" :badge="$bookmarks->count() ?: null" badge-class="text-bg-info">
            @if ($bookmarks->isNotEmpty())
                <span class="dropdown-header">{{ $bookmarks->count() }} Bookmarks</span>
                <div class="dropdown-divider"></div>
                @foreach ($bookmarks as $bookmark)
                    <a href="{{ $bookmark->safeLink() }}" class="dropdown-item" title="Go To {{ $bookmark->title }}">
                        <i class="fa-solid fa-link"></i>&nbsp; {{ $bookmark->title }}
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
            @endif
            <a href="{{ route('user.quicklink.index') }}" class="dropdown-item dropdown-footer">All Bookmarks</a>
        </x-header-dropdown>

        {{-- Tickets (replies on my open tickets) --}}
        <x-header-dropdown icon="fa-solid fa-headset" tile="#0d9488" title="Tickets" :badge="$openTickets->count() ?: null" badge-class="text-bg-success" live="tickets">
            @if ($openTickets->isNotEmpty())
                <span class="dropdown-header">{{ $openTickets->count() }} Open Tickets</span>
                <div class="dropdown-divider"></div>
                @foreach ($openTickets as $t)
                    <a href="{{ route('user.ticket.index') }}" class="dropdown-item text-sm"><i class="fa-solid fa-ticket"></i>&nbsp; {{ \Illuminate\Support\Str::limit($t->subject, 40) }} <span class="float-right text-xs text-bs-secondary">{{ $t->comments_count }} reply</span></a>
                @endforeach
                <div class="dropdown-divider"></div>
            @endif
            <a href="{{ route('user.ticket.index') }}" class="dropdown-item dropdown-footer">All Tickets</a>
        </x-header-dropdown>

        {{-- Messages (unread chats) --}}
        <x-header-dropdown icon="fa-solid fa-comment-dots" tile="#0891b2" title="Messages" :badge="$unreadChats->count() ?: null" badge-class="text-bg-danger" live="messages">
            @foreach ($unreadChats->groupBy('sender_id') as $msgs)
                <a href="{{ route('user.chat.show', $msgs->first()->sender_id) }}" class="dropdown-item text-sm">
                    <b>{{ $msgs->first()->sender?->full_name }}</b> <span class="badge text-bg-danger">{{ $msgs->count() }}</span><br>
                    <span class="text-bs-secondary">{{ \Illuminate\Support\Str::limit($msgs->last()->message, 45) }}</span>
                </a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a href="{{ route('user.chat.index') }}" class="dropdown-item dropdown-footer">All Messages</a>
        </x-header-dropdown>

        {{-- Notifications (unread) --}}
        <x-header-dropdown icon="fa-solid fa-bell" tile="#7c3aed" title="Notifications" :badge="$unreadNotifications->count() ?: null" badge-class="text-bg-warning" live="notifications">
            @if ($unreadNotifications->isNotEmpty())
                <span class="dropdown-header">{{ $unreadNotifications->count() }} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach ($unreadNotifications->take(5) as $n)
                    <a href="{{ route('user.notification.index') }}" class="dropdown-item text-sm"><i class="fa-regular fa-bell"></i>&nbsp; {{ \Illuminate\Support\Str::limit($n->data['subject'] ?? '', 40) }} <span class="float-right text-xs text-bs-secondary">{{ $n->created_at->diffForHumans(short: true) }}</span></a>
                @endforeach
                <div class="dropdown-divider"></div>
            @endif
            <a href="{{ route('user.notification.index') }}" class="dropdown-item dropdown-footer">All Notifications</a>
        </x-header-dropdown>

        {{-- Fullscreen --}}
        <li>
            <a href="javascript:void(0)" @click="toggleFullscreen()" class="flex h-11 items-center px-1.5" title="Fullscreen">
                <span class="header-tile" style="--tile: #475569">
                    <i class="fa-solid fa-expand" x-show="!fullscreen"></i>
                    <i class="fa-solid fa-compress" x-show="fullscreen" x-cloak></i>
                </span>
            </a>
        </li>

        {{-- User menu --}}
        <li class="relative" x-data="{ open: false }" @click.outside="open = false">
            <a href="javascript:void(0)" @click="open = !open"
               class="ml-2 flex items-center gap-2 rounded-full border border-slate-200 bg-white py-1 pl-1 pr-1 text-slate-700 no-underline shadow-sm transition hover:border-slate-300 hover:shadow md:pr-3">
                <img src="{{ $user->avatarUrl() }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-army/40" alt="User Image">
                <span class="hidden flex-col leading-tight md:flex">
                    <span class="text-[.9rem] font-semibold">{{ $user->full_name }}</span>
                    <span class="text-[.7rem] text-slate-500">{{ $user->role?->name }}</span>
                </span>
                <span class="hidden text-[.65rem] text-slate-400 md:inline"><i class="fa-solid fa-chevron-down"></i></span>
            </a>
            <ul x-show="open" x-cloak x-transition.origin.top.right class="dropdown-menu !p-0 overflow-hidden">
                <li class="bg-army px-4 py-3 text-center text-white">
                    <img src="{{ $user->avatarUrl() }}" class="mx-auto h-[90px] w-[90px] rounded-full border-[3px] border-white/20 object-cover shadow" alt="User Image">
                    <p class="mt-2 mb-0 text-[1.1rem]">
                        {{ $user->name }}<br>{{ $user->full_name }}
                        <small class="block text-xs">Login Time: {{ session('login_time', $user->last_login_at?->format('Y-m-d H:i:s')) }}</small>
                    </p>
                </li>
                <li class="flex justify-between bg-[#f8f9fa] p-3">
                    <a href="{{ route('user.profile.show', $user) }}" class="btn btn-default btn-flat">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
