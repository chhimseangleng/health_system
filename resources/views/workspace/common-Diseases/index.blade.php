<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">
                    <div class="p-8">

                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10 gap-4">
                            <div>
                                <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight drop-shadow-sm">Common
                                    Diseases</h1>
                                <p class="text-lg text-gray-500 mt-2">Manage, search, and export common disease records
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                {{-- <button id="openAddDiseaseModal"
                                    class="text-blue-600 border border-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex ">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Disease
                                </button> --}}
                                <a href="{{ route('workspace.common-diseases.print') }}" target="_blank"
                                    class="text-orange-600 border border-orange-600 hover:text-white hover:bg-orange-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex ">
                                    Export
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="bi bi-box-arrow-up-right size-3 ms-2" viewBox="0 0 17 18">
                                        <path fill-rule="evenodd"
                                            d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                        <path fill-rule="evenodd"
                                            d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="mb-8">
                            @if (session('success'))
                                <div
                                    class="mb-4 px-6 py-4 rounded-2xl bg-green-100 text-green-900 font-semibold shadow">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <div class="relative">
                                        <input id="searchInput" type="text" placeholder="Search patient name..."
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-blue-200 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all bg-white shadow focus:shadow-lg text-lg" />

                                        <svg class="w-6 h-6 text-blue-400 absolute left-4 top-1/2 -translate-y-1/2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                                        </svg>
                                        <div id="patientSuggestions"
                                            class="absolute z-30 mt-2 w-full bg-white border border-blue-200 rounded-2xl shadow-xl hidden">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="flex items-center gap-3">
                                    <select
                                        class="flex-1 px-3 py-3 rounded-xl border border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-blue-500">
                                        <option>All Categories</option>
                                        <option>Viral</option>
                                        <option>Bacterial</option>
                                        <option>Other</option>
                                    </select>
                                    <button
                                        class="px-4 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium shadow-sm">Reset</button>
                                </div> --}}
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const addModal = document.getElementById('addDiseaseModal');
                                const openAddBtn = document.getElementById('openAddDiseaseModal');
                                const closeAddBtn = document.getElementById('closeAddDiseaseModal');

                                const searchInput = document.getElementById('searchInput');
                                const suggestionsEl = document.getElementById('patientSuggestions');
                                const tableBody = document.getElementById('diseasesTableBody');

                                // Modal handlers (safe checks)
                                if (openAddBtn && addModal) {
                                    openAddBtn.addEventListener('click', () => {
                                        addModal.classList.remove('hidden');
                                        addModal.classList.add('flex');
                                    });
                                }
                                if (closeAddBtn && addModal) {
                                    closeAddBtn.addEventListener('click', () => {
                                        addModal.classList.add('hidden');
                                        addModal.classList.remove('flex');
                                    });
                                }

                                // debounce helper
                                function debounce(fn, wait) {
                                    let t;
                                    return (...args) => {
                                        clearTimeout(t);
                                        t = setTimeout(() => fn.apply(null, args), wait);
                                    };
                                }

                                // ---------- Client-side table filter ----------
                                if (searchInput && tableBody) {
                                    // add a "no results" row
                                    const noResultsRow = document.createElement('tr');
                                    noResultsRow.id = 'noResultsRow';
                                    noResultsRow.innerHTML =
                                        '<td colspan="11" class="px-5 py-6 text-center text-gray-500">No matching records</td>';
                                    noResultsRow.style.display = 'none';
                                    tableBody.appendChild(noResultsRow);

                                    function filterLocal(term) {
                                        const q = (term || '').toLowerCase().trim();
                                        let anyVisible = false;
                                        const rows = tableBody.querySelectorAll('tr');
                                        rows.forEach(row => {
                                            if (row.id === 'noResultsRow') return;
                                            const nameCell = row.querySelector('td:nth-child(2)'); // second column is Name
                                            if (!nameCell) return;
                                            const name = nameCell.textContent.toLowerCase();
                                            const show = q.length === 0 || name.includes(q);
                                            row.style.display = show ? '' : 'none';
                                            if (show) anyVisible = true;
                                        });
                                        noResultsRow.style.display = anyVisible ? 'none' : '';
                                    }

                                    // listen with debounce
                                    searchInput.addEventListener('input', debounce((e) => {
                                        filterLocal(e.target.value);
                                    }, 120));
                                }

                                // ---------- Remote suggestions (keeps your existing logic) ----------
                                async function fetchPatientSuggestions(term) {
                                    if (!term || term.trim().length === 0) return [];
                                    const baseUrl = searchInput?.getAttribute('data-search-url') ||
                                        '/workspace/common-diseases/patient-search';
                                    const url = `${baseUrl}?q=${encodeURIComponent(term)}`;
                                    try {
                                        const res = await fetch(url, {
                                            headers: {
                                                'Accept': 'application/json'
                                            }
                                        });
                                        if (!res.ok) return [];
                                        const json = await res.json();
                                        return Array.isArray(json.data) ? json.data : [];
                                    } catch (e) {
                                        return [];
                                    }
                                }

                                function highlight(text, term) {
                                    const i = text.toLowerCase().indexOf(term.toLowerCase());
                                    if (i === -1) return text;
                                    const before = text.slice(0, i);
                                    const match = text.slice(i, i + term.length);
                                    const after = text.slice(i + term.length);
                                    return `${before}<span class='bg-yellow-200 font-bold'>${match}</span>${after}`;
                                }

                                async function renderSuggestions(term) {
                                    if (!suggestionsEl) return;
                                    if (!term || term.trim().length === 0) {
                                        suggestionsEl.classList.add('hidden');
                                        suggestionsEl.innerHTML = '';
                                        return;
                                    }
                                    const matches = await fetchPatientSuggestions(term);
                                    if (matches.length === 0) {
                                        suggestionsEl.classList.add('hidden');
                                        suggestionsEl.innerHTML = '';
                                        return;
                                    }
                                    suggestionsEl.innerHTML = matches.map(m => `
                                        <a href="${m.url}" class="block px-4 py-2 hover:bg-blue-50 text-base text-blue-900 font-semibold rounded-xl transition">${highlight(m.name, term)}</a>
                                    `).join('');
                                    suggestionsEl.classList.remove('hidden');
                                }

                                // wire suggestions to input (focus optional)
                                if (searchInput) {
                                    const onInputSuggestions = debounce((e) => renderSuggestions(e.target.value), 200);
                                    searchInput.addEventListener('input', onInputSuggestions);
                                    searchInput.addEventListener('focus', (e) => renderSuggestions(e.target.value));
                                }

                                // hide suggestions when clicking outside
                                document.addEventListener('click', (e) => {
                                    if (!suggestionsEl) return;
                                    if (!suggestionsEl.contains(e.target) && e.target !== searchInput) {
                                        suggestionsEl.classList.add('hidden');
                                    }
                                });
                            });
                        </script>

                        <div class="overflow-x-auto rounded-2xl ring-1 ring-blue-200 shadow-lg mt-6">
                            <table class="w-full text-left text-base">
                                <thead class="bg-gradient-to-r from-blue-100 to-blue-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Nº</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Name</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Category</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Physician</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Age</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Gender</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Drug Diagnosis</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Village</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Commune</th>
                                        <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider">
                                            Updated</th>
                                        <th
                                            class="px-6 py-4 text-xs font-bold text-blue-800 uppercase tracking-wider text-center">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="diseasesTableBody" class="bg-white divide-y divide-blue-100">
                                    @forelse($diseases as $i => $d)
                                        <tr class="hover:bg-blue-50 transition duration-150">
                                            <td class="px-6 py-4 text-base text-blue-900 font-semibold">
                                                {{ $diseases->total() - $diseases->firstItem() - $i + 1 }}
                                            </td>
                                            <td class="px-6 py-4 text-base font-bold text-blue-900">{{ $d->name }}
                                            </td>
                                            <td class="px-6 py-4 text-base">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-900 shadow">{{ $d->category }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-base text-blue-800">{{ $d->physician }}</td>
                                            <td class="px-6 py-4 text-base text-blue-800">{{ $d->age }}</td>
                                            <td class="px-6 py-4 text-base text-blue-800">{{ $d->gender }}</td>
                                            <td class="px-6 py-4 text-base text-blue-800">
                                                @php
                                                    $prescriptions = $d->prescriptions ?? null;
                                                @endphp
                                                @if (!empty($prescriptions) && is_array($prescriptions))
                                                    <div class="space-y-2">
                                                        @foreach ($prescriptions as $p)
                                                            @php
                                                                $mid = (string) ($p['medicine_id'] ?? '');
                                                                $mname = $medicineMap[$mid] ?? '';
                                                                $tm = $p['total_medicine'] ?? null;
                                                                $td = $p['total_day'] ?? null;
                                                                $times = $p['times'] ?? [];
                                                            @endphp
                                                            <div>
                                                                <div class="text-blue-900">
                                                                    <span
                                                                        class="font-semibold">{{ $mname }}</span>
                                                                    @if (!is_null($td) || !is_null($tm))
                                                                        <span class="text-blue-700 text-xs">-
                                                                            @if (!is_null($td))
                                                                                Total Day: {{ $td }}
                                                                            @endif
                                                                            @if (!is_null($td) && !is_null($tm))
                                                                                ,
                                                                            @endif
                                                                            @if (!is_null($tm))
                                                                                Total Medicine: {{ $tm }}
                                                                            @endif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="mt-1 text-xs text-blue-700">
                                                                    @foreach (['M' => 'Morning', 'A' => 'Afternoon', 'E' => 'Evening'] as $k => $label)
                                                                        @php $t = $times[$k] ?? null; @endphp
                                                                        @if ($t && (isset($t['qty']) || !empty($t['remark'])))
                                                                            <div>
                                                                                <span
                                                                                    class="inline-block w-20 text-blue-500">{{ $label }}
                                                                                    ({{ $k }})
                                                                                </span>
                                                                                @if (isset($t['qty']))
                                                                                    <span
                                                                                        class="font-medium">x{{ $t['qty'] }}</span>
                                                                                @endif
                                                                                @if (!empty($t['remark']))
                                                                                    <span class="text-blue-400">-
                                                                                        {{ $t['remark'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    {{ $d->drug_diagnosis }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-base text-blue-800">{{ $d->village }}</td>
                                            <td class="px-6 py-4 text-base text-blue-800">{{ $d->commune }}</td>
                                            <td class="px-6 py-4 text-base text-blue-800">
                                                {{ optional($d->updated_at)->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 text-base">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('workspace.common-diseases.export.pdf', $d->_id) }}"
                                                        title="Export PDF"
                                                        class="inline-flex items-center p-2.5 text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 rounded-xl transition-all duration-200 group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                                                            class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 8v8m0 0l-3-3m3 3l3-3M5 12a7 7 0 1114 0 7 7 0 01-14 0z" />
                                                        </svg>
                                                    </a>


                                                    <a href="{{ route('workspace.common-diseases.edit', $d->_id) }}"
                                                        title="Edit"
                                                        class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-5 h-5 mr-1 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </a>

                                                    <form
                                                        action="{{ route('workspace.common-diseases.destroy', $d->_id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete"
                                                            class="inline-flex items-center p-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                                                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                                fill="none" stroke="currentColor"
                                                                stroke-width="1.5" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11"
                                                class="px-6 py-8 text-center text-blue-400 text-lg font-semibold">No
                                                records yet</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8">
                            {{ $diseases->links() }}
                        </div>

                        <!-- Patients Needing Common Disease Information Section -->
                        @if (!$incompletePatients->isEmpty())
                            <div class="mt-16">
                                <div
                                    class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border-2 border-yellow-200">
                                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                        Patients Needing Common Disease Information
                                        <span
                                            class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $incompletePatients->count() }} pending
                                        </span>
                                    </h3>

                                    <div class="overflow-x-auto">
                                        <table class="w-full divide-y divide-gray-200 text-center">
                                            <thead class="bg-yellow-100">
                                                <tr>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        Nº</th>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        Patient Name</th>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        DOB</th>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        Age</th>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        Phone</th>
                                                    <th
                                                        class="px-6 py-4 text-xs font-bold text-yellow-900 uppercase tracking-wider">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-yellow-100">
                                                @foreach ($incompletePatients as $index => $patient)
                                                    <tr class="hover:bg-yellow-50 transition">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base text-yellow-900 font-semibold">
                                                            {{ $index + 1 }}</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base font-bold text-yellow-900">
                                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base text-yellow-900">
                                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base text-yellow-900">
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 shadow">
                                                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                                                years
                                                            </span>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base text-yellow-900">
                                                            {{ $patient->phone }}</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base flex justify-center space-x-1">
                                                            <!-- Complete Button (Tick) -->
                                                            <a href="{{ route('workspace.common-diseases.patient.form', $patient->_id) }}"
                                                                class="text-blue-600 border border-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex "
                                                                title="Complete common disease information">
                                                                <svg class="w-5 h-5 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Complete
                                                            </a>

                                                            <!-- Dismiss Button (Cross) -->
                                                            <form
                                                                action="{{ route('workspace.common-diseases.patient.dismiss', $patient->_id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to dismiss this patient?');"
                                                                class="inline">
                                                                @csrf
                                                                @method('POST')
                                                                <button type="submit"
                                                                    class="text-red-600 border border-red-600 hover:text-white hover:bg-red-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex"
                                                                    title="Dismiss from list">
                                                                    <svg class="w-5 h-5 mr-2" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                    Dismiss
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Add Disease Modal -->
                        <div id="addDiseaseModal"
                            class="fixed inset-0 z-50 items-center justify-center hidden bg-gray-900/60 backdrop-blur">
                            <div
                                class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-2xl mx-4 ring-1 ring-blue-200 border-2 border-blue-100">
                                <div class="text-2xl font-extrabold text-blue-900 mb-6">Add New Disease</div>
                                <form action="{{ route('workspace.common-diseases.store') }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block mb-2 text-base font-semibold text-blue-800">Disease
                                                Name</label>
                                            <input name="name" type="text" placeholder="e.g. Flu"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                                                required />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-base font-semibold text-blue-800">Category</label>
                                            <input name="category" type="text" placeholder="e.g. Viral"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                                                required />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-base font-semibold text-blue-800">Physician</label>
                                            <input name="physician" type="text" placeholder="e.g. Dr. Sok"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block mb-2 text-base font-semibold text-blue-800">Age</label>
                                                <input name="age" type="number" min="0"
                                                    placeholder="e.g. 3"
                                                    class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                            </div>
                                            <div>
                                                <label
                                                    class="block mb-2 text-base font-semibold text-blue-800">Gender</label>
                                                <select name="gender"
                                                    class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg">
                                                    <option value="">Select</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block mb-2 text-base font-semibold text-blue-800">Drug
                                                Diagnosis</label>
                                            <input name="drug_diagnosis" type="text"
                                                placeholder="e.g. Paracetamol"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-base font-semibold text-blue-800">Village</label>
                                            <input name="village" type="text" placeholder="e.g. Trapeang Russey"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-base font-semibold text-blue-800">Commune</label>
                                            <input name="commune" type="text" placeholder="e.g. Ta Sal"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block mb-2 text-base font-semibold text-blue-800">Staff
                                                Name</label>
                                            <input name="staff_name" type="text" placeholder="e.g. Nurse Dara"
                                                class="w-full border border-blue-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end space-x-4 mt-8">
                                        <button type="button" id="closeAddDiseaseModal"
                                            class="px-6 py-3 rounded-xl border border-blue-200 text-blue-800 font-bold hover:bg-blue-50 transition">Cancel</button>
                                        <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow transition">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            const addModal = document.getElementById('addDiseaseModal');
                            const openAddBtn = document.getElementById('openAddDiseaseModal');
                            const closeAddBtn = document.getElementById('closeAddDiseaseModal');
                            const searchInput = document.getElementById('searchInput');
                            const suggestionsEl = document.getElementById('patientSuggestions');

                            openAddBtn.addEventListener('click', () => {
                                addModal.classList.remove('hidden');
                                addModal.classList.add('flex');
                            });
                            closeAddBtn.addEventListener('click', () => {
                                addModal.classList.add('hidden');
                                addModal.classList.remove('flex');
                            });

                            function debounce(fn, wait) {
                                let t;
                                return (...args) => {
                                    clearTimeout(t);
                                    t = setTimeout(() => fn.apply(null, args), wait);
                                };
                            }

                            async function fetchPatientSuggestions(term) {
                                const baseUrl = searchInput?.getAttribute('data-search-url') || '/workspace/common-diseases/patient-search';
                                const url = `${baseUrl}?q=${encodeURIComponent(term)}`;
                                try {
                                    const res = await fetch(url, {
                                        headers: {
                                            'Accept': 'application/json'
                                        }
                                    });
                                    if (!res.ok) return [];
                                    const json = await res.json();
                                    return Array.isArray(json.data) ? json.data : [];
                                } catch (e) {
                                    return [];
                                }
                            }

                            function highlight(text, term) {
                                const i = text.toLowerCase().indexOf(term.toLowerCase());
                                if (i === -1) return text;
                                const before = text.slice(0, i);
                                const match = text.slice(i, i + term.length);
                                const after = text.slice(i + term.length);
                                return `${before}<span class='bg-yellow-200 font-bold'>${match}</span>${after}`;
                            }

                            async function renderSuggestions(term) {
                                if (!term || term.trim().length === 0) {
                                    suggestionsEl.classList.add('hidden');
                                    suggestionsEl.innerHTML = '';
                                    return;
                                }
                                const matches = await fetchPatientSuggestions(term);
                                if (matches.length === 0) {
                                    suggestionsEl.classList.add('hidden');
                                    suggestionsEl.innerHTML = '';
                                    return;
                                }
                                suggestionsEl.innerHTML = matches.map(m => `
                                    <a href="${m.url}" class="block px-4 py-2 hover:bg-blue-50 text-base text-blue-900 font-semibold rounded-xl transition">${highlight(m.name, term)}</a>
                                `).join('');
                                suggestionsEl.classList.remove('hidden');
                            }

                            const onInput = debounce((e) => {
                                renderSuggestions(e.target.value);
                            }, 200);

                            if (searchInput) {
                                searchInput.addEventListener('input', onInput);
                                searchInput.addEventListener('focus', (e) => renderSuggestions(e.target.value));
                            }
                            document.addEventListener('click', (e) => {
                                if (!suggestionsEl.contains(e.target) && e.target !== searchInput) {
                                    suggestionsEl.classList.add('hidden');
                                }
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
