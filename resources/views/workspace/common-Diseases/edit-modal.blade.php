<!-- Edit Disease Modal Partial -->
<div id="editDiseaseModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4" aria-hidden="true">
    <div class="bg-white rounded-3xl shadow-2xl border border-blue-200 max-w-4xl w-full mx-auto overflow-hidden">
        <div class="flex items-center justify-between px-8 py-6 bg-gradient-to-r from-blue-400 via-blue-200 to-blue-100 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-blue-900 tracking-tight">Edit Disease</h2>
                <p class="text-sm text-blue-700 mt-1">Update information for this common disease.</p>
            </div>
            <div>
                <button type="button" onclick="closeEditModal()"
                    class="text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-xl text-base w-10 h-10 flex justify-center items-center transition-colors duration-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="px-8 py-6">
            <form id="editDiseaseForm" action="#" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Disease Name</label>
                        <input id="edit_name" name="name" type="text" value=""
                               placeholder="e.g. Flu"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Physician</label>
                        <input id="edit_physician" name="physician" type="text" value=""
                               placeholder="e.g. Dr. Sok"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Age</label>
                        <input id="edit_age" name="age" type="number" min="0" max="150" value=""
                               placeholder="e.g. 3"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Gender</label>
                        <select id="edit_gender" name="gender"
                                class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Diagnosis</label>
                        <input id="edit_drug_diagnosis" name="drug_diagnosis" type="text" value=""
                               placeholder="e.g. Paracetamol"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Village</label>
                        <input id="edit_village" name="village" type="text" value=""
                               placeholder="e.g. Trapeang Russey"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Commune</label>
                        <input id="edit_commune" name="commune" type="text" value=""
                               placeholder="e.g. Ta Sal"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Staff Name</label>
                        <input id="edit_staff_name" name="staff_name" type="text" value=""
                               placeholder="e.g. Nurse Dara"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r bg-blue-600 to-blue-800 text-white font-bold rounded-lg shadow">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(disease) {
        const modal = document.getElementById('editDiseaseModal');
        const form = document.getElementById('editDiseaseForm');
        if (!modal || !form) return;
        if (disease) {
            document.getElementById('edit_name').value = disease.name ?? '';
            document.getElementById('edit_physician').value = disease.physician ?? '';
            document.getElementById('edit_age').value = disease.age ?? '';
            document.getElementById('edit_gender').value = disease.gender ?? '';
            document.getElementById('edit_drug_diagnosis').value = disease.drug_diagnosis ?? '';
            document.getElementById('edit_village').value = disease.village ?? '';
            document.getElementById('edit_commune').value = disease.commune ?? '';
            document.getElementById('edit_staff_name').value = disease.staff_name ?? '';
            if (disease._id) {
                form.action = "{{ url('/workspace/common-diseases') }}/" + disease._id;
            }
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editDiseaseModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>


