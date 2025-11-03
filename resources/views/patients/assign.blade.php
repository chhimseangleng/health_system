<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-extrabold text-purple-700 tracking-tight">
                            {{ trans('lang.assign patient to service') }}
                        </h2>
                        <a href="{{ route('patients.index') }}" class="text-gray-400 hover:text-purple-600 transition-colors duration-200 p-2 rounded-full hover:bg-purple-50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Patient Information -->
                    <div class="bg-purple-50 border border-purple-100 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-purple-700 mb-5">{{ trans('lang.patient information') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block uppercase tracking-wider text-purple-700 font-semibold mb-1">{{ trans('lang.name') }}</label>
                                <p class="text-gray-900 text-lg font-semibold">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                            </div>
                            <div>
                                <label class="block uppercase tracking-wider text-purple-700 font-semibold mb-1">{{ trans('lang.phone number') }}</label>
                                <p class="text-gray-900 text-lg font-semibold">{{ $patient->phone }}</p>
                            </div>
                            <div>
                                <label class="block uppercase tracking-wider text-purple-700 font-semibold mb-1">{{ trans('lang.date of birth') }}</label>
                                <p class="text-gray-900">{{ $patient->date_of_birth }}</p>
                            </div>
                            <div>
                                <label class="block uppercase tracking-wider text-purple-700 font-semibold mb-1">
                                    {{ trans('lang.gender') }}
                                </label>
                                <p class="text-gray-900">
                                    {{ trans('lang.' . strtolower($patient->gender)) }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block uppercase tracking-wider text-purple-700 font-semibold mb-1">{{ trans('lang.address') }}</label>
                                <p class="text-gray-900">{{ $patient->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Form -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-inner">
                        <h3 class="text-lg font-bold text-purple-700 mb-6">{{ trans('lang.select service') }}</h3>

                        <form action="{{ route('patients.assign', $patient->_id) }}" method="POST" class="space-y-7">
                            @csrf

                            <div>
                                <label for="assigned_to" class="block text-lg font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.assign to service') }}
                                </label>
                                <select id="assigned_to" name="assigned_to"
                                    class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all duration-200 bg-purple-50"
                                    required>
                                    <option value="" disabled selected>{{ trans('lang.select a service') }}</option>
                                    @foreach($assignmentTypes as $type)
                                    <option value="{{ $type }}">
                                        {{ trans('lang.' . strtolower($type)) !== 'lang.' . strtolower($type)
                                            ? trans('lang.' . strtolower($type))
                                            : ucfirst($type) }}
                                    </option>
                                @endforeach

                                </select>
                                @error('assigned_to')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="assigned_user_id" class="block text-lg font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.assign to user') }}
                                </label>
                                <select id="assigned_user_id" name="assigned_user_id"
                                    class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all duration-200 bg-purple-50"
                                    required>
                                    <option value="" disabled selected>{{ trans('lang.select a user') }}</option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{ $user->_id }}">{{ $user->name }} ({{ $user->role }})</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>{{ trans('lang.no users available') }}</option>
                                    @endif
                                </select>
                                @error('assigned_user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_type" class="block text-lg font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.payment type') }}
                                </label>
                                <select id="payment_type" name="payment_type"
                                    class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all duration-200 bg-purple-50"
                                    required>
                                    <option value="" disabled selected>{{ trans('lang.select payment type') }}</option>
                                    @foreach($paymentTypes as $key => $value)
                                        {{-- <option value="{{ $key }}">{{ $value }}</option> --}}
                                        <option value="{{ $key }}">
                                            {{ trans('lang.' . strtolower($key)) !== 'lang.' . strtolower($key)
                                                ? trans('lang.' . strtolower($key))
                                                : $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-4 pt-5">
                                <a href="{{ route('patients.index') }}"
                                    class="flex items-center px-6 py-3 text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-xl font-semibold transition shadow-xs hover:text-purple-800">
                                    {{ trans('lang.cancel') }}
                                </a>
                                <button type="submit"
                                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium transition-colors duration-200 flex items-center">
                                    <svg aria-hidden="true" class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ trans('lang.assign patient') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
