{{-- Patient History Modal --}}
<div id="history-modal-{{ $patient->_id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/60 backdrop-blur-md">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[94vh] flex flex-col border border-gray-100 overflow-hidden">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-7 py-5 bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-100 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ trans('lang.patient history') }}</h3>
                    <p class="text-xl font-bold text-gray-700 m-2">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                </div>
            </div>
            <button data-modal-hide="history-modal-{{ $patient->_id }}"
                class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-400 hover:bg-purple-100 transition"
                aria-label="Close Modal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto py-8 px-7">
            @php
                $history = $patient->getHistory();
            @endphp

            @if(empty($history))
                {{-- No History --}}
                <div class="flex flex-col items-center justify-center py-12">
                    <span class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ trans('lang.no history found') }}</h4>
                    <p class="text-gray-500 text-base">{{ trans('lang.this patient hasn\'t received any vaccines or common disease treatments yet') }}.</p>
                </div>
            @else
                {{-- Stylized Timeline --}}
                <div class="relative pl-6 space-y-10">
                    {{-- Vertical timeline line --}}
                    <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gradient-to-b from-purple-100 via-gray-200 to-pink-100 pointer-events-none"></div>
                    @foreach($history as $entry)
                        <div class="relative flex items-start gap-5 group">
                            <div class="flex-shrink-0 flex flex-col items-center">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center border-4 border-white shadow
                                    {{ $entry['type'] === 'vaccine' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                    @if($entry['type'] === 'vaccine')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    @endif
                                </span>
                                {{-- Timeline dot below icon for not last entry --}}
                                @if(!$loop->last)
                                    <span class="block mt-1 w-1 h-12 rounded bg-gray-200"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-white via-gray-50 to-purple-50 shadow p-5 hover:shadow-lg transition">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-3">
                                        <div class="flex items-center space-x-3">
                                            <h4 class="text-base md:text-lg font-semibold text-gray-900">
                                                {{ $entry['type'] === 'vaccine' ? trans('lang.vaccine administration') : trans('lang.common disease treatment') }}
                                            </h4>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full
                                                {{ $entry['type'] === 'vaccine' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-green-50 text-green-700 border border-green-200' }}">
                                                {{ ucfirst(str_replace('_', ' ', $entry['type'])) }}
                                            </span>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="block text-sm font-medium text-gray-900">{{ $entry['date'] }}</span>
                                            <span class="block text-xs text-gray-400">{{ trans('lang.by') }} {{ $entry['staff_name'] }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                                        @if($entry['type'] === 'vaccine')
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.vaccine category') }}</span>
                                                <div class="text-gray-900 font-semibold">{{ $entry['data']['vaccine_category_id'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.vaccination date') }}</span>
                                                <div class="text-gray-900 font-semibold">{{ $entry['data']['vaccination_date'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.description') }}</span>
                                                <div class="text-gray-900">{{ $entry['data']['description'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.follow-up required') }}</span>
                                                <div>
                                                    @if(isset($entry['data']['comeback']) && $entry['data']['comeback'])
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                            {{ trans('lang.yes') }} ({{ $entry['data']['comeback_count'] ?? 1 }} {{ trans('lang.visits') }})
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                            {{ trans('lang.no') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(isset($entry['data']['father_name']))
                                                <div>
                                                    <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.father\'s name') }}</span>
                                                    <div class="text-gray-900">{{ $entry['data']['father_name'] }}</div>
                                                </div>
                                            @endif
                                            @if(isset($entry['data']['mother_name']))
                                                <div>
                                                    <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.mother\'s name') }}</span>
                                                    <div class="text-gray-900">{{ $entry['data']['mother_name'] }}</div>
                                                </div>
                                            @endif
                                        @else
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.diagnosis') }}</span>
                                                <div class="text-gray-900 font-semibold">{{ $entry['data']['diagnosis'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.treatment date') }}</span>
                                                <div class="text-gray-900 font-semibold">{{ $entry['data']['treatment_date'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.symptoms') }}</span>
                                                <div class="text-gray-900">{{ $entry['data']['symptoms'] ?? 'N/A' }}</div>
                                            </div>
                                            <div>
                                                <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.treatment') }}</span>
                                                <div class="text-gray-900">{{ $entry['data']['treatment'] ?? 'N/A' }}</div>
                                            </div>
                                            @if(isset($entry['data']['medication']) && $entry['data']['medication'])
                                                <div>
                                                    <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.medication') }}</span>
                                                    <div class="text-gray-900">{{ $entry['data']['medication'] }}</div>
                                                </div>
                                            @endif
                                            @if(isset($entry['data']['follow_up_date']) && $entry['data']['follow_up_date'])
                                                <div>
                                                    <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.follow-up date') }}</span>
                                                    <div class="text-gray-900">{{ $entry['data']['follow_up_date'] }}</div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    @if(isset($entry['data']['notes']) && $entry['data']['notes'])
                                        <div class="mt-5 pt-4 border-t border-gray-100">
                                            <span class="block text-xs text-gray-500 font-medium mb-1">{{ trans('lang.notes') }}</span>
                                            <div class="text-gray-900">{{ $entry['data']['notes'] }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Modal Footer --}}
        <div class="bg-gray-100 border-t border-gray-100 px-7 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 font-medium">
                    {{ trans('lang.total entries') }}: {{ count($history) }}
                </div>
                <button data-modal-hide="history-modal-{{ $patient->_id }}"
                    class="px-6 py-2 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-800 transition">
                    {{ trans('lang.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
