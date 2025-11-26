<div id="add-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-black/30">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="bg-white border-b border-gray-200 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-600 rounded-xl shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ trans('lang.add new medicine') }}</h3>
                            <p class="text-gray-500 text-sm mt-0.5">
                                {{ trans('lang.fill in the medicine details below to add it to your inventory') }}</p>
                        </div>
                    </div>
                    <button type="button" data-modal-toggle="add-modal"
                        class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="sr-only">{{ trans('lang.close modal') }}</span>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                <form method="POST" action="{{ route('workspace.medicine.store') }}" class="space-y-6">
                    @csrf

                    {{-- Form Fields --}}
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2  gap-5">

                            {{-- Medicine Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.medicine name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., Paracetamol">
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Generic Name --}}
                            <div>
                                <label for="generic_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.generic name') }}
                                </label>
                                <input type="text" name="generic_name" id="generic_name"
                                    value="{{ old('generic_name') }}"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., Acetaminophen">
                                @error('generic_name')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.category') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="category" id="category" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white">
                                    <option value="">{{ trans('lang.select category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Manufacturer --}}
                            <div>
                                <label for="manufacturer" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.manufacturer') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="manufacturer" id="manufacturer"
                                    value="{{ old('manufacturer') }}" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., Pfizer">
                                @error('manufacturer')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Strength --}}
                            <div>
                                <label for="strength" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.strength') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="strength" id="strength" value="{{ old('strength') }}" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., 500">
                                @error('strength')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Unit --}}
                            <div>
                                <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.unit') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="unit" id="unit" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white">
                                    <option value="">{{ trans('lang.select unit') }}</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>
                                            {{ $unit }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Form --}}
                            <div>
                                <label for="form" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.form') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="form" id="form" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white">
                                    <option value="">{{ trans('lang.select form') }}</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form }}" {{ old('form') == $form ? 'selected' : '' }}>
                                            {{ $form }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('form')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stock Quantity --}}
                            <div>
                                <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.stock quantity') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stock_quantity" id="stock_quantity"
                                    value="{{ old('stock_quantity') }}" required min="0"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="0">
                                @error('stock_quantity')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Minimum Stock --}}
                            <div>
                                <label for="minimum_stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.minimum stock') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="minimum_stock" id="minimum_stock"
                                    value="{{ old('minimum_stock') }}" required min="0"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="10">
                                @error('minimum_stock')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div>
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.price') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-gray-500 text-sm font-semibold">$</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" required
                                        min="0" step="0.01"
                                        class="block w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="0.00">
                                </div>
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Batch Number --}}
                            <div>
                                <label for="batch_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.batch number') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="batch_number" id="batch_number"
                                    value="{{ old('batch_number') }}" required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., BT2024001">
                                @error('batch_number')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Expiry Date --}}
                            <div>
                                <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.expiry date') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                                    required
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                @error('expiry_date')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.description') }}
                                </label>
                                <textarea name="description" id="description" rows="2"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="Brief description of the medicine">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Indications --}}
                            <div>
                                <label for="indications" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.indications') }}
                                </label>
                                <textarea name="indications" id="indications" rows="2"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="What this medicine is used for">{{ old('indications') }}</textarea>
                                @error('indications')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Dosage Instructions --}}
                            <div>
                                <label for="dosage_instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.dosage instructions') }}
                                </label>
                                <textarea name="dosage_instructions" id="dosage_instructions" rows="2"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="How to take this medicine">{{ old('dosage_instructions') }}</textarea>
                                @error('dosage_instructions')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Storage Conditions --}}
                            <div>
                                <label for="storage_conditions" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.storage conditions') }}
                                </label>
                                <input type="text" name="storage_conditions" id="storage_conditions"
                                    value="{{ old('storage_conditions') }}"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="e.g., Store in a cool, dry place">
                                @error('storage_conditions')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contraindications --}}
                            <div>
                                <label for="contraindications" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.contraindications') }}
                                </label>
                                <textarea name="contraindications" id="contraindications" rows="2"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="When this medicine should not be used">{{ old('contraindications') }}</textarea>
                                @error('contraindications')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Side Effects --}}
                            <div>
                                <label for="side_effects" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ trans('lang.side effects') }}
                                </label>
                                <textarea name="side_effects" id="side_effects" rows="2"
                                    class="block w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="Common side effects">{{ old('side_effects') }}</textarea>
                                @error('side_effects')
                                    <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Checkboxes --}}
                            <div class="md:col-span-2 flex flex-wrap items-center gap-6 pt-3">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                        class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition mr-2.5">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                                        {{ trans('lang.active medicine') }}
                                    </span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="requires_prescription" id="requires_prescription"
                                        value="1" {{ old('requires_prescription') ? 'checked' : '' }}
                                        class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 transition mr-2.5">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                                        {{ trans('lang.requires prescription') }}
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-200">
                        <button type="button" data-modal-toggle="add-modal"
                            class="inline-flex items-center px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ trans('lang.cancel') }}
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ trans('lang.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>