@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-100 transition-colors']) }}>
    {{ $value ?? $slot }}
</label>