<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl border border-white/20 overflow-hidden shadow-2xl">
                <div class="bg-gradient-to-r from-white to-blue-50/30 overflow-hidden">
                    <div class="p-8 lg:p-12">
                        <!-- Header -->
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-10">
                            <div class="mb-6 lg:mb-0">
                                <h1
                                    class="text-4xl font-bold bg-gradient-to-r  via-blue-800 bg-indigo-800 bg-clip-text text-transparent tracking-tight">
                                    {{ trans('lang.complete common disease information') }}
                                </h1>
                                <p class="text-gray-700 mt-2 text-lg">
                                    {{ trans('lang.fill in the patient\'s common disease details') }}</p>
                            </div>
                            <a href="{{ route('workspace.common-diseases.index') }}"
                                class="inline-flex items-center px-6 py-3  via-blue-800 bg-indigo-800  hover:via-blue-900 hover:bg-indigo-900 text-white rounded-xl font-medium transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                {{ trans('lang.back') }}
                            </a>
                        </div>

                        <!-- Patient Info Card -->
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 mb-10 border border-blue-200/50 shadow-lg">
                            <h3 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                {{ trans('lang.patient information') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.name') }}</label>
                                    <p class="text-blue-900 font-bold text-lg">{{ $patient->first_name }}
                                        {{ $patient->last_name }}</p>
                                </div>
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.date of birth') }}</label>
                                    <p class="text-blue-900 font-semibold">
                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.age') }}</label>
                                    <p class="text-blue-900 font-semibold">
                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                        {{ trans('lang.years') }}</p>
                                </div>
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.phone number') }}</label>
                                    <p class="text-blue-900 font-semibold">{{ $patient->phone }}</p>
                                </div>
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.gender') }}</label>
                                    <p class="text-blue-900 font-semibold">
                                        {{ trans('lang.' . strtolower($patient->gender)) }}</p>
                                </div>
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <label
                                        class="block text-sm font-semibold text-blue-800 mb-1">{{ trans('lang.address') }}</label>
                                    <p class="text-blue-900 font-semibold">{{ $patient->address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment Info -->
                        @if ($patientAssign)
                            <div
                                class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-2xl p-8 mb-10 border border-yellow-200/50 shadow-lg">
                                <h3 class="text-xl font-bold text-yellow-900 mb-6 flex items-center">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    {{ trans('lang.assignment details') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white/60 rounded-xl p-4 border border-yellow-100">
                                        <label
                                            class="block text-sm font-semibold text-yellow-800 mb-1">{{ trans('lang.assigned to') }}</label>
                                        <p class="text-yellow-900 font-semibold">{{ trans('lang.' . strtolower($patientAssign->assigned_to)) }}</p>

                                    </div>
                                    <div class="bg-white/60 rounded-xl p-4 border border-yellow-100">
                                        <label
                                            class="block text-sm font-semibold text-yellow-800 mb-1">{{ trans('lang.payment type') }}</label>
                                        {{-- <p class="text-yellow-900 font-semibold">{{ $patientAssign->payment_type === 'nssf' ? trans('lang.nssf member') : ucfirst($patientAssign->payment_type) }}</p> --}}
                                        <p class="text-yellow-900 font-semibold">
                                            {{ trans('lang.' . strtolower($patientAssign->payment_type)) ?? ucfirst($patientAssign->payment_type) }}
                                        </p>

                                    </div>
                                    <div class="bg-white/60 rounded-xl p-4 border border-yellow-100">
                                        <label
                                            class="block text-sm font-semibold text-yellow-800 mb-1">{{ trans('lang.assigned date') }}</label>
                                        <p class="text-yellow-900 font-semibold">
                                            {{ $patientAssign->assigned_date->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Common Disease Form -->
                        <form action="{{ route('workspace.common-diseases.patient.store', $patient->_id) }}"
                            method="POST" class="space-y-10">
                            @csrf

                            <!-- Symptoms Section -->
                            <div
                                class="bg-gradient-to-br from-white to-red-50/30 rounded-2xl border border-red-200/50 p-8 shadow-lg">
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    {{ trans('lang.symptoms') }}
                                </h3>
                                <div>
                                    <label
                                        class="block text-sm font-bold text-gray-800 mb-3">{{ trans('lang.patient symptoms') }}
                                        <span class="text-red-500 font-bold">*</span></label>
                                    <textarea name="symptoms" rows="5"
                                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-200 focus:border-red-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700 placeholder-gray-400 resize-none"
                                        placeholder="{{ trans('lang.Describe the patient\'s symptoms in detail...') }}" required>{{ old('symptoms') }}</textarea>
                                    @error('symptoms')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Diagnosis Section -->
                            <div
                                class="bg-gradient-to-br from-white to-blue-50/30 rounded-2xl border border-blue-200/50 p-8 shadow-lg">
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    {{ trans('lang.diagnosis') }}
                                </h3>
                                <div>
                                    <label
                                        class="block text-sm font-bold text-gray-800 mb-3">{{ trans('lang.medical diagnosis') }}
                                        <span class="text-red-500 font-bold">*</span></label>
                                    <input type="text" name="diagnosis"
                                        class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700 placeholder-gray-400"
                                        placeholder="{{ trans('lang.enter diagnosis details here...') }}"
                                        value="{{ old('diagnosis') }}" required>
                                    @error('diagnosis')
                                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Treatment Section -->
                            <div
                                class="bg-gradient-to-br from-white to-green-50/30 rounded-2xl border border-green-200/50 p-8 shadow-lg">
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    {{ trans('lang.medication prescribed') }}
                                </h3>
                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="block text-sm font-bold text-gray-800 mb-4">{{ trans('lang.medication prescribed') }}</label>
                                        <div class="space-y-4">
                                            <div id="prescription-rows" class="space-y-4"></div>
                                            <div
                                                class="flex items-center gap-4 p-4 bg-green-50 rounded-xl border border-green-200">
                                                <button type="button" id="add-prescription-row"
                                                    class="inline-flex items-center px-6 py-3  bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors duration-200">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    {{ trans('lang.add medicine') }}
                                                </button>
                                                <span
                                                    class="text-sm text-green-700 font-medium">{{ trans('lang.select medicine and specify times with remarks') }}</span>
                                            </div>
                                        </div>
                                        @error('prescriptions')
                                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div
                                class="bg-gradient-to-br from-white to-purple-50/30 rounded-2xl border border-purple-200/50 p-8 shadow-lg">
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <div
                                        class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    {{ trans('lang.additional information') }}
                                </h3>
                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="block text-sm font-bold text-gray-800 mb-3">{{ trans('lang.notes') }}</label>
                                        <textarea name="notes" rows="4"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700 placeholder-gray-400 resize-none"
                                            placeholder="{{ trans('lang.additional notes or observations...') }}">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold text-gray-800 mb-3">{{ trans('lang.follow-up date') }}</label>
                                        <input type="date" name="follow_up_date"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700"
                                            value="{{ old('follow_up_date') }}">
                                        @error('follow_up_date')
                                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t-2 border-gray-200">
                                <a href="{{ route('workspace.common-diseases.index') }}"
                                    class="px-8 py-4 text-gray-700 bg-gray-100 hover:bg-gray-200 font-semibold rounded-xl transition-all duration-300 text-center">
                                    {{ trans('lang.cancel') }}
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors duration-200 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ trans('lang.complete information') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="success-alert"
            class="fixed bottom-6 right-6 z-50 border-2 border-green-400 text-green-800 px-6 py-4 rounded-2xl mb-4 bg-gradient-to-r from-green-50 to-green-100 shadow-2xl min-w-[300px] max-w-sm backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert"
            class="fixed bottom-6 right-6 z-50 bg-gradient-to-r from-red-50 to-red-100 border-2 border-red-400 text-red-800 px-6 py-4 rounded-2xl mb-4 shadow-2xl min-w-[300px] max-w-sm backdrop-blur-sm"
            role="alert">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-600 mr-3 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                    <h4 class="font-bold mb-2">{{ trans('lang.errors occurred') }}</h4>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Hide success alert after 5 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        // Hide error alert after 5 seconds
        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);

        // Dynamic Medication Prescriptions
        (function() {
            // Gather medicines from multiple possible variables and shapes
            const _medA = @json($medicines ?? []);
            const _medB = @json($medicineList ?? []);
            const _medC = @json($medications ?? []);
            let medicinesData = []
                .concat(Array.isArray(_medA) ? _medA : (_medA ? Object.values(_medA) : []))
                .concat(Array.isArray(_medB) ? _medB : (_medB ? Object.values(_medB) : []))
                .concat(Array.isArray(_medC) ? _medC : (_medC ? Object.values(_medC) : []));
            // Normalize objects to have id and name when possible
            medicinesData = medicinesData.map(function(med) {
                if (!med || typeof med !== 'object') return med;
                const id = med.id || med._id || med.value || med.code || med.uuid || '';
                const name = med.name || med.label || med.medicine_name || med.title || med.text || '';
                return {
                    id: id,
                    name: name
                };
            }).filter(function(med) {
                return med && (med.id !== '' || med.name !== '');
            });
            const oldPrescriptions = @json(old('prescriptions', []));

            const rowsContainer = document.getElementById('prescription-rows');
            const addButton = document.getElementById('add-prescription-row');
            let rowIndexCounter = 0;

            function findMedicineNameById(id) {
                if (!id) return '';
                const m = medicinesData.find(function(x) {
                    const xid = x && (x.id || x._id || x.value || x.code || x.uuid);
                    return String(xid) === String(id);
                });
                return m ? (m.name || m.label || m.medicine_name || m.title || m.text || '') : '';
            }

            function renderSuggestions(listEl, query, onPick) {
                const q = String(query || '').trim().toLowerCase();
                let matches = [];
                if (q.length === 0) {
                    listEl.innerHTML = '';
                    listEl.classList.add('hidden');
                    return;
                }
                matches = medicinesData.filter(function(m) {
                    const name = (m && (m.name || m.label || m.medicine_name || m.title || m.text || '')) + '';
                    return name.toLowerCase().includes(q);
                }).slice(0, 10);
                if (matches.length === 0) {
                    listEl.innerHTML =
                        '<div class="px-4 py-3 text-sm text-gray-500 font-medium">{{ trans('lang.no matches') }}</div>';
                    listEl.classList.remove('hidden');
                    return;
                }
                listEl.innerHTML = matches.map(function(m) {
                    const id = m.id || m._id || m.value || m.code || m.uuid || '';
                    const name = m.name || m.label || m.medicine_name || m.title || m.text || '';
                    return '<div class="px-4 py-3 text-sm hover:bg-green-100 cursor-pointer font-medium text-gray-700 border-b border-gray-100 last:border-b-0 transition-colors duration-200" data-id="' +
                        id + '">' + name + '</div>';
                }).join('');
                listEl.querySelectorAll('div[data-id]').forEach(function(div) {
                    div.addEventListener('click', function() {
                        const id = div.getAttribute('data-id');
                        const name = div.textContent.trim();
                        onPick(id, name);
                        listEl.classList.add('hidden');
                    });
                });
                listEl.classList.remove('hidden');
            }

            function createRow(preset) {
                const idx = rowIndexCounter++;
                const presetMedicineId = preset && preset.medicine_id ? preset.medicine_id : '';
                const presetTotalMedicine = preset && preset.total_medicine ? preset.total_medicine : '';
                const presetTotalDay = preset && preset.total_day ? preset.total_day : '';
                const presetTimes = preset && preset.times ? preset.times : '';

                const row = document.createElement('div');
                row.className =
                    'prescription-row border-2 border-green-200 rounded-2xl p-6 bg-gradient-to-br from-white to-green-50/30 shadow-lg hover:shadow-xl transition-all duration-300';
                row.innerHTML = `
                    <div class="flex flex-col lg:flex-row items-start gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-800 mb-2">{{ trans('lang.medicine') }}</label>
                            <div class="relative">
                                <input type="text" class="medicine-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700 placeholder-gray-400" placeholder="{{ trans('lang.type to search medicine...') }}" />
                                <input type="hidden" name="prescriptions[${idx}][medicine_id]" class="medicine-id" value="${presetMedicineId || ''}" />
                                <div class="medicine-suggestions absolute z-20 w-full bg-white border-2 border-gray-200 rounded-xl shadow-2xl hidden max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>
                        <div class="w-full lg:w-28">
                            <label class="block text-sm font-bold text-gray-800 mb-2">{{ trans('lang.total medicine') }}</label>
                            <input type="number" name="prescriptions[${idx}][total_medicine]" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700" min="0" value="${presetTotalMedicine || ''}" />
                        </div>
                        <div class="w-full lg:w-28">
                            <label class="block text-sm font-bold text-gray-800 mb-2">{{ trans('lang.total day') }}</label>
                            <input type="number" name="prescriptions[${idx}][total_day]" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700" min="0" value="${presetTotalDay || ''}" />
                        </div>
                        <div class="w-full lg:w-40">
                            <label class="block text-sm font-bold text-gray-800 mb-2">{{ trans('lang.remark') }}</label>
                            <input type="text" name="prescriptions[${idx}][times]" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-400 transition-all duration-300 bg-white hover:bg-gray-50 text-gray-700 placeholder-gray-400" placeholder="{{ trans('lang.e.g. 2x daily') }}" value="${presetTimes || ''}" />
                        </div>
                        <div class="pt-8 lg:pt-0">
                            <button type="button" class="remove-prescription-row text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                // Autocomplete wiring
                const hiddenId = row.querySelector('.medicine-id');
                const textInput = row.querySelector('.medicine-input');
                const list = row.querySelector('.medicine-suggestions');

                // Initialize from preset if present
                if (presetMedicineId) {
                    hiddenId.value = presetMedicineId;
                    textInput.value = findMedicineNameById(presetMedicineId) || '';
                }

                // Input event for suggestions
                textInput.addEventListener('input', function() {
                    const query = textInput.value;
                    renderSuggestions(list, query, function(id, name) {
                        hiddenId.value = id;
                        textInput.value = name;
                    });
                });

                // Close suggestions on outside click
                document.addEventListener('click', function(e) {
                    if (!row.contains(e.target)) {
                        list.classList.add('hidden');
                    }
                });

                // Validate selection on blur: require suggestion pick
                textInput.addEventListener('blur', function() {
                    // small timeout to allow click on suggestion before blur clears
                    setTimeout(function() {
                        const currentName = textInput.value.trim();
                        const selectedName = findMedicineNameById(hiddenId.value);
                        if (!hiddenId.value || (selectedName && selectedName !== currentName)) {
                            // Reset if not matched to a selected id
                            hiddenId.value = '';
                        }
                    }, 150);
                });

                // No special listeners required for numeric inputs

                // Remove handler
                const removeBtn = row.querySelector('.remove-prescription-row');
                removeBtn.addEventListener('click', function() {
                    row.remove();
                });

                return row;
            }

            function addRow(preset) {
                const row = createRow(preset);
                rowsContainer.appendChild(row);
            }

            if (addButton && rowsContainer) {
                addButton.addEventListener('click', function() {
                    addRow();
                });

                if (Array.isArray(oldPrescriptions) && oldPrescriptions.length > 0) {
                    oldPrescriptions.forEach(function(p) {
                        addRow(p);
                    });
                } else {
                    addRow();
                }
            }
        })();
    </script>
</x-app-layout>
