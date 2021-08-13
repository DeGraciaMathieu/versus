@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-4 md:w-2/3 md:mx-auto">
        Authentification
    </h1>
    <div class="text-white text-sm text-center mt-8 md:w-2/3 md:mx-auto bg-secondary-dark py-4 mb-8">
        Tu n'as pas de compte ? <a href="{{ route('register') }}" class="underline hover:text-primary">Inscris toi !</a>
    </div>
    <form action="{{ route('login') }}" method="post" class="md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <div class="mb-4">
            <x-label for="email">Email</x-label>
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>
        <div class="mb-4">
            <x-label for="password">Mot de passe</x-label>
            <x-input id="password" type="password" name="password" required autocomplete="current-password" />
        </div>

        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ml-2 text-sm">Se souvenir de moi</span>
            </label>
        </div>

        <x-button>
            Se connecter
        </x-button>

{{--        <div class="mt-4 text-center">--}}
{{--            <a href="#" class="text-sm underline hover:text-primary">Mot de passe oublié ?</a>--}}
{{--        </div>--}}
    </form>
@endsection
