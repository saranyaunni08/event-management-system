<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Event Management System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold mb-4">Welcome to Event Management System</h1>
            @auth
                <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">Go to Events</a>
            @else
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                </div>
            @endauth
        </div>
    </body>
</html>