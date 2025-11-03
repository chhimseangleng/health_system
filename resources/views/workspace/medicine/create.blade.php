<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-2xl rounded-3xl border border-white/20">
                <div class="p-8">
                    {{-- Header --}}
                    <div class="mb-10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 14a4 4 0 10-8 0m8 0a4 4 0 00-8 0m8 0v2a4 4 0 004 4H4a4 4 0 004-4v-2" />
                                        <circle cx="12" cy="7" r="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 6h2m-1-1v2m0-2v2" />
                                    </svg>
                                </div>

                                <div>
                                    <h1 class="text-4xl font-bold text-blue-600">{{ trans('lang.add new medicine') }}</h1>
                                    <p class="text-gray-400 mt-2 text-lg">{{ trans('lang.enter comprehensive medicine details') }}</p>
                                </div>
                            </div>

                            <a href="{{ route('workspace.medicine.index') }}"
                                class="group px-6 py-3 text-blue-800 border border-blue-300 rounded-xl text-sm font-medium hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span>{{ trans('lang.back to medicines') }}</span>
                                </span>
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('workspace.medicine.store') }}" class="space-y-3">
                        @csrf
                        {{-- Basic Information --}}
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl border border-blue-100 shadow-lg transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ trans('lang.basic information') }}</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.medicine name') }}
                                        *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., Paracetamol">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="generic_name"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.generic name') }}</label>
                                    <input type="text" name="generic_name" id="generic_name"
                                        value="{{ old('generic_name') }}"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., Acetaminophen">
                                    @error('generic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.category') }}
                                        *</label>
                                    <select name="category" id="category" required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm">
                                        <option value="">{{ trans('lang.select category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}"
                                                {{ old('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="manufacturer"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.manufacturer') }} *</label>
                                    <input type="text" name="manufacturer" id="manufacturer"
                                        value="{{ old('manufacturer') }}" required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., Pfizer">
                                    @error('manufacturer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Strength and Form --}}
                        <div
                            class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl border border-green-100 shadow-lg transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ trans('lang.strength & form') }}</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="strength" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.strength') }}
                                        *</label>
                                    <input type="text" name="strength" id="strength" value="{{ old('strength') }}"
                                        required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., 500">
                                    @error('strength')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.unit') }}
                                        *</label>
                                    <select name="unit" id="unit" required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm">
                                        <option value="">{{ trans('lang.select unit') }}</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit }}"
                                                {{ old('unit') == $unit ? 'selected' : '' }}>
                                                {{ $unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="form" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.form') }}
                                        *</label>
                                    <select name="form" id="form" required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm">
                                        <option value="">{{ trans('lang.select form') }}</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form }}"
                                                {{ old('form') == $form ? 'selected' : '' }}>
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
                        <div
                            class="bg-gradient-to-br from-orange-50 to-amber-50 p-8 rounded-2xl border border-orange-100 shadow-lg transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ trans('lang.stock information') }}</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label for="stock_quantity"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.stock quantity') }} *</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity"
                                        value="{{ old('stock_quantity') }}" required min="0"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="0">
                                    @error('stock_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="minimum_stock"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.minimum stock') }} *</label>
                                    <input type="number" name="minimum_stock" id="minimum_stock"
                                        value="{{ old('minimum_stock') }}" required min="0"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="10">
                                    @error('minimum_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.price') }}
                                        *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                                        <input type="number" name="price" id="price"
                                            value="{{ old('price') }}" required min="0" step="0.01"
                                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                            placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="batch_number"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.batch number') }} *</label>
                                    <input type="text" name="batch_number" id="batch_number"
                                        value="{{ old('batch_number') }}" required
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., BT2024001">
                                    @error('batch_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.expiry date') }} *</label>
                                <input type="date" name="expiry_date" id="expiry_date"
                                    value="{{ old('expiry_date') }}" required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm">
                                @error('expiry_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Medical Information --}}
                        <div
                            class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl border border-purple-100 shadow-lg transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ trans('lang.medical information') }}</h3>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.description') }}</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="Brief description of the medicine">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="indications"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.indications') }}</label>
                                    <textarea name="indications" id="indications" rows="3"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="What this medicine is used for">{{ old('indications') }}</textarea>
                                    @error('indications')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="dosage_instructions"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.dosage instructions') }}</label>
                                    <textarea name="dosage_instructions" id="dosage_instructions" rows="3"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="How to take this medicine">{{ old('dosage_instructions') }}</textarea>
                                    @error('dosage_instructions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="storage_conditions"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.storage conditions') }}</label>
                                    <input type="text" name="storage_conditions" id="storage_conditions"
                                        value="{{ old('storage_conditions') }}"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="e.g., Store in a cool, dry place">
                                    @error('storage_conditions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Additional Information --}}
                        <div
                            class="bg-gradient-to-br from-red-50 to-rose-50 p-8 rounded-2xl border border-red-100 shadow-lg transition-shadow duration-300">
                            <div class="flex items-center space-x-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-red-500 to-rose-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ trans('lang.additional information') }}</h3>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <label for="contraindications"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.contraindications') }}</label>
                                    <textarea name="contraindications" id="contraindications" rows="3"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="When this medicine should not be used">{{ old('contraindications') }}</textarea>
                                    @error('contraindications')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="side_effects"
                                        class="block text-sm font-medium text-gray-700 mb-2">{{ trans('lang.side effects') }}</label>
                                    <textarea name="side_effects" id="side_effects" rows="3"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 bg-white/80 backdrop-blur-sm"
                                        placeholder="Common side effects">{{ old('side_effects') }}</textarea>
                                    @error('side_effects')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ old('is_active') ? 'checked' : '' }}
                                            class="w-5 h-5 rounded-lg border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all duration-200">
                                        <span class="ml-2 text-sm text-gray-700">{{ trans('lang.active medicine') }}</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="requires_prescription"
                                            id="requires_prescription" value="1"
                                            {{ old('requires_prescription') ? 'checked' : '' }}
                                            class="w-5 h-5 rounded-lg border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all duration-200">
                                        <span class="ml-2 text-sm text-gray-700">{{ trans('lang.requires prescription') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex justify-end space-x-4 pt-8">
                            <a href="{{ route('workspace.medicine.index') }}"
                                class="group px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-200 font-medium hover:border-gray-400">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>{{ trans('lang.cancel') }}</span>
                                </span>
                            </a>
                            <button type="submit"
                                class="group px-8 py-4 from-blue-600 bg-blue-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>{{ trans('lang.add medicine') }}</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
