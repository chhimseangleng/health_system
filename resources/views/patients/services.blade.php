<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ trans('lang.patient services') }}</h1>
                                <p class="text-gray-600 mt-1">{{ $patient->first_name }} {{ $patient->last_name }} - {{ $patient->phone }}</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('patients.index') }}"
                                   class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                    {{ trans('lang.back to patients') }}
                                </a>

                                <button data-modal-target="add-service-modal" data-modal-toggle="add-service-modal"
                                    class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 shadow">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ trans('lang.add new service') }}
                                </button>
                            </div>
                        </div>

                        {{-- Patient Info Card --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.name') }}:</span>
                                    <p class="text-blue-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.phone') }}:</span>
                                    <p class="text-blue-900">{{ $patient->phone }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.date of birth') }}:</span>
                                    <p class="text-blue-900">{{ $patient->date_of_birth }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.gender') }}:</span>
                                    <p class="text-blue-900">{{ ucfirst($patient->gender) }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.address') }}:</span>
                                    <p class="text-blue-900">{{ $patient->address }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-blue-800">{{ trans('lang.total services') }}:</span>
                                    <p class="text-blue-900 font-semibold">{{ $patient->services->count() }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Services Table --}}
                        <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="text-xs tracking-wider uppercase bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">{{ trans('lang.service name') }}</th>
                                        <th scope="col" class="px-6 py-3">{{ trans('lang.date') }}</th>
                                        <th scope="col" class="px-6 py-3">{{ trans('lang.status') }}</th>
                                        <th scope="col" class="px-6 py-3">{{ trans('lang.notes') }}</th>
                                        <th scope="col" class="px-6 py-3">{{ trans('lang.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if ($patient->services->count() > 0)
                                        @foreach ($patient->services as $service)
                                            <tr class="hover:bg-gray-50 transition duration-150">
                                                <td class="px-6 py-4 text-center font-medium">{{ $service->service_name }}</td>
                                                <td class="px-6 py-4 text-center">{{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('M d, Y') : 'N/A' }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'completed' => 'bg-green-100 text-green-800',
                                                            'cancelled' => 'bg-red-100 text-red-800'
                                                        ];
                                                        $color = $statusColors[$service->status] ?? 'bg-gray-100 text-gray-800';
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                        {{ ucfirst($service->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    @if($service->notes)
                                                        <span class="text-gray-600">{{ Str::limit($service->notes, 50) }}</span>
                                                    @else
                                                        <span class="text-gray-400 text-sm">{{ trans('lang.no notes') }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center items-center gap-3">
                                                        <button class="text-blue-600 hover:text-blue-800 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </button>
                                                        <button class="text-red-600 hover:text-red-800 transition">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-8 text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-lg font-medium">{{ trans('lang.no services found') }}</p>
                                                    <p class="text-sm text-gray-400">{{ trans('lang.this patient hasn\'t received any services yet') }}.</p>
                                                </div>
                                            </td>
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

    {{-- Include the add service modal --}}
    @include('patients.add-service', ['patients' => collect([$patient])])

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
    @endif>

    <script>
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

        // Hide alerts after 5 seconds
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
