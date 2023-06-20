@php
    $classes = 'flex items-center w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600';
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd">
        </path>
    </svg>
</button>
