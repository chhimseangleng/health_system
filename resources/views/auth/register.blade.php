<x-app-layout>
    <div class="p-8 bg-[#f8fafc] min-h-screen">
        <!-- Header with Add User Button -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 space-y-4 sm:space-y-0">
            <h2 class="text-3xl font-extrabold tracking-tight text-[#22223B]"></h2>
            <button onclick="openModal()"
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-semibold rounded-xl shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ trans('lang.add admin') }}
            </button>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table id="CommonDiseasesTable"
                class="min-w-full bg-white text-base divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 uppercase tracking-wider">Nº</th>
                        <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 uppercase tracking-wider">Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 uppercase tracking-wider">Email
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-base font-bold text-gray-700 uppercase tracking-wider">Role
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">Created At</th>
                        <th scope="col" class="px-6 py-4 text-left text-base font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users ?? [] as $user)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-700">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center"> {{-- Added justify-center for centering --}}
                                    <span class="text-base font-semibold text-[#22223B]">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                {{ $user->email }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-sm shadow">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-base text-gray-800">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 text-base font-medium">
                                <button
                                    onclick="openEditRoleModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ $user->role }}')"
                                    class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 mr-1 group-hover:scale-110 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>

                                </button>
                                <button type="button"
                                    onclick="openDeleteModal({{ json_encode(route('register.destroy', $user)) }}, {{ json_encode($user->name) }})"
                                    class="inline-flex items-center p-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-lg font-semibold">No
                                users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if (isset($users) && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="mb-8">
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
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal"
        class="fixed inset-0 bg-[#21223b]/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-8 w-full max-w-lg shadow-2xl rounded-2xl bg-white border border-blue-100">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-tr bg-blue-600 to-blue-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 013.894 3.017A5.002 5.002 0 0117 13v1a3 3 0 01-3 3h-4a3 3 0 01-3-3v-1a5.002 5.002 0 011.106-5.629A4 4 0 0112 4.354zm0 0V3m0 1.354V3" />
                                <circle cx="12" cy="6" r="2" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-blue-900">
                            {{ trans('lang.create an account') }}
                        </h3>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-5 py-4 rounded-xl shadow">
                        <ul class="list-disc list-inside ml-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Modal Body -->
                <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="modal_name" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="modal_name" name="name"
                            class="w-full px-4 py-3 border @error('name') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                            value="{{ old('name') }}" required autofocus autocomplete="name"
                            placeholder="{{ trans('lang.enter name') }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="modal_email" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.email') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="modal_email" name="email"
                            class="w-full px-4 py-3 border @error('email') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                            value="{{ old('email') }}" required autocomplete="username"
                            placeholder="{{ trans('lang.enter your email') }}">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label for="modal_role" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ trans('lang.select role') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="modal_role" name="role"
                            class="w-full px-4 py-3 border @error('role') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-gray-800 bg-white"
                            required>
                            <option value="" disabled selected>{{ trans('lang.select a role') }}</option>
                            @foreach ($roles as $role)
                                @php
                                    $currentUserRole = Auth::user()->role ?? '';
                                    $isSuperadmin = in_array($currentUserRole, ['Superadmin', 'Super User']);
                                @endphp
                                @if ($isSuperadmin || $role->name !== 'Admin')
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="modal_password" class="block text-base font-semibold text-blue-800 mb-2">
                            {{ __('Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="modal_password" name="password"
                            class="w-full px-4 py-3 border @error('password') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                            required autocomplete="new-password" placeholder="{{ __('Password') }}">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="modal_password_confirmation"
                            class="block text-base font-semibold text-blue-800 mb-2">
                            {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="modal_password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 border @error('password_confirmation') border-red-400 @else border-blue-200 @enderror rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 text-gray-800"
                            required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-3 bg-gray-200 text-gray-700 text-base font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all">
                            {{ trans('lang.cancel') }}
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-bold rounded-xl shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                            {{ trans('lang.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div
            class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative border border-gray-200 transform transition-all">
            <button type="button" onclick="closeDeleteModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-3 text-center">
                {{ trans('lang.confirm delete') }}
            </h2>
            <p class="text-gray-600 text-center mb-8">
                {{ trans('lang.are you sure you want to delete') }}
                <span id="deleteItemName" class="font-semibold text-red-700"></span>?<br>
                {{ trans('lang.this action cannot be undone') }}.
            </p>

            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all duration-200">
                    {{ trans('lang.cancel') }}
                </button>

                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold transition-all duration-200 shadow-sm">
                        {{ trans('lang.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div id="editRoleModal"
        class="fixed inset-0 bg-[#21223b]/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
        <div
            class="relative top-28 mx-auto p-7 w-full max-w-md shadow-2xl rounded-2xl bg-white border border-indigo-100">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-tr bg-indigo-600 to-indigo-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-center text-[#364fc7]">
                            Edit Role
                        </h3>
                    </div>
                    <button onclick="closeEditRoleModal()" class="text-gray-400 hover:text-[#364fc7]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="editRoleForm" method="POST" action="" class="space-y-7">
                    @csrf
                    @method('PUT')

                    <div>
                        <p class="text-base text-gray-700 mb-4">
                            Change role for: <span id="editUserName" class="font-semibold text-[#364fc7]"></span>
                        </p>
                    </div>

                    <div>
                        <label for="edit_role" class="block text-base font-semibold text-indigo-700 mb-1">
                            {{ trans('lang.select role') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_role" name="role"
                            class="w-full px-4 py-3 border border-indigo-200 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 text-gray-900 bg-white"
                            required>
                            <option value="" disabled selected>{{ trans('lang.select a role') }}</option>
                            @foreach ($roles as $role)
                                @php
                                    $currentUserRole = Auth::user()->role ?? '';
                                    $isSuperadmin = in_array($currentUserRole, ['Superadmin', 'Super User']);
                                @endphp
                                @if ($isSuperadmin || $role->name !== 'Admin')
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <button type="button" onclick="closeEditRoleModal()"
                            class="px-6 py-3 bg-gray-200 text-gray-700 text-base font-semibold rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all">
                            {{ trans('lang.cancel') }}
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-base font-bold rounded-xl shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-all">
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addUserModal').classList.add('hidden');
            // Reset form
            document.querySelector('#addUserModal form').reset();
            // Clear errors
            const errorElements = document.querySelectorAll('#addUserModal .text-red-600, #addUserModal .border-red-400');
            errorElements.forEach(el => {
                el.classList.remove('text-red-600', 'border-red-400');
                el.classList.add('border-blue-200');
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

        function openEditRoleModal(userId, userName, currentRole) {
            document.getElementById('editRoleModal').classList.remove('hidden');
            document.getElementById('editUserName').textContent = userName;
            document.getElementById('edit_role').value = currentRole;
            // Build the route URL - Laravel route model binding will use the user ID
            document.getElementById('editRoleForm').action = `/register/${userId}/role`;
        }

        function closeEditRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
            document.getElementById('editRoleForm').reset();
        }

        function openDeleteModal(deleteUrl, userName) {
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const deleteName = document.getElementById('deleteItemName');

            if (deleteForm) {
                deleteForm.action = deleteUrl;
            }

            if (deleteName) {
                deleteName.textContent = userName;
            }

            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Close modals when clicking outside
        document.getElementById('addUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('editRoleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditRoleModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeEditRoleModal();
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
