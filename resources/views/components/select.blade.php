@props(['name', 'options', 'value'])

<div class="flex-shrink w-full inline-block relative">
    <select name="{{ $name }}"
        {!! $attributes->merge(['class' => 'appearance-none block w-full bg-secondary-light text-gray-300 py-3 px-4 leading-tight focus:text-gray-600 focus:outline-none focus:bg-white']) !!}
    >
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ $value === $key ? 'selected' : null }}>{{ $option }}</option>
        @endforeach
</select>
    <div class="pointer-events-none absolute top-0 mt-3 right-1 flex items-center px-2 text-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>
@error($name)
    <span class="text-red-500 text-sm font-semibold"> {{ $message }}</span>
@enderror
