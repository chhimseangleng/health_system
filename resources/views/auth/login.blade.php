<x-guest-layout>
    <body class="min-h-screen bg-gradient-to-br from-[#caf0f5] via-[#e5fafd] to-[#cae3f5] flex items-center justify-center py-8">
        <div class="flex justify-center w-full">
            <div class="flex flex-col lg:flex-row shadow-xl rounded-3xl bg-white overflow-hidden w-full max-w-5xl">

                <!-- Left side: login form -->
                <div class="w-full lg:w-1/2 flex flex-col justify-center p-10 lg:p-12">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('IMG/samaky.png') }}" alt="Samky Logo" class="w-24 h-24 object-contain mb-4" />
                        <h1 class="text-2xl md:text-3xl font-bold text-[#21809f] text-center mb-1">Sign In</h1>
                        <p class="text-center text-sm text-[#3a5c6b] mb-7">Welcome back! Please login to your account.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-[#21809f] font-medium text-sm mb-1">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                   class="block w-full px-4 py-2 rounded-lg bg-[#f4fafb] border border-[#bee0ed] focus:outline-none focus:ring-2 focus:ring-[#50bde3] transition" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-[#21809f] font-medium text-sm mb-1">{{ __('Password') }}</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                                       class="block w-full px-4 py-2 rounded-lg bg-[#f4fafb] border border-[#bee0ed] focus:outline-none focus:ring-2 focus:ring-[#50bde3] transition pr-10" />
                                <button type="button"
                                        @click="show = !show"
                                        class="absolute inset-y-0 right-0 px-3 flex items-center text-[#50bde3] hover:text-[#19788d]">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.3.97-.741 1.874-1.302 2.682A9.956 9.956 0 0112 19c-4.477 0-8.268-2.943-9.542-7z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 012.458 12c1.274 4.057 5.065 7 9.542 7
                                                 1.694 0 3.292-.421 4.698-1.172M15 12a3 3 0 00-4.243-2.829m0 0L3 3m7.757
                                                 6.171A3 3 0 0115 12m0 0a3 3 0 01-3 3m0 0a3 3 0 01-3-3"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                       class="rounded border-[#bee0ed] text-[#21809f] shadow-sm focus:ring-2 focus:ring-[#50bde3]" />
                                <span class="ml-2 text-sm text-[#19788d]">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-xs text-[#50bde3] hover:text-[#19788d] font-semibold transition" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit -->
                        <div>
                            <button type="submit"
                                    class="w-full py-2 rounded-xl bg-gradient-to-r from-[#48c2db] to-[#21809f] text-white font-bold text-lg shadow-md hover:from-[#21809f] hover:to-[#48c2db] transition duration-150 ease-in-out">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right side: doctor image & graphic bg -->
                <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#e9fcfe] via-[#caf0f5] to-[#e4ebf1] relative items-center">
                    <img src="{{ asset('IMG/doctor.jpg') }}" alt="Hospital Icon"
                         class="w-full max-w-[400px] mx-auto rounded-2xl border-8 border-white shadow-xl" />
                    <div class="absolute top-6 right-10 bg-[#50bde3] bg-opacity-80 rounded-full w-16 h-16 flex items-center justify-center shadow-lg z-10">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1112.21 3a7 7 0 108.79 9.79z"/>
                        </svg>
                    </div>
                    <div class="absolute left-0 bottom-0">
                        <svg width="160" height="120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="80" cy="60" rx="80" ry="60" fill="#caf0f5" fill-opacity=".5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-guest-layout>
