@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 md:w-2/3 md:mx-auto">
        <a href="{{ route('ladder.index') }}" class="text-primary hover:text-white">Ladders</a> / <a href="{{ route('ladder.ranking', $ladder) }}" class="text-primary hover:text-white">{{ $ladder->name }}</a>
    </h1>
    <h2 class="font-bold text-xl text-white mt-2 pb-2 mb-4 md:w-2/3 md:mx-auto border-b border-secondary-light">Inscris ton équipe</h2>
    <form action="{{ route('team.store', $ladder) }}" method="post" class=" md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <div class="mb-4">
            <x-label for="name">Nom de ton équipe</x-label>
            <x-input id="name" type="text" name="name" :value="old('name')" required autofocus />
        </div>
        <x-button class="w-full">
            Let's go !
        </x-button>
    </form>
@endsection
