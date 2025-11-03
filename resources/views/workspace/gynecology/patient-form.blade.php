<x-app-layout>
    <div class="py-12 min-h-screen bg-gradient-to-br from-pink-100 to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl ring-1 ring-pink-100 overflow-hidden">
                <div class="bg-white rounded-3xl">
                    <div class="p-8">
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-pink-100 shadow">
                                    <!-- Pregnancy icon (FontAwesome baby icon) -->
                                    <svg class="w-7 h-7 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.492-1.026 3.365.847 2.339 2.338a1.724 1.724 0 001.066 2.574c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c1.026 1.492-.847 3.365-2.338 2.339a1.724 1.724 0 00-2.574 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.492 1.026-3.365-.847-2.339-2.338a1.724 1.724 0 00-1.066-2.574c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-1.026-1.492.847-3.365 2.338-2.339a1.724 1.724 0 002.574-1.066z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <h1 class="text-4xl font-bold text-gray-700 tracking-tight">
                                        Complete Pregnancy Information
                                    </h1>
                                    <p class="text-base text-gray-600 mt-2">fill in the patient's pregnancy details</p>
                                </div>
                            </div>
                            <a href="{{ route('workspace.gynecology.index') }}"
                               class="flex items-center px-6 py-2 bg-pink-200 text-pink-800 font-semibold rounded-full shadow hover:bg-pink-300 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                {{ trans('back') }}
                            </a>
                        </div>

                        <!-- Patient Info Card -->
                        <div class="bg-gradient-to-r from-pink-50 via-pink-100 to-pink-200 rounded-2xl p-7 mb-12 border border-pink-200 shadow-inner">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center shadow">
                                    <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-semibold text-pink-900">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </h3>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mt-2 text-pink-800 text-[15px] font-medium">
                                        <span>
                                            <span class="font-semibold">{{ trans('age') }}:</span>
                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} {{ trans('years') }}
                                        </span>
                                        <span>-</span>
                                        <span>
                                            <span class="font-semibold">{{ trans('gender') }}:</span>
                                            {{ ucfirst($patient->gender) }}
                                        </span>
                                        <span>-</span>
                                        <span>
                                            <span class="font-semibold">{{ trans('phone') }}:</span>
                                            {{ $patient->phone }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mt-2 text-pink-700 text-sm">
                                        <span class="font-semibold">{{ trans('lang.payment type') }}:</span>
                                        @php
                                            $currentAssignment = $patient->assignments()->latest()->first();
                                            $paymentType = $currentAssignment
                                                ? $currentAssignment->payment_type
                                                : null;
                                            $paymentColors = [
                                                'nssf' => 'bg-blue-100 text-blue-800',
                                                'cash' => 'bg-green-100 text-green-800',
                                                'health equity fund' => 'bg-yellow-100 text-yellow-800',
                                            ];
                                        @endphp
                                        @if ($paymentType)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $paymentColors[$paymentType] ?? 'bg-pink-200 text-pink-800' }}">
                                                {{ $paymentType === 'nssf' ? trans('lang.nssf member') : trans('lang.' . strtolower($paymentType)) }}
                                            </span>
                                        @else
                                            <span class="text-pink-400">{{ trans('lang.not assigned') }}</span>
                                        @endif
                                    </div>
                                    @if ($patient->address)
                                        <p class="text-pink-700 mt-2 text-sm">
                                            <span class="font-semibold">{{ trans('address') }}:</span>
                                            <span>{{ $patient->address }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        @php
                            $isEdit = isset($gynecologyRecord);
                        @endphp
                        <form action="{{ $isEdit ? route('workspace.gynecology.update', $gynecologyRecord->_id ?? '') : route('workspace.gynecology.patient.store', $patient->_id) }}" method="POST"
                              class="space-y-10">
                            @csrf
                            @if($isEdit)
                                @method('PUT')
                            @endif

                            <!-- Disease Information -->
                            <div class="bg-white rounded-2xl p-7 border border-pink-100 shadow">
                                <h3 class="text-xl font-bold text-pink-800 mb-8 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10z"></path>
                                    </svg>
                                    {{ trans('disease information') }}
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label for="disease_id" class="block text-sm font-semibold text-pink-700 mb-2">
                                            {{ trans('disease name') }} <span class="text-red-400">*</span>
                                        </label>
                                        <select name="disease_id" id="disease_id" required
                                                class="w-full px-4 py-3 border border-pink-300 rounded-lg bg-pink-50 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-200">
                                            <option value="" disabled selected>{{ trans('select a disease') }}
                                            </option>
                                            @foreach ($gynecologyDiseases as $disease)
                                                <option value="{{ $disease->_id }}"
                                                        {{ old('disease_id', $isEdit ? ($gynecologyRecord->disease_id ?? null) : null) == $disease->_id ? 'selected' : '' }}>
                                                    {{ $disease->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('disease_id')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="symptoms" class="block text-sm font-semibold text-pink-700 mb-2">
                                            {{ trans('patient symptoms') }} <span class="text-red-400">*</span>
                                        </label>
                                        <textarea name="symptoms" id="symptoms" rows="3" required
                                                  class="w-full px-4 py-3 border border-pink-300 rounded-lg bg-pink-50 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-200"
                                                  placeholder="{{ trans('describe patient symptoms') }}">{{ old('symptoms', $isEdit ? ($gynecologyRecord->symptoms ?? '') : '') }}</textarea>
                                        @error('symptoms')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Treatment Section -->
                            <div class="bg-white rounded-2xl border border-pink-100 p-7 shadow">
                                <h3 class="text-xl font-bold text-pink-800 mb-8 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ trans('medication prescribed') }}
                                </h3>
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold text-pink-700 mb-3">
                                            {{ trans('medication prescribed') }}
                                        </label>
                                        <div class="space-y-4">
                                            <div id="prescription-rows" class="space-y-4"></div>
                                            <div class="flex items-center gap-4">
                                                <button type="button" id="add-prescription-row"
                                                        class="flex items-center px-4 py-2 bg-pink-400 hover:bg-pink-500 text-white text-sm font-semibold rounded-full shadow transition">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    {{ trans('add medicine') }}
                                                </button>
                                                <span
                                                    class="text-xs italic text-pink-500">{{ trans('select medicine and specify times with remarks') }}</span>
                                            </div>
                                        </div>
                                        @error('prescriptions')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-white rounded-2xl border border-pink-100 p-7 shadow">
                                <h3 class="text-xl font-bold text-purple-700 mb-8 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ trans('additional information') }}
                                </h3>
                                <div>
                                    <label class="block text-sm font-bold text-purple-700 mb-2">
                                        {{ trans('notes') }}
                                    </label>
                                    <textarea name="notes" rows="3"
                                              class="w-full px-4 py-3 border border-purple-200 rounded-lg bg-purple-50 focus:ring-2 focus:ring-purple-300 focus:border-purple-300 transition"
                                              placeholder="{{ trans('additional notes or observations...') }}">{{ old('notes', $isEdit ? ($gynecologyRecord->notes ?? '') : '') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex justify-end gap-6 pt-8 border-t border-pink-100 mt-6">
                                <a href="{{ route('workspace.gynecology.index') }}"
                                   class="px-8 py-3 text-pink-700 bg-pink-100 hover:bg-pink-200 font-bold rounded-full shadow transition">
                                    {{ trans('cancel') }}
                                </a>
                                <button type="submit"
                                        class="px-8 py-3 bg-pink-700 hover:bg-pink-800 text-white rounded-full font-bold shadow transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $isEdit ? trans('lang.update') : trans('complete information') }}
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
             class="fixed bottom-6 right-6 z-50 border-green-400 bg-green-50 text-green-700 px-5 py-4 rounded-lg mb-4 shadow-xl min-w-[260px] max-w-sm"
             role="alert">
            <span class="font-semibold block">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert"
             class="fixed bottom-6 right-6 z-50 bg-red-50 border border-red-400 text-red-700 px-5 py-4 rounded-lg mb-4 shadow-xl min-w-[260px] max-w-sm"
             role="alert">
            <ul class="pl-5 space-y-1 list-disc">
                @foreach ($errors->all() as $error)
                    <li class="font-medium">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
        // Hide success alert after 5 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-in';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        // Hide error alert after 5 seconds
        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease-in';
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
                    listEl.innerHTML = '<div class="px-3 py-2 text-sm text-gray-500">No matches</div>';
                    listEl.classList.remove('hidden');
                    return;
                }
                listEl.innerHTML = matches.map(function(m) {
                    const id = m.id || m._id || m.value || m.code || m.uuid || '';
                    const name = m.name || m.label || m.medicine_name || m.title || m.text || '';
                    return '<div class="px-3 py-2 text-sm hover:bg-pink-100 cursor-pointer" data-id="' + id +
                        '">' + name + '</div>';
                }).join('');
                listEl.classList.remove('hidden');
                listEl.querySelectorAll('div[data-id]').forEach(function(div) {
                    div.addEventListener('click', function() {
                        const id = div.getAttribute('data-id');
                        const name = div.textContent.trim();
                        onPick(id, name);
                        listEl.classList.add('hidden');
                    });
                });
            }

            function createRow(preset) {
                const rowIndex = rowIndexCounter++;
                const presetMedicineId = preset && (preset.medicine_id || preset.medicineId || preset.id || preset._id);
                const presetMedicineName = preset && (preset.medicine_name || preset.medicineName || preset.name);
                const presetTotalMedicine = preset && (preset.total_medicine || preset.totalMedicine);
                const presetTotalDay = preset && (preset.total_day || preset.totalDay);
                const presetTimes = preset && (preset.times || []);

                const row = document.createElement('div');
                row.className = 'prescription-row border border-pink-200 rounded-xl p-5 bg-pink-50 shadow-sm';
                row.innerHTML = `
                    <div class="flex flex-col md:flex-row items-start md:items-end gap-4 w-full">
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-semibold text-pink-700 mb-1">{{ trans('medicine') }}</label>
                            <div class="relative w-full">
                                <input type="text" class="medicine-input w-full px-4 py-2 border border-pink-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-pink-300" placeholder="{{ trans('type to search medicine...') }}" />
                                <input type="hidden" name="prescriptions[${rowIndex}][medicine_id]" class="medicine-id" value="${presetMedicineId || ''}" />
                                <div class="medicine-suggestions absolute z-10 w-full bg-white border border-pink-200 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                            </div>
                        </div>
                        <div class="w-full max-w-[90px]">
                            <label class="block text-sm font-semibold text-pink-700 mb-1">{{ trans('total medicine') }}</label>
                            <input type="number" name="prescriptions[${rowIndex}][total_medicine]" class="w-full px-3 py-2 border border-pink-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-pink-300" min="0" value="${presetTotalMedicine || ''}" />
                        </div>
                        <div class="w-full max-w-[90px]">
                            <label class="block text-sm font-semibold text-pink-700 mb-1">{{ trans('total day') }}</label>
                            <input type="number" name="prescriptions[${rowIndex}][total_day]" class="w-full px-3 py-2 border border-pink-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-pink-300" min="0" value="${presetTotalDay || ''}" />
                        </div>
                        <div class="w-full max-w-[130px]">
                            <label class="block text-sm font-semibold text-pink-700 mb-1">{{ trans('times') }}</label>
                            <input type="text" name="prescriptions[${rowIndex}][times]" class="w-full px-3 py-2 border border-pink-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-pink-300" placeholder="{{ trans('e.g. 2x daily') }}" value="${presetTimes || ''}" />
                        </div>
                        <div class="pt-2 md:pt-0 flex-shrink-0">
                            <button type="button" class="remove-prescription-row bg-pink-200 hover:bg-pink-300 text-pink-700 rounded-full p-2 shadow transition" title="Remove row">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                const textInput = row.querySelector('.medicine-input');
                const hiddenId = row.querySelector('.medicine-id');
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
