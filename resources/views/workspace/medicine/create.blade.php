<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-2 border-gray-200 border-dashed rounded-lg">

                    {{-- Header --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Add New Medicine</h1>
                                <p class="text-gray-600 mt-1">Enter medicine details to add to your inventory</p>
                            </div>

                            <a href="{{ route('workspace.medicine.index') }}"
                               class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                ← Back to Medicines
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('workspace.medicine.store') }}" class="space-y-6">
                        @csrf

                        {{-- Basic Information --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Medicine Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., Paracetamol">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="generic_name" class="block text-sm font-medium text-gray-700 mb-2">Generic Name</label>
                                    <input type="text" name="generic_name" id="generic_name" value="{{ old('generic_name') }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., Acetaminophen">
                                    @error('generic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select name="category" id="category" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-2">Manufacturer *</label>
                                    <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., Pfizer">
                                    @error('manufacturer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Strength and Form --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Strength & Form</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="strength" class="block text-sm font-medium text-gray-700 mb-2">Strength *</label>
                                    <input type="text" name="strength" id="strength" value="{{ old('strength') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., 500">
                                    @error('strength')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                    <select name="unit" id="unit" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>
                                                {{ $unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="form" class="block text-sm font-medium text-gray-700 mb-2">Form *</label>
                                    <select name="form" id="form" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Form</option>
                                        @foreach($forms as $form)
                                            <option value="{{ $form }}" {{ old('form') == $form ? 'selected' : '' }}>
                                                {{ $form }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Stock Information --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}" required min="0"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0">
                                    @error('stock_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock *</label>
                                    <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock') }}" required min="0"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="10">
                                    @error('minimum_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="0.01"
                                               class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number *</label>
                                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., BT2024001">
                                    @error('batch_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('expiry_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Medical Information --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Brief description of the medicine">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="indications" class="block text-sm font-medium text-gray-700 mb-2">Indications</label>
                                    <textarea name="indications" id="indications" rows="3"
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="What this medicine is used for">{{ old('indications') }}</textarea>
                                    @error('indications')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="dosage_instructions" class="block text-sm font-medium text-gray-700 mb-2">Dosage Instructions</label>
                                    <textarea name="dosage_instructions" id="dosage_instructions" rows="3"
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="How to take this medicine">{{ old('dosage_instructions') }}</textarea>
                                    @error('dosage_instructions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="storage_conditions" class="block text-sm font-medium text-gray-700 mb-2">Storage Conditions</label>
                                    <input type="text" name="storage_conditions" id="storage_conditions" value="{{ old('storage_conditions') }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="e.g., Store in a cool, dry place">
                                    @error('storage_conditions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Additional Information --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="contraindications" class="block text-sm font-medium text-gray-700 mb-2">Contraindications</label>
                                    <textarea name="contraindications" id="contraindications" rows="3"
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="When this medicine should not be used">{{ old('contraindications') }}</textarea>
                                    @error('contraindications')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="side_effects" class="block text-sm font-medium text-gray-700 mb-2">Side Effects</label>
                                    <textarea name="side_effects" id="side_effects" rows="3"
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Common side effects">{{ old('side_effects') }}</textarea>
                                    @error('side_effects')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                               {{ old('is_active') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Active Medicine</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="requires_prescription" id="requires_prescription" value="1"
                                               {{ old('requires_prescription') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Requires Prescription</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('workspace.medicine.index') }}"
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Add Medicine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
