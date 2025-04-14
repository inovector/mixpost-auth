@props(['id', 'name'])
<div {{ $attributes->merge(['class' => 'block']) }} id="{{ $id }}">
    <label class="inline-flex items-center">
        <input id="{{ $id }}" type="checkbox"
               class="w-5 h-5 rounded-md border-stone-600 text-indigo-600 shadow-xs focus:ring-3 focus:ring-indigo-200/50"
               name="{{ $name }}">
        <span class="ml-xs text-gray-600">{{ $slot }}</span>
    </label>
</div>
