<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Assign Patient to Service</h2>
                        <a href="{{ route('patients.index') }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Patient Information -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="text-gray-900">{{ $patient->phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <p class="text-gray-900">{{ $patient->date_of_birth }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <p class="text-gray-900">{{ ucfirst($patient->gender) }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <p class="text-gray-900">{{ $patient->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Form -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Service</h3>

                        <form action="{{ route('patients.assign', $patient->_id) }}" method="POST">
                            @csrf

                            <div class="mb-6">
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-2">Assign to Service</label>
                                <select id="assigned_to" name="assigned_to"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    required>
                                    <option value="" disabled selected>Select a service</option>
                                    @foreach($assignmentTypes as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="mb-6">
                                <label for="assigned_user_id" class="block text-sm font-medium text-gray-700 mb-2">Assign to User</label>
                                <select id="assigned_user_id" name="assigned_user_id"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    required>
                                    <option value="" disabled selected>Select a user</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->_id }}">{{ $user->name }} ({{ $user->role }})</option>
                                    @endforeach
                                </select>
                                @error('assigned_user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="mb-6">
                                <label for="assigned_user_id" class="block text-sm font-medium text-gray-700 mb-2">Assign to User</label>
                                <select id="assigned_user_id" name="assigned_user_id"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    required>
                                    <option value="" disabled selected>Select a user</option>
                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{ $user->_id }}">{{ $user->name }} ({{ $user->role }})</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No users available</option>
                                    @endif
                                </select>
                                @error('assigned_user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                                <select id="payment_type" name="payment_type"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    required>
                                    <option value="" disabled selected>Select payment type</option>
                                    @foreach($paymentTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('payment_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('patients.index') }}"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium transition-colors duration-200">
                                    Assign Patient
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
