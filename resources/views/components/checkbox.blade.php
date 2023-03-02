@props(['id', 'name'])
<div {{ $attributes->merge(['class' => 'block']) }} id="{{ $id }}">
    <label class="inline-flex items-center">
        <input id="{{ $id }}" type="checkbox"
               class="w-5 h-5 rounded-md border-stone-600 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
               name="{{ $name }}">
        <span class="ml-xs text-gray-600">{{ $slot }}</span>
    </label>
</div>
