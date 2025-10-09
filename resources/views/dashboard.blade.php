<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Greeting Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Hi {{ auth()->user()->name ?? 'Admin' }}!</h2>
                    <p class="text-gray-500 mb-6">Welcome to Samaky Health Center<br>The weather is nice today, don't you think?</p>
                    <div class="flex items-center text-3xl font-bold text-gray-700 mb-2">
                        25°C <span class="ml-3 text-2xl">☁️</span>
                    </div>
                    <div class="text-gray-400 text-sm">Outdoor temperature<br>Foggy, cloudy weather</div>
                </div>
                <div class="hidden lg:block">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center">
                        <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Devices -->
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">My devices</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">🏥</span>
                            <span class="text-sm font-medium">Patients</span>
                        </div>
                        <span class="text-purple-600 font-semibold text-sm">{{ $patient }}</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">👨‍⚕️</span>
                            <span class="text-sm font-medium">Doctors</span>
                        </div>
                        <span class="text-purple-600 font-semibold text-sm">{{ $doctors }}</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">👥</span>
                            <span class="text-sm font-medium">Patient Assign</span>
                        </div>

                        <span class="text-purple-600 font-semibold text-sm">{{ $ticket }}</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">💰</span>
                            <span class="text-sm font-medium">Revenue</span>
                        </div>
                        <span class="text-purple-600 font-semibold text-sm">${{ $totalPaySum }}</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">💊</span>
                            <span class="text-sm font-medium">Medicine</span>
                        </div>
                        <span class="text-purple-600 font-semibold text-sm">{{ $medicineCount }}</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">💉</span>
                            <span class="text-sm font-medium">Vaccine</span>
                        </div>
                        <span class="text-purple-600 font-semibold text-sm">{{ $vaccineCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Eno's Home -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Health Center Overview</h3>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-purple-50 rounded-xl p-4 flex flex-col items-center">
                        <span class="text-2xl mb-2">🏥</span>
                        <span class="text-sm text-gray-700 text-center">Patient Care</span>
                        <span class="mt-1 text-purple-600 font-semibold text-sm">Active</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 flex flex-col items-center">
                        <span class="text-2xl mb-2">👨‍⚕️</span>
                        <span class="text-sm text-gray-700 text-center">Medical Staff</span>
                        <span class="mt-1 text-purple-600 font-semibold text-sm">Available</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 flex flex-col items-center">
                        <span class="text-2xl mb-2">💊</span>
                        <span class="text-sm text-gray-700 text-center">Pharmacy</span>
                        <span class="mt-1 text-purple-600 font-semibold text-sm">Stocked</span>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 flex flex-col items-center">
                        <span class="text-2xl mb-2">💉</span>
                        <span class="text-sm text-gray-700 text-center">Vaccination</span>
                        <span class="mt-1 text-purple-600 font-semibold text-sm">Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Team Members</h3>
                <div class="flex -space-x-2 mb-4">
                    @php
                        $colors = ['purple', 'green', 'blue', 'yellow', 'red', 'indigo', 'pink', 'teal'];
                        // Try different approaches to get team members
                        $doctorsList = \App\Models\User::where('role', 'Doctor')->take(4)->get();

                        // If no doctors found, try getting all users
                        if ($doctorsList->count() == 0) {
                            $doctorsList = \App\Models\User::take(4)->get();
                        }

                        // If still no users, create a fallback
                        if ($doctorsList->count() == 0) {
                            $doctorsList = collect([
                                (object)['name' => 'Admin User', 'role' => 'Admin'],
                                (object)['name' => 'Test Doctor', 'role' => 'Doctor'],
                                (object)['name' => 'Nurse Staff', 'role' => 'Nurse'],
                                (object)['name' => 'Support Team', 'role' => 'Support']
                            ]);
                        }
                    @endphp

                    @forelse($doctorsList as $index => $doctor)
                        <div class="w-10 h-10 bg-{{ $colors[$index % count($colors)] }}-100 rounded-full border-2 border-white flex items-center justify-center">
                            <span class="text-{{ $colors[$index % count($colors)] }}-600 font-semibold text-sm">
                                {{ substr($doctor->name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                    @empty
                        <div class="w-10 h-10 bg-gray-100 rounded-full border-2 border-white flex items-center justify-center">
                            <span class="text-gray-600 font-semibold text-sm">N</span>
                        </div>
                    @endforelse
                </div>
                <div class="text-sm text-gray-600">
                    @if($doctorsList->count() > 0)
                        <div class="mb-1">
                            @foreach($doctorsList->take(3) as $doctor)
                                {{ $doctor->name ?? 'Unknown User' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                            @if($doctorsList->count() > 3)
                                and {{ $doctorsList->count() - 3 }} more
                            @endif
                        </div>
                        <div class="text-purple-600 font-medium">{{ $doctorsList->count() }} team members</div>
                        @if($doctorsList->count() > 0 && isset($doctorsList->first()->role))
                            <div class="text-xs text-gray-400 mt-1">Roles: {{ $doctorsList->pluck('role')->unique()->implode(', ') }}</div>
                        @endif
                    @else
                        <div class="mb-1">No team members found</div>
                        <div class="text-purple-600 font-medium">0 team members</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Living Room Temperature -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-2 mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-700 text-lg">Patient Statistics</span>
                </div>
                <div class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-medium">
                    Active
                </div>
            </div>
            <div class="flex flex-col items-center">
                <div class="relative mb-6">
                    <div class="w-48 h-48 rounded-full bg-gradient-to-tr from-purple-200 via-purple-300 to-purple-400 flex items-center justify-center shadow-lg">
                        <div class="text-center">
                            <span class="text-5xl font-bold text-purple-700">{{ $patient }}</span>
                            <div class="text-purple-600 font-medium">Total Patients</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between w-full max-w-xs">
                    <button class="bg-purple-100 text-purple-700 rounded-xl px-6 py-3 hover:bg-purple-200 transition-colors">
                        <span class="text-2xl">-</span>
                    </button>
                    <button class="bg-purple-100 text-purple-700 rounded-xl px-6 py-3 hover:bg-purple-200 transition-colors">
                        <span class="text-2xl">+</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Power Consumed -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Monthly Revenue</h3>
                <div class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs font-medium">
                    2025
                </div>
            </div>
            <div class="w-full h-48 mb-4">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">${{ $totalPaySum }}</div>
                <div class="text-sm text-gray-500">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: [{{ $totalPaySum }}, {{ $totalPaySum * 1.2 }}, {{ $totalPaySum * 0.9 }}, {{ $totalPaySum * 1.5 }}, {{ $totalPaySum * 1.3 }}, {{ $totalPaySum * 1.8 }}, {{ $totalPaySum * 1.6 }}, {{ $totalPaySum * 2.0 }}, {{ $totalPaySum * 1.7 }}, {{ $totalPaySum * 2.2 }}, {{ $totalPaySum * 1.9 }}, {{ $totalPaySum * 2.4 }}],
                        fill: true,
                        borderColor: 'rgb(147, 51, 234)',
                        backgroundColor: 'rgba(147, 51, 234, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(147, 51, 234)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: false
                        },
                        x: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 6
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
