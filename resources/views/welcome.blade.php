<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Samky Hospital Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="h-screen" style="background-color: rgb(195, 233, 237);">
    <!-- Centered box -->
    <div class="max-w-5xl mx-auto h-full flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg flex w-full max-w-4xl p-8">
            <!-- Left side small box -->
<div class="w-1/2 flex flex-col justify-center items-center space-y-6 pr-8">
    <img src="{{ asset('IMG/samaky.png') }}" alt="Samky Logo" class="w-32 mb-6" />
    <h1 class="text-3xl font-bold mb-4 text-center">Welcome to Samky Hospital</h1>
    <div class="flex space-x-4">
        <a href="{{ route('login') }}"
            class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Login</a>
        {{-- <a href="{{ route('register') }}"
            class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Sign Up</a> --}}
    </div>
</div>

<!-- Right side small box -->
<div class="w-1/2 flex items-center justify-center pl-8">
    <img src="{{ asset('IMG/doctor.jpg') }}" alt="Hospital Icon" class="w-96" />
</div>

        </div>
    </div>
</body>

</html>
