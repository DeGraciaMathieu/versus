@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto">
        <a href="{{ route('user.index') }}" class="text-primary hover:text-white">Utilisateurs</a> / {{ $user->name }}
    </h1>
    <form action="{{ route('user.update', $user) }}" method="post" class="md:w-2/3 md:mx-auto mb-4 text-white font-bold">
        @method('put')
        @csrf
        <div class="mb-4">
            <x-label for="name">Nom</x-label>
            <x-input id="name" type="text" name="name" :value="old('name', $user->name)" />
        </div>
        <div class="mb-4">
            <x-label for="email">Email</x-label>
            <x-input id="email" type="text" name="email" :value="old('email', $user->email)" />
        </div>
        <div class="mb-4">
            <x-label for="role">Rôle</x-label>
            <x-select id="role" name="role" :options="['member' => __('Membre'), 'admin' => __('Admin')]" :value="old('role', $user->role)"/>
        </div>

        <x-button class="w-full">
            Enregistrer
        </x-button>
    </form>
@endsection

