<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Carter+One:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <div id="app">
            <div class="min-h-screen bg-blue-800">

                <!-- Page Heading -->
                <header class="bg-blue-900 border-b-2 border-black text-white">
                    <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8 font-title text-4xl text-yellow-star text-center text-shadow">
                        <a href="{{ url('/') }}">Versus</a>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="mx-4 mt-4">
                    @yield('content')
                </main>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
