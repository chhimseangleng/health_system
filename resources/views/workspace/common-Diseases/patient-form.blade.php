<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">
                    <div class="p-8">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Complete Common Disease Information</h1>
                                <p class="text-gray-500 mt-1">Fill in the patient's common disease details</p>
                            </div>
                            <a href="{{ route('workspace.common-diseases.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-sm transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Common Diseases
                            </a>
                        </div>

                        <!-- Patient Info Card -->
                        <div class="bg-blue-50 rounded-xl p-6 mb-8 border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-900 mb-4">Patient Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Name</label>
                                    <p class="text-blue-900 font-semibold">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Date of Birth</label>
                                    <p class="text-blue-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Age</label>
                                    <p class="text-blue-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Phone</label>
                                    <p class="text-blue-900">{{ $patient->phone }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Gender</label>
                                    <p class="text-blue-900">{{ ucfirst($patient->gender) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700">Address</label>
                                    <p class="text-blue-900">{{ $patient->address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment Info -->
                        @if($patientAssign)
                        <div class="bg-yellow-50 rounded-xl p-6 mb-8 border border-yellow-200">
                            <h3 class="text-lg font-semibold text-yellow-900 mb-4">Assignment Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700">Assigned To</label>
                                    <p class="text-yellow-900 font-semibold">{{ ucfirst($patientAssign->assigned_to) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700">Payment Type</label>
                                    <p class="text-yellow-900">{{ $patientAssign->payment_type === 'nssf' ? 'NSSF Member' : ucfirst($patientAssign->payment_type) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-yellow-700">Assigned Date</label>
                                    <p class="text-yellow-900">{{ $patientAssign->assigned_date->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Common Disease Form -->
                        <form action="{{ route('workspace.common-diseases.patient.store', $patient->_id) }}" method="POST" class="space-y-8">
                            @csrf

                            <!-- Symptoms Section -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    Symptoms
                                </h3>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Patient Symptoms <span class="text-red-500">*</span></label>
                                    <textarea name="symptoms" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                        placeholder="Describe the patient's symptoms in detail..." required>{{ old('symptoms') }}</textarea>
                                    @error('symptoms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Diagnosis Section -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Diagnosis
                                </h3>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Medical Diagnosis <span class="text-red-500">*</span></label>
                                    <input type="text" name="diagnosis"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                        placeholder="Enter the medical diagnosis..." value="{{ old('diagnosis') }}" required>
                                    @error('diagnosis')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Treatment Section -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                {{-- <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center"> --}}
                                    {{-- <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Treatment
                                </h3> --}}
                                <div class="space-y-4">
                                    {{-- <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Treatment Plan <span class="text-red-500">*</span></label>
                                        <textarea name="treatment" rows="4"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                            placeholder="Describe the treatment plan..." required>{{ old('treatment') }}</textarea>
                                        @error('treatment')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div> --}}

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Medication Prescribed<span class="text-red-500">*</span></label>
                                        <div class="space-y-3">
                                            <div id="prescription-rows" class="space-y-3"></div>
                                            <div class="flex items-center gap-3">
                                                <button type="button" id="add-prescription-row" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Add medicine
                                                </button>
                                                <span class="text-xs text-gray-500">Select medicine and specify times with remarks</span>
                                            </div>
                                        </div>
                                        @error('prescriptions')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Additional Information
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                                        <textarea name="notes" rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                            placeholder="Additional notes or observations...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Follow-up Date</label>
                                        <input type="date" name="follow_up_date"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                            value="{{ old('follow_up_date') }}">
                                        @error('follow_up_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('workspace.common-diseases.index') }}"
                                   class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Complete Information
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
            class="fixed bottom-6 right-6 z-50 border-green-400 text-green-700 px-4 py-3 rounded mb-4 bg-green-50 shadow-lg min-w-[250px] max-w-xs"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert"
            class="fixed bottom-6 right-6 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-lg min-w-[250px] max-w-xs"
            role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                return { id: id, name: name };
            }).filter(function(med) { return med && (med.id !== '' || med.name !== ''); });
            const oldPrescriptions = @json(old('prescriptions', []));

            const rowsContainer = document.getElementById('prescription-rows');
            const addButton = document.getElementById('add-prescription-row');
            let rowIndexCounter = 0;

            function findMedicineNameById(id) {
                if (!id) return '';
                const m = medicinesData.find(function(x){
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
                matches = medicinesData.filter(function(m){
                    const name = (m && (m.name || m.label || m.medicine_name || m.title || m.text || '')) + '';
                    return name.toLowerCase().includes(q);
                }).slice(0, 10);
                if (matches.length === 0) {
                    listEl.innerHTML = '<div class="px-3 py-2 text-sm text-gray-500">No matches</div>';
                    listEl.classList.remove('hidden');
                    return;
                }
                listEl.innerHTML = matches.map(function(m){
                    const id = m.id || m._id || m.value || m.code || m.uuid || '';
                    const name = m.name || m.label || m.medicine_name || m.title || m.text || '';
                    return '<button type="button" data-id="' + String(id).replace(/"/g,'&quot;') + '" class="w-full text-left px-3 py-2 hover:bg-blue-50">' + name.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</button>';
                }).join('');
                Array.prototype.forEach.call(listEl.querySelectorAll('button[data-id]'), function(btn){
                    btn.addEventListener('click', function(){
                        const id = btn.getAttribute('data-id');
                        const name = btn.textContent || '';
                        onPick(id, name);
                        listEl.classList.add('hidden');
                    });
                });
                listEl.classList.remove('hidden');
            }

            function createRow(preset) {
                const idx = rowIndexCounter++;
                const presetMedicineId = preset && preset.medicine_id ? preset.medicine_id : '';
                const presetTimes = (preset && preset.times) || {};

                const row = document.createElement('div');
                row.className = 'w-full border border-gray-200 rounded-lg p-3';
                row.setAttribute('data-row-index', String(idx));
                row.innerHTML =
                    '<div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">' +
                        // Top row: medicine, totals, remove
                        '<div class="md:col-span-6">' +
                            '<label class="block text-xs font-medium text-gray-600 mb-1">Medicine</label>' +
                            '<div class="relative">' +
                                '<input type="hidden" name="prescriptions[' + idx + '][medicine_id]" class="prescription-medicine-id">' +
                                '<input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white prescription-medicine-input" placeholder="Type to search medicine...">' +
                                '<div class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg hidden prescription-suggestion-list"></div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="md:col-span-3">' +
                            '<label class="block text-xs font-medium text-gray-600 mb-1">Total Medicine</label>' +
                            '<input type="number" min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" ' +
                                'name="prescriptions[' + idx + '][total_medicine]" placeholder="# of units">' +
                        '</div>' +

                        '<div class="md:col-span-2">' +
                            '<label class="block text-xs font-medium text-gray-600 mb-1">Total Day</label>' +
                            '<input type="number" min="0" step="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" ' +
                                'name="prescriptions[' + idx + '][total_day]" placeholder="# of days">' +
                        '</div>' +

                        '<div class="md:col-span-1 flex md:justify-end mt-1">' +
                            '<button type="button" class="px-3 py-2 text-sm text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 rounded-md remove-prescription-row">Remove</button>' +
                        '</div>' +

                        // Bottom row: M/A/E group
                        '<div class="md:col-span-12">' +
                            '<div class="grid grid-cols-1 md:grid-cols-3 gap-3">' +
                                ['M','A','E'].map(function(timeKey) {
                                    const timeLabel = timeKey === 'M' ? 'Morning' : (timeKey === 'A' ? 'Afternoon' : 'Evening');
                                    const qty = presetTimes[timeKey] && presetTimes[timeKey].qty != null ? presetTimes[timeKey].qty : '';
                                    const remark = presetTimes[timeKey] && presetTimes[timeKey].remark ? presetTimes[timeKey].remark : '';
                                    return '' +
                                        '<div>' +
                                            '<label class="block text-xs font-medium text-gray-600 mb-1">' + timeLabel + ' (' + timeKey + ')</label>' +
                                            '<div class="flex items-center gap-2">' +
                                                '<input type="number" min="0" step="1" class="w-20 px-2 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" ' +
                                                    'placeholder="#" ' +
                                                    'name="prescriptions[' + idx + '][times][' + timeKey + '][qty]" ' +
                                                    'value="' + (qty !== '' ? String(qty).replace(/&/g,'&amp;').replace(/\"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : '') + '">' +
                                                '<input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" ' +
                                                    'placeholder="Remark" ' +
                                                    'name="prescriptions[' + idx + '][times][' + timeKey + '][remark]" ' +
                                                    'value="' + (remark ? String(remark).replace(/&/g,'&amp;').replace(/\"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : '') + '">' +
                                            '</div>' +
                                        '</div>';
                                }).join('') +
                            '</div>' +
                        '</div>' +
                    '</div>';

                // Autocomplete wiring
                const hiddenId = row.querySelector('.prescription-medicine-id');
                const textInput = row.querySelector('.prescription-medicine-input');
                const list = row.querySelector('.prescription-suggestion-list');

                // Initialize from preset if present
                if (presetMedicineId) {
                    hiddenId.value = presetMedicineId;
                    textInput.value = findMedicineNameById(presetMedicineId) || '';
                }

                // Input event for suggestions
                textInput.addEventListener('input', function(){
                    const query = textInput.value;
                    renderSuggestions(list, query, function(id, name){
                        hiddenId.value = id;
                        textInput.value = name;
                    });
                });

                // Close suggestions on outside click
                document.addEventListener('click', function(e){
                    if (!row.contains(e.target)) {
                        list.classList.add('hidden');
                    }
                });

                // Validate selection on blur: require suggestion pick
                textInput.addEventListener('blur', function(){
                    // small timeout to allow click on suggestion before blur clears
                    setTimeout(function(){
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
                addButton.addEventListener('click', function() { addRow(); });

                if (Array.isArray(oldPrescriptions) && oldPrescriptions.length > 0) {
                    oldPrescriptions.forEach(function(p) { addRow(p); });
                } else {
                    addRow();
                }
            }
        })();
    </script>
</x-app-layout>
