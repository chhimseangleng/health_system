<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">


                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-5">
                            <p class="text-xl font-bold">
                                Patients
                            </p>

                            <div class="flex items-center space-x-4">
                                <form class="w-64" onsubmit="searchTable(event)">
                                    <label for="default-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <!-- Search Icon -->
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="default-search"
                                            class="block w-full p-2 pl-8 pr-4 text-sm text-gray-700
                                        placeholder-gray-400 bg-gray-100 border border-gray-200
                                        rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Search Name..." oninput="searchTable()" />
                                    </div>
                                </form>

                                <button data-modal-target="add-service-modal" data-modal-toggle="add-service-modal"
                                    class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 shadow">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Add Service
                                </button>

                                @include('patients.add-service')

                                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Add Patient
                                </button>

                                @include('patients.create')
                            </div>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                            <table id="patientsTable" class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="text-xs tracking-wider uppercase bg-gray-100">
                                    <tr>

                                        <th scope="col" class="px-6 py-3">Nº</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">DOB</th>
                                        <th scope="col" class="px-6 py-3">Phone</th>
                                        <th scope="col" class="px-6 py-3">Date</th>
                                        <th scope="col" class="px-6 py-3">Address</th>
                                        <th scope="col" class="px-6 py-3">Gender</th>
                                        <th scope="col" class="px-6 py-3">Services</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if ($patients->count() > 0)
                                        @foreach ($patients as $patient)
                                            <tr class="hover:bg-gray-50 transition duration-150">
                                                <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->first_name }}
                                                    {{ $patient->last_name }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->date_of_birth }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->phone }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->date }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->address }}</td>
                                                <td class="px-6 py-4 text-center">{{ $patient->gender }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    @if($patient->services->count() > 0)
                                                        <div class="flex flex-wrap gap-1 justify-center">
                                                            @foreach($patient->services->take(3) as $service)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                    {{ $service->service_name }}
                                                                </span>
                                                            @endforeach
                                                            @if($patient->services->count() > 3)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                                    +{{ $patient->services->count() - 3 }} more
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 text-sm">No services</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center items-center gap-3">
                                                        {{-- View Services Button --}}
                                                        <a href="{{ route('patients.services.index', $patient->_id) }}"
                                                            class="text-green-600 hover:text-green-800 transition"
                                                            title="View Services">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.639 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.639 0-8.573-3.007-9.963-7.178z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                        </a>

                                                        {{-- Edit Button --}}
                                                        <button data-modal-target="edit-modal-{{ $patient->_id }}"
                                                            data-modal-toggle="edit-modal-{{ $patient->_id }}"
                                                            class="text-blue-600 hover:text-blue-800 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </button>


                                                        @include('patients.edit', ['patient' => $patient])

                                                        <button type="button"
                                                            data-modal-target="deleteModal-{{ $patient->_id }}"
                                                            data-modal-toggle="deleteModal-{{ $patient->_id }}"
                                                            class="text-red-600 hover:text-red-800 transition">
                                                            <svg class="w-5 h-5 text-red-600" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>

                                                        {{-- Delete Modal --}}
                                                        <div id="deleteModal-{{ $patient->_id }}"
                                                            class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
                                                            <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
                                                                <h2
                                                                    class="text-lg text-center font-semibold text-gray-800">
                                                                    Confirm Delete</h2>
                                                                <p class="text-sm text-center text-gray-600 mt-2">Are
                                                                    you sure you want to delete this patient?</p>
                                                                <div class="mt-4 flex justify-center space-x-4">
                                                                    <button
                                                                        data-modal-target="deleteModal-{{ $patient->_id }}"
                                                                        data-modal-toggle="deleteModal-{{ $patient->_id }}"
                                                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                                                    <form
                                                                        action="{{ route('patients.destroy', $patient->_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr id="no-results">
                                            <td colspan="9" class="text-center py-4 text-gray-500">No patients
                                                found.</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>


                        </div>


                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Flash Messages --}}
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
    {{-- Search Script --}}
    <script>
        function searchTable(event) {
            if (event) event.preventDefault();

            const searchInput = document.getElementById('default-search').value.toLowerCase();
            const rows = document.querySelectorAll('#patientsTable tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                // Skip "no results" row
                if (row.id === 'no-results') return;

                const nameCell = row.querySelector('td:nth-child(2)');
                const idCell = row.querySelector('td:nth-child(1)');
                if (!nameCell || !idCell) return;

                const nameText = nameCell.textContent.toLowerCase();
                const idText = idCell.textContent.toLowerCase();
                const match = nameText.includes(searchInput) || idText.includes(searchInput);

                row.style.display = match ? '' : 'none';
                if (match) hasVisibleRows = true;

                if (searchInput) {
                    [nameCell, idCell].forEach(cell => {
                        const text = cell.textContent;
                        cell.innerHTML = text.replace(new RegExp(searchInput, 'gi'), match =>
                            `<span class="bg-yellow-200 dark:bg-yellow-600">${match}</span>`
                        );
                    });
                } else {
                    [nameCell, idCell].forEach(cell => cell.innerHTML = cell.textContent);
                }
            });

            const noResults = document.getElementById('no-results');
            if (noResults) {
                noResults.classList.toggle('hidden', hasVisibleRows);
            }
        }

        // Modal toggle logic
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                if (!modal) return;

                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            });
        });

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
    </script>

</x-app-layout>
