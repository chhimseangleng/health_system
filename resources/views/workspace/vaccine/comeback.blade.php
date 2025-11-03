<x-app-layout>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="vaccineModal()">

                        <!-- Header Section -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-6">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-amber-500 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-4xl font-bold text-gray-800 tracking-tight">
                                        {{ trans('lang.vaccine comeback records') }}</h1>
                                    <p class="text-gray-600 mt-2 text-lg">
                                        {{ trans('lang.track and manage vaccine comeback schedules') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('workspace.vaccine.index') }}">
                                    <button
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:bg-blue-600 hover:to-indigo-800 bg-blue-500 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        {{ trans('lang.back') }}
                                    </button>
                                </a>
                            </div>
                        </div>

                        <!-- Search Section -->
                        <div
                            class="mb-8 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                            <form method="GET" action="{{ route('workspace.vaccine.comeback') }}"
                                class="flex flex-col sm:flex-row items-center gap-4">
                                <div class="flex-1 w-full sm:w-auto">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="{{ trans('lang.search by patient name...') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white hover:bg-gray-50">
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r bg-blue-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        {{ trans('lang.search') }}
                                    </button>
                                    <a href="{{ route('workspace.vaccine.comeback') }}"
                                        class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        {{ trans('lang.clear') }}
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Vaccine Records Table -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-lg">
                            <div
                                class="px-8 py-6 bg-gradient-to-r from-amber-50 to-orange-100 border-b border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    {{ trans('lang.comeback records') }}
                                </h3>
                            </div>

                            <div class="p-0 md:p-2">
                                <div class="overflow-x-auto">
                                    <table id="vaccineTable"
                                        class="min-w-full  bg-white text-base divide-y divide-orange-300 shadow-sm text-center">
                                        <thead class="font-semibold text-4sm tracking-wider uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.nº') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.name') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.dob') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.age') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.father') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.mother') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.vaccine type') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.dose count') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.date') }}</th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.description') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">{{ trans('lang.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($vaccinesComeback as $vaccine)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                                        {{ $vaccinesComeback->total() - ($vaccinesComeback->firstItem() - 1 + $loop->index) }}
                                                    </td>

                                                    <td
                                                        class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $vaccine->name }}</td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($vaccine->bod)->format('Y-m-d') }}
                                                    </td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $vaccine->age }} years
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ $vaccine->father_name }}</td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ $vaccine->mother_name }}</td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $vaccine->vaccineCategory?->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            {{ $vaccine->comeback_count }}
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($vaccine->currentDate)->format('Y-m-d') }}
                                                    </td>
                                                    <td class="px-8 py-4 text-sm text-gray-600 max-w-xs truncate">
                                                        {{ $vaccine->description }}</td>
                                                    <td class="px-8 py-4 flex items-center space-x-2">
                                                        <!-- Add Dose Button -->
                                                        <button @click="openAddDoseModal(@js($vaccine))"
                                                            class="inline-flex items-center p-2.5 text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 rounded-xl transition-all duration-200 group"
                                                            title="{{ trans('lang.add dose') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                                                                </path>
                                                            </svg>
                                                        </button>

                                                        <!-- View Details Button -->
                                                        <button @click="openModal(@js($vaccine))"
                                                            class="inline-flex items-center p-2.5 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-200 group"
                                                            title="{{ trans('lang.details') }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="px-8 py-16 text-center">
                                                        <div class="flex flex-col items-center text-gray-500">
                                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            <p class="text-xl font-medium text-gray-600">
                                                                {{ trans('lang.no comeback records found') }}</p>
                                                            <p class="text-gray-500 mt-2">
                                                                {{ trans('lang.no patients are currently scheduled for vaccine comebacks') }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- Details Modal -->
                            <div x-show="isModalOpen" x-transition.opacity.duration.300ms
                                class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
                                style="display: none;" aria-labelledby="modal-title" role="dialog"
                                aria-modal="true">
                                <div x-transition.scale.duration.300ms @click.away="closeModal()"
                                    class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full mx-4 sm:mx-0 border border-gray-100">

                                    <!-- New Header -->
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 p-6 bg-gradient-to-r bg-blue-600 to-blue-500 rounded-t-3xl">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center">
                                                <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 2a10 10 0 00-3.16 19.45c.5.09.68-.22.68-.48 0-.24-.01-.87-.01-1.7-2.78.61-3.37-1.33-3.37-1.33-.45-1.15-1.11-1.46-1.11-1.46-.91-.62.07-.61.07-.61 1.01.07 1.54 1.04 1.54 1.04.9 1.54 2.36 1.1 2.94.84.09-.65.35-1.1.64-1.35-2.22-.25-4.55-1.11-4.55-4.94 0-1.09.39-1.98 1.03-2.68-.1-.26-.45-1.28.1-2.66 0 0 .84-.27 2.75 1.02A9.57 9.57 0 0112 6.8c.85 0 1.71.11 2.51.32 1.91-1.29 2.75-1.02 2.75-1.02.55 1.38.21 2.4.1 2.66.64.7 1.03 1.59 1.03 2.68 0 3.84-2.34 4.68-4.57 4.93.36.31.68.92.68 1.85 0 1.33-.01 2.4-.01 2.72 0 .27.18.58.69.48A10.01 10.01 0 0012 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-white mb-0" id="modal-title">
                                                    {{ trans('lang.vaccine comeback details') }}
                                                </h3>
                                            </div>
                                        </div>
                                        <button @click="closeModal()" type="button"
                                            class="text-white hover:bg-white/10 rounded-xl text-base w-10 h-10 flex justify-center items-center transition-colors"
                                            data-modal-toggle="default-modal">
                                            <svg class="w-5 h-5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <!-- New Body -->
                                    <div class="px-8 py-8 max-h-[72vh] overflow-y-auto bg-slate-50 rounded-b-3xl">

                                        <!-- Patient & Vaccine - Card Layout -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                                            <!-- Patient Card -->
                                            <div
                                                class="bg-white rounded-2xl shadow p-6 border border-gray-100 flex flex-col gap-4">
                                                <div class="flex items-center mb-1">
                                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5h10c0-2.761-2.239-5-5-5z" />
                                                    </svg>
                                                    <h4 class="font-bold text-xl text-gray-700">
                                                        {{ trans('lang.patient') }}</h4>
                                                </div>
                                                <div class="space-y-2 text-sm mb-2">
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.name') }}:</span>
                                                        <span class="font-semibold text-gray-900"
                                                            x-text="modalData.name"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.dob') }}:</span>
                                                        <span class="font-semibold text-gray-900"
                                                            x-text="formatDate(modalData.bod)"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.age') }}:</span>
                                                        <span
                                                            class="inline-block ml-1 px-2 py-0.5 bg-blue-100 rounded-full font-bold text-blue-700 text-xs"
                                                            x-text="modalData.age + ' years'"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.father name') }}:</span>
                                                        <span class="font-semibold text-gray-900"
                                                            x-text="modalData.father_name"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.mother name') }}:</span>
                                                        <span class="font-semibold text-gray-900"
                                                            x-text="modalData.mother_name"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Vaccine Card -->
                                            <div
                                                class="bg-white rounded-2xl shadow p-6 border border-gray-100 flex flex-col gap-4">
                                                <div class="flex items-center mb-1">
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <h4 class="font-bold text-xl text-gray-700">
                                                        {{ trans('lang.vaccine') }}</h4>
                                                </div>
                                                <div class="space-y-2 text-sm mb-2">
                                                    <div>
                                                        <span class="text-gray-500 font-medium">
                                                            {{ trans('lang.vaccine type') }}:</span>
                                                        <span
                                                            class="inline-flex items-center ml-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                            {{ $vaccine->vaccineCategory?->name ?? 'N/A' }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.dose count') }}:</span>
                                                        <span
                                                            class="inline-flex items-center ml-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800"
                                                            x-text="modalData.comeback_count ?? 'N/A'"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.date') }}:</span>
                                                        <span class="font-semibold text-gray-900 ml-1"
                                                            x-text="formatDate(modalData.currentDate)"></span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-gray-500 font-medium">{{ trans('lang.description') }}:</span>
                                                        <span
                                                            class="block font-normal rounded-md mt-1 bg-gray-100 text-gray-800 border border-gray-200 px-2 py-3"
                                                            x-text="modalData.description"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Comeback Schedule Timeline -->
                                        <template
                                            x-if="modalData.first_come || modalData.second_come || modalData.third_come || modalData.fourt_come || modalData.fifth_come">

                                            <!-- Dose Dates Section -->
                                            <div class="mt-6">
                                                <div class="flex items-center mb-3">
                                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <h4 class="font-bold text-md text-blue-800">
                                                        {{ trans('lang.dose dates') }}</h4>
                                                </div>

                                                <!-- Timeline Style List -->
                                                <ol class="relative border-l-2 border-blue-200 ml-3"
                                                    x-show="modalData.dose_dates && modalData.dose_dates.length > 0">
                                                    <template x-for="(doseDate, index) in modalData.dose_dates"
                                                        :key="index">
                                                        <li class="mb-6 ml-6 relative">
                                                            <!-- Number Circle -->
                                                            <span
                                                                class="absolute -left-3 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full border border-blue-300 text-blue-600 font-bold shadow">
                                                                <span x-text="index + 1"></span>
                                                            </span>

                                                            <!-- Date Display -->
                                                            <span
                                                                class="block mt-1 px-4 py-1 rounded-lg text-sm font-semibold bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 shadow-sm"
                                                                x-text="formatDate(doseDate)">
                                                            </span>
                                                        </li>
                                                    </template>
                                                </ol>

                                                <!-- Empty State -->
                                                <div class="text-gray-400 text-sm mt-2"
                                                    x-show="!modalData.dose_dates || modalData.dose_dates.length === 0">
                                                    {{ trans('lang.no dose dates recorded') }}
                                                </div>
                                            </div>

                                        </template>
                                    </div>

                                    <!-- Footer -->
                                    <div
                                        class="flex justify-end px-8 py-6 border-t border-gray-200 bg-white rounded-b-3xl">
                                        <button @click="closeModal()" type="button"
                                            class="inline-flex items-center rounded-lg border border-blue-600 bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ trans('lang.close') }}
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <!-- Add Dose Modal -->
                            <div x-show="isAddDoseModalOpen" x-transition.opacity.duration.300ms
                                class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50"
                                style="display: none;" aria-labelledby="add-dose-modal-title" role="dialog"
                                aria-modal="true">
                                <div x-transition.scale.duration.300ms @click.away="closeAddDoseModal()"
                                    class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 sm:mx-0 border border-gray-200">
                                    <!-- Header -->

                                    <div class="flex items-center justify-between p-6 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <div
                                                class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mr-3 text-white">
                                                <div class="flex justify-between items-center">
                                                    <div class="flex items-center space-x-3">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    {{ trans('lang.add dose') }}
                                                </h3>
                                                <p class="text-sm text-gray-500">{{ trans('lang.patient') }}: <span
                                                        x-text="addDoseData.name" class="font-semibold"></span></p>
                                            </div>
                                        </div>
                                        <button @click="closeAddDoseModal()"
                                            class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-8 h-8 inline-flex justify-center items-center transition-colors"
                                            data-modal-toggle="default-modal">
                                            <svg class="w-4 h-4" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('workspace.vaccine.addDose') }}"
                                        class="p-8 space-y-8">
                                        @csrf
                                        <input type="hidden" name="id" :value="addDoseData.id" />

                                        <!-- Patient Information Section -->
                                        <div
                                            class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ trans('lang.patient details') }}
                                            </h4>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                <div class="bg-white rounded-xl p-4 border border-gray-200">
                                                    <label
                                                        class="block text-gray-600 text-sm font-medium mb-2">{{ trans('lang.name') }}</label>
                                                    <p class="text-gray-900 text-lg font-semibold"
                                                        x-text="addDoseData.name"></p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-gray-200">
                                                    <label
                                                        class="block text-gray-600 text-sm font-medium mb-2">{{ trans('lang.age') }}</label>
                                                    <p class="text-gray-900 text-lg font-semibold"
                                                        x-text="addDoseData.age + ' years'"></p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-gray-200">
                                                    <label
                                                        class="block text-gray-600 text-sm font-medium mb-2">{{ trans('lang.vaccine type') }}</label>
                                                    <p class="text-gray-900 text-lg font-semibold"
                                                        x-text="addDoseData.comeback_count ?? 'N/A'"></p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-gray-200">
                                                    <label
                                                        class="block text-gray-600 text-sm font-medium mb-2">{{ trans('lang.current dose count') }}</label>
                                                    <p class="text-gray-900 text-lg font-semibold"
                                                        x-text="addDoseData.comeback_count ?? 'N/A'"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Comeback Selection Section -->
                                        <div
                                            class="bg-gradient-to-r from-amber-50 to-orange-100 rounded-2xl p-6 border border-amber-200">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-amber-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ trans('lang.schedule follow-up') }}
                                            </h4>
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-gray-800 font-semibold text-lg">
                                                        {{ trans('lang.mark for comeback') }}</p>
                                                    <p class="text-gray-600 text-sm mt-1">
                                                        {{ trans('lang.schedule this patient for a follow-up vaccine dose') }}
                                                    </p>
                                                </div>
                                                <div class="relative">
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" name="comeback"
                                                            class="sr-only peer" />
                                                        <div
                                                            class="relative w-14 h-7 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                                        peer-checked:after:translate-x-[27px] peer-checked:after:border-white
                                                        after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white
                                                        after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all
                                                        peer-checked:bg-gradient-to-r peer-checked:from-orange-500 peer-checked:to-red-600">
                                                        </div>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Action Buttons -->
                                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                            <button type="button" @click="closeAddDoseModal()"
                                                class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                                {{ trans('lang.cancel') }}
                                            </button>
                                            <button type="submit"
                                                class="px-8 py-3 bg-gradient-to-r bg-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                {{ trans('lang.add dose') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            {{ $vaccinesComeback->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function vaccineModal() {
            return {
                isModalOpen: false,
                modalData: null,

                isAddDoseModalOpen: false,
                addDoseData: {},

                openModal(data) {
                    this.modalData = data;
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.modalData = null;
                },

                openAddDoseModal(data) {
                    this.addDoseData = data;
                    this.isAddDoseModalOpen = true;
                },

                closeAddDoseModal() {
                    this.isAddDoseModalOpen = false;
                    this.addDoseData = {};
                },

                formatDate(dateStr) {
                    if (!dateStr) return '';
                    let date = new Date(dateStr);
                    return date.toISOString().split('T')[0];
                }
            }
        }
    </script>
</x-app-layout>
