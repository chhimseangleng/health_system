<x-app-layout>
    <div class="py-12 bg-gradient-to-tr from-blue-50 via-white to-green-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="px-10 py-8">
                <div class="mb-10 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-tr bg-blue-600 to-blue-400 rounded-full flex items-center justify-center shadow-lg mb-3">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 013.894 3.017A5.002 5.002 0 0117 13v1a3 3 0 01-3 3h-4a3 3 0 01-3-3v-1a5.002 5.002 0 011.106-5.629A4 4 0 0112 4.354zm0 0V3m0 1.354V3"/>
                            <circle cx="12" cy="6" r="2" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-blue-900 mb-1 tracking-tight">
                        {{ trans('lang.create an account') }}
                    </h2>
                    <p class="text-gray-500 text-base mb-2">{{ trans('lang.please fill in the information below to register') }}.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-5 py-4 rounded-xl shadow">
                        <ul class="list-disc list-inside ml-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="space-y-7">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                               class="w-full px-4 py-3 border @error('name') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                               value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ trans('lang.enter name') }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.email') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                               class="w-full px-4 py-3 border @error('email') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                               value="{{ old('email') }}" required autocomplete="username" placeholder="{{ trans('lang.enter your email') }}">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label for="role" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.select role') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role"
                                class="w-full px-4 py-3 border @error('role') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-gray-800 bg-white"
                                required>
                            <option value="" disabled selected>{{ trans('lang.select a role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ __('Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 border @error('password') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                               required autocomplete="new-password" placeholder="{{ __('Password') }}">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-3 border @error('password_confirmation') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                               required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-bold rounded-xl shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                            {{ trans('lang.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
