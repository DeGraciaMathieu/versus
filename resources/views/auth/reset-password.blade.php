@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-4 md:w-2/3 md:mx-auto">
        Mot de passe oublié
    </h1>
    <div class="text-white text-sm text-center mt-8 md:w-2/3 md:mx-auto bg-secondary-dark py-4 px-2 mb-8">
        Renseigne ton email et nous t'enverrons un email de récupération de mot de passe.
    </div>
    <form action="{{ route('password.update') }}" method="post" class="md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
            Changer le mot de passe
        </x-button>
    </form>
@endsection
