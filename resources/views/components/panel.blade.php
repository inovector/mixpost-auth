@props(['title' => ''])
<div {{ $attributes->merge(['class' => 'bg-white border border-gray-100 rounded-lg']) }}>
    <div class="p-lg">
        @if($title)
            <div class="text-lg font-semibold text-black">
                {{ $title }}
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
