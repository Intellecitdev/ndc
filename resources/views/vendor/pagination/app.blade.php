{{-- App-wide pagination: "Showing x to y of z" on top, separate page buttons centred below. --}}
@php
    $btn = 'inline-flex h-8 min-w-8 items-center justify-center rounded-md border px-2.5 text-sm font-medium transition-colors';
    $link = $btn.' border-bs-border bg-white text-gray-700 no-underline hover:border-bs-primary hover:bg-bs-primary/10 hover:text-bs-primary';
    $current = $btn.' border-bs-primary bg-bs-primary text-white shadow-sm';
    $off = $btn.' border-bs-border bg-gray-50 text-gray-400 cursor-not-allowed';
@endphp
@if ($paginator->hasPages())
    <nav class="flex flex-col items-center gap-3 py-3 text-sm" role="navigation" aria-label="Pagination">
        <div class="text-bs-secondary">
            Showing <b class="text-gray-800">{{ $paginator->firstItem() }}</b> to <b class="text-gray-800">{{ $paginator->lastItem() }}</b>
            of <b class="text-gray-800">{{ $paginator->total() }}</b> results
        </div>

        <ul class="m-0 flex list-none flex-wrap items-center justify-center gap-1.5 p-0">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="{{ $off }}" aria-disabled="true" aria-label="@lang('pagination.previous')"><i class="fa-solid fa-angle-left"></i></span>
                @else
                    <a class="{{ $link }}" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa-solid fa-angle-left"></i></a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="max-sm:hidden"><span class="inline-flex h-8 min-w-6 items-end justify-center text-gray-400">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- Phones: only the current page and its neighbours, so the row never overflows. --}}
                        <li class="{{ abs($page - $paginator->currentPage()) > 1 ? 'max-sm:hidden' : '' }}">
                            @if ($page == $paginator->currentPage())
                                <span class="{{ $current }}" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="{{ $link }}" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a class="{{ $link }}" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa-solid fa-angle-right"></i></a>
                @else
                    <span class="{{ $off }}" aria-disabled="true" aria-label="@lang('pagination.next')"><i class="fa-solid fa-angle-right"></i></span>
                @endif
            </li>
        </ul>
    </nav>
@endif
