<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <a href="#" class="block py-4 pl-4 flex items-center md:inline-block md:mt-0 hover:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 md:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Administration
                            </a>
                        @endif
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
