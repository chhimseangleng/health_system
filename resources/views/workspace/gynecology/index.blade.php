    <x-app-layout>
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">

                        <div
                            class="px-6 py-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div class="flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-pink-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm0-4v-4m0 0V8m0 4h4m-4 0H8" />
                                    </svg>
                                </span>
                                <div>
                                    <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight tracking-tight">
                                        {{ trans('lang.pregnancy') }}</h1>
                                    <p class="text-base md:text-lg text-gray-500 mt-1">
                                        {{ trans('lang.manage, search, and export pregnancy records') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3 items-center space-x-2">
                                <form method="GET" action="{{ route('workspace.gynecology.index') }}" class="w-80">
                                    <label for="default-search" class="sr-only">{{ trans('lang.search') }}</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-pink-500 transition-colors"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            id="default-search"
                                            class="block w-full p-3 pl-12 pr-4 text-sm text-gray-700
                                            placeholder-gray-400 bg-white border border-gray-200
                                            rounded-2xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500
                                            shadow-sm transition-all duration-200 hover:shadow-md"
                                            placeholder="{{ trans('lang.search pregnancy by name, or address...') }}"
                                            oninput="searchTable()" />
                                        <input type="hidden" name="role" value="{{ request('role') }}">
                                    </div>
                                </form>
                                <button id="openAddDiseaseModal"
                                    class="inline-flex items-center px-5 py-2 bg-pink-700 hover:bg-pink-800 text-white text-base font-semibold rounded-lg shadow focus:outline-none transition">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ trans('lang.add disease') }}
                                </button>
                            </div>
                        </div>

                        <div class="p-0 md:p-2">
                            <div class="overflow-x-auto border-b">
                                <table id="gynecologyTable"
                                    class="min-w-full  bg-white text-base divide-y divide-pink-300 shadow-sm text-center">
                                    <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-100 ">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                Nº</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.name') }}</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.physician') }}</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.age') }}</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.gender') }}</th>
                                            {{-- <th
                                                class="px-6 py-3 text-xs font-semibold text-pink-700 uppercase tracking-wide">
                                                {{ trans('lang.drug diagnosis') }}</th> --}}
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.village') }}</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.updated') }}</th>
                                            <th scope="col" class="px-6 py-3 text-gray-700">
                                                {{ trans('lang.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="diseasesTableBody" class="divide-y divide-pink-100 bg-white">
                                        @forelse($gynecologyRecords as $index => $record)
                                            <tr class="hover:bg-gray-50 transition-all duration-200">
                                                <td class="px-6 py-4 text-center font-semibold">
                                                    {{ $gynecologyRecords->total() - $gynecologyRecords->firstItem() - $index + 1 }}
                                                </td>
                                                <td class="px-6 py-3 text-center font-bold text-gray-800">
                                                    {{ $record->patient ? $record->patient->first_name . ' ' . $record->patient->last_name : 'N/A' }}
                                                </td>
                                                {{-- <td class="px-6 py-3 text-center text-pink-800">
                                                    {{ $record->staff_name ?? 'N/A' }}
                                                </td> --}}
                                                <td class="px-6 py-3 text-center text-pink-800">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-sm shadow">
                                                        {{ $record->staff_name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-3 text-center text-gray-800">
                                                    {{ $record->patient ? \Carbon\Carbon::parse($record->patient->date_of_birth)->age : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-3 text-center whitespace-nowrap">
                                                    @if ($record->patient)
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full truncate font-medium {{ strtolower($record->patient->gender) === 'male'
                                                                ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                                                : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                                            {{ trans('lang.' . strtolower($record->patient->gender)) }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-500">N/A</span>
                                                    @endif
                                                </td>


                                                {{-- <td class="px-6 py-3 text-pink-800">
                                                    {{ $record->medication ?? 'N/A' }}
                                                </td> --}}
                                                <td class="px-6 py-3 text-center text-gray-800">
                                                    {{ $record->patient ? $record->patient->address : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-3 text-center text-gray-800">
                                                    {{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-3 text-center">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <!-- Detail -->
                                                        <button
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-pink-600 hover:text-pink-900 hover:bg-pink-50 transition"
                                                            onclick="viewRecord(this)"
                                                            title="{{ trans('lang.view details') }}"
                                                            data-id="{{ $record->_id }}"
                                                            data-name="{{ $record->patient ? $record->patient->first_name . ' ' . $record->patient->last_name : 'N/A' }}"
                                                            data-staff="{{ $record->staff_name ?? 'N/A' }}"
                                                            data-age="{{ $record->patient ? \Carbon\Carbon::parse($record->patient->date_of_birth)->age : 'N/A' }}"
                                                            data-gender="{{ $record->patient ? ucfirst(strtolower($record->patient->gender)) : 'N/A' }}"
                                                            data-address="{{ $record->patient ? $record->patient->address ?? 'N/A' : 'N/A' }}"
                                                            data-updated="{{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                        </button>

                                                        <!-- Edit -->
                                                        <a href="{{ route('workspace.gynecology.edit', $record->_id) }}"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-blue-600 hover:text-blue-900 hover:bg-blue-50 transition"
                                                            title="{{ trans('lang.edit') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>

                                                        <!-- Delete -->
                                                        <!-- Delete Button (Triggers Modal) -->
                                                        <button data-modal-target="deleteModal-{{ $record->_id }}"
                                                            data-modal-toggle="deleteModal-{{ $record->_id }}"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-900 hover:bg-red-50 transition"
                                                            title="{{ trans('lang.delete') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-6 0V5a1 1 0 011-1h4a1 1 0 011 1v2" />
                                                            </svg>
                                                        </button>

                                                        <!-- Delete Confirmation Modal -->
                                                        <div id="deleteModal-{{ $record->_id }}"
                                                            class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                            <div
                                                                class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                                <div class="text-center">
                                                                    <!-- Warning Icon -->
                                                                    <div
                                                                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                                                                        <svg class="h-8 w-8 text-red-500" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                                        </svg>
                                                                    </div>

                                                                    <!-- Title -->
                                                                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                                                                        {{ trans('lang.confirm delete') }}
                                                                    </h3>

                                                                    <!-- Description -->
                                                                    <p class="text-gray-600 mb-8">
                                                                        {{ trans('lang.are you sure you want to delete this record') }}?<br>
                                                                        {{ trans('lang.this action cannot be undone') }}.
                                                                    </p>

                                                                    <!-- Buttons -->
                                                                    <div class="flex justify-center space-x-4">
                                                                        <button
                                                                            data-modal-target="deleteModal-{{ $record->_id }}"
                                                                            data-modal-toggle="deleteModal-{{ $record->_id }}"
                                                                            class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                            {{ trans('lang.cancel') }}
                                                                        </button>

                                                                        <form
                                                                            action="{{ route('workspace.gynecology.destroy', $record->_id) }}"
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

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-6 py-16 text-center text-gray-400">
                                                    <div class="flex flex-col items-center">
                                                        <svg class="w-14 h-14 text-gray-200 mb-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10z" />
                                                        </svg>
                                                        <p class="text-lg font-bold">
                                                            {{ trans('lang.no gynecology records found') }}</p>
                                                        <p class="text-base text-gray-400 mt-2">
                                                            {{ trans('lang.complete some patient forms to see records here') }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-8 flex justify-end">
                                {{ $gynecologyRecords->links() }}
                            </div>
                        </div>
                    </div>

                    <div class="fixed z-50 right-8 bottom-8 space-y-3 w-full max-w-xs" style="pointer-events:none;">
                        @if (session('success'))
                            <div id="success-alert"
                                class="flex items-center border-l-4 border-pink-700 bg-white px-4 py-3 shadow-lg rounded-lg animate-fadeIn pointer-events-auto">
                                <svg class="w-6 h-6 mr-3 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div id="error-alert"
                                class="flex flex-col border-l-4 border-pink-700 bg-white px-4 py-3 shadow-lg rounded-lg animate-fadeIn pointer-events-auto">
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-6 h-6 mr-2 text-pink-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="font-semibold text-pink-800">{{ trans('lang.please fix the following errors') }}</span>
                                </div>
                                <ul class="list-inside list-disc text-sm text-pink-700 pl-6">
                                    @foreach ($errors->all() as $error)
                                        <li class="py-0.5">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- PATIENTS NEEDING GYNECOLOGY INFORMATION --}}
                    @if (!$incompletePatients->isEmpty())
                        <div class="mt-14">
                            <div
                                class="bg-gradient-to-r from-pink-50 to-fuchsia-50 rounded-2xl border-2 border-pink-200 px-8 py-8 shadow">
                                <div class="flex items-center mb-4">
                                    <svg class="w-7 h-7 text-pink-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">
                                        {{ trans('lang.patients needing gynecology information') }}
                                    </h2>
                                    <span
                                        class="ml-4 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        {{ $incompletePatients->count() }} {{ trans('lang.pending') }}
                                    </span>
                                </div>
                                <div class="overflow-x-auto">
                                    <table
                                        class="min-w-full divide-y divide-pink-100 text-center bg-white rounded-2xl shadow">
                                        <thead class="bg-pink-100">
                                            <tr>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    Nº</th>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    {{ trans('lang.patient name') }}</th>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    {{ trans('lang.dob') }}</th>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    {{ trans('lang.age') }}</th>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    {{ trans('lang.phone number') }}</th>
                                                <th
                                                    class="px-5 py-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                                    {{ trans('lang.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-pink-50">
                                            @foreach ($incompletePatients as $index => $patient)
                                                <tr class="hover:bg-pink-50 transition duration-150">
                                                    <td class="px-6 py-1 text-center text-pink-900 font-semibold">
                                                <tr class="hover:bg-gray-50 transition-all duration-200">
                                                    <td class="px-6 py-4 text-center font-semibold">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="px-5 py-4 text-base font-bold text-gray-900">
                                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                                    </td>
                                                    <td class="px-5 py-4 text-base text-pink-900">
                                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-5 py-4 text-base">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-xs shadow">
                                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                                            {{ trans('lang.years') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-4 text-base text-pink-900">
                                                        {{ $patient->phone }}
                                                    </td>
                                                    <td class="px-5 py-4 text-base">
                                                        <div class="flex items-center gap-2 justify-center">
                                                            <a href="{{ route('workspace.gynecology.patient.form', $patient->_id) }}"
                                                                class="inline-flex items-center px-4 py-1.5 text-sm rounded-lg bg-pink-700 text-white font-medium hover:bg-pink-900 transition shadow"
                                                                title="Complete gynecology information">
                                                                <svg class="w-4 h-4 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                {{ trans('Complete') }}
                                                            </a>
                                                            <!-- Dismiss Button (Triggers Modal) -->
                                                            <button data-modal-target="dismissModal-{{ $patient->_id }}"
                                                                data-modal-toggle="dismissModal-{{ $patient->_id }}"
                                                                class="inline-flex items-center px-4 py-1.5 text-sm rounded-lg bg-white text-pink-700 border border-pink-300 hover:bg-pink-100 font-medium transition shadow"
                                                                title="{{ trans('lang.dismiss from list') }}">
                                                                <svg class="w-4 h-4 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                {{ trans('lang.dismiss') }}
                                                            </button>

                                                            <!-- Modal -->
                                                            <div id="dismissModal-{{ $patient->_id }}"
                                                                class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                                <div
                                                                    class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                                    <div class="text-center">
                                                                        <!-- Icon -->
                                                                        <div
                                                                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-pink-50 mb-6">
                                                                            <svg class="h-8 w-8 text-pink-500"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                                            </svg>
                                                                        </div>

                                                                        <!-- Title -->
                                                                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                                                                            {{ trans('lang.confirm dismiss') }}
                                                                        </h3>

                                                                        <!-- Description -->
                                                                        <p class="text-gray-600 mb-8">
                                                                            {{ trans('lang.are you sure you want to dismiss this patient') }}?<br>
                                                                            {{ trans('lang.this action cannot be undone') }}.
                                                                        </p>

                                                                        <!-- Actions -->
                                                                        <div class="flex justify-center space-x-4">
                                                                            <button
                                                                                data-modal-target="dismissModal-{{ $patient->_id }}"
                                                                                data-modal-toggle="dismissModal-{{ $patient->_id }}"
                                                                                class="px-6 py-2 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                                {{ trans('lang.cancel') }}
                                                                            </button>

                                                                            <form
                                                                                action="{{ route('workspace.gynecology.patient.dismiss', $patient->_id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <button type="submit"
                                                                                    class="px-6 py-2 bg-pink-600 text-white rounded-2xl hover:bg-pink-700 transition-colors duration-200 font-medium">
                                                                                    {{ trans('lang.dismiss') }}
                                                                                </button>
                                                                            </form>
                                                                        </div>
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
                            </div>
                        </div>
                    @endif

                        <!-- Detail Modal -->
                        {{-- <div id="recordDetailModal"
                            class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 min-h-screen min-w-screen flex items-center justify-center transition">
                            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto p-6">
                                <div class="flex justify-between items-start border-b border-gray-100 pb-3 mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ trans('lang.record details') }}</h3>
                                    <button type="button" id="closeRecordDetailModal"
                                        class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-200 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="recordDetailBody" class="space-y-3 text-sm">
                                    <div class="text-gray-400">{{ trans('lang.loading') }}...</div>
                                </div>
                            </div>
                        </div> --}}

                    <!-- Add Disease Modal -->
                    <div id="addDiseaseModal" tabindex="-1" aria-hidden="true"
                        class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 min-h-screen min-w-screen flex items-center justify-center transition">
                        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto p-8">
                            <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">{{ trans('lang.add new disease') }}
                                        </h2>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ trans('lang.enter disease information below') }}</p>
                                    </div>
                                </div>
                                <button type="button" id="closeAddDiseaseModal"
                                    class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-200 flex items-center justify-center transition focus:outline-none">
                                    <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('workspace.gynecology.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-800 mb-1">
                                        {{ trans('lang.disease name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                                        placeholder="{{ trans('lang.enter disease name') }}" required>
                                </div>
                                <div class="flex justify-end pt-2 space-x-2 border-t border-gray-100 mt-3">
                                    <button type="button" id="closeAddDiseaseModalBtn"
                                        class="px-6 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition">
                                        {{ trans('lang.cancel') }}
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-2 bg-pink-700 hover:bg-pink-900 text-white rounded-lg font-semibold transition flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        {{ trans('lang.add disease') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            // MODAL logic
            const addModal = document.getElementById('addDiseaseModal');
            const openAddBtn = document.getElementById('openAddDiseaseModal');
            const closeAddBtn = document.getElementById('closeAddDiseaseModal');
            const closeAddBtnSecondary = document.getElementById('closeAddDiseaseModalBtn');

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

            if (closeAddBtnSecondary && addModal) {
                closeAddBtnSecondary.addEventListener('click', () => {
                    addModal.classList.add('hidden');
                    addModal.classList.remove('flex');
                });
            }

            // Click outside modal to close
            if (addModal) {
                addModal.addEventListener('click', function(e) {
                    if (e.target === addModal) {
                        addModal.classList.add('hidden');
                        addModal.classList.remove('flex');
                    }
                });
            }

            // Auto-hide alerts
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

            // View record: replace with modal or route if you want
            function viewRecord(btnEl) {
                const modal = document.getElementById('recordDetailModal');
                const body = document.getElementById('recordDetailBody');
                if (!modal || !body) return;

                const name = btnEl.getAttribute('data-name') || 'N/A';
                const staff = btnEl.getAttribute('data-staff') || 'N/A';
                const age = btnEl.getAttribute('data-age') || 'N/A';
                const gender = btnEl.getAttribute('data-gender') || 'N/A';
                const address = btnEl.getAttribute('data-address') || 'N/A';
                const updated = btnEl.getAttribute('data-updated') || 'N/A';

                body.innerHTML = `
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.patient name') }}</span>
                            <div class="text-gray-900 font-semibold">${name}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.age') }}</span>
                                <div class="text-gray-900">${age}</div>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.gender') }}</span>
                                <div class="text-gray-900">${gender}</div>
                            </div>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.physician') }}</span>
                            <div class="text-gray-900">${staff}</div>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.village') }}</span>
                            <div class="text-gray-900">${address}</div>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs font-medium">{{ trans('lang.updated') }}</span>
                            <div class="text-gray-900">${updated}</div>
                        </div>
                    </div>
                `;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            // Close detail modal handlers
            (function() {
                const modal = document.getElementById('recordDetailModal');
                const closeBtn = document.getElementById('closeRecordDetailModal');
                if (closeBtn && modal) {
                    closeBtn.addEventListener('click', function() {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                }
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }
                    });
                }
            })();

            // Search Table Function
            function searchTable() {
                const searchInput = document.getElementById('default-search').value.toLowerCase();
                const rows = document.querySelectorAll('#gynecologyTable tbody tr');

                rows.forEach(row => {
                    // Skip empty rows or rows with colspan (no results row)
                    if (row.querySelector('td[colspan]')) return;

                    // Get searchable columns: Name (2), Physician (3), Village (6)
                    const nameCell = row.querySelector('td:nth-child(2)');
                    const physicianCell = row.querySelector('td:nth-child(3)');
                    const villageCell = row.querySelector('td:nth-child(6)');

                    if (!nameCell) return;

                    // Store original HTML if not already stored
                    if (!nameCell.dataset.originalHtml) {
                        nameCell.dataset.originalHtml = nameCell.innerHTML;
                    }
                    if (physicianCell && !physicianCell.dataset.originalHtml) {
                        physicianCell.dataset.originalHtml = physicianCell.innerHTML;
                    }
                    if (villageCell && !villageCell.dataset.originalHtml) {
                        villageCell.dataset.originalHtml = villageCell.innerHTML;
                    }

                    // If search is cleared, restore all rows and original content
                    if (!searchInput || searchInput.trim() === '') {
                        row.style.display = '';
                        // Restore original HTML content
                        if (nameCell.dataset.originalHtml) {
                            nameCell.innerHTML = nameCell.dataset.originalHtml;
                        }
                        if (physicianCell && physicianCell.dataset.originalHtml) {
                            physicianCell.innerHTML = physicianCell.dataset.originalHtml;
                        }
                        if (villageCell && villageCell.dataset.originalHtml) {
                            villageCell.innerHTML = villageCell.dataset.originalHtml;
                        }
                        return;
                    }

                    // Get text content for searching from original HTML (before highlighting)
                    const tempNameDiv = document.createElement('div');
                    tempNameDiv.innerHTML = nameCell.dataset.originalHtml || nameCell.innerHTML;
                    const nameText = (tempNameDiv.textContent || tempNameDiv.innerText || '').toLowerCase();

                    const tempPhysicianDiv = document.createElement('div');
                    if (physicianCell) {
                        tempPhysicianDiv.innerHTML = physicianCell.dataset.originalHtml || physicianCell.innerHTML;
                    }
                    const physicianText = (tempPhysicianDiv.textContent || tempPhysicianDiv.innerText || '').toLowerCase();

                    const tempVillageDiv = document.createElement('div');
                    if (villageCell) {
                        tempVillageDiv.innerHTML = villageCell.dataset.originalHtml || villageCell.innerHTML;
                    }
                    const villageText = (tempVillageDiv.textContent || tempVillageDiv.innerText || '').toLowerCase();

                    const match = nameText.includes(searchInput) ||
                        physicianText.includes(searchInput) ||
                        villageText.includes(searchInput);

                    // Show/hide rows based on match
                    row.style.display = match ? '' : 'none';

                    // Restore or highlight cells
                    [nameCell, physicianCell, villageCell].forEach(cell => {
                        if (cell && cell.dataset.originalHtml) {
                            if (match) {
                                // Highlight matches
                                const originalHtml = cell.dataset.originalHtml;
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = originalHtml;
                                const existingSpan = tempDiv.querySelector('span:not(.bg-emerald-100)');

                                if (existingSpan) {
                                    // Preserve existing span structure (like physician column)
                                    const spanText = existingSpan.textContent;
                                    const highlightedText = spanText.replace(new RegExp(`(${searchInput.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi'), match =>
                                        `<span class="bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-lg font-medium">${match}</span>`
                                    );
                                    const newSpan = existingSpan.cloneNode(false);
                                    newSpan.innerHTML = highlightedText;
                                    cell.innerHTML = newSpan.outerHTML;
                                } else {
                                    // Regular cell without existing spans
                                    const text = tempDiv.textContent || tempDiv.innerText || '';
                                    cell.innerHTML = text.replace(new RegExp(`(${searchInput.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi'), match =>
                                        `<span class="bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-lg font-medium">${match}</span>`
                                    );
                                }
                            } else {
                                // Restore original content for non-matching rows
                                cell.innerHTML = cell.dataset.originalHtml;
                            }
                        }
                    });
                });
            }

            // Initialize: Store original HTML on page load
            document.addEventListener('DOMContentLoaded', function() {
                const rows = document.querySelectorAll('#gynecologyTable tbody tr');
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return;

                    const nameCell = row.querySelector('td:nth-child(2)');
                    const physicianCell = row.querySelector('td:nth-child(3)');
                    const villageCell = row.querySelector('td:nth-child(6)');

                    if (nameCell && !nameCell.dataset.originalHtml) {
                        nameCell.dataset.originalHtml = nameCell.innerHTML;
                    }
                    if (physicianCell && !physicianCell.dataset.originalHtml) {
                        physicianCell.dataset.originalHtml = physicianCell.innerHTML;
                    }
                    if (villageCell && !villageCell.dataset.originalHtml) {
                        villageCell.dataset.originalHtml = villageCell.innerHTML;
                    }
                });
            });

            // Auto-submit form on Enter key for server-side search
            const searchInput = document.getElementById('default-search');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.closest('form').submit();
                    }
                });
            }
        </script>
    </x-app-layout>
