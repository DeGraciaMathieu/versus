<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Icons -->
        <link href="{{ asset('images/favicon-16x16.png') }}" rel="icon" sizes="16x16"/>
        <link href="{{ asset('images/favicon-32x32.png') }}" rel="icon" sizes="32x32"/>
        <link href="{{ asset('images/favicon-96x96.png') }}" rel="icon" sizes="96x96"/>
        <link href="{{ asset('images/favicon-256x256.png') }}" rel="icon" sizes="256x256"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Bangers:400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased bg-secondary">
        <div id="app">

            <!-- Page Heading -->
            <header class="flex justify-between items-center flex-wrap bg-secondary-dark pl-2 pr-4">
                <div class="block self-center md:hidden hover:bg-gray-600 rounded">
                    <button id="buttonMenu" class="flex items-center p-2 text-white focus:outline-none" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="text-3xl text-primary my-2 md:mr-4 md:my-0 md:w-auto md:text-left self-center font-logo">Versus</div>

                <nav class="hidden text-white md:flex md:items-center md:w-auto">
                    <a href="{{ route('ladder.index') }}" class="block py-4 pl-4 flex items-center md:inline-block hover:text-primary">
                        Ladders
                    </a>
                    @can('viewAny', 'App\Models\User')
                        <a href="{{ route('user.index') }}" class="block py-4 pl-4 flex items-center md:inline-block hover:text-primary">
                            Utilisateurs
                        </a>
                    @endcan
                </nav>

                @auth
                    <div class="md:flex-grow md:flex md:justify-end">
                        <div class="ml-3 relative">
                            <button type="button" id="buttonUserMenu" onclick="toggleUserMenu()" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full" src="{{ route('image', Auth::user()->getPhoto()) }}" alt="">
                            </button>
                            <div id="navUserMenu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
{{--                                <a href="{{ route('home.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon compte</a>--}}
                                <a href="{{ route('home.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Se déconnecter
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="md:flex-grow md:flex md:justify-end">
                        <a href="{{ route('login') }}" class="bg-primary text-white flex text-sm rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </a>
                    </div>
                @endauth

                <nav id="navMenu" class="w-full block flex-grow text-white hidden">
                    <a href="{{ route('ladder.index') }}" class="block py-4 pl-4 flex items-center md:inline-block md:mt-0 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                        Ladders
                    </a>
                    @can('viewAny', 'App\Models\User')
                        <a href="{{ route('user.index') }}" class="block py-4 pl-4 flex items-center md:inline-block md:mt-0 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Utilisateurs
                        </a>
                    @endcan
                </nav>
            </header>

            <!-- Page Content -->
            <main class="mx-4 mt-4">
                @yield('content')
            </main>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
