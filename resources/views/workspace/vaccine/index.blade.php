<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="relative">

                            <!-- Header Section -->
                            <div
                                class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-3 bg-blue-100 rounded-xl">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Vaccine Records</h1>
                                        <p class="text-gray-600 mt-1">Manage and track vaccination records</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('workspace.vaccine.comeback') }}">
                                        <button
                                            class="inline-flex items-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Comeback List
                                        </button>
                                    </a>

                                    <a href="{{ route('workspace.vaccine.vaccineList') }}">
                                        <button
                                            class="inline-flex items-center px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Vaccine
                                        </button>
                                    </a>

                                    <button id="showFormBtn"
                                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white bg-blue-500 font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Record
                                    </button>
                                </div>
                            </div>

                            <!-- Vaccine Records Table -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                <!-- Record Summary -->
                                <div class="px-6 py-3 bg-blue-50 border-b border-blue-100">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-blue-800">
                                                Total Records: {{ $vaccines->total() }}
                                                @if(request('search'))
                                                    <span class="text-blue-600">(Filtered)</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-xs text-blue-600">
                                            Page {{ $vaccines->currentPage() }} of {{ $vaccines->lastPage() }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <h3 class="text-lg font-semibold text-gray-700">Recent Vaccination Records</h3>

                                        <!-- Search Bar -->
                                        <form method="GET" action="{{ route('workspace.vaccine.index') }}" class="w-full sm:w-auto">
                                            <div class="relative flex items-center">
                                                <input type="text"
                                                    name="search"
                                                    value="{{ request('search') }}"
                                                    placeholder="Search by name, father, or mother..."
                                                    class="w-full sm:w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                @if(request('search'))
                                                    <a href="{{ route('workspace.vaccine.index') }}"
                                                       class="ml-2 px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md transition-all duration-200">
                                                        Clear
                                                    </a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Name</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    DOB</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Age</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Father</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Mother</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Vaccine Type</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Dose Count</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Date</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @forelse ($vaccines as $vaccine)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $vaccine->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($vaccine->bod)->format('Y-m-d') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $vaccine->age }} years
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ $vaccine->father_name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ $vaccine->mother_name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $vaccine->vaccineCategory?->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            {{ $vaccine->comeback_count }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($vaccine->currentDate)->format('Y-m-d') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                                        {{ $vaccine->description }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="px-6 py-12 text-center">
                                                        <div class="flex flex-col items-center text-gray-500">
                                                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            @if(request('search'))
                                                                <p class="text-lg font-medium">No search results found</p>
                                                                <p class="text-sm">Try adjusting your search terms or <a href="{{ route('workspace.vaccine.index') }}" class="text-blue-600 hover:underline">clear the search</a></p>
                                                            @else
                                                                <p class="text-lg font-medium">No records found</p>
                                                                <p class="text-sm">Start by adding your first vaccination record</p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if($vaccines->hasPages())
                                <div class="mt-6 bg-white rounded-lg border border-gray-200 p-4">
                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                        <div class="text-sm text-gray-700">
                                            <span class="font-medium">Showing {{ $vaccines->firstItem() ?? 0 }} to {{ $vaccines->lastItem() ?? 0 }}</span>
                                            <span class="text-gray-500">of {{ $vaccines->total() }} results</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            {{ $vaccines->appends(['search' => request('search')])->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Modal Overlay -->
                            <div id="modalOverlay"
                                class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-40 transition-all duration-300">
                            </div>

                            <!-- Vaccine Form Modal -->
                            <div id="vaccineFormContainer"
                                class="fixed inset-0 flex items-center justify-center p-4 hidden z-50 transition-all duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden relative">
                                    <!-- Close button positioned absolutely in top-right corner -->

                                    <div class="flex items-center justify-between p-6 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mr-3">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900">Add New Record</h3>
                                                <p class="text-sm text-gray-500">Enter record information below</p>
                                            </div>
                                        </div>
                                        <button type="button" id="hideFormBtn"
                                            class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-8 h-8 inline-flex justify-center items-center transition-colors"
                                            data-modal-toggle="default-modal">
                                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>


                                    <div class="p-8 overflow-auto max-h-[80vh]">
                                        <form method="POST" action="{{ route('workspace.vaccine.store') }}">
                                            @csrf

                                            <!-- Name -->
                                            <div class="mb-6">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name
                                                    <span class="text-red-500">*</span></label>
                                                <input type="text" name="name"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                    placeholder="Enter full name" required>
                                            </div>

                                            <!-- BOD & Age -->
                                            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date
                                                        of
                                                        Birth <span class="text-red-500">*</span></label>
                                                    <input type="date" name="bod" id="bod"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                        required onchange="calculateAge()">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Age
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="number" name="age" id="age"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                        min="0" placeholder="Age in years" required>
                                                </div>
                                            </div>

                                            <!-- Parent Information -->
                                            <div class="mb-6">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                    Parent Information
                                                </h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <!-- Father Info -->
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-gray-700 mb-2">Father's
                                                                Name <span class="text-red-500">*</span></label>
                                                            <input type="text" name="father_name"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                                placeholder="Enter father's name" required>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-gray-700 mb-2">Father's
                                                                Phone <span class="text-red-500">*</span></label>
                                                            <input type="tel" name="father_phone"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                                placeholder="Enter phone number" required>
                                                        </div>
                                                    </div>

                                                    <!-- Mother Info -->
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-gray-700 mb-2">Mother's
                                                                Name <span class="text-red-500">*</span></label>
                                                            <input type="text" name="mother_name"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                                placeholder="Enter mother's name" required>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-semibold text-gray-700 mb-2">Mother's
                                                                Phone <span class="text-red-500">*</span></label>
                                                            <input type="tel" name="mother_phone"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                                placeholder="Enter phone number" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Carer Info (Optional) -->
                                            <div class="mb-6">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    Carer Information (Optional)
                                                </h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Carer
                                                            Name</label>
                                                        <input type="text" name="carer"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                            placeholder="Enter carer's name">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Carer
                                                            Phone Number</label>
                                                        <input type="tel" name="carer_phone"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                            placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Locations -->
                                            <div class="mb-6">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                    Location Information
                                                </h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Location
                                                            of Birth <span class="text-red-500">*</span></label>
                                                        <input type="text" name="birth_location"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                            placeholder="Enter birth location" required>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Current
                                                            Location <span class="text-red-500">*</span></label>
                                                        <input type="text" name="current_location"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                            placeholder="Enter current location" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Vaccine Information -->
                                            <div class="mb-6">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Vaccine Information
                                                </h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2"
                                                            for="vaccine_category_id">Vaccine Type <span
                                                                class="text-red-500">*</span></label>
                                                        <select name="vaccine_category_id" id="vaccine_category_id"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                            required>
                                                            <option value="">Select vaccine type</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->_id }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="flex items-center space-x-3 pt-8">
                                                        <input type="checkbox" name="comeback" id="comeback"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                        <label for="comeback"
                                                            class="text-sm font-medium text-gray-700">Mark as
                                                            Comeback</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div class="mb-6">
                                                <label
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Description
                                                    <span class="text-red-500">*</span></label>
                                                <textarea name="description"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                    rows="4" placeholder="Enter description or notes about the vaccination" required></textarea>
                                            </div>

                                            <!-- Date (Current) -->
                                            <div class="mb-8">
                                                <label
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Vaccination
                                                    Date <span class="text-red-500">*</span></label>
                                                <input type="date" name="currentDate"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-gray-50"
                                                    value="{{ date('Y-m-d') }}" required>
                                            </div>

                                            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                                <button type="button" id="cancelFormBtn"
                                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg transition-all duration-200">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium transition-colors duration-200 flex items-center">
                                                    <svg class="w-5 h-5 inline mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Submit Record
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    @endif

    <script>

        // Hide success alert after 5 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        // Hide error alert after 5 seconds
        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);



        function calculateAge() {
            const bod = document.getElementById('bod').value;
            if (bod) {
                const birthDate = new Date(bod);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById('age').value = age;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const showFormBtn = document.getElementById('showFormBtn');
            const hideFormBtn = document.getElementById('hideFormBtn');
            const cancelFormBtn = document.getElementById('cancelFormBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const formContainer = document.getElementById('vaccineFormContainer');
            const modalOverlay = document.getElementById('modalOverlay');

            function openModal() {
                formContainer.classList.remove('hidden');
                modalOverlay.classList.remove('hidden');
                showFormBtn.classList.add('hidden');
            }

            function closeModal() {
                formContainer.classList.add('hidden');
                modalOverlay.classList.add('hidden');
                showFormBtn.classList.remove('hidden');
            }

            showFormBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });

            hideFormBtn.addEventListener('click', function() {
                closeModal();
            });

            cancelFormBtn.addEventListener('click', function() {
                closeModal();
            });

            closeModalBtn.addEventListener('click', function() {
                closeModal();
            });

            // Close modal if clicked outside the form (on overlay)
            modalOverlay.addEventListener('click', function() {
                closeModal();
            });

            // Close modal on ESC key press
            document.addEventListener('keydown', function(e) {
                if (e.key === "Escape" || e.key === "Esc") {
                    if (!formContainer.classList.contains('hidden')) {
                        closeModal();
                    }
                }
            });
        });
    </script>

</x-app-layout>
