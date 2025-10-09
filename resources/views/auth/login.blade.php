<x-guest-layout>
    <body class="h-screen" style="background-color: rgb(195, 233, 237);">
        <!-- Centered box -->
        <div class="max-w-6xl mx-auto h-full flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg flex w-full p-8">
                <!-- Left side: login form -->
                <div class="w-1/2 flex flex-col justify-center px-8 space-y-6">
                    <img src="{{ asset('IMG/samaky.png') }}" alt="Samky Logo" class="w-32 mb-6 mx-auto" />
                    <h1 class="text-3xl font-bold mb-4 text-center">Login to Samky Hospital</h1>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                            @if ($errors->any())
    <div class="mb-4 text-red-600 font-semibold text-center">
        {{ $errors->first() }}
    </div>
@endif

                        </div>
                    </form>
                </div>

                <!-- Right side: doctor image -->
                <div class="w-1/2 flex items-center justify-center pl-8">
                    <img src="{{ asset('IMG/doctor.jpg') }}" alt="Hospital Icon" class="w-full max-w-[600px]" />
                </div>
            </div>
        </div>
    </body>
</x-guest-layout>
