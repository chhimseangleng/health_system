<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Disease</h1>
                                <p class="text-gray-500 mt-1">Update common disease information</p>
                            </div>
                            <a href="{{ route('workspace.common-diseases.index') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-sm transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to List
                            </a>
                        </div>

                        <div class="mb-6">
                            @if (session('success'))
                                <div class="mb-4 px-4 py-3 rounded-xl bg-green-100 text-green-800">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 px-4 py-3 rounded-xl bg-red-100 text-red-800">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-lg ring-1 ring-gray-100">
                            <div class="text-lg font-bold text-gray-900 mb-6">Edit Disease Information</div>

                            <form action="{{ route('workspace.common-diseases.update', $disease->_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Disease Name</label>
                                        <input name="name" type="text"
                                            value="{{ old('name', $disease->name) }}"
                                            placeholder="e.g. Flu"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('name') border-red-500 @enderror"
                                            required />
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Category</label>
                                        <input name="category" type="text"
                                            value="{{ old('category', $disease->category) }}"
                                            placeholder="e.g. Viral"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('category') border-red-500 @enderror"
                                            required />
                                        @error('category')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Physician</label>
                                        <input name="physician" type="text"
                                            value="{{ old('physician', $disease->physician) }}"
                                            placeholder="e.g. Dr. Sok"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('physician') border-red-500 @enderror" />
                                        @error('physician')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Age</label>
                                            <input name="age" type="number" min="0" max="150"
                                                value="{{ old('age', $disease->age) }}"
                                                placeholder="e.g. 3"
                                                class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('age') border-red-500 @enderror" />
                                            @error('age')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Gender</label>
                                            <select name="gender"
                                                class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('gender') border-red-500 @enderror">
                                                <option value="">Select</option>
                                                <option value="M" {{ old('gender', $disease->gender) == 'M' ? 'selected' : '' }}>Male</option>
                                                <option value="F" {{ old('gender', $disease->gender) == 'F' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('gender')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Drug Diagnosis</label>
                                        <input name="drug_diagnosis" type="text"
                                            value="{{ old('drug_diagnosis', $disease->drug_diagnosis) }}"
                                            placeholder="e.g. Paracetamol"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('drug_diagnosis') border-red-500 @enderror" />
                                        @error('drug_diagnosis')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Village</label>
                                        <input name="village" type="text"
                                            value="{{ old('village', $disease->village) }}"
                                            placeholder="e.g. Trapeang Russey"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('village') border-red-500 @enderror" />
                                        @error('village')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Commune</label>
                                        <input name="commune" type="text"
                                            value="{{ old('commune', $disease->commune) }}"
                                            placeholder="e.g. Ta Sal"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('commune') border-red-500 @enderror" />
                                        @error('commune')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block mb-1 text-sm font-medium text-gray-700">Staff Name</label>
                                        <input name="staff_name" type="text"
                                            value="{{ old('staff_name', $disease->staff_name) }}"
                                            placeholder="e.g. Nurse Dara"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300 @error('staff_name') border-red-500 @enderror" />
                                        @error('staff_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <a href="{{ route('workspace.common-diseases.index') }}"
                                        class="px-5 py-2 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                                        Update Disease
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
