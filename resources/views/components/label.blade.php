@props(['value'])

<label {{ $attributes->merge(['class' => 'block uppercase tracking-wide text-white text-xs font-bold mb-2']) }}>
    {{ $value ?? $slot }}
</label>
