<div id="add-unit" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-screen-sm max-h-full">
        <div class="relative p-5 bg-white rounded-lg shadow">
            <div class="flex items-center justify-between pb-4  border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Add Service
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="add-unit">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

            </div>
            <form action="{{ route('patients.services.store') }}" method="POST">
            @csrf
            <label for="service_name" class="block mb-2">Service Name</label>
            <input type="text" name="service_name" id="service_name" required
                class="border border-gray-300 rounded px-3 py-2 w-full mb-4" />

            <label for="patient_id" class="block mb-2">Patient</label>
            <select name="patient_id" id="patient_id" required class="border border-gray-300 rounded px-3 py-2 w-full mb-4">
                @foreach ($patients as $patient)
                    <option value="{{ $patient->_id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
        </div>
    </div>
</div>
