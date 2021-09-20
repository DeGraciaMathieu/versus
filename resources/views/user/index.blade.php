@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto md:flex md:items-center">
        Utilisateurs
    </h1>
    <div class="overflow-auto">
    <table class="text-white w-full md:w-2/3 md:mx-auto whitespace-nowrap border-collapse">
        <thead>
            <tr class="bg-secondary-dark uppercase text-xs">
                <th class="py-2 px-4 text-left">Nom</th>
                <th class="py-2 px-4 text-left">Email</th>
                <th class="py-2 px-4 text-left">Rôle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="bg-secondary-light border-b border-secondary-dark">
                    <td class="py-4 px-4 text-left">
                        @can('update', $user)
                            <a class="text-primary hover:text-white" href="{{ route('user.edit', $user) }}">{{ $user->name }}</a>
                        @else
                            {{ $user->name }}
                        @endcan
                    </td>
                    <td class="py-4 px-4 text-left">{{ $user->email }}</td>
                    <td class="py-4 px-4 text-left">{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
