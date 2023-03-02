<div {{ $attributes->merge(['class' => 'flex justify-between items-center']) }}>
    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex justify-start w-full font-semibold sm:mr-xs">
            {{ $title }}
        </div>

        <div class="w-full flex justify-end mt-xs sm:mt-0">
           {{ $slot }}
        </div>
    </div>
</div>
