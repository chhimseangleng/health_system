<x-app-layout>
    <div class="py-16 min-h-screen bg-gradient-to-b from-blue-100 via-white to-blue-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Outer Card --}}
            <div class="bg-white rounded-3xl shadow-2xl border border-blue-200 overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between px-10 py-8 bg-gradient-to-r bg-blue-400 via-blue-200 to-blue-100">
                    <div>
                        <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight drop-shadow-sm">Edit Disease</h1>
                        <p class="text-blue-700 mt-1 font-medium">Update information for this common disease.</p>
                    </div>
                    <a href="{{ route('workspace.common-diseases.index') }}"
                       class="mt-6 md:mt-0 inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-gray-700 to-gray-900 hover:from-blue-700 hover:to-blue-900 text-white font-semibold rounded-lg shadow-md transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>

                {{-- Alerts --}}
                <div class="px-10 pt-8 space-y-3">
                    @if(session('success'))
                        <div class="px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-900 font-semibold shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800 font-semibold shadow-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Form Card --}}
                <div class="px-10 py-8 mt-8 bg-white rounded-2xl shadow-lg ring-2 ring-blue-100">
                    <h2 class="text-xl md:text-2xl font-bold text-blue-900 mb-8">Edit Disease Information</h2>

                    <form action="{{ route('workspace.common-diseases.update', $disease->_id) }}" method="POST" class="space-y-7">
                        @csrf
                        @method('PUT')

                        {{-- Grid Inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                            {{-- Disease Name --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Disease Name</label>
                                <input name="name" type="text" value="{{ old('name', $disease->name) }}"
                                       placeholder="e.g. Flu"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror transition"/>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            {{-- <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Category</label>
                                <select name="category"
                                    class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('category') border-red-500 @enderror transition">
                                    <option value="">Select Category</option>
                                    <option value="Viral" {{ old('category', $disease->category) == 'Viral' ? 'selected' : '' }}>Viral</option>
                                    <option value="Bacterial" {{ old('category', $disease->category) == 'Bacterial' ? 'selected' : '' }}>Bacterial</option>
                                    <option value="Parasitic" {{ old('category', $disease->category) == 'Parasitic' ? 'selected' : '' }}>Parasitic</option>
                                    <option value="Fungal" {{ old('category', $disease->category) == 'Fungal' ? 'selected' : '' }}>Fungal</option>
                                    <option value="Other" {{ old('category', $disease->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            {{-- Physician --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Physician</label>
                                <input name="physician" type="text" value="{{ old('physician', $disease->physician) }}"
                                       placeholder="e.g. Dr. Sok"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('physician') border-red-500 @enderror transition"/>
                                @error('physician')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Age --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Age</label>
                                <input name="age" type="number" min="0" max="150" value="{{ old('age', $disease->age) }}"
                                       placeholder="e.g. 3"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('age') border-red-500 @enderror transition"/>
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Phone Number</label>
                                <input name="phone" type="text" value="{{ old('phone', $disease->phone) }}"
                                       placeholder=""
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('phone') border-red-500 @enderror transition"/>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            {{-- Gender --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Gender</label>
                                <select name="gender"
                                        class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('gender') border-red-500 @enderror transition">
                                    <option value="">Select Gender</option>
                                    <option value="M" {{ old('gender', $disease->gender) == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ old('gender', $disease->gender) == 'F' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Drug Diagnosis --}}
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-base font-semibold text-blue-800">Diagnosis</label>
                                <input name="drug_diagnosis" type="text"
                                       value="{{ old('drug_diagnosis', $disease->drug_diagnosis) }}"
                                       placeholder="e.g. Paracetamol"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('drug_diagnosis') border-red-500 @enderror transition"/>
                                @error('drug_diagnosis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Village --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Village</label>
                                <input name="village" type="text" value="{{ old('village', $disease->village) }}"
                                       placeholder="e.g. Trapeang Russey"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('village') border-red-500 @enderror transition"/>
                                @error('village')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Commune --}}
                            <div>
                                <label class="block mb-2 text-base font-semibold text-blue-800">Commune</label>
                                <input name="commune" type="text" value="{{ old('commune', $disease->commune) }}"
                                       placeholder="e.g. Ta Sal"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('commune') border-red-500 @enderror transition"/>
                                @error('commune')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Staff Name --}}
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-base font-semibold text-blue-800">Staff Name</label>
                                <input name="staff_name" type="text" value="{{ old('staff_name', $disease->staff_name) }}"
                                       placeholder="e.g. Nurse Dara"
                                       class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('staff_name') border-red-500 @enderror transition"/>
                                @error('staff_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-row justify-end gap-4 mt-8">
                            <a href="{{ route('workspace.common-diseases.index') }}"
                               class="px-6 py-2 rounded-lg border border-blue-300 text-blue-700 font-semibold bg-white hover:bg-blue-50 shadow-sm transition">Cancel</a>
                            <button type="submit"
                                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold rounded-lg shadow-lg transition">Update Disease</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
