@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-4 md:w-2/3 md:mx-auto">
        Mot de passe oublié
    </h1>
    <div class="text-white text-sm text-center mt-8 md:w-2/3 md:mx-auto bg-secondary-dark py-4 px-2 mb-8">
        Renseigne ton email et nous t'enverrons un email de récupération de mot de passe.
    </div>
    <x-errors class="mb-8" :errors="$errors"/>
    <form action="{{ route('password.email') }}" method="post" class="md:w-2/3 md:mx-auto text-white font-bold">
        @csrf
        <div class="mb-4">
            <x-label for="email">Email</x-label>
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <x-button>
            Envoyer
        </x-button>
    </form>
@endsection
