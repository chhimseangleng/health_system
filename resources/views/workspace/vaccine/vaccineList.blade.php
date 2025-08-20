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

                        <div
                            class="mb-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                <div class="flex-1 w-full">
                                    <input id="searchInput" type="text" placeholder="Search by category name..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white hover:bg-gray-50" />
                                </div>
                            </div>
                        </div>

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
                                                No
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
                                                    <a href=""
                                                        class="inline-flex items-center px-4 py-2 text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 transition font-semibold text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5h2m-8 8h8m-8 4h8m2.586-11.586a2 2 0 112.828 2.828L13 15l-4 1 1-4 7.586-7.586z" />
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <form action="" method="POST"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 text-white bg-red-600 rounded-lg shadow hover:bg-red-700 transition font-semibold text-sm">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V6a2 2 0 012-2h2a2 2 0 012 2v1m-7 0h8" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
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
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-4 rounded-t-2xl">
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

                    <script>
                        const modal = document.getElementById('modal');
                        const openModalBtn = document.getElementById('openModalBtn');
                        const openModalBtnEmpty = document.getElementById('openModalBtnEmpty');
                        const closeModalBtn = document.getElementById('closeModalBtn');
                        const closeModalX = document.getElementById('closeModalX');
                        const searchInput = document.getElementById('searchInput');
                        const tableRows = Array.from(document.querySelectorAll('tbody tr'));

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
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
