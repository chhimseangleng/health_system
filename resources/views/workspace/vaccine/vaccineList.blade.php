<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <!-- Add Record Button -->
                        <div class="flex justify-between items-center mb-6">
                            <a href="{{ route('workspace.vaccine.index') }}">
                                <button
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 bg-blue-600 hover:from-blue-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back
                                </button>
                            </a>

                            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                                Vaccine List
                            </h1>

                            <div class="space-x-2">
                                <button id="openModalBtn"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 bg-blue-600 hover:from-blue-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Vaccine
                                </button>
                            </div>

                        </div>

                        {{-- <div
                            class="mb-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <div class="flex-1 w-full">
                                    <input id="searchInput" type="text" placeholder="Search by category name..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white hover:bg-gray-50" />
                                </div>
                            </div>
                        </div> --}}

                        @if ($categories->isEmpty())
                            <div class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center text-gray-500">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-xl font-medium text-gray-600">No vaccine categories found</p>
                                    <button id="openModalBtnEmpty"
                                        class="mt-6 inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Vaccine
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="overflow-x-auto mb-8">
                                <table class="w-full divide-y divide-gray-200 text-center">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-8 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Nº
                                            </th>
                                            <th class="w-1/3 px-4 py-2 text-xs font-medium text-gray-500 uppercase">Name
                                            </th>
                                            <th class="w-1/6 px-4 py-2 text-xs font-medium text-gray-500 uppercase">Dose
                                            </th>
                                            <th class="w-1/3 px-4 py-2 text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($categories as $index => $category)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                    {{ $index + 1 }}</td>
                                                <td
                                                    class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $category->name }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">{{ $category->dose }}</span>
                                                </td>
                                                <td
                                                    class="px-4 py-2 whitespace-nowrap text-sm flex justify-center space-x-2">
                                                    <button type="button" data-open="editModal-{{ $category->_id }}"
                                                        class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition font-semibold text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-8 8h8m-8 4h8m2.586-11.586a2 2 0 112.828 2.828L13 15l-4 1 1-4 7.586-7.586z" />
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <button type="button" data-open="deleteModal-{{ $category->_id }}"
                                                        class="inline-flex items-center px-4 py-2 text-white bg-red-500 rounded-lg shadow hover:bg-red-600 transition font-semibold text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Delete
                                                    </button>

                                                    <!-- Edit Modal -->
                                                    <div id="editModal-{{ $category->_id }}"
                                                        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                        <div
                                                            class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                            <div class="text-center mb-6">
                                                                <h3 class="text-xl font-bold text-gray-900">Edit
                                                                    Category</h3>
                                                            </div>
                                                            <form
                                                                action="{{ route('workspace.vaccineCategory.update', $category->_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-4 text-left">
                                                                    <label
                                                                        class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ $category->name }}" required
                                                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                                                                </div>
                                                                <div class="mb-6 text-left">
                                                                    <label
                                                                        class="block mb-1 text-sm font-medium text-gray-700">Dose</label>
                                                                    <input type="number" name="dose"
                                                                        value="{{ $category->dose }}" min="1"
                                                                        required
                                                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                                                                </div>
                                                                <div class="flex justify-center space-x-4">
                                                                    <button type="button"
                                                                        data-close="editModal-{{ $category->_id }}"
                                                                        class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">Cancel</button>
                                                                    <button type="submit"
                                                                        class="px-8 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition-colors duration-200 font-medium">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Modal -->
                                                    <div id="deleteModal-{{ $category->_id }}"
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
                                                                    Confirm Delete</h3>
                                                                <p class="text-gray-600 mb-8">Are you sure you want to
                                                                    delete this category? <br>This action cannot be
                                                                    undone.</p>
                                                                <div class="flex justify-center space-x-4">
                                                                    <!-- Cancel -->
                                                                    <button type="button"
                                                                        data-close="deleteModal-{{ $category->_id }}"
                                                                        class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                        Cancel
                                                                    </button>

                                                                    <!-- Confirm Delete -->
                                                                    <form
                                                                        action="{{ route('workspace.vaccineCategory.destroy', $category->_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="px-8 py-3 bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-colors duration-200 font-medium">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                    <!-- Modal backdrop -->
                    <div id="modal"
                        class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm items-center justify-center hidden z-50">
                        <!-- Modal content -->
                        <div
                            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 relative border border-gray-200">
                            <div
                                class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-4 rounded-t-2xl">
                                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Add Vaccine Category</h2>
                            </div>
                            <div class="p-6">

                                <form id="vaccineForm" action="{{ route('workspace.vaccineCategory.store') }}"
                                    method="POST">
                                    <!-- Add CSRF token for Laravel -->
                                    @csrf

                                    <div class="mb-4">
                                        <label for="name" class="block mb-1 font-medium">Name</label>
                                        <input type="text" id="name" name="name" required
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                                    </div>

                                    <div class="mb-4">
                                        <label for="dose" class="block mb-1 font-medium">Dose</label>
                                        <input type="number" id="dose" name="dose" min="1" required
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                                    </div>

                                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                        <button type="button" id="closeModalBtn"
                                            class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2 bg-gradient-to-r from-orange-500 bg-blue-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">
                                            Save
                                        </button>
                                    </div>
                                </form>

                                <!-- Close X button -->
                                <button id="closeModalX"
                                    class="absolute top-3 right-3 text-white hover:text-orange-200 font-bold text-2xl">&times;</button>
                            </div>
                        </div>
                    </div>

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
                                <span class="font-semibold">Please fix the following errors:</span>
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

                    <script>
                        const modal = document.getElementById('modal');
                        const openModalBtn = document.getElementById('openModalBtn');
                        const openModalBtnEmpty = document.getElementById('openModalBtnEmpty');
                        const closeModalBtn = document.getElementById('closeModalBtn');
                        const closeModalX = document.getElementById('closeModalX');
                        const searchInput = document.getElementById('searchInput');
                        const tableRows = Array.from(document.querySelectorAll('tbody tr'));

                        // Open/Close per-row modals (Edit/Delete)
                        document.querySelectorAll('[data-open]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const id = btn.getAttribute('data-open');
                                const m = document.getElementById(id);
                                if (m) {
                                    m.classList.remove('hidden');
                                    m.classList.add('flex');
                                }
                            });
                        });
                        document.querySelectorAll('[data-close]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const id = btn.getAttribute('data-close');
                                const m = document.getElementById(id);
                                if (m) {
                                    m.classList.add('hidden');
                                    m.classList.remove('flex');
                                }
                            });
                        });

                        openModalBtn.addEventListener('click', () => {
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        });

                        if (openModalBtnEmpty) {
                            openModalBtnEmpty.addEventListener('click', () => {
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');
                            });
                        }

                        closeModalBtn.addEventListener('click', () => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        });

                        closeModalX.addEventListener('click', () => {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        });

                        // Optional: close modal when clicking outside content
                        modal.addEventListener('click', (e) => {
                            if (e.target === modal) {
                                modal.classList.add('hidden');
                                modal.classList.remove('flex');
                            }
                        });

                        // Client-side filter by category name
                        if (searchInput) {
                            searchInput.addEventListener('input', (e) => {
                                const q = e.target.value.trim().toLowerCase();
                                tableRows.forEach((row) => {
                                    const nameCell = row.querySelector('td:nth-child(2)');
                                    if (!nameCell) return;
                                    const name = nameCell.textContent.toLowerCase();
                                    row.style.display = name.includes(q) ? '' : 'none';
                                });
                            });
                        }

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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
