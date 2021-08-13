@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 md:w-2/3 md:mx-auto">
        <a href="{{ route('ladder.index') }}" class="text-primary hover:text-white">Ladders</a> / <a href="{{ route('ladder.ranking', $ladder) }}" class="text-primary hover:text-white">{{ $ladder->name }}</a>
    </h1>
    <h2 class="font-bold text-xl text-white mt-2 pb-2 mb-4 md:w-2/3 md:mx-auto border-b border-secondary-light">Enregistre un match</h2>
    <form action="{{ route('game.store', $ladder) }}" method="post" class=" md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <div class="mb-4">
            <x-label for="home_id">Ton équipe</x-label>
            <x-select id="home_id" name="home_id" :options="$ownTeams->pluck('name', 'id')" :value="old('home_id')"/>
        </div>
        <div class="mb-4">
            <x-label for="home_score">Ton score</x-label>
            <x-input id="home_score" type="text" name="home_score" :value="old('home_score')"/>
        </div>
        <div class="mb-4">
            <x-label for="away_id">Ton adversaire</x-label>
            <x-select id="away_id" name="away_id" :options="$opponents->pluck('name', 'id')" :value="old('away_id')"/>
        </div>
        <div class="mb-4">
            <x-label for="away_score">Son score</x-label>
            <x-input id="away_score" type="text" name="away_score" :value="old('away_score')"/>
        </div>
        <x-button class="w-full">
            Envoyer
        </x-button>
    </form>
@endsection
