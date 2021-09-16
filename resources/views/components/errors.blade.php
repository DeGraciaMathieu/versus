@props(['errors'])

@if ($errors->any())
    <div {!! $attributes->merge(['class' => 'text-white text-sm text-center mt-8 md:w-2/3 md:mx-auto bg-secondary-dark border border-primary py-4 px-2']) !!}>
        {{ __('Une erreur est survenue') }}

        <ul class="mt-3 list-disc list-inside text-sm text-white">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
