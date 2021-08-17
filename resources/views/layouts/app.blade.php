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
            <header class="flex justify-between flex-wrap bg-secondary-dark">
                <div class="text-3xl text-primary ml-4 my-2 md:mt-0 md:my-0 md:mx-4 md:w-auto md:text-left self-center font-logo">Versus</div>

                <div class="block self-center mr-4 md:hidden">
                    <button id="buttonMenu" class="flex items-center px-3 py-2 text-white focus:outline-none" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <nav id="navMenu" class="w-full block flex-grow text-white mt-2 md:mt-0 md:flex md:items-center md:w-auto hidden">
                    <div class="md:flex-grow md:flex md:justify-end">
                        <a href="{{ route('ladder.index') }}" class="block py-4 pl-4 flex items-center md:inline-block md:mt-0 hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                            Ladders
                        </a>
                        @auth
                            <a href="#" class="block py-4 pl-4 flex items-center md:inline-block md:mt-0 hover:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ Auth::user()->name }}
                            </a>
                        @endauth
                    </div>
                    <div>
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block m-4 p-3">
                                    Se déconnecter
                                </x-link>
                            </form>
                        @else
                            <x-link href="{{ route('login') }}" class="block m-4 p-3">
                                Se connecter
                            </x-link>
                        @endauth
                    </div>
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
