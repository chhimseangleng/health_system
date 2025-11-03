<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xl">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl ring-1 ring-gray-100">
                    <div class="p-8">

                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10 gap-4">
                            <div class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10z" />
                                </svg>

                                <!-- Heading and subtitle -->
                                <div>
                                    <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight drop-shadow-sm">
                                        {{ trans('lang.common diseases') }}</h1>
                                    <p class="text-lg text-gray-500 mt-2">
                                        {{ trans('lang.manage search export common disease records') }}</p>
                                </div>
                            </div>



                            <div class="flex items-center gap-3 space-x-2">
                                {{-- <button id="openAddDiseaseModal"
                                    class="text-blue-600 border border-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex ">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Disease
                                </button> --}}

                                <form method="GET" action="{{ route('workspace.common-diseases.index') }}"
                                    class="w-80">
                                    <label for="common-disease-search"
                                        class="sr-only">{{ trans('lang.search') }}</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="search" id="common-disease-search"
                                            value="{{ request('search') }}"
                                            class="block w-full p-3 pl-12 pr-12 text-sm text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 hover:shadow-md"
                                            placeholder="   {{ trans('lang.search common diseases by name, address...') }}"
                                            oninput="searchCommonDiseaseTable()" />

                                        <!-- Clear button -->
                                        @if (request('search'))
                                            <button type="button" onclick="clearCommonDiseaseSearch()"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <input type="hidden" name="role" value="{{ request('role') }}">
                                    </div>
                                </form>
                                <a href="{{ route('workspace.common-diseases.print') }}" target="_blank"
                                    class="text-orange-600 border border-orange-600 hover:text-white hover:bg-orange-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex ">
                                    {{ trans('lang.export') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="bi bi-box-arrow-up-right size-3 ms-2" viewBox="0 0 17 18">
                                        <path fill-rule="evenodd"
                                            d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                        <path fill-rule="evenodd"
                                            d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table id="CommonDiseasesTable"
                                class="min-w-full  bg-white text-base divide-y divide-blue-300 shadow-sm text-center">
                                <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-100 ">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-gray-700">Nº</th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">
                                            {{ trans('lang.physician') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.age') }}</th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.gender') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">
                                            {{ trans('lang.diagnosis') }}</th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.village') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.updated') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-gray-700">{{ trans('lang.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="diseasesTableBody" class="divide-y divide-blue-100 bg-white">
                                    @forelse($diseases as $i => $d)
                                         <tr class="hover:bg-gray-50 transition-all duration-200">
                                            <td class="px-6 py-4 text-center font-semibold">
                                                {{ $diseases->total() - $diseases->firstItem() - $i + 1 }}</td>
                                            <td class="px-5 py-4 text-base font-bold text-gray-900">{{ $d->name }}
                                            </td>
                                            <td class="px-6 py-4 text-base text-gray-800">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-sm shadow">
                                                    {{ $d->physician ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-base text-gray-800">{{ $d->age }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if (!empty($d->gender))
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full truncate font-medium{{ strtolower($d->gender) === 'male' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                                        {{ trans('lang.' . strtolower($d->gender)) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 italic">—</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 text-base text-gray-800">
                                                @php
                                                    $prescriptions = $d->prescriptions ?? null;
                                                @endphp
                                                @if (!empty($prescriptions) && is_array($prescriptions))
                                                    <div class="space-y-2">
                                                        @foreach ($prescriptions as $p)
                                                            @php
                                                                $mid = (string) ($p['medicine_id'] ?? '');
                                                                $mname = $medicineMap[$mid] ?? '';
                                                                $tm = $p['total_medicine'] ?? null;
                                                                $td = $p['total_day'] ?? null;
                                                                $times = $p['times'] ?? [];
                                                            @endphp
                                                            <div>
                                                                <div class="text-gray-900">
                                                                    <span
                                                                        class="font-semibold">{{ $mname }}</span>
                                                                    @if (!is_null($td) || !is_null($tm))
                                                                        <span class="text-gray-700 text-xs">-
                                                                            @if (!is_null($td))
                                                                                Total Day: {{ $td }}
                                                                            @endif
                                                                            @if (!is_null($td) && !is_null($tm))
                                                                                ,
                                                                            @endif
                                                                            @if (!is_null($tm))
                                                                                Total Medicine: {{ $tm }}
                                                                            @endif
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="mt-1 text-xs text-gray-700">
                                                                    @foreach (['M' => 'Morning', 'A' => 'Afternoon', 'E' => 'Evening'] as $k => $label)
                                                                        @php $t = $times[$k] ?? null; @endphp
                                                                        @if ($t && (isset($t['qty']) || !empty($t['remark'])))
                                                                            <div>
                                                                                <span
                                                                                    class="inline-block w-20 text-blue-500">{{ $label }}
                                                                                    ({{ $k }})
                                                                                </span>
                                                                                @if (isset($t['qty']))
                                                                                    <span
                                                                                        class="font-medium">x{{ $t['qty'] }}</span>
                                                                                @endif
                                                                                @if (!empty($t['remark']))
                                                                                    <span class="text-blue-400">-
                                                                                        {{ $t['remark'] }}</span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    {{ $d->drug_diagnosis }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-base text-gray-800">{{ $d->village }}</td>
                                            {{-- <td class="px-6 py-4 text-base text-blue-800">{{ $d->commune }}</td> --}}
                                            <td class="px-6 py-4 text-base text-gray-800">
                                                {{ optional($d->updated_at)->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 text-base">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('workspace.common-diseases.export.pdf', $d->_id) }}"
                                                        title="Export PDF"
                                                        class="inline-flex items-center p-2.5 text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 rounded-xl transition-all duration-200 group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            class="w-5 h-5 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 8v8m0 0l-3-3m3 3l3-3M5 12a7 7 0 1114 0 7 7 0 01-14 0z" />
                                                        </svg>
                                                    </a>


                                                    <a href="{{ route('workspace.common-diseases.edit', $d->_id) }}"
                                                        title="Edit"
                                                        class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-5 h-5 mr-1 group-hover:scale-110 transition-transform">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </a>

                                                    <button
                                                        onclick="openDeleteModal('{{ route('workspace.common-diseases.destroy', $d->_id) }}', '{{ $d->name ?? 'this record' }}')"
                                                        class="inline-flex items-center p-2.5 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                                            fill="none" stroke="currentColor" stroke-width="1.5"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>


                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11"
                                                class="px-6 py-8 text-center text-blue-400 text-lg font-semibold">
                                                {{ trans('lang.no record yet') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8">
                            {{ $diseases->links() }}
                        </div>


                        {{-- Delete Modal --}}
                        <div id="deleteModal"
                            class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden flex items-center justify-center z-50 backdrop-blur-sm">
                            <div
                                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative border border-gray-200">

                                <!-- Close Button -->
                                <button onclick="closeDeleteModal()"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- Icon -->
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667
                                        1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732
                                        0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
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
                                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium transition">
                                        {{ trans('lang.cancel') }}
                                    </button>

                                    <form id="deleteForm" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-6 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition">
                                            {{ trans('lang.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            @if (session('success'))
                                <div id="success-alert"
                                    class="fixed bottom-6 right-6 z-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-2xl mb-4 bg-emerald-50 shadow-xl min-w-[320px] max-w-sm"
                                    role="alert">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-emerald-500 mr-3" fill="currentColor"
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
                                    class="fixed bottom-6 right-6 z-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl mb-4 bg-red-50 shadow-xl min-w-[320px] max-w-sm"
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

                        <!-- Patients Needing Common Disease Information Section -->
                        @if (!$incompletePatients->isEmpty())
                            <div class="mt-14">
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-fuchsia-50 rounded-2xl border-2 border-blue-200 px-8 py-8 shadow">
                                    <div class="flex items-center mb-4">
                                        <svg class="w-7 h-7 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                        <h2 class="text-xl md:text-2xl font-semibold text-gray-900">
                                            {{ trans('lang.patients needing common disease information') }}
                                        </h2>
                                        <span
                                            class="ml-4 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            {{ $incompletePatients->count() }} {{ trans('lang.pending') }}
                                        </span>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table
                                            class="min-w-full divide-y divide-blue-100 text-center bg-white rounded-2xl shadow">
                                            <thead class="bg-blue-100">
                                                <tr>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        Nº</th>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        {{ trans('lang.patient name') }}</th>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        {{ trans('lang.dob') }}</th>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        {{ trans('lang.age') }}</th>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        {{ trans('lang.phone number') }}</th>
                                                    <th
                                                        class="px-5 py-4 text-sm font-semibold text-blue-700 uppercase tracking-wide">
                                                        {{ trans('lang.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-blue-50">
                                                @foreach ($incompletePatients as $index => $patient)
                                                    <tr class="hover:bg-blue-50 transition duration-150">
                                                        <td class="px-6 py-1 text-center text-blue-900 font-semibold">
                                                    <tr class="hover:bg-gray-50 transition-all duration-200">
                                                        <td class="px-6 py-4 text-center font-semibold">
                                                            {{ $index + 1 }}</td>
                                                        <td class="px-5 py-4 text-base font-bold text-gray-900">
                                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                                        </td>
                                                        <td class="px-5 py-4 text-base text-blue-900">
                                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-5 py-4 text-base text-blue-900">
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 shadow">
                                                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                                                years
                                                            </span>
                                                        </td>
                                                        <td class="px-5 py-4 text-base text-blue-900">
                                                            {{ $patient->phone }}</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-base flex justify-center space-x-1">
                                                            <!-- Complete Button (Tick) -->
                                                            <a href="{{ route('workspace.common-diseases.patient.form', $patient->_id) }}"
                                                                class="text-blue-600 border border-blue-600 hover:text-white hover:bg-blue-600 font-medium rounded-lg text-sm px-5  py-2.5 text-center  inline-flex "
                                                                title="Complete common disease information">
                                                                <svg class="w-5 h-5 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                {{ trans('lang.complete') }}
                                                            </a>

                                                            <!-- Dismiss Button (Cross) -->
                                                            <!-- Dismiss Button (Triggers Modal) -->
                                                            <button
                                                                data-modal-target="dismissModal-{{ $patient->_id }}"
                                                                data-modal-toggle="dismissModal-{{ $patient->_id }}"
                                                                class="text-red-600 border border-red-600 hover:text-white hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center"
                                                                title="{{ trans('lang.dismiss from list') }}">
                                                                <svg class="w-5 h-5 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                {{ trans('lang.dismiss') }}
                                                            </button>

                                                            <!-- Dismiss Confirmation Modal -->
                                                            <div id="dismissModal-{{ $patient->_id }}"
                                                                class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
                                                                <div
                                                                    class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
                                                                    <div class="text-center">
                                                                        <div
                                                                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                                                                            <svg class="h-8 w-8 text-red-500"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                                            </svg>
                                                                        </div>
                                                                        <h3
                                                                            class="text-xl font-bold text-gray-900 mb-3">
                                                                            {{ trans('lang.confirm dismiss') }}
                                                                        </h3>
                                                                        <p class="text-gray-600 mb-8">
                                                                            {{ trans('lang.are you sure you want to dismiss this patient') }}?<br>
                                                                            {{ trans('lang.this action cannot be undone') }}.
                                                                        </p>
                                                                        <div class="flex justify-center space-x-4">
                                                                            <!-- Cancel Button -->
                                                                            <button
                                                                                data-modal-target="dismissModal-{{ $patient->_id }}"
                                                                                data-modal-toggle="dismissModal-{{ $patient->_id }}"
                                                                                class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                                                                {{ trans('lang.cancel') }}
                                                                            </button>

                                                                            <!-- Confirm Form -->
                                                                            <form
                                                                                action="{{ route('workspace.common-diseases.patient.dismiss', $patient->_id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <button type="submit"
                                                                                    class="px-8 py-3 bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-colors duration-200 font-medium">
                                                                                    {{ trans('lang.dismiss') }}
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
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Delete Modal
            function openDeleteModal(actionUrl, itemName) {
                const modal = document.getElementById('deleteModal');
                const form = document.getElementById('deleteForm');
                const nameSpan = document.getElementById('deleteItemName');

                form.action = actionUrl;
                nameSpan.textContent = itemName;
                modal.classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

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

            const addModal = document.getElementById('addDiseaseModal');
            const openAddBtn = document.getElementById('openAddDiseaseModal');
            const closeAddBtn = document.getElementById('closeAddDiseaseModal');
            const searchInput = document.getElementById('searchInput');
            const suggestionsEl = document.getElementById('patientSuggestions');

            openAddBtn.addEventListener('click', () => {
                addModal.classList.remove('hidden');
                addModal.classList.add('flex');
            });
            closeAddBtn.addEventListener('click', () => {
                addModal.classList.add('hidden');
                addModal.classList.remove('flex');
            });

            function debounce(fn, wait) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(null, args), wait);
                };
            }

            async function fetchPatientSuggestions(term) {
                const baseUrl = searchInput?.getAttribute('data-search-url') || '/workspace/common-diseases/patient-search';
                const url = `${baseUrl}?q=${encodeURIComponent(term)}`;
                try {
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) return [];
                    const json = await res.json();
                    return Array.isArray(json.data) ? json.data : [];
                } catch (e) {
                    return [];
                }
            }

            function highlight(text, term) {
                const i = text.toLowerCase().indexOf(term.toLowerCase());
                if (i === -1) return text;
                const before = text.slice(0, i);
                const match = text.slice(i, i + term.length);
                const after = text.slice(i + term.length);
                return `${before}<span class='bg-yellow-200 font-bold'>${match}</span>${after}`;
            }

            async function renderSuggestions(term) {
                if (!term || term.trim().length === 0) {
                    suggestionsEl.classList.add('hidden');
                    suggestionsEl.innerHTML = '';
                    return;
                }
                const matches = await fetchPatientSuggestions(term);
                if (matches.length === 0) {
                    suggestionsEl.classList.add('hidden');
                    suggestionsEl.innerHTML = '';
                    return;
                }
                suggestionsEl.innerHTML = matches.map(m => `
                                    <a href="${m.url}" class="block px-4 py-2 hover:bg-blue-50 text-base text-blue-900 font-semibold rounded-xl transition">${highlight(m.name, term)}</a>
                                `).join('');
                suggestionsEl.classList.remove('hidden');
            }

            const onInput = debounce((e) => {
                renderSuggestions(e.target.value);
            }, 200);

            if (searchInput) {
                searchInput.addEventListener('input', onInput);
                searchInput.addEventListener('focus', (e) => renderSuggestions(e.target.value));
            }
            document.addEventListener('click', (e) => {
                if (!suggestionsEl.contains(e.target) && e.target !== searchInput) {
                    suggestionsEl.classList.add('hidden');
                }
            });

            // Clean Search Script for Common Diseases Table
            function searchCommonDiseaseTable() {
                const searchInput = document.getElementById('common-disease-search').value.toLowerCase();
                const rows = document.querySelectorAll('#CommonDiseasesTable tbody tr');
                let hasVisibleRows = false;

                rows.forEach(row => {
                    // Skip empty rows or "no results" rows
                    if (row.cells.length < 2) return;

                    const nameCell = row.querySelector('td:nth-child(2)'); // Name
                    const physicianCell = row.querySelector('td:nth-child(3)'); // Physician
                    const villageCell = row.querySelector('td:nth-child(7)'); // Village
                    const diagnosisCell = row.querySelector('td:nth-child(6)'); // Diagnosis

                    if (!nameCell) return;

                    const nameText = nameCell.textContent.toLowerCase();
                    const physicianText = physicianCell ? physicianCell.textContent.toLowerCase() : '';
                    const villageText = villageCell ? villageCell.textContent.toLowerCase() : '';
                    const diagnosisText = diagnosisCell ? diagnosisCell.textContent.toLowerCase() : '';

                    const match = nameText.includes(searchInput) ||
                        physicianText.includes(searchInput) ||
                        villageText.includes(searchInput) ||
                        diagnosisText.includes(searchInput);

                    row.style.display = match ? '' : 'none';
                    if (match) hasVisibleRows = true;
                });

                // Show/hide no results message
                const noResults = document.querySelector('#CommonDiseasesTable tbody tr td[colspan]');
                if (noResults && noResults.parentElement) {
                    if (!hasVisibleRows && searchInput) {
                        noResults.parentElement.style.display = '';
                    } else if (!searchInput) {
                        noResults.parentElement.style.display = '';
                    } else {
                        noResults.parentElement.style.display = 'none';
                    }
                }
            }

            function clearCommonDiseaseSearch() {
                const searchInput = document.getElementById('common-disease-search');
                searchInput.value = '';
                searchCommonDiseaseTable();
                // Optionally reload the page or submit form to clear server-side filter
                window.location.href = "{{ route('workspace.common-diseases.index') }}";
            }

            // Auto-submit form on Enter key
            const commonDiseaseSearchInput = document.getElementById('common-disease-search');
            if (commonDiseaseSearchInput) {
                commonDiseaseSearchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.closest('form').submit();
                    }
                });
            }
        </script>
</x-app-layout>
