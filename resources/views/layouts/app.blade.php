<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @if (Auth::user()->is_admin)
                <!-- Admin user -->
                @include('layouts.sidebar')

                <main class="p-4 sm:ml-64">
                    <div class="p-3 rounded-lg mt-12">
                        @if (isset($header))
                            <header class="py-5 px-4 mb-5 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                <div class="max-w-xl">
                                    {{ $header }}
                                </div>
                            </header>
                        @endif
                        {{ $slot }}
                    </div>
                </main>
            @else
                <!-- Normal user -->
                @include('layouts.navigation')

                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="py-12 sm:px-12 lg:px-16 ">
                    {{ $slot }}
                </main>
            @endif
        </div>
    </body>
</html>
