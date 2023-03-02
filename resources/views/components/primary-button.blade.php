<button {{ $attributes->merge(['class' => 'px-4 py-3 relative inline-flex items-center bg-indigo-500 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:border-indigo-700 focus:shadow-outline-indigo disabled:bg-indigo-400 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
