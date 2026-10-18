<div class="{{ $menuClass }}">
    <label class="cursor-pointer"><input type="checkbox" :checked="any(@js($pageKeys))" @change="setAll(@js($pageKeys), $event.target.checked)"> {{ $page['title'] }}</label>&nbsp;&nbsp;
    <span class="text-secondary">[
        @foreach ($page['abilities'] as $ability)
            &nbsp;<label class="cursor-pointer"><input type="checkbox" name="permissions[]" value="{{ $page['path'] }}|{{ $ability }}" x-model="selected"> {{ $ability }}</label>
        @endforeach
    ]</span>
</div>
