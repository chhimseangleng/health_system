<div id="edit-modal-{{ $patient->_id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-xl shadow-2xl border border-gray-200">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ trans('lang.edit patient information') }}
                    </h3>
                </div>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-10 h-10 ms-auto inline-flex justify-center items-center transition-colors duration-200"
                    data-modal-toggle="edit-modal-{{ $patient->_id }}">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                    <span class="sr-only">{{ trans('lang.close modal') }}</span>
                </button>
            </div>

            <form class="p-6" method="POST" action="{{ route('patients.update', $patient->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-6 mb-6 grid-cols-1 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="first_name" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.first name') }} </span>
                        </label>
                        <input type="text" name="first_name" id="first_name"
                            value="{{ old('first_name', $patient->first_name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            placeholder="{{ trans('lang.enter first name') }}" required>
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="last_name" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.last name') }} </span>
                        </label>
                        <input type="text" name="last_name" id="last_name"
                            value="{{ old('last_name', $patient->last_name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            placeholder="{{ trans('lang.enter last name') }}" required>
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.date of birth') }} </span>
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            value="{{ old('date_of_birth', $patient->date_of_birth) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            required>
                        @error('date_of_birth')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                     <div class="space-y-2">
                        <label for="gender" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.gender') }} </span>
                        </label>
                        <select id="gender" name="gender"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            required>
                            <option value="" disabled {{ $patient->gender ? '' : 'selected' }}>{{ trans('lang.select gender') }}</option>
                            <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>{{ trans('lang.male') }}</option>
                            <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>{{ trans('lang.female') }}</option>
                            {{-- <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option> --}}
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.phone number') }} </span>
                        </label>
                        <input type="tel" name="phone" id="phone"
                            value="{{ old('phone', $patient->phone) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            placeholder="Enter phone number" required>
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700 text-left">
                            {{ trans('lang.address') }} </span>
                        </label>
                        <input type="text" name="address" id="address"
                            value="{{ old('address', $patient->address) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            placeholder="{{ trans('lang.enter address') }}" required>
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>



                    {{-- <div class="space-y-2">
                        <label for="role" class="block text-sm font-semibold text-gray-700 text-left">
                            Patient Role </span>
                        </label>
                        <select id="role" name="role"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                            required>
                            <option value="" disabled {{ !$patient->role ? 'selected' : '' }}>Select role</option>
                            <option value="vaccine" {{ old('role', $patient->role) == 'vaccine' ? 'selected' : '' }}>Vaccine</option>
                            <option value="common disease" {{ old('role', $patient->role) == 'common disease' ? 'selected' : '' }}>Common Disease</option>
                            <option value="gynecology" {{ old('role', $patient->role) == 'gynecology' ? 'selected' : '' }}>Gynecology</option>
                                    <option value="medicine" {{ old('role', $patient->role) == 'medicine' ? 'selected' : '' }}>{{ trans('lang.medicine') }}</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg transition-colors duration-200"
                            data-modal-toggle="edit-modal-{{ $patient->_id }}">
                            {{ trans('lang.cancel') }}
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white  bg-blue-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ trans('lang.update patient') }}
                        </button>
                    </div>
                </form>
            </form>
        </div>
    </div>
</div>
