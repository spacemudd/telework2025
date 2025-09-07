@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 rtl:text-right ltr:text-left']) }}>
    {{ $value ?? $slot }}
</label>
