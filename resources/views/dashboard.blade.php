<x-app-layout>
    <!-- Dashboard Content -->
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Samaky Health Center Dashboard</h1>
            <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Patients -->
            <div
                class="bg-white border border-blue-100 p-6 rounded-xl shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $patient }}</p>
                        <p class="text-gray-500">Patients</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>{{ $patient }} Total Patients</span>
                </div>
            </div>


            <!-- Doctors -->
            <div
                class="bg-white border border-green-100 p-6 rounded-xl shadow-sm hover:shadow-md hover:border-green-200 transition-all duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p id="doctor-count" class="text-2xl font-bold text-gray-800">{{ $doctors }}</p>
                        <p class="text-gray-500">Doctors</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-green-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>{{ $doctors }} Total Doctors</span>
                </div>
            </div>

            <!-- Appointments -->
            <div
                class="bg-white border border-purple-100 p-6 rounded-xl shadow-sm hover:shadow-md hover:border-purple-200 transition-all duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $ticket }}</p>
                        <p class="text-gray-500">Appointments</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-purple-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>{{ $ticket }} Total Appointments</span>
                </div>
            </div>

            <!-- Revenue -->
            <div
                class="bg-white border border-amber-100 p-6 rounded-xl shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-full bg-amber-50 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">${{$totalPaySum}}</p>

                        <p class="text-gray-500">Income</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-amber-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>${{$totalPaySum}} Total Income of Hospital</span>
                </div>
            </div>
        </div>

        <!-- Charts and Calendar Section -->
        <div class=" grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Bar Chart -->
            <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Patients Chart</h3>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">Monthly</button>
                        <button
                            class="px-3 py-1 text-sm bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Weekly</button>
                    </div>
                </div>
                <div class="relative w-full h-[400px]">
                    <canvas id="barChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Chart.js & Plugin -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const labels = @json($dates);
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Patients per Day',
                        data: @json($counts),
                        fill: false,
                        borderColor: 'rgb(59, 130, 246)', // Tailwind blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.3)',
                        tension: 0.3,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointRadius: 4
                    }]
                };

                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Visits'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        }
                    }
                };

                new Chart(document.getElementById('barChart'), config);
            </script>




            <!-- Calendar -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Appointments</h3>
                    <button class="p-2 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <button class="p-1 rounded-lg text-gray-500 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <span class="font-semibold text-gray-700">July 2023</span>
                    <button class="p-1 rounded-lg text-gray-500 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-sm mb-2">
                    <div class="text-gray-400 font-medium py-1">Sun</div>
                    <div class="text-gray-400 font-medium py-1">Mon</div>
                    <div class="text-gray-400 font-medium py-1">Tue</div>
                    <div class="text-gray-400 font-medium py-1">Wed</div>
                    <div class="text-gray-400 font-medium py-1">Thu</div>
                    <div class="text-gray-400 font-medium py-1">Fri</div>
                    <div class="text-gray-400 font-medium py-1">Sat</div>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-sm">
                    <div class="py-1 text-gray-400">25</div>
                    <div class="py-1 text-gray-400">26</div>
                    <div class="py-1 text-gray-400">27</div>
                    <div class="py-1 text-gray-400">28</div>
                    <div class="py-1 text-gray-400">29</div>
                    <div class="py-1 text-gray-400">30</div>
                    <div class="py-1 rounded-full bg-blue-50 text-blue-600 font-medium">1</div>
                    <div class="py-1 rounded-full bg-blue-50 text-blue-600 font-medium">2</div>
                    <div class="py-1 rounded-full bg-blue-100 text-blue-700 font-medium">3</div>
                    <div class="py-1 rounded-full bg-blue-100 text-blue-700 font-medium">4</div>
                    <div class="py-1">5</div>
                    <div class="py-1">6</div>
                    <div class="py-1">7</div>
                    <div class="py-1">8</div>
                    <div class="py-1">9</div>
                    <div class="py-1">10</div>
                    <div class="py-1">11</div>
                    <div class="py-1">12</div>
                    <div class="py-1">13</div>
                    <div class="py-1">14</div>
                    <div class="py-1">15</div>
                    <div class="py-1">16</div>
                    <div class="py-1">17</div>
                    <div class="py-1">18</div>
                    <div class="py-1">19</div>
                    <div class="py-1">20</div>
                    <div class="py-1">21</div>
                    <div class="py-1">22</div>
                    <div class="py-1">23</div>
                    <div class="py-1">24</div>
                    <div class="py-1">25</div>
                    <div class="py-1">26</div>
                    <div class="py-1">27</div>
                    <div class="py-1">28</div>
                    <div class="py-1">29</div>
                    <div class="py-1">30</div>
                    <div class="py-1 text-gray-400">31</div>
                    <div class="py-1 text-gray-400">1</div>
                    <div class="py-1 text-gray-400">2</div>
                </div>

                <!-- Upcoming Appointments -->
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Upcoming Appointments</h4>
                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                            <div class="p-2 bg-white rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Dr. Smith - Checkup</p>
                                <p class="text-xs text-gray-500">Today, 10:30 AM</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                            <div class="p-2 bg-white rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Dr. Johnson - Follow-up</p>
                                <p class="text-xs text-gray-500">Tomorrow, 2:15 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Chart.js Script -->
{{-- <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}
