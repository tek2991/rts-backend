
@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full mt-1 border-gray-300 rounded-md p-2 focus:ring-0 focus:border-piss-yellow disabled:bg-gray-100']) !!}>
    {{ $slot }}
</select>