<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-purple-50/40 backdrop-blur-sm overflow-y-auto overflow-x-hidden">
    <div class="relative p-6 w-full max-w-4xl max-h-[90vh]">
        <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ trans('lang.add new patient') }}</h3>
                        <p class="text-base text-gray-500 mt-2">{{ trans('lang.enter patient information below') }}</p>
                    </div>
                </div>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-10 h-10 inline-flex justify-center items-center transition-colors"
                    data-modal-toggle="default-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ trans('lang.close modal') }}</span>
                </button>
            </div>



            <!-- Form -->
            <form action="{{ route('patients.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Personal Information -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.first name') }}
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                placeholder="{{ trans('lang.enter first name') }}" required>
                        </div>
                        <div>
                            <label for="last_name"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.last name') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                placeholder="{{ trans('lang.enter last name') }}" required>
                        </div>
                        <div>
                            <label for="date_of_birth"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.date of birth') }}</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                required>
                        </div>
                        <div>
                            <label for="gender"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.gender') }} <span
                                    class="text-red-500">*</span></label>
                            <select id="gender" name="gender"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                required>
                                <option value="" disabled selected>{{ trans('lang.select gender') }}</option>
                                <option value="male">{{ trans('lang.male') }}</option>
                                <option value="female">{{ trans('lang.female') }}</option>
                                {{-- <option value="other">{{ trans('lang.other') }}</option> --}}
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-6">
                    {{-- <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Contact Information
                    </h4> --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.phone number') }}
                                <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" id="phone"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                placeholder="{{ trans('lang.enter phone number') }}" required>
                        </div>
                        <div>
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.address') }}
                                </span></label>
                            <input type="text" name="address" id="address"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                placeholder="{{ trans('lang.enter address') }}">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button"
                        class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors duration-200"
                        data-modal-toggle="default-modal">
                        {{ trans('lang.cancel') }}
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ trans('lang.submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
