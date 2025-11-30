<x-app-layout>
    <div class="py-12 bg-gradient-to-tr from-blue-50 via-white to-green-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-blue-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="px-10 py-8">
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0 flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-700 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                    fill="#e0f2fe" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            <div>
                                <h2 class="text-3xl font-extrabold text-blue-900 mb-1 tracking-tight">
                                    {{ trans('lang.user list') }}
                                </h2>
                                <p class="text-gray-500 text-base">
                                    {{ trans('lang.manage user accounts and edit their specializations') }}.
                                </p>
                            </div>
                        </div>
                        {{-- You can add a button here for "Add Doctor", if needed --}}
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table id="CommonDiseasesTable"
                            class="min-w-full bg-white text-base divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">Nº</th>
                                    <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                                        {{ trans('lang.name') }}</th>
                                    <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                                        {{ trans('lang.email') }}</th>
                                    <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                                        {{ trans('lang.special list') }}</th>
                                    <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">
                                        {{ trans('lang.created at') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 uppercase tracking-wider">
                                        {{ trans('lang.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($user as $doctor)
                                    <tr class="hover:bg-blue-50/50 transition-all duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-gray-700">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <!-- @if($doctor->hasPhoto())
                                                    <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name ?? 'N/A' }}" class="flex-shrink-0 h-10 w-10 rounded-full object-cover mr-3 border-2 border-blue-200" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 items-center justify-center text-white font-bold text-sm mr-3 border-2 border-blue-200 hidden">
                                                        {{ strtoupper(substr($doctor->name ?? 'N/A', 0, 1)) }}
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm mr-3 border-2 border-blue-200">
                                                        {{ strtoupper(substr($doctor->name ?? 'N/A', 0, 1)) }}
                                                    </div>
                                                @endif -->
                                                <div class="text-sm font-semibold text-gray-900">{{ $doctor->name ?? 'N/A' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $doctor->email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                                {{ $doctor->role ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($doctor->created_at)->format('d M, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('doctors.edit', $doctor->_id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 shadow-sm transition-all duration-200 transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    {{ trans('lang.edit') }}
                                                </a>
                                                <button type="button" onclick="openDeleteModal({{ json_encode($doctor->name ?? 'N/A') }}, {{ json_encode(route('doctors.softDelete', $doctor->_id)) }})"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 shadow-sm transition-all duration-200 transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    {{ trans('lang.delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <p class="text-gray-500 font-medium text-lg">{{ trans('lang.no users found') }}</p>
                                                <p class="text-gray-400 text-sm mt-1">No users available to display</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Delete Modal -->
                    <div id="deleteModal"
                        class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden flex items-center justify-center z-50 backdrop-blur-sm">
                        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative border border-gray-200 transform transition-all">
                            <!-- Close Button -->
                            <button onclick="closeDeleteModal()"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Icon -->
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>

                            <!-- Text -->
                            <h2 class="text-2xl font-bold text-gray-900 mb-3 text-center">
                                {{ trans('lang.confirm delete') }}</h2>
                            <p class="text-gray-600 text-center mb-8">
                                {{ trans('lang.are you sure you want to delete') }}
                                <span id="deleteItemName" class="font-semibold text-red-700"></span>?<br>
                                {{ trans('lang.this action cannot be undone') }}.
                            </p>

                            <!-- Buttons -->
                            <div class="flex justify-center space-x-4">
                                <button onclick="closeDeleteModal()"
                                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all duration-200">
                                    {{ trans('lang.cancel') }}
                                </button>

                                <form id="deleteForm" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="delete" value="1" />
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold transition-all duration-200 shadow-sm">
                                        {{ trans('lang.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div id="success-alert"
                    class="mt-8 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-2xl bg-emerald-50 shadow-xl max-w-xl"
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
                    class="mt-8 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl bg-red-50 shadow-xl max-w-xl"
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
        </div>
    </div>
    <script>
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

        // Open the delete confirmation modal and set the form action/name
        function openDeleteModal(itemName, actionUrl) {
            const modal = document.getElementById('deleteModal');
            const nameEl = document.getElementById('deleteItemName');
            const form = document.getElementById('deleteForm');

            if (nameEl) {
                nameEl.textContent = itemName || '';
            }
            if (form) {
                form.action = actionUrl || '';
            }
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            if (modal) {
                modal.classList.add('hidden');
            }
            if (form) {
                form.action = '#';
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
