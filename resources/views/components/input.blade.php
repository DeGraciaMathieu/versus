@props(['name'])

<input name="{{ $name }}"
    {!! $attributes->merge(['class' => 'appearance-none block w-full bg-secondary-light text-gray-500 py-3 px-4 leading-tight focus:outline-none focus:bg-white']) !!}
/>
@error($name)
    <span class="text-red-500 text-sm font-semibold"> {{ $message }}</span>
@enderror
