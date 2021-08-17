@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto md:flex md:items-center">
        <span class="md:flex-grow">
            Ladders
        </span>
        @can('create', App\Models\Ladder::class)
            <x-link href="{{ route('ladder.create') }}" class="hidden md:block p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </x-link>
        @endcan
    </h1>
    @can('create', App\Models\Ladder::class)
        <x-link href="{{ route('ladder.create') }}" class="md:hidden fixed bottom-0 right-0 p-3 mr-4 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </x-link>
    @endcan
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 md:w-2/3 md:mx-auto">
        @foreach($ladders as $ladder)
            <div class="bg-secondary-light flex flex-col">
                @if($ladder->thumbnail)
                    <div class="h-32 bg-cover bg-center" style="background-image: url({{ route('image', $ladder->thumbnail) }})">&nbsp;</div>
                @endif
                <div class="flex-grow px-6 py-4">
                    <div class="font-bold text-xl text-primary mb-2">
                        {{ $ladder->name }}
                    </div>
                    <p class="text-white text-sm text-shadow">
                        {{ $ladder->description }}
                    </p>
                    <ul class="text-gray-300 text-sm mt-4">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $ladder->teams_count }} participants
                        </li>
                        <li class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Créé le {{ $ladder->created_at->format('d/m/Y') }}
                        </li>
                    </ul>
                </div>
                <div class="flex items-stretch justify-between mt-4">
                    @can('update', $ladder)
                        <x-link-secondary href="{{ route('ladder.edit', $ladder) }}" class="p-3 m-4 w-full">Éditer</x-link-secondary>
                    @endcan
                    <x-link href="{{ route('ladder.ranking', $ladder) }}" class="p-3 m-4 w-full">Voir</x-link>
                </div>
            </div>
        @endforeach
    </div>
@endsection
