<x-app-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Welcome to <span class="text-purple-600">WorkSpace</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Access your specialized healthcare modules and manage patient care with precision and efficiency.
                </p>
                <div class="mt-6 flex items-center justify-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                        <span>Role-based access control</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span>Secure & private</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                        <span>Mobile optimized</span>
                    </div>
                </div>
            </div>
        </div>

        @php $role = auth()->user()->role ?? null; @endphp





        <!-- Module Grid -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your Modules</h2>
                <p class="text-gray-600">Select a module to get started</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Vaccine Module -->
                @php $canAccess = $role === 'Vaccine'; @endphp
                <a href="{{ $canAccess ? route('workspace.vaccine.index') : '#' }}"
                   class="{{ !$canAccess ? 'pointer-events-none opacity-50' : '' }}">
                    <div class="flex flex-col items-center justify-center h-64 rounded-3xl shadow-xl border-4 border-cyan-400 bg-gradient-to-tr from-cyan-400 to-blue-400 transition-transform hover:-translate-y-2">
                        <img src="{{ asset('IMG/vaccine_logo.png') }}"
                             class="w-20 h-20 rounded-full object-cover shadow mb-4 mt-6" alt="Vaccine">
                        <span class="text-2xl font-extrabold text-cyan-900 mb-2">Vaccine</span>
                        <span class="text-cyan-800 text-sm font-medium">Immunization & Records</span>
                    </div>
                </a>

                {{-- Common Diseases --}}
                @php $canAccess = $role === 'Common diseases'; @endphp
                <a href="{{ $canAccess ? route('workspace.common-diseases.index') : '#' }}"
                   class="{{ !$canAccess ? 'pointer-events-none opacity-50' : '' }}">
                    <div class="flex flex-col items-center justify-center h-64 rounded-3xl shadow-xl border-4 border-yellow-400 bg-gradient-to-tr from-yellow-300 to-orange-300 transition-transform hover:-translate-y-2">
                        <img src="{{ asset('IMG/common_disease.png') }}"
                             class="w-20 h-20 rounded-full object-cover shadow mb-4 mt-6" alt="Common Diseases">
                        <span class="text-2xl font-extrabold text-yellow-900 mb-2">Common Diseases</span>
                        <span class="text-yellow-800 text-sm font-medium">Frequent Health Issues</span>
                    </div>
                </a>

                {{-- Gynecology --}}
                @php $canAccess = $role === 'Gynecology'; @endphp
                <a href="{{ $canAccess ? route('workspace.gynecology.index') : '#' }}"
                   class="{{ !$canAccess ? 'pointer-events-none opacity-50' : '' }}">
                    <div class="flex flex-col items-center justify-center h-64 rounded-3xl shadow-xl border-4 border-pink-400 bg-gradient-to-tr from-pink-300 to-fuchsia-300 transition-transform hover:-translate-y-2">
                        <img src="{{ asset('IMG/zei.png') }}"
                             class="w-20 h-20 rounded-full object-cover shadow mb-4 mt-6" alt="Gynecology">
                        <span class="text-2xl font-extrabold text-pink-900 mb-2">Gynecology</span>
                        <span class="text-pink-800 text-sm font-medium">Women's Health</span>
                    </div>
                </a>

                {{-- Medicine --}}
                @php $canAccess = $role === 'Medicine'; @endphp
                <a href="{{ $canAccess ? route('workspace.medicine.index') : '#' }}"
                   class="{{ !$canAccess ? 'pointer-events-none opacity-50' : '' }}">
                    <div class="flex flex-col items-center justify-center h-64 rounded-3xl shadow-xl border-4 border-green-400 bg-gradient-to-tr from-green-300 to-emerald-300 transition-transform hover:-translate-y-2">
                        <img src="{{ asset('IMG/medicine.png') }}"
                             class="w-20 h-20 rounded-full object-cover shadow mb-4 mt-6" alt="Medicine">
                        <span class="text-2xl font-extrabold text-green-900 mb-2">Medicine</span>
                        <span class="text-green-800 text-sm font-medium">Prescriptions & Drugs</span>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
