<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="px-8 py-8 bg-gradient-to-r from-purple-500 to-purple-600 border-b border-purple-200/50">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-4xl font-bold text-white flex items-center">
                            <div
                                class="w-14 h-14 mr-5 bg-purple-500 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-4xl text-gray-800 font-bold">{{ trans('lang.patient records') }}</div>
                                <div class="text-gray-700 text-lg font-medium mt-1">
                                    {{ trans('lang.manage your healthcare data') }}</div>
                            </div>
                        </h3>
                        <div class="flex items-center space-x-4">
                            <!-- Clean Search Form -->
                            <form method="GET" action="{{ route('patients.index') }}" class="w-80">
                                <label for="default-search" class="sr-only">{{ trans('lang.search') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-purple-500 transition-colors"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        id="default-search"
                                        class="block w-full p-4 pl-12 pr-4 text-sm text-gray-700
                                        placeholder-gray-400 bg-white border border-gray-200
                                        rounded-2xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500
                                        shadow-sm transition-all duration-200 hover:shadow-md"
                                        placeholder="{{ trans('lang.search patients by name, phone, or address...') }}"
                                        oninput="searchTable()" />
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                </div>
                            </form>

                            <a href="{{ route('assignments.my') }}"
                                class="flex items-center gap-3 px-6 py-4 bg-purple-100 backdrop-blur-sm text-purple-700 rounded-2xl text-sm font-medium hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-300 transition-all duration-200 border border-purple-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                {{ trans('lang.patient assigns') }}
                            </a>

                            <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="flex items-center gap-3 px-6 py-4 bg-purple-600 text-white rounded-2xl text-sm font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ trans('lang.add patient') }}
                            </button>

                            @include('patients.create')
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Clean Table -->
                    <div class="overflow-x-auto">
                        <table id="patientsTable" class="min-w-full divide-y divide-gray-200 text-center">
                            <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-100 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.nº') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.name') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.date of birth') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.phone number') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.address') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.gender') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ trans('lang.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @if ($patients->count() > 0)
                                    @foreach ($patients as $patient)
                                        <tr class="hover:bg-gray-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-center font-semibold">
                                                {{ $patients->total() - ($patients->firstItem() - 1 + $loop->index) }}
                                            </td>
                                            <td class="px-6 py-4 truncate font-semibold text-gray-900">
                                                {{ $patient->first_name }} {{ $patient->last_name }}
                                            </td>
                                            <td class="px-6 py-4 truncate">{{ $patient->date_of_birth }}</td>
                                            <td class="px-6 py-4 truncate">{{ $patient->phone }}</td>
                                            <td class="px-6 py-4 truncate">{{ $patient->address }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full truncate font-medium {{ $patient->gender === 'Male' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                                    {{ trans('lang.' . strtolower($patient->gender)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex justify-center items-center gap-2">
                                                    {{-- Assign Button (only show if no current assignment) --}}
                                                    @if (!$patient->current_assignment)
                                                        <a href="{{ route('patients.assign', $patient->_id) }}"
                                                            class="inline-flex items-center p-2.5 text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-all duration-200 group"
                                                            title="{{ trans('lang.assign to service') }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                            </svg>
                                                        </a>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    <button data-modal-target="edit-modal-{{ $patient->_id }}"
                                                        data-modal-toggle="edit-modal-{{ $patient->_id }}"
                                                        class="inline-flex items-center p-2.5 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </button>

                                                    @include('patients.edit', ['patient' => $patient])

                                                    {{-- History Button --}}
                                                    <button data-modal-target="history-modal-{{ $patient->_id }}"
                                                        data-modal-toggle="history-modal-{{ $patient->_id }}"
                                                        class="inline-flex items-center p-2.5 text-purple-600 hover:text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all duration-200 group"
                                                        title="{{ trans('lang.view patient history') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>

                                                    @include('patients.history', ['patient' => $patient])

                                                    <button type="button"
                                                        data-modal-target="deleteModal-{{ $patient->_id }}"
                                                        data-modal-toggle="deleteModal-{{ $patient->_id }}"
                                                        class="inline-flex items-center p-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                            fill="none" stroke="currentColor" stroke-width="1.5"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>

                                                    {{-- Clean Delete Modal --}}
                                                    <div id="deleteModal-{{ $patient->_id }}"
                                                        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                        <div
                                                            class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                            <div class="text-center">
                                                                <div
                                                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                                                                    <svg class="h-8 w-8 text-red-500" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                                    </svg>
                                                                </div>
                                                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                                                    {{ trans('lang.confirm delete') }}</h3>
                                                                <p class="text-gray-600 mb-8">
                                                                    {{ trans('lang.are you sure you want to delete this patient') }}?
                                                                    <br>{{ trans('lang.this action cannot be undone') }}.
                                                                </p>
                                                                <div class="flex justify-center space-x-4">
                                                                    <button
                                                                        data-modal-target="deleteModal-{{ $patient->_id }}"
                                                                        data-modal-toggle="deleteModal-{{ $patient->_id }}"
                                                                        class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">{{ trans('lang.cancel') }}</button>
                                                                    <form
                                                                        action="{{ route('patients.destroy', $patient->_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="px-8 py-3 bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-colors duration-200 font-medium">{{ trans('lang.delete') }}</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="no-results">
                                        <td colspan="7" class="text-center py-16">
                                            <div class="flex flex-col items-center">
                                                <div
                                                    class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                                                    <svg class="w-10 h-10 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-xl font-semibold text-gray-600 mb-2">
                                                    {{ trans('lang.no patients found') }}</p>
                                                <p class="text-gray-500">
                                                    {{ trans('lang.get started by adding your first patient') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Clean Flash Messages --}}
    @if (session('success'))
        <div id="success-alert"
            class="fixed bottom-6 right-6 z-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-2xl mb-4 bg-emerald-50 shadow-xl min-w-[320px] max-w-sm"
            role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert"
            class="fixed bottom-6 right-6 z-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl mb-4 bg-red-50 shadow-xl min-w-[320px] max-w-sm"
            role="alert">
            <div class="flex items-center mb-3">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold">{{ trans('lang.please fix the following errors') }}:</span>
            </div>
            <ul class="text-sm space-y-2">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Clean Search Script --}}
    <script>
        function searchTable() {
            const searchInput = document.getElementById('default-search').value.toLowerCase();
            const rows = document.querySelectorAll('#patientsTable tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                // Skip "no results" row
                if (row.id === 'no-results') return;

                const nameCell = row.querySelector('td:nth-child(2)');
                const phoneCell = row.querySelector('td:nth-child(4)');
                const addressCell = row.querySelector('td:nth-child(5)');

                if (!nameCell) return;

                const nameText = nameCell.textContent.toLowerCase();
                const phoneText = phoneCell ? phoneCell.textContent.toLowerCase() : '';
                const addressText = addressCell ? addressCell.textContent.toLowerCase() : '';

                const match = nameText.includes(searchInput) ||
                    phoneText.includes(searchInput) ||
                    addressText.includes(searchInput);

                row.style.display = match ? '' : 'none';
                if (match) hasVisibleRows = true;

                // Clean highlighting with better styling
                if (searchInput && match) {
                    [nameCell, phoneCell, addressCell].forEach(cell => {
                        if (cell) {
                            const text = cell.textContent;
                            cell.innerHTML = text.replace(new RegExp(searchInput, 'gi'), match =>
                                `<span class="bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-lg font-medium">${match}</span>`
                            );
                        }
                    });
                }
            });

            // Show/hide no results message with clean styling
            const noResults = document.getElementById('no-results');
            if (noResults) {
                if (!hasVisibleRows && searchInput) {
                    noResults.style.display = '';
                    noResults.innerHTML = `
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-xl font-semibold text-gray-600 mb-2">{{ trans('lang.no patients found matching') }}</p>
                                <p class="text-gray-500">"${searchInput}"</p>
                            </div>
                        </td>`;
                } else if (!searchInput) {
                    noResults.style.display = '';
                    noResults.innerHTML = `
                        <td colspan="7" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-6">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-xl font-semibold text-gray-600 mb-2">{{ trans('lang.no patients found') }}</p>
                                <p class="text-gray-500">{{ trans('lang.get started by adding your first patient') }}</p>
                            </div>
                        </td>`;
                } else {
                    noResults.style.display = 'none';
                }
            }
        }

        // Clear highlighting when search is cleared
        document.getElementById('default-search').addEventListener('input', function() {
            if (this.value === '') {
                // Reset all cells to original content
                const rows = document.querySelectorAll('#patientsTable tbody tr');
                rows.forEach(row => {
                    if (row.id === 'no-results') return;
                    const cells = row.querySelectorAll('td');
                    cells.forEach(cell => {
                        if (cell.innerHTML.includes(
                                '<span class="bg-emerald-100 text-emerald-800')) {
                            cell.innerHTML = cell.textContent;
                        }
                    });
                });
            }
        });

        // Clean modal toggle logic
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

        // Clean alert animations
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = 'all 0.5s ease-in-out';
                successAlert.style.transform = 'translateX(100%)';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = 'all 0.5s ease-in-out';
                errorAlert.style.transform = 'translateX(100%)';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);
    </script>

</x-app-layout>
