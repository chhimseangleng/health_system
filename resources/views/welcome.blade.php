<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen bg-gradient-to-br from-blue-50 via-cyan-100 to-blue-200">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Centered content -->
    <div class="relative max-w-6xl mx-auto h-full flex items-center justify-center px-4">
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl flex w-full max-w-5xl p-8 border border-white/20">
            <!-- Left side content -->
            <div class="w-1/2 flex flex-col justify-center items-center space-y-8 pr-8">
                <div class="text-center space-y-4">
                    <img src="{{ asset('IMG/samaky.png') }}" alt="Samky Logo" class="w-36 mx-auto drop-shadow-lg" />
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                        {{ trans('lang.welcome to samaky health center') }}
                    </h1>
                    <p class="text-gray-600 text-lg max-w-md">
                        {{ trans('lang.providing exceptional healthcare services with compassion and excellence') }}
                    </p>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('login') }}"
                        class="group relative px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 hover:shadow-lg font-semibold">
                        <span class="relative z-10">{{ trans('lang.login') }}</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>

                    {{-- <a href="{{ route('register') }}"
                        class="px-8 py-3 bg-white text-blue-600 border-2 border-blue-500 rounded-xl hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 hover:shadow-lg font-semibold">
                        Sign Up
                    </a> --}}
                </div>

                <!-- Feature highlights -->
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-blue-800">{{ trans('lang.quality care') }}</p>
                    </div>
                    <div class="text-center p-3 bg-cyan-50 rounded-lg">
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-cyan-800">{{ trans('lang.expert staff') }}</p>
                    </div>
                </div>
            </div>

            <!-- Right side image -->
            <div class="w-1/2 flex items-center justify-center pl-8">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-3xl transform rotate-3 scale-105 opacity-20"></div>
                    <img src="{{ asset('IMG/doctor.jpg') }}" alt="Hospital Icon" class="w-96 h-96 object-cover rounded-3xl shadow-2xl relative z-10" />
                </div>
            </div>
        </div>
    </div>

    <!-- Floating elements -->
    <div class="absolute bottom-8 left-8 text-gray-400 text-sm">
        <p>© 2025 {{ trans('lang.samaky health center') }}. {{ trans('lang.all rights reserved') }}.</p>
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
