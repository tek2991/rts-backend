@php
    $classes = "z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
        {{ $slot }}
    </ul>
</div>