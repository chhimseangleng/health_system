<x-app-layout>
    <div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
        <div class="max-w-3xl w-full mx-auto">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
                <div class="p-8">
                    {{-- Header --}}
                    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shadow">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 14a4 4 0 10-8 0m8 0a4 4 0 00-8 0m8 0v2a4 4 0 004 4H4a4 4 0 004-4v-2" />
                                    <circle cx="12" cy="7" r="3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 6h2m-1-1v2m0-2v2" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-semibold text-gray-700">{{ trans('lang.add new medicine') }}</h1>
                                <p class="text-gray-400 mt-1 text-base">{{ trans('lang.enter comprehensive medicine details') }}</p>
                            </div>  
                        </div>

                        <a href="{{ route('workspace.medicine.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-blue-200 rounded-md text-blue-600 bg-blue-50 text-sm font-medium hover:bg-blue-600 hover:text-white transition focus:outline-none">
                            <svg class="w-4 h-4 mr-1 transform hover:-translate-x-1 transition-transform" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 19l-7-7 7-7" />
                            </svg>
                            {{ trans('lang.back to medicines') }}
                        </a>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('workspace.medicine.store') }}" class="space-y-6">
                        @csrf

                        {{-- Basic Information --}}
                        <section class="p-6 bg-gray-50 rounded-lg border border-gray-100 mb-4">
                            <h3 class="text-md font-semibold text-gray-600 mb-4 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                {{ trans('lang.basic information') }}
                            </h3>
                            <div class="flex flex-col gap-4 md:grid md:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.medicine name') }} <span class="text-red-400">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                           required
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., Paracetamol">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="generic_name" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.generic name') }}</label>
                                    <input type="text" name="generic_name" id="generic_name"
                                           value="{{ old('generic_name') }}"
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., Acetaminophen">
                                    @error('generic_name')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.category') }} <span class="text-red-400">*</span></label>
                                    <select name="category" id="category" required
                                            class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">{{ trans('lang.select category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}"
                                                {{ old('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="manufacturer" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.manufacturer') }} <span class="text-red-400">*</span></label>
                                    <input type="text" name="manufacturer" id="manufacturer"
                                           value="{{ old('manufacturer') }}" required
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., Pfizer">
                                    @error('manufacturer')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        {{-- Strength and Form --}}
                        <section class="p-6 bg-green-50 rounded-lg border border-green-100 mb-4">
                            <h3 class="text-md font-semibold text-gray-600 mb-4 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                {{ trans('lang.strength & form') }}
                            </h3>
                            <div class="flex flex-col gap-4 md:grid md:grid-cols-3">
                                <div>
                                    <label for="strength" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.strength') }}
                                        <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" name="strength" id="strength" value="{{ old('strength') }}"
                                           required
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., 500">
                                    @error('strength')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.unit') }}
                                        <span class="text-red-400">*</span>
                                    </label>
                                    <select name="unit" id="unit" required
                                            class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">{{ trans('lang.select unit') }}</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit }}"
                                                {{ old('unit') == $unit ? 'selected' : '' }}>
                                                {{ $unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="form" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.form') }}
                                        <span class="text-red-400">*</span>
                                    </label>
                                    <select name="form" id="form" required
                                            class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">{{ trans('lang.select form') }}</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form }}"
                                                {{ old('form') == $form ? 'selected' : '' }}>
                                                {{ $form }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        {{-- Stock Information --}}
                        <section class="p-6 bg-orange-50 rounded-lg border border-orange-100 mb-4">
                            <h3 class="text-md font-semibold text-gray-600 mb-4 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-400 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </span>
                                {{ trans('lang.stock information') }}
                            </h3>
                            <div class="flex flex-col gap-4 md:grid md:grid-cols-4">
                                <div>
                                    <label for="stock_quantity"
                                           class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.stock quantity') }} <span class="text-red-400">*</span></label>
                                    <input type="number" name="stock_quantity" id="stock_quantity"
                                           value="{{ old('stock_quantity') }}" required min="0"
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="0">
                                    @error('stock_quantity')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="minimum_stock"
                                           class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.minimum stock') }} <span class="text-red-400">*</span></label>
                                    <input type="number" name="minimum_stock" id="minimum_stock"
                                           value="{{ old('minimum_stock') }}" required min="0"
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="10">
                                    @error('minimum_stock')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.price') }}
                                        <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1.5 text-gray-400 text-sm">$</span>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="0.01"
                                               class="block w-full border border-gray-300 rounded-md pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                               placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="batch_number"
                                           class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.batch number') }} <span class="text-red-400">*</span></label>
                                    <input type="text" name="batch_number" id="batch_number"
                                           value="{{ old('batch_number') }}" required
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., BT2024001">
                                    @error('batch_number')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="expiry_date" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.expiry date') }} <span class="text-red-400">*</span></label>
                                <input type="date" name="expiry_date" id="expiry_date"
                                       value="{{ old('expiry_date') }}" required
                                       class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @error('expiry_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>

                        {{-- Medical Information --}}
                        <section class="p-6 bg-purple-50 rounded-lg border border-purple-100 mb-4">
                            <h3 class="text-md font-semibold text-gray-600 mb-4 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </span>
                                {{ trans('lang.medical information') }}
                            </h3>
                            <div class="flex flex-col gap-4">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.description') }}</label>
                                    <textarea name="description" id="description" rows="2"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        placeholder="Brief description of the medicine">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="indications" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.indications') }}</label>
                                    <textarea name="indications" id="indications" rows="2"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        placeholder="What this medicine is used for">{{ old('indications') }}</textarea>
                                    @error('indications')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="dosage_instructions" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.dosage instructions') }}</label>
                                    <textarea name="dosage_instructions" id="dosage_instructions" rows="2"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        placeholder="How to take this medicine">{{ old('dosage_instructions') }}</textarea>
                                    @error('dosage_instructions')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="storage_conditions" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.storage conditions') }}</label>
                                    <input type="text" name="storage_conditions" id="storage_conditions"
                                           value="{{ old('storage_conditions') }}"
                                           class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                           placeholder="e.g., Store in a cool, dry place">
                                    @error('storage_conditions')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        {{-- Additional Information --}}
                        <section class="p-6 bg-red-50 rounded-lg border border-red-100">
                            <h3 class="text-md font-semibold text-gray-600 mb-4 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </span>
                                {{ trans('lang.additional information') }}
                            </h3>
                            <div class="flex flex-col gap-4">
                                <div>
                                    <label for="contraindications" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.contraindications') }}</label>
                                    <textarea name="contraindications" id="contraindications" rows="2"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        placeholder="When this medicine should not be used">{{ old('contraindications') }}</textarea>
                                    @error('contraindications')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="side_effects" class="block text-sm font-medium text-gray-600 mb-1">{{ trans('lang.side effects') }}</label>
                                    <textarea name="side_effects" id="side_effects" rows="2"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        placeholder="Common side effects">{{ old('side_effects') }}</textarea>
                                    @error('side_effects')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center space-x-8 pt-3">
                                    <label class="inline-flex items-center text-sm text-gray-600 font-medium">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                                {{ old('is_active') ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-blue-400 mr-1">
                                        <span>{{ trans('lang.active medicine') }}</span>
                                    </label>
                                    <label class="inline-flex items-center text-sm text-gray-600 font-medium">
                                        <input type="checkbox" name="requires_prescription"
                                            id="requires_prescription" value="1"
                                            {{ old('requires_prescription') ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-blue-400 mr-1">
                                        <span>{{ trans('lang.requires prescription') }}</span>
                                    </label>
                                </div>
                            </div>
                        </section>
                        {{-- Actions --}}
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('workspace.medicine.index') }}"
                               class="inline-flex items-center px-6 py-2 border border-gray-300 text-gray-500 rounded-md text-sm font-medium bg-white hover:bg-gray-100 transition focus:outline-none">
                                <svg class="w-4 h-4 mr-1 transform hover:-translate-x-1 transition-transform"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ trans('lang.cancel') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                                <svg class="w-5 h-5 mr-1" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ trans('lang.add medicine') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
