<x-app-layout>
    <div class="py-12 bg-gradient-to-tr from-blue-50 via-white to-green-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="px-10 py-8">
                    <div class="mb-10 flex flex-col items-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-tr bg-blue-600 to-blue-400 rounded-full flex items-center justify-center shadow-lg mb-3">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-4 0-8 2-8 6v3h16v-3c0-4-4-6-8-6z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-blue-900 mb-1 tracking-tight">
                            {{ trans('lang.edit user') }}</h2>
                        <p class="text-gray-500 text-base">{{ trans('lang.update user information') }}</p>
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

                    <form method="POST" action="{{ route('doctors.update', $doctor->_id) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-7">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-base font-semibold text-blue-800 mb-2">
                                    <span class="inline-block mr-2">{{ trans('lang.name') }}</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $doctor->name) }}"
                                    class="w-full px-4 py-3 border @error('name') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                                    required placeholder="{{ trans('lang.name') }}">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-base font-semibold text-blue-800 mb-2">
                                    <span class="inline-block mr-2">{{ trans('lang.email') }}</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $doctor->email) }}"
                                    class="w-full px-4 py-3 border @error('email') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                                    required placeholder="{{ trans('lang.email') }}">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role Field -->
                            <div>
                                <label for="role" class="block text-base font-semibold text-blue-800 mb-2">
                                    <span class="inline-block mr-2">{{ trans('lang.medical specialization') }}</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select id="role" name="role"
                                    class="w-full px-4 py-3 border @error('role') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-gray-800 bg-white"
                                    required>
                                    <option value="" disabled selected>
                                        {{ trans('lang.select a specialization') }}</option>
                                    @foreach ($roles as $role)
                                        @php
                                            $translationKey = 'lang.' . strtolower($role->name);
                                            $translated = trans($translationKey);
                                        @endphp
                                        <option value="{{ $role->name }}"
                                            {{ old('role', $doctor->role) == $role->name ? 'selected' : '' }}>
                                            {{ $translated !== $translationKey ? $translated : ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end pt-8 border-t border-blue-100 mt-10 space-x-3">
                            <a href="{{ route('doctors.index') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-blue-200 text-blue-700 rounded-xl font-semibold shadow hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                {{ trans('lang.cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 border border-blue-600 transition">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ trans('lang.update user') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
