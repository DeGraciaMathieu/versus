@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto md:flex md:items-center">
        <span class="md:flex-grow">
            <a href="{{ route('ladder.index') }}" class="text-primary hover:text-white">Ladders</a> / {{ $ladder->name }}
        </span>
        <x-link href="{{ route('game.create', $ladder) }}" class="hidden md:block p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </x-link>
    </h1>
    <x-link href="{{ route('game.create', $ladder) }}" class="md:hidden fixed bottom-0 right-0 p-3 mr-4 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </x-link>
    <div class="overflow-hidden">
        <div class="text-white flex items-stretch justify-between md:justify-start mb-6 overflow-auto md:w-2/3 md:mx-auto">
            <a href="{{ route('ladder.ranking', $ladder) }}" class="border-primary hover:border-primary py-4 px-4 border-b-2 text-center flex-grow md:flex-grow-0">Classement</a>
            <a href="{{ route('game.index', $ladder) }}" class="border-secondary-light hover:border-primary py-4 px-4 border-b-2 text-center border-green-500 flex-grow md:flex-grow-0">Matchs</a>
            @can('update', $ladder)
                <a href="{{ route('ladder.edit', $ladder) }}" class="border-secondary-light hover:border-primary py-4 px-4 border-b-2 text-center border-purple-500 flex-grow md:flex-grow-0">Éditer</a>
            @endcan
        </div>
    </div>
    <div class="grid grid-cols-1 md:w-2/3 md:mx-auto text-white">
        @foreach($teams as $team)
            <div class="flex flex-row mb-6 border-b {{ $team->current ? 'border-white' : 'border-primary' }}">
                <div class="{{ $team->current ? 'bg-white text-primary' : 'bg-primary' }} text-2xl h-16 w-16 font-logo flex items-center justify-center">
                    {{ $team->rank }}
                </div>
                <div class="flex-grow self-center w-4/6 pl-3 py-2">
                    <div>
                        {{ $team->name }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $team->elo }} pts
                    </div>
                </div>
                <div class="flex flex-row items-center justify-end space-x-1">
                    @foreach($team->games->reverse() as $game)
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ 'text-' . ($game->pivot->won ? 'green' : 'red') . '-500'  }}" fill="currentColor" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
