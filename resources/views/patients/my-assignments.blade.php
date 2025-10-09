<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-lg">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">My Patient Assigns</h1>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('patients.index') }}"
                            class="group px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200">
                            <span class="flex items-center space-x-2">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Back to Patients
                            </a>
                        </div>
                    </div>

                    <!-- Status Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-800">{{ $statusCounts['total'] }}</div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $statusCounts['pending'] }}</div>
                            <div class="text-sm text-yellow-600">Pending</div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $statusCounts['in_progress'] }}</div>
                            <div class="text-sm text-blue-600">In Progress</div>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $statusCounts['completed'] }}</div>
                            <div class="text-sm text-green-600">Completed</div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $statusCounts['cancelled'] }}</div>
                            <div class="text-sm text-red-600">Cancelled</div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($validAssignments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50 text-center">
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nº
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Service
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Assigned Date
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Payment Type
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-center">
                                    @foreach ($validAssignments as $index => $assignment)
                                        <tr class="hover:bg-gray-50">
                                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono text-center">
                                            {{ ($validAssignments->total() ?? $validAssignments->count()) - ($loop->iteration - 1 + ($validAssignments->firstItem() - 1)) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($assignment->patient)
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $assignment->patient->first_name }}
                                                        {{ $assignment->patient->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $assignment->patient->phone }}
                                                    </div>
                                                @else
                                                    <div class="text-sm text-red-600 font-medium">
                                                        Patient Not Found
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        ID: {{ $assignment->patient_id }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($assignment->assigned_to) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ $assignment->assigned_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ ucfirst($assignment->payment_type) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @switch($assignment->status)
                                                    @case('pending')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @break

                                                    @case('in_progress')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            In Progress
                                                        </span>
                                                    @break

                                                    @case('completed')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Completed
                                                        </span>
                                                    @break

                                                    @case('cancelled')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Cancelled
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ ucfirst($assignment->status ?? 'Unknown') }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="flex justify-center space-x-2">
                                                    @if ($assignment->status === 'pending')
                                                        <form action="{{ route('assignments.read', $assignment->_id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                                                Start Processing
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($assignment->status === 'in_progress')
                                                        <form action="{{ route('assignments.processed', $assignment->_id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                                                Mark as Completed
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($assignment->status === 'completed')
                                                        <span class="text-green-600 text-xs">✓ Completed</span>
                                                        @if ($assignment->processed_at)
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                {{ \Carbon\Carbon::parse($assignment->processed_at)->format('M d, Y H:i') }}
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if ($assignment->status === 'cancelled')
                                                        <span class="text-red-600 text-xs">✗ Cancelled</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8">
                            {{ $validAssignments->links() }}
                        </div>

                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 text-lg mb-4">No patient assignments found.</div>
                            <p class="text-gray-400">You haven't been assigned any patients yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Debug: Log assignments data when page loads
        console.log('Assignments data:', @json($validAssignments));
    </script>
</x-app-layout>
