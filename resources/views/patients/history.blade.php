{{-- Patient History Modal --}}
<div id="history-modal-{{ $patient->_id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden border border-gray-100">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-purple-600">Patient History</h3>
                        <p class="text-purple-400">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                    </div>
                </div>
                <button data-modal-hide="history-modal-{{ $patient->_id }}"
                        class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="p-8 overflow-y-auto max-h-[calc(90vh-120px)]">
            @php
                $history = $patient->getHistory();
            @endphp

            @if(empty($history))
                {{-- No History --}}
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">No History Found</h4>
                    <p class="text-gray-600">This patient hasn't received any vaccines or common disease treatments yet.</p>
                </div>
            @else
                {{-- History Timeline --}}
                <div class="space-y-6">
                    @foreach($history as $entry)
                        <div class="relative">
                            {{-- Timeline Line --}}
                            @if(!$loop->last)
                                <div class="absolute left-6 top-12 w-0.5 h-full bg-gray-200"></div>
                            @endif

                            {{-- Timeline Item --}}
                            <div class="flex items-start space-x-4">
                                {{-- Icon --}}
                                <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center
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
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                        {{-- Header --}}
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $entry['type'] === 'vaccine' ? 'Vaccine Administration' : 'Common Disease Treatment' }}
                                                </h4>
                                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                                    {{ $entry['type'] === 'vaccine' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $entry['type'])) }}
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">{{ $entry['date'] }}</p>
                                                <p class="text-xs text-gray-500">by {{ $entry['staff_name'] }}</p>
                                            </div>
                                        </div>

                                        {{-- Details --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @if($entry['type'] === 'vaccine')
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vaccine Category</label>
                                                    <p class="text-gray-900">{{ $entry['data']['vaccine_category_id'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vaccination Date</label>
                                                    <p class="text-gray-900">{{ $entry['data']['vaccination_date'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                    <p class="text-gray-900">{{ $entry['data']['description'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Follow-up Required</label>
                                                    <p class="text-gray-900">
                                                        @if(isset($entry['data']['comeback']) && $entry['data']['comeback'])
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                Yes ({{ $entry['data']['comeback_count'] ?? 1 }} visits)
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                No
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                                @if(isset($entry['data']['father_name']))
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Father's Name</label>
                                                        <p class="text-gray-900">{{ $entry['data']['father_name'] }}</p>
                                                    </div>
                                                @endif
                                                @if(isset($entry['data']['mother_name']))
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Mother's Name</label>
                                                        <p class="text-gray-900">{{ $entry['data']['mother_name'] }}</p>
                                                    </div>
                                                @endif
                                            @else
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                                                    <p class="text-gray-900">{{ $entry['data']['diagnosis'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Treatment Date</label>
                                                    <p class="text-gray-900">{{ $entry['data']['treatment_date'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Symptoms</label>
                                                    <p class="text-gray-900">{{ $entry['data']['symptoms'] ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Treatment</label>
                                                    <p class="text-gray-900">{{ $entry['data']['treatment'] ?? 'N/A' }}</p>
                                                </div>
                                                @if(isset($entry['data']['medication']) && $entry['data']['medication'])
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Medication</label>
                                                        <p class="text-gray-900">{{ $entry['data']['medication'] }}</p>
                                                    </div>
                                                @endif
                                                @if(isset($entry['data']['follow_up_date']) && $entry['data']['follow_up_date'])
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                                                        <p class="text-gray-900">{{ $entry['data']['follow_up_date'] }}</p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        @if(isset($entry['data']['notes']) && $entry['data']['notes'])
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                                <p class="text-gray-900">{{ $entry['data']['notes'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Modal Footer --}}
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Total entries: {{ count($history) }}
                </div>
                <button data-modal-hide="history-modal-{{ $patient->_id }}"
                        class="px-6 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
