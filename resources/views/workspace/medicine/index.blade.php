<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Medicine Management</h1>
                                <p class="text-gray-600 mt-1">Manage your clinic's medicine inventory</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('workspace.medicine.dashboard') }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    Dashboard
                                </a>

                                <a href="{{ route('workspace.medicine.create') }}"
                                   class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                                    Add Medicine
                                </a>
                            </div>
                        </div>

                        {{-- Search and Filters --}}
                        <div class="mb-6">
                            <form method="GET" action="{{ route('workspace.medicine.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" id="search" value="{{ $search }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Search medicines...">
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" id="category"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                                    <select name="stock_status" id="stock_status"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Status</option>
                                        <option value="low_stock" {{ $stockStatus == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                        <option value="out_of_stock" {{ $stockStatus == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="expiring_soon" {{ $stockStatus == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                                    </select>
                                </div>

                                <div class="flex items-end">
                                    <button type="submit"
                                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        Filter
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Medicines Table --}}
                        <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="text-xs tracking-wider uppercase bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left">Medicine</th>
                                        <th scope="col" class="px-6 py-3 text-left">Category</th>
                                        <th scope="col" class="px-6 py-3 text-left">Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left">Expiry</th>
                                        <th scope="col" class="px-6 py-3 text-left">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($medicines as $medicine)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="px-6 py-4">
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $medicine->name }}</div>
                                                    @if($medicine->generic_name)
                                                        <div class="text-sm text-gray-500">{{ $medicine->generic_name }}</div>
                                                    @endif
                                                    <div class="text-xs text-gray-400">{{ $medicine->strength }} {{ $medicine->unit }} {{ $medicine->form }}</div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $medicine->category }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="text-sm">
                                                    <span class="font-medium">{{ $medicine->stock_quantity }}</span>
                                                    @if($medicine->minimum_stock)
                                                        <span class="text-gray-500">/ {{ $medicine->minimum_stock }}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <span class="font-medium text-gray-900">{{ $medicine->formatted_price }}</span>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="text-sm">
                                                    <div>{{ \Carbon\Carbon::parse($medicine->expiry_date)->format('M d, Y') }}</div>
                                                    @if($medicine->days_until_expiry < 30)
                                                        <div class="text-red-600 text-xs">
                                                            {{ $medicine->days_until_expiry }} days left
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                @php
                                                    $statusColors = [
                                                        'out_of_stock' => 'bg-red-100 text-red-800',
                                                        'low_stock' => 'bg-yellow-100 text-yellow-800',
                                                        'in_stock' => 'bg-green-100 text-green-800'
                                                    ];
                                                    $color = $statusColors[$medicine->stock_status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $medicine->stock_status)) }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center items-center space-x-2">
                                                    <a href="{{ route('workspace.medicine.show', $medicine->_id) }}"
                                                       class="text-blue-600 hover:text-blue-800 transition"
                                                       title="View Details">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>

                                                    <a href="{{ route('workspace.medicine.edit', $medicine->_id) }}"
                                                       class="text-green-600 hover:text-green-800 transition"
                                                       title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>

                                                    <button onclick="deleteMedicine('{{ $medicine->_id }}', '{{ $medicine->name }}')"
                                                            class="text-red-600 hover:text-red-800 transition"
                                                            title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                    <p class="text-lg font-medium">No medicines found</p>
                                                    <p class="text-sm text-gray-400">Start by adding your first medicine</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($medicines->hasPages())
                            <div class="mt-6">
                                {{ $medicines->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete <span id="medicineName" class="font-semibold"></span>?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
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
        function deleteMedicine(id, name) {
            document.getElementById('medicineName').textContent = name;
            document.getElementById('deleteForm').action = `/workspace/medicine/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Hide alerts after 5 seconds
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);

        setTimeout(function() {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);
    </script>
</x-app-layout>
