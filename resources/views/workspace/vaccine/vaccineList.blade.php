<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-4xl">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">
                    <div class="p-8">
                        <!-- Header Section -->
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10 gap-4">
                            <div class="flex items-center space-x-3">
                                <!-- Icon -->
                                <div class="p-3 bg-blue-100 rounded-xl">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10z" />
                                    </svg>
                                </div>
                                <!-- Heading and subtitle -->
                                <div>
                                    <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight drop-shadow-sm">
                                        {{ trans('lang.vaccine list') }}</h1>
                                    <p class="text-lg text-gray-500 mt-2">{{ trans('lang.manage vaccine categories') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('workspace.vaccine.index') }}"
                                    class="text-gray-600 border border-gray-300 hover:text-gray-700 hover:bg-gray-50 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    {{ trans('lang.back') }}
                                </a>
                                <button id="openModalBtn" type="button"
                                    class="text-blue-600 border border-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ trans('lang.add vaccine') }}
                                </button>
                            </div>
                        </div>

                        <!-- Search Section -->
                        @if (!$categories->isEmpty())
                            <div class="mb-8 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <!-- Heroicon: Magnifying Glass -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                </span>

                                <input id="searchInput" type="text" placeholder="{{ trans('lang.search') }}..."
                                    class="w-full sm:w-80 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" />
                            </div>
                        @endif

                        @if ($categories->isEmpty())
                            <div
                                class="flex flex-col min-h-[400px] justify-center items-center gap-7 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span
                                    class="text-2xl text-gray-600 font-bold">{{ trans('lang.no vaccine categories found') }}</span>
                                <button id="openModalBtnEmpty"
                                    class="inline-flex items-center gap-2 px-7 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>{{ trans('lang.add vaccine') }}</span>
                                </button>
                            </div>
                        @else
                            <div class="p-0 md:p-2">
                                <div class="overflow-x-auto">
                                    <table id="VaccineTable"
                                        class="min-w-full  bg-white text-base divide-y divide-blue-300 shadow-sm text-center">
                                        <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-100 ">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-gray-700">
                                                    {{ trans('lang.nº') }}</th>
                                                <th scope="col" class="px-6 py-3 text-gray-700">
                                                    {{ trans('lang.name') }}</th>
                                                <th scope="col" class="px-6 py-3 text-gray-700">
                                                    {{ trans('lang.doses') }}</th>
                                                <th scope="col" class="px-6 py-3 text-gray-700">
                                                    {{ trans('lang.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($categories as $index => $category)
                                                <tr class="hover:bg-gray-100 transition-colors duration-150">
                                                    <td class="px-6 py-4 text-base text-gray-900 font-semibold">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4 text-base font-bold text-gray-900">
                                                        {{ $category->name }}
                                                    </td>
                                                    <td class="px-6 py-4 text-base">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-900 shadow">
                                                            {{ $category->dose }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-base">
                                                        <div class="flex justify-center gap-2">
                                                            <!-- ✏️ Edit Button -->
                                                            <button data-modal-target="editModal-{{ $category->_id }}"
                                                                data-modal-toggle="editModal-{{ $category->_id }}"
                                                                class="inline-flex items-center p-2.5 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group"
                                                                title="{{ trans('lang.edit category') }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor"
                                                                    class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                </svg>
                                                            </button>

                                                            <!-- 🗑️ Delete Button -->
                                                            <button
                                                                data-modal-target="deleteModal-{{ $category->_id }}"
                                                                data-modal-toggle="deleteModal-{{ $category->_id }}"
                                                                class="inline-flex items-center p-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group"
                                                                title="{{ trans('lang.delete category') }}">
                                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-width="1.5" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- ✏️ Edit Modal -->
                                                <div id="editModal-{{ $category->_id }}"
                                                    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                    <div
                                                        class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                        <!-- Remove text-center here -->
                                                        <div class="text-left">
                                                            <div
                                                                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-50 mb-2">
                                                                <svg class="h-8 w-8 text-blue-500" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.212l-4.5 1.125 1.125-4.5 12.737-12.35z" />
                                                                </svg>

                                                            </div>
                                                            <h3
                                                                class="text-2xl font-bold text-gray-900 flex justify-center mb-2">
                                                                {{ trans('lang.edit vaccine category') }}</h3>

                                                            <form
                                                                action="{{ route('workspace.vaccineCategory.update', $category->_id) }}"
                                                                method="POST" class="text-left mt-6">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-4">
                                                                    <label
                                                                        class="block mb-1 text-sm font-semibold text-gray-700">
                                                                        {{ trans('lang.name') }}
                                                                    </label>
                                                                    <input type="text" name="name"
                                                                        value="{{ $category->name }}" required
                                                                        class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                                                </div>

                                                                <div class="mb-6">
                                                                    <label
                                                                        class="block mb-1 text-sm font-semibold text-gray-700">
                                                                        {{ trans('lang.doses') }}
                                                                    </label>
                                                                    <input type="number" name="dose"
                                                                        value="{{ $category->dose }}" min="1"
                                                                        required
                                                                        class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                                                </div>

                                                                <div class="flex justify-end space-x-4">
                                                                    <button
                                                                        data-modal-target="editModal-{{ $category->_id }}"
                                                                        data-modal-toggle="editModal-{{ $category->_id }}"
                                                                        type="button"
                                                                        class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                        {{ trans('lang.cancel') }}
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="px-8 py-3 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition-colors duration-200 font-medium">
                                                                        {{ trans('lang.save') }}
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
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
                                                            <h3
                                                                class="text-2xl font-bold text-gray-900 flex justify-center mb-2">
                                                                {{ trans('lang.confirm delete') }}
                                                            </h3>
                                                            <p class="text-gray-600 mb-8">
                                                                {{ trans('lang.are you sure you want to delete this category') }}?<br>
                                                                <span
                                                                    class="text-red-600 font-semibold">{{ trans('lang.this action cannot be undone') }}.</span>
                                                            </p>
                                                            <div class="flex justify-center space-x-4">
                                                                <button
                                                                    data-modal-target="deleteModal-{{ $category->_id }}"
                                                                    data-modal-toggle="deleteModal-{{ $category->_id }}"
                                                                    class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                    {{ trans('lang.cancel') }}
                                                                </button>
                                                                <form
                                                                    action="{{ route('workspace.vaccineCategory.destroy', $category->_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="px-8 py-3 bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-colors duration-200 font-medium">
                                                                        {{ trans('lang.delete') }}
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Modal: Add Vaccine Category -->
                        <div id="modal"
                            class="fixed inset-0 bg-gray-900/60 hidden flex items-center justify-center z-50 backdrop-blur">
                            <div
                                class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 relative">
                                <!-- Close Button -->
                                <button id="closeModalX"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition mt-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- Header -->
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                    {{ trans('lang.add vaccine category') }}</h2>

                                <!-- Form -->
                                <form id="vaccineForm" action="{{ route('workspace.vaccineCategory.store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="name" class="block mb-2 text-sm font-semibold text-gray-700">
                                            {{ trans('lang.name') }}
                                        </label>
                                        <input type="text" id="name" name="name" required maxlength="50"
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div class="mb-6">
                                        <label for="dose" class="block mb-2 text-sm font-semibold text-gray-700">
                                            {{ trans('lang.dose') }}
                                        </label>
                                        <input type="number" id="dose" name="dose" min="1" required
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                        <button type="button" id="closeModalBtn"
                                            class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold bg-gray-50 hover:bg-gray-100 transition">
                                            {{ trans('lang.cancel') }}
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                            {{ trans('lang.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Toast Alerts -->
                        <div class="fixed right-8 top-8 z-50 max-w-sm space-y-4">
                            @if (session('success'))
                                <div id="success-alert"
                                    class="border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-2xl bg-green-50 shadow-xl"
                                    role="alert">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
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
                                    class="border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl bg-red-50 shadow-xl"
                                    role="alert">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span
                                            class="font-semibold">{{ trans('lang.please fix the following errors') }}:</span>
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
                        </div>
                        <!-- End Toast Alerts -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal logic
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
        if (openModalBtn) {
            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }
        if (openModalBtnEmpty) {
            openModalBtnEmpty.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
        if (closeModalX) {
            closeModalX.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
        // Filter by name
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
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

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
