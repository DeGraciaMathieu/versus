@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto">
        <a href="{{ route('ladder.index') }}" class="text-primary hover:text-white">Ladders</a> / {{ $ladder->name }}
    </h1>
    <div class="overflow-hidden">
        <div class="text-white flex items-stretch justify-between md:justify-start mb-6 overflow-auto md:w-2/3 md:mx-auto">
            <a href="{{ route('ladder.ranking', $ladder) }}" class="border-secondary-light hover:border-primary py-4 px-4 border-b-2 text-center flex-grow md:flex-grow-0">Classement</a>
            <a href="{{ route('game.index', $ladder) }}" class="border-primary hover:border-primary py-4 px-4 border-b-2 text-center border-green-500 flex-grow md:flex-grow-0">Matchs</a>
            @can('edit', $ladder)
                <a href="{{ route('ladder.edit', $ladder) }}" class="border-secondary-light hover:border-primary py-4 px-4 border-b-2 text-center border-purple-500 flex-grow md:flex-grow-0">Éditer</a>
            @endcan
        </div>
    </div>
    <div class="overflow-auto">
        <table class="text-white w-full md:w-2/3 md:mx-auto whitespace-nowrap border-collapse">
            <thead>
                <tr class="bg-secondary-dark uppercase text-xs">
                    <th class="py-2 px-4 text-left">Date</th>
                    <th class="py-2 px-4 text-center" colspan="3">Score</th>
                    <th class="py-2 px-4 text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr class="bg-secondary-light border-b border-secondary-dark">
                        <td class="py-4 px-4 text-left">{{ $game->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-4 px-2 text-right">{{ $game->teams->first()->name }}</td>
                        <td class="py-4 px-2 text-center">
                            {{ $game->teams->first()->pivot->score }} - {{ $game->teams->last()->pivot->score }}
                        </td>
                        <td class="py-4 px-2 text-left">{{ $game->teams->last()->name }}</td>
                        <td class="py-4 px-4 text-left flex items-center justify-end">
                            @can('delete', $game)
                                <form method="POST" action="{{ route('game.destroy', [$ladder, $game]) }}" class="flex">
                                    @method('delete')
                                    @csrf

                                    <x-link href="{{ route('game.destroy', [$ladder, $game]) }}" onclick="event.preventDefault(); this.closest('form').submit();" class="p-2 inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </x-link>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
