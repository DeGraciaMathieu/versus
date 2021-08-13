@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-4 md:w-2/3 md:mx-auto">
        Enregistrement
    </h1>
    <form action="{{ route('register') }}" method="post" class="md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <div class="mb-4">
            <x-label for="name">Nom</x-label>
            <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name')" required autofocus />
        </div>
        <div class="mb-4">
            <x-label for="email">Email</x-label>
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>
        <div class="mb-4">
            <x-label for="password">Mot de passe</x-label>
            <x-input id="password" type="password" name="password" required autocomplete="new-password" />
        </div>
        <div class="mb-4">
            <x-label for="password_confirmation">Confirmation</x-label>
            <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <x-button>
            S'enregistrer
        </x-button>
    </form>
@endsection
