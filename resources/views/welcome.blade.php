<x-layouts.app :content-header="false">
    <div class="-mx-3 grid grid-cols-[repeat(auto-fit,minmax(150px,1fr))] gap-[15px] p-2.5"
         x-data="{ active: 0, count: {{ count($modules) }} }"
         x-init="setInterval(() => active = (active + 1) % count, 2000)">
        @foreach ($modules as $module)
            <a href="{{ url($module['path']) }}" class="group relative block overflow-hidden rounded-[10px] bg-white p-[15px] text-center no-underline shadow-[0_4px_10px_rgba(0,0,0,0.2)] transition-all duration-300"
               @mouseenter="active = {{ $loop->index }}">
                <img src="{{ asset($module['image']) }}" alt="{{ $module['title'] }}"
                     class="inline-block h-auto max-w-full rounded-[5px] object-cover transition-transform duration-1000 ease-in-out group-hover:-translate-y-5"
                     :class="{ '-translate-y-5': active === {{ $loop->index }} }">
                <p class="absolute bottom-0 left-0 mt-0 mb-4 w-full bg-[rgba(61,66,29,0.6)] p-2 text-center font-bold text-white opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                   :class="{ 'opacity-100': active === {{ $loop->index }} }">
                    Click to go {{ $module['title'] }}
                </p>
            </a>
        @endforeach
    </div>
</x-layouts.app>
