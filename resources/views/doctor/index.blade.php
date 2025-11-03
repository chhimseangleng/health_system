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

                    <div class="overflow-x-auto">
                        <table id="CommonDiseasesTable"
                            class="min-w-full  bg-white text-base divide-y divide-blue-300 shadow-sm text-center">
                            <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-100 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">Nº</th>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">
                                        {{ trans('lang.name') }}</th>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">
                                        {{ trans('lang.email') }}</th>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">
                                        {{ trans('lang.special list') }}</th>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">
                                        {{ trans('lang.created at') }}</th>
                                    <th scope="col" class="px-6 py-4 text-blue-900 font-bold text-center">
                                        {{ trans('lang.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-blue-100">
                                @forelse ($user as $doctor)
                                    <tr class="hover:bg-blue-50 transition-all duration-200">
                                        <td class="px-6 py-4 text-center font-semibold text-blue-800">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 truncate font-semibold text-gray-900">{{ $doctor->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">{{ $doctor->email ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                                {{ $doctor->role ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-mono text-blue-900">
                                                {{ \Carbon\Carbon::parse($doctor->created_at)->format('Y-m-d') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('doctors.edit', $doctor->_id) }}"
                                                class="inline-flex items-center px-4 py-2 border border-blue-400 text-xs font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition-all">
                                                {{ trans('lang.edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-8 text-center text-blue-600 font-medium bg-blue-50 rounded-xl">
                                            {{ trans('lang.no users found') }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
    </script>
</x-app-layout>
