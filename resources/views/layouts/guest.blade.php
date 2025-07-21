<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased" style="background-color: rgb(195, 233, 237);">
    <div class="min-h-screen h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="w-full max-w-6xl mx-auto mt-6 bg-white shadow-md rounded-lg p-8">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
