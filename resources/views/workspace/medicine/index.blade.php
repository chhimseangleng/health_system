<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                            <div>
                                <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight">Medicine Management</h1>
                                <p class="text-gray-500 mt-2 text-lg">Manage your clinic's medicine inventory</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('workspace.medicine.create') }}"
                                    class="inline-flex items-center px-5 py-2.5 text-white rounded-xl text-base font-semibold shadow bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Medicine
                                </a>
                                <button type="button" onclick="openBulkDispenseModal()"
                                    class="inline-flex items-center px-5 py-2.5  text-white rounded-xl text-base font-semibold shadow bg-orange-500  focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2a4 4 0 014-4h4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01" />
                                    </svg>
                                    Dispense
                                </button>
                            </div>
                        </div>

                        {{-- Search and Filters --}}
                        <div class="mb-8">
                            <form method="GET" action="{{ route('workspace.medicine.index') }}"
                                class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label for="search"
                                        class="block text-base font-semibold text-gray-700 mb-2">Search</label>
                                    <input type="text" name="search" id="search" value="{{ $search }}"
                                        class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 text-gray-800 bg-blue-50 placeholder-gray-400"
                                        placeholder="Search medicines...">
                                </div>
                                <div>
                                    <label for="stock_status"
                                        class="block text-base font-semibold text-gray-700 mb-2">Stock
                                        Status</label>
                                    <select name="stock_status" id="stock_status"
                                        class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 text-gray-800 bg-blue-50">
                                        <option value="">All Status</option>
                                        <option value="low_stock" {{ $stockStatus == 'low_stock' ? 'selected' : '' }}>
                                            Low Stock</option>
                                        <option value="out_of_stock"
                                            {{ $stockStatus == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="expiring_soon"
                                            {{ $stockStatus == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon
                                        </option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full px-4 py-2.5 bg-blue-500 text-white rounded-xl font-semibold shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                                        Filter
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Medicines Table --}}
                        <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow">
                            <table class="min-w-full divide-y divide-gray-200 text-base">
                                <thead
                                    class="text-xs tracking-wider uppercase bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left font-bold"> Nº</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Medicine</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Category</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Stock</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Price</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Expiry</th>
                                        <th scope="col" class="px-6 py-4 text-left font-bold">Status</th>
                                        <th scope="col" class="px-6 py-4 text-center font-bold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse ($medicines as $i => $medicine)
                                        {{-- @dd($medicine) --}}
                                        {{-- @dd($medicine) --}}
                                        <tr class="hover:bg-blue-50 transition duration-150">
                                            <td class="px-6 py-5">
                                                <span class="font-semibold text-blue-800">
                                                    {{ $medicines->total() - (($medicines->currentPage() - 1) * $medicines->perPage() + $i) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div>
                                                    <div class="font-semibold text-blue-900 text-lg">
                                                        {{ $medicine->name }}</div>
                                                    @if ($medicine->generic_name)
                                                        <div class="text-sm text-gray-500 italic">
                                                            {{ $medicine->generic_name }}</div>
                                                    @endif
                                                    <div class="text-xs text-gray-400">{{ $medicine->strength }}
                                                        {{ $medicine->unit }} {{ $medicine->form }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-200 text-blue-900 shadow">
                                                    {{ $medicine->category }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="text-base">
                                                    <span
                                                        class="font-bold text-blue-800">{{ $medicine->stock_quantity }}</span>
                                                    @if ($medicine->minimum_stock)
                                                        <span class="text-gray-400">/
                                                            {{ $medicine->minimum_stock }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span
                                                    class="font-semibold text-green-700">{{ $medicine->formatted_price }}</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="text-base">
                                                    <div>
                                                        {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('M d, Y') }}
                                                    </div>
                                                    @if ($medicine->days_until_expiry < 30)
                                                        <div class="text-red-600 text-xs font-semibold">
                                                            {{ $medicine->days_until_expiry }} days left
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                @php
                                                    $statusColors = [
                                                        'out_of_stock' => 'bg-red-200 text-red-800',
                                                        'low_stock' => 'bg-yellow-200 text-yellow-900',
                                                        'in_stock' => 'bg-green-200 text-green-900',
                                                    ];
                                                    $color =
                                                        $statusColors[$medicine->stock_status] ??
                                                        'bg-gray-200 text-gray-800';
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow {{ $color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $medicine->stock_status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-center">
                                                <div class="flex justify-center items-center gap-2">
                                                    <button type="button"
                                                        onclick='showMedicineDetails(@json($medicine))'
                                                        class="p-2 rounded-full bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900 transition"
                                                        title="View Details">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                                c4.478 0 8.268 2.943 9.542 7
                                                                -1.274 4.057-5.064 7-9.542 7
                                                                -4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>

                                                    <button type="button"
                                                        onclick='showEditMedicineModal(@json($medicine))'
                                                        class="p-2 rounded-full  bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition"
                                                        title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>

                                                    <button
                                                        onclick="deleteMedicine('{{ $medicine->_id }}', '{{ $medicine->name }}')"
                                                        class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition"
                                                        title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-14 h-14 text-blue-100 mb-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                    <p class="text-xl font-semibold">No medicines found</p>
                                                    <p class="text-base text-gray-300">Start by adding your first
                                                        medicine</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($medicines->hasPages())
                        <div class="mt-6">
                            {{ $medicines->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Medicine Detail Modal --}}
    <div id="medicineDetailModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div
            class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-8 relative border border-gray-200 overflow-y-auto max-h-[90vh]">

            <!-- Close Button -->
            <button onclick="closeMedicineModal()"
                class="absolute top-5 right-5 text-gray-500 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Title -->
            <div class="mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h8l6 6v8a2 2 0 01-2 2z" />
                </svg>
                <h2 class="text-3xl font-bold text-green-700">Medicine Details</h2>
            </div>

            <!-- Sections -->
            <div id="medicineDetailContent" class="space-y-6 text-gray-700 text-lg">
                <!-- Dynamic content goes here -->
            </div>

            <!-- Optional Footer -->
            <div class="mt-6 text-right">
                <button onclick="closeMedicineModal()"
                    class="px-6 py-2 bg-green-700 text-white rounded-xl font-semibold hover:bg-green-800 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function showMedicineDetails(medicine) {
            const modal = document.getElementById('medicineDetailModal');
            const content = document.getElementById('medicineDetailContent');

            const sections = [{
                    title: "Basic Info",
                    fields: [
                        ['Name', medicine.name],
                        ['Generic Name', medicine.generic_name ?? '-'],
                        ['Category', medicine.category],
                        ['Manufacturer', medicine.manufacturer ?? '-'],
                        ['Strength', `${medicine.strength ?? '-'} ${medicine.unit ?? ''} ${medicine.form ?? ''}`]
                    ]
                },
                {
                    title: "Stock & Pricing",
                    fields: [
                        ['Stock Quantity', medicine.stock_quantity],
                        ['Minimum Stock', medicine.minimum_stock ?? '-'],
                        ['Price', medicine.formatted_price ?? medicine.price],
                        ['Batch Number', medicine.batch_number ?? '-'],
                        ['Expiry Date', medicine.expiry_date ? new Date(medicine.expiry_date).toLocaleDateString() :
                            '-'
                        ]
                    ]
                },
                {
                    title: "Usage & Safety",
                    fields: [
                        ['Description', medicine.description ?? '-'],
                        ['Indications', medicine.indications ?? '-'],
                        ['Dosage Instructions', medicine.dosage_instructions ?? '-'],
                        ['Storage Conditions', medicine.storage_conditions ?? '-'],
                        ['Contraindications', medicine.contraindications ?? '-'],
                        ['Side Effects', medicine.side_effects ?? '-'],
                        ['Requires Prescription', medicine.requires_prescription ?
                            '<span class="text-green-600 font-semibold">Yes</span>' :
                            '<span class="text-gray-500">No</span>'
                        ],
                        ['Active', medicine.is_active ?
                            '<span class="text-green-600 font-semibold">Yes</span>' :
                            '<span class="text-red-500 font-semibold">No</span>'
                        ]
                    ]
                }
            ];

            content.innerHTML = sections.map(section => `
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <h3 class="text-xl font-semibold text-green-700 mb-3">${section.title}</h3>
            <div class="space-y-2">
                ${section.fields.map(([label, value]) => `
                                                <div class="flex justify-between">
                                                    <span class="font-medium text-gray-800">${label}</span>
                                                    <span class="text-gray-700">${value}</span>
                                                </div>
                                            `).join('')}
            </div>
        </div>
        `).join('');

            modal.classList.remove('hidden');
        }

        function closeMedicineModal() {
            document.getElementById('medicineDetailModal').classList.add('hidden');
        }
    </script>

    {{-- edit modal --}}
    <!-- Edit Medicine Modal -->
    <div id="editMedicineModal"
        class="fixed inset-0 bg-gray-900/70 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-8 relative overflow-y-auto max-h-[90vh]">

            <!-- Close Button -->
            <button type="button" onclick="closeEditMedicineModal()"
                class="absolute top-5 right-5 text-gray-500 hover:text-gray-700 transition">✕</button>

            <h3 class="text-2xl font-bold text-blue-800 mb-6">Edit Medicine</h3>

            <form id="editMedicineForm" method="POST" action="{{ route('workspace.medicine.update', '__id__') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <!-- Basic Fields -->
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Name<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_name" name="name"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Generic Name<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_generic_name" name="generic_name"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Category<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_category" name="category"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Manufacturer<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_manufacturer" name="manufacturer"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Strength<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_strength" name="strength"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Unit<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_unit" name="unit"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Form<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_form" name="form"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Stock Quantity<span
                                class="text-red-500">*</span></label>
                        <input type="number" id="edit_stock_quantity" name="stock_quantity"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Minimum Stock<span
                                class="text-red-500">*</span></label>
                        <input type="number" id="edit_minimum_stock" name="minimum_stock"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Price<span
                                class="text-red-500">*</span></label>
                        <input type="number" id="edit_price" name="price" step="0.01"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Batch Number<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="edit_batch_number" name="batch_number"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Expiry Date<span
                                class="text-red-500">*</span></label>
                        <input type="date" id="edit_expiry_date" name="expiry_date"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Textareas -->
                <div class="mt-6 grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Description<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_description" name="description"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Indications<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_indications" name="indications"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Dosage Instructions<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_dosage_instructions" name="dosage_instructions"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Storage Conditions<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_storage_conditions" name="storage_conditions"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Contraindications<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_contraindications" name="contraindications"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Side Effects<span
                                class="text-red-500">*</span></label>
                        <textarea id="edit_side_effects" name="side_effects"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <!-- Checkboxes -->
                <div class="mt-5 flex gap-4 items-center">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="edit_requires_prescription" name="requires_prescription"
                            class="w-4 h-4">
                        <span>Requires Prescription</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="edit_is_active" name="is_active" class="w-4 h-4">
                        <span>Active</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="closeEditMedicineModal()"
                        class="px-5 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition font-semibold">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-xl  font-semibold transition">
                        Update Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Fill Modal -->
    <script>
        function showEditMedicineModal(medicine) {
            const id = medicine._id?.$oid || medicine._id || medicine.id;

            // Set form action dynamically
            const form = document.getElementById('editMedicineForm');
            form.action = "{{ route('workspace.medicine.update', '__id__') }}".replace('__id__', id);
            document.getElementById('edit_id').value = id;

            // Text/Number fields
            const fields = [
                'name', 'generic_name', 'category', 'manufacturer', 'strength', 'unit', 'form',
                'stock_quantity', 'minimum_stock', 'price', 'batch_number',
                'description', 'indications', 'dosage_instructions',
                'storage_conditions', 'contraindications', 'side_effects'
            ];
            fields.forEach(field => {
                const input = document.getElementById('edit_' + field);
                if (input) input.value = medicine[field] ?? '';
            });

            // Checkboxes
            document.getElementById('edit_requires_prescription').checked = !!medicine.requires_prescription;
            document.getElementById('edit_is_active').checked = !!medicine.is_active;

            // Expiry date (Carbon)
            if (medicine.expiry_date) {
                try {
                    const date = new Date(medicine.expiry_date);
                    document.getElementById('edit_expiry_date').value = date.toISOString().split('T')[0];
                } catch (e) {
                    document.getElementById('edit_expiry_date').value = '';
                }
            }

            // Show modal
            document.getElementById('editMedicineModal').classList.remove('hidden');
        }

        function closeEditMedicineModal() {
            document.getElementById('editMedicineModal').classList.add('hidden');
        }
    </script>




    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-6">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667
                        1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732
                        0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Confirm Delete</h3>
                <p class="text-gray-600 mb-8">
                    Are you sure you want to delete
                    <span id="medicineName" class="font-semibold text-red-600"></span>?
                    <br>This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-4">
                    <button onclick="closeDeleteModal()"
                        class="px-8 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                        Cancel
                    </button>

                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-8 py-3 bg-red-500 text-white rounded-2xl hover:bg-red-600 transition-colors duration-200 font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bulk Dispense Modal --}}
    <div id="bulkDispenseModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/60 backdrop-blur">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Dispense Medicines</h3>
            <form id="bulkDispenseForm" method="POST" action="{{ route('workspace.medicine.bulkDispense') }}"
                class="space-y-5">
                @csrf
                <div id="bulkRows" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 bulk-row">
                        <div class="md:col-span-8">
                            <label class="block text-base font-semibold text-gray-700 mb-2">Medicine</label>
                            <input list="medicineOptions" name="items[0][medicine_name]"
                                class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 bg-blue-50 text-gray-800 placeholder-gray-400"
                                placeholder="Search medicine by name" required>
                            <datalist id="medicineOptions">
                                @foreach ($allMedicines as $m)
                                    <option value="{{ $m->name }}" data-id="{{ $m->_id }}"
                                        data-stock="{{ (int) $m->stock_quantity }}">{{ $m->name }} (Stock:
                                        {{ (int) $m->stock_quantity }})</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-base font-semibold text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="items[0][quantity]" min="1" step="1"
                                class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 bg-blue-50 text-gray-800"
                                required>
                            <p class="text-xs text-gray-500 mt-1 stock-hint"></p>
                            <p class="text-xs text-red-600 mt-1 qty-warning hidden"></p>
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button type="button"
                                class="w-full px-3 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 font-bold text-lg"
                                onclick="removeBulkRow(this)">-</button>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button"
                        class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl hover:bg-gray-200 font-semibold"
                        onclick="addBulkRow()">+ Add another</button>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeBulkDispenseModal()"
                        class="px-5 py-2 text-gray-700 bg-gray-200 rounded-xl hover:bg-gray-300 font-semibold transition">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2 text-white bg-amber-600 rounded-xl hover:bg-amber-700 font-semibold transition">Dispense</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div id="success-alert"
            class="fixed bottom-8 right-8 z-50 border-green-400 text-green-700 px-6 py-4 rounded-xl mb-4 bg-green-50 shadow-xl min-w-[250px] max-w-xs text-base font-semibold"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-alert"
            class="fixed bottom-8 right-8 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-4 shadow-xl min-w-[250px] max-w-xs text-base font-semibold"
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

        function openBulkDispenseModal() {
            document.getElementById('bulkDispenseModal').classList.remove('hidden');
        }

        function closeBulkDispenseModal() {
            document.getElementById('bulkDispenseModal').classList.add('hidden');
        }

        function addBulkRow() {
            const container = document.getElementById('bulkRows');
            const index = container.querySelectorAll('.bulk-row').length;
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 bulk-row';
            row.innerHTML = `
                <div class="md:col-span-8">
                    <label class="block text-base font-semibold text-gray-700 mb-2">Medicine</label>
                    <input list="medicineOptions" name="items[${index}][medicine_name]" class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 bg-blue-50 text-gray-800 placeholder-gray-400" placeholder="Search medicine by name" required>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-base font-semibold text-gray-700 mb-2">Quantity</label>
                    <input type="number" name="items[${index}][quantity]" min="1" step="1" class="w-full border border-blue-200 rounded-xl px-4 py-2.5 focus:ring-blue-400 focus:border-blue-400 bg-blue-50 text-gray-800" required>
                    <p class="text-xs text-gray-500 mt-1 stock-hint"></p>
                    <p class="text-xs text-red-600 mt-1 qty-warning hidden"></p>
                </div>
                <div class="md:col-span-1 flex items-end">
                    <button type="button" class="w-full px-3 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 font-bold text-lg" onclick="removeBulkRow(this)">-</button>
                </div>
            `;
            container.appendChild(row);
        }

        function removeBulkRow(btn) {
            const row = btn.closest('.bulk-row');
            if (row) row.remove();
        }

        // Sync max and hints when a medicine is selected/changed
        function syncRowConstraints(row) {
            const dataList = document.getElementById('medicineOptions');
            const options = Array.from(dataList.options);
            const nameInput = row.querySelector('input[list="medicineOptions"]');
            const qtyInput = row.querySelector('input[type="number"]');
            const hint = row.querySelector('.stock-hint');
            const warn = row.querySelector('.qty-warning');
            if (!nameInput || !qtyInput) return;
            const typed = nameInput.value.trim();
            const match = options.find(o => o.value === typed);
            if (!match) {
                qtyInput.removeAttribute('max');
                if (hint) hint.textContent = '';
                if (warn) {
                    warn.textContent = '';
                    warn.classList.add('hidden');
                }
                return;
            }
            const stock = parseInt(match.getAttribute('data-stock') || '0', 10);
            qtyInput.max = stock;
            if (hint) hint.textContent = `Available: ${stock}`;
            if (qtyInput.value && parseInt(qtyInput.value, 10) > stock) {
                if (warn) {
                    warn.textContent = `Exceeds stock (${stock}). Adjusted to max.`;
                    warn.classList.remove('hidden');
                }
                qtyInput.value = stock;
            } else {
                if (warn) {
                    warn.textContent = '';
                    warn.classList.add('hidden');
                }
            }
        }

        document.addEventListener('input', function(e) {
            if (e.target && e.target.matches('#bulkRows input[list="medicineOptions"]')) {
                const row = e.target.closest('.bulk-row');
                if (row) syncRowConstraints(row);
            }
        });

        // Live validate quantity inputs
        document.addEventListener('input', function(e) {
            if (e.target && e.target.matches('#bulkRows input[type="number"]')) {
                const row = e.target.closest('.bulk-row');
                if (!row) return;
                const dataList = document.getElementById('medicineOptions');
                const options = Array.from(dataList.options);
                const nameInput = row.querySelector('input[list="medicineOptions"]');
                const warn = row.querySelector('.qty-warning');
                const typed = nameInput ? nameInput.value.trim() : '';
                const match = options.find(o => o.value === typed);
                const stock = match ? parseInt(match.getAttribute('data-stock') || '0', 10) : null;
                const qty = parseInt(e.target.value || '0', 10);
                if (stock !== null && qty > stock) {
                    if (warn) {
                        warn.textContent = `Exceeds stock (${stock}).`;
                        warn.classList.remove('hidden');
                    }
                    e.target.setCustomValidity(`Exceeds stock (${stock}).`);
                } else {
                    if (warn) {
                        warn.textContent = '';
                        warn.classList.add('hidden');
                    }
                    e.target.setCustomValidity('');
                }
            }
        });

        // Before submitting bulk form, map medicine name -> id and validate max
        document.getElementById('bulkDispenseForm').addEventListener('submit', function(e) {
            const dataList = document.getElementById('medicineOptions');
            const options = Array.from(dataList.options);
            const nameInputs = document.querySelectorAll('#bulkRows input[list="medicineOptions"]');
            let invalid = false;
            nameInputs.forEach((input) => {
                const typed = input.value.trim();
                const match = options.find(o => o.value === typed);
                if (!match) {
                    return;
                }
                const id = match.getAttribute('data-id');
                const stock = parseInt(match.getAttribute('data-stock') || '0', 10);
                const nameAttr = input.getAttribute('name'); // items[i][medicine_name]
                const idName = nameAttr.replace('medicine_name', 'medicine_id');
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = idName;
                hidden.value = id;
                this.appendChild(hidden);

                const row = input.closest('.bulk-row');
                const qtyInput = row ? row.querySelector('input[type="number"]') : null;
                if (qtyInput) {
                    const qty = parseInt(qtyInput.value || '0', 10);
                    if (qty > stock) {
                        invalid = true;
                        qtyInput.reportValidity();
                    }
                }
            });
            if (invalid) {
                e.preventDefault();
                alert('One or more quantities exceed available stock.');
            }
        });

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
