<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-2 border-gray-200 border-dashed rounded-lg">

                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-8">
                        <a href="{{ route('workspace.vaccine.index') }}">
                            <button
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 bg-blue-600 hover:from-blue-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ trans('lang.back to vaccine list') }}
                            </button>
                        </a>

                        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">
                            {{ trans('lang.complete vaccine information') }}
                        </h1>

                        <div class="w-48"></div> <!-- Spacer -->
                    </div>

                    <!-- Patient Info Card -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 mb-8">
                        <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ trans('lang.patient information') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.name') }}:</span>
                                <p class="text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.date of birth') }}:</span>
                                <p class="text-gray-900">
                                    {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.age') }}:</span>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                    years</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.phone number') }}:</span>
                                <p class="text-gray-900">{{ $patient->phone }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.gender') }}:</span>
                                <p class="text-gray-900">{{ ucfirst($patient->gender) }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.address') }}:</span>
                                <p class="text-gray-900">{{ $patient->address }}</p>
                            </div>
                            {{-- @dd($patient->assignments()->latest()->first()) --}}
                            <div>
                                <span class="font-semibold text-gray-700">{{ trans('lang.payment type') }}:</span>
                                @php
                                    $currentAssignment = $patient->assignments()->latest()->first();
                                    $paymentType = $currentAssignment ? $currentAssignment->payment_type : null;
                                    $paymentColors = [
                                        'nssf' => 'bg-blue-100 text-blue-800',
                                        'cash' => 'bg-green-100 text-green-800',
                                        'health equity fund' => 'bg-yellow-100 text-yellow-800',

                                    ];
                                @endphp
                                @if ($paymentType)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$paymentType] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $paymentType === 'nssf' ? trans('lang.nssf member') : trans('lang.' . strtolower($paymentType)) }}
                                    </span>
                                @else
                                    <p class="text-gray-500">{{ trans('lang.not assigned') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vaccine Information Form -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ trans('lang.additional vaccine information') }}
                        </h3>

                        <form action="{{ route('workspace.vaccine.patient.store', $patient->_id) }}" method="POST"
                            class="space-y-6">
                            @csrf

                            <!-- Parents Information Section -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                                    {{ trans('lang.parents information') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Father Information -->
                                    <div class="space-y-4">
                                        <h5 class="text-md font-medium text-gray-700 border-b pb-2">
                                            {{ trans('lang.father') }}</h5>
                                        <div>
                                            <label for="father_name"
                                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.full name') }}</label>
                                            <input type="text" id="father_name" name="father_name" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                        <div>
                                            <label for="father_phone"
                                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.phone number') }}</label>
                                            <input type="tel" id="father_phone" name="father_phone" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                    </div>

                                    <!-- Mother Information -->
                                    <div class="space-y-4">
                                        <h5 class="text-md font-medium text-gray-700 border-b pb-2">
                                            {{ trans('lang.mother') }}</h5>
                                        <div>
                                            <label for="mother_name"
                                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.full name') }}</label>
                                            <input type="text" id="mother_name" name="mother_name" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                        <div>
                                            <label for="mother_phone"
                                                class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.phone number') }}</label>
                                            <input type="tel" id="mother_phone" name="mother_phone" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carer Information (Optional) -->
                            {{-- <div class="bg-yellow-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Carer Information (Optional)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="carer" class="block text-sm font-medium text-gray-700 mb-2">Carer Name</label>
                                        <input type="text" id="carer" name="carer"
                                            value="{{ $patient->carer }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors">
                                    </div>
                                    <div>
                                        <label for="carer_phone" class="block text-sm font-medium text-gray-700 mb-2">Carer Phone</label>
                                        <input type="tel" id="carer_phone" name="carer_phone"
                                            value="{{ $patient->carer_phone }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors">
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Location Information -->
                            <div class="bg-green-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                                    {{ trans('lang.location information') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="birth_location"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.birth location') }}</label>
                                        <input type="text" id="birth_location" name="birth_location" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    </div>
                                    <div>
                                        <label for="current_location"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.current location') }}</label>
                                        <input type="text" id="current_location" name="current_location" required
                                            value="{{ $patient->address }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- Vaccine Details -->
                            <div class="bg-purple-50 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                                    {{ trans('lang.vaccine details') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="vaccine_category_id"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.vaccine type') }}</label>
                                        <select id="vaccine_category_id" name="vaccine_category_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                            <option value="">{{ trans('lang.select vaccine type') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->_id }}">
                                                    {{ $category->name }} ({{ $category->dose }}
                                                    {{ trans('lang.doses') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="vaccination_date"
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.vaccination date') }}</label>
                                        <input type="date" id="vaccination_date" name="vaccination_date" required
                                            value="{{ now()->toDateString() }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.description/notes') }}</label>
                                    <textarea id="description" name="description" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                        placeholder="   {{ trans('lang.enter any additional notes or observations...') }}"></textarea>
                                </div>

                                <div class="mt-4 flex items-center">
                                    <input type="checkbox" id="comeback" name="comeback"
                                        class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <label for="comeback" class="ml-3 text-sm font-medium text-gray-700">
                                        {{ trans('lang.schedule for follow-up/next dose') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('workspace.vaccine.vaccineList') }}"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                    {{ trans('lang.cancel') }}
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r bg-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    {{ trans('lang.complete vaccine information') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
