<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-3xl bg-white p-8 rounded-2xl shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Common Disease Record</h2>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm">Print</button>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-gray-500">Name</div>
                    <div class="font-semibold text-gray-900">{{ $record->name }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Updated</div>
                    <div class="font-semibold text-gray-900">{{ optional($record->updated_at)->format('Y-m-d H:i') }}</div>
                </div>
                {{-- <div>
                    <div class="text-gray-500">Category</div>
                    <div class="font-semibold text-gray-900">{{ $record->category }}</div>
                </div> --}}
                <div>
                    <div class="text-gray-500">Physician</div>
                    <div class="font-semibold text-gray-900">{{ $record->physician }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Age</div>
                    <div class="font-semibold text-gray-900">{{ $record->age }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Gender</div>
                    <div class="font-semibold text-gray-900">{{ $record->gender }}</div>
                </div>
                <div>
                    <div class="text-gray-500">Village</div>
                    <div class="font-semibold text-gray-900">{{ $record->village }}</div>
                </div>
                {{-- <div>
                    <div class="text-gray-500">Commune</div>
                    <div class="font-semibold text-gray-900">{{ $record->commune }}</div>
                </div> --}}
            </div>

            <div class="mt-6">
                <div class="text-gray-500 text-sm">Drug Diagnosis</div>
                <div class="text-gray-900">{{ $record->drug_diagnosis }}</div>
            </div>

            @php $prescriptions = $record->prescriptions ?? []; @endphp
            @if(!empty($prescriptions) && is_array($prescriptions))
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Prescriptions</h3>
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Medicine</th>
                                    <th class="px-4 py-3">Total Day</th>
                                    <th class="px-4 py-3">Total Medicine</th>
                                    <th class="px-4 py-3">Morning (M)</th>
                                    <th class="px-4 py-3">Afternoon (A)</th>
                                    <th class="px-4 py-3">Evening (E)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescriptions as $p)
                                    @php
                                        $mid = (string)($p['medicine_id'] ?? '');
                                        $mname = $medicineMap[$mid] ?? $mid;
                                        $times = $p['times'] ?? [];
                                    @endphp
                                    <tr class="border-t border-gray-200">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $mname }}</td>
                                        <td class="px-4 py-3">{{ $p['total_day'] ?? '' }}</td>
                                        <td class="px-4 py-3">{{ $p['total_medicine'] ?? '' }}</td>
                                        <td class="px-4 py-3">{{ $times['M']['qty'] ?? '' }}</td>
                                        <td class="px-4 py-3">{{ $times['A']['qty'] ?? '' }}</td>
                                        <td class="px-4 py-3">{{ $times['E']['qty'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @media print {
            button { display: none; }
            .shadow { box-shadow: none !important; }
        }
    </style>
</x-app-layout>


