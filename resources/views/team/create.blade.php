@extends('layouts.app')

@section('content')
    <div class="max-w-sm mx-auto text-white text-xl text-shadow font-bold text-center bg-blue-700 py-2 mb-4">
        {{ $ladder->name }} : Inscription d'équipe
    </div>
    <div class="max-w-sm overflow-hidden mx-auto text-shadow">
        <form action="{{ route('team.store', $ladder) }}" method="post" class="px-3 py-6 bg-blue-500 border-b-2 border-t border-l border-r border-black mb-4 text-white font-bold">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="name">
                    Nom de votre équipe
                </label>
                <input id="name" type="text" name="name" placeholder="Best Team Ever" class="shadow appearance-none border w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="block text-center w-full text-white text-shadow uppercase bg-yellow-star font-bold py-1 border-b-4 border-yellow-600 sm:hover:shadow-lg">
                Let's go !
            </button>
        </form>
    </div>
@endsection
