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
    <div class="grid grid-cols-1 md:w-2/3 md:mx-auto text-white">
        @foreach($teams as $team)
            <div class="flex items-center mb-6 border-b border-primary">
                <div class="bg-primary text-2xl h-16 w-16 font-logo flex items-center justify-center">
                    {{ $team->rank }}
                </div>
                <div class="self-center w-4/6 pl-3 py-2">
                    <div>
                        {{ $team->name }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $team->elo }} pts
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
