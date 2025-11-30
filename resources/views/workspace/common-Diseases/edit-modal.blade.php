<!-- Edit Disease Modal Partial -->
<div id="editDiseaseModal" class="fixed inset-0 bg-gray-900/70 hidden flex items-center justify-center z-50 backdrop-blur-sm" aria-hidden="true">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-8 relative overflow-y-auto max-h-[90vh] border border-gray-100">
        <!-- Close Button -->
        <button type="button" onclick="closeEditModal()" class="absolute top-5 right-8 text-gray-500 hover:text-gray-800 transition mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        </button>

        <div class="mb-6 flex items-center gap-4 border-b border-gray-200 pb-4">

            <div>
                <h2 class="text-3xl font-extrabold text-blue-800 tracking-tight">Edit Disease</h2>
                <p class="text-base text-gray-600 mt-1">Update information for this common disease.</p>
            </div>
        </div>

        <div class="px-2 py-1">
            <form id="editDiseaseForm" action="#" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Disease Name</label>
                        <input id="edit_name" name="name" type="text" value=""
                               placeholder="e.g. Flu"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Physician</label>
                        <input id="edit_physician" name="physician" type="text" value=""
                               placeholder="e.g. Dr. Sok"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Age</label>
                        <input id="edit_age" name="age" type="number" min="0" max="150" value=""
                               placeholder="e.g. 3"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"/>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">Gender</label>
                        <select id="edit_gender" name="gender"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
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
                    <!-- Prescriptions editor -->
                    <div id="edit_prescriptions_summary" class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Prescriptions</label>
                        <div id="edit_prescriptions_container" class="space-y-3"></div>
                        <div class="mt-2">
                            <button type="button" id="edit_add_prescription_btn" class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm">Add prescription</button>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-blue-800">Village</label>
                        <input id="edit_village" name="village" type="text" value=""
                               placeholder="e.g. Trapeang Russey"
                               class="w-full border border-blue-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                    </div>
                    {{-- <div>
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
                    </div> --}}
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r bg-blue-600 to-blue-800 text-white font-bold rounded-lg shadow">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(disease, idOverride) {
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
            // document.getElementById('edit_commune').value = disease.commune ?? '';
            // document.getElementById('edit_staff_name').value = disease.staff_name ?? '';
            // Determine form action:
            // If idOverride looks like a URL (contains a slash), use it directly.
            // Otherwise if it's an id string, append to base URL; else extract from disease._id.
            const maybe = (idOverride || '').toString();
            if (maybe.includes('/')) {
                form.action = maybe;
            } else {
                let resolvedId = null;
                if (maybe && maybe !== '') {
                    resolvedId = maybe;
                } else if (disease._id) {
                    const rawId = disease._id;
                    resolvedId = (typeof rawId === 'object' && rawId !== null)
                        ? (rawId.$oid || rawId['$oid'] || rawId.$id || rawId['$id'] || (rawId.toString ? rawId.toString() : null))
                        : rawId;
                }
                if (resolvedId) {
                    form.action = "{{ url('/workspace/common-diseases') }}/" + resolvedId;
                }
            }
            // Populate prescriptions editor if available
            const presContainer = document.getElementById('edit_prescriptions_container');
            const addBtn = document.getElementById('edit_add_prescription_btn');
            if (presContainer) {
                // helpers for rows
                function renderPrescriptionRow(p, idx) {
                    p = p || {};
                    const mid = p.medicine_id ?? '';
                    const mname = p.medicine_name ?? '';
                    const td = p.total_day ?? '';
                    const tm = p.total_medicine ?? '';
                    const times = p.times ?? {};
                    return `
                        <div class="p-3 border border-blue-100 rounded-lg bg-white" data-pres-index="${idx}">
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                                <div class="md:col-span-2">
                                    <label class="block text-xs text-gray-600">Medicine</label>
                                    <input type="hidden" name="prescriptions[${idx}][medicine_id]" value="${escapeHtml(mid)}" />
                                    <input name="prescriptions[${idx}][medicine_name]" type="text" value="${escapeHtml(mname)}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                                 <div>
                                    <label class="block text-xs text-gray-600">Total Medicine</label>
                                    <input name="prescriptions[${idx}][total_medicine]" type="number" min="0" value="${escapeHtml(tm)}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600">Total Day</label>
                                    <input name="prescriptions[${idx}][total_day]" type="number" min="0" value="${escapeHtml(td)}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs text-gray-600">Morning (M) qty</label>
                                    <input name="prescriptions[${idx}][times][M][qty]" type="number" min="0" value="${escapeHtml(times.M?.qty ?? '')}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                                <div>
                                    <button type="button" class="remove-prescription-btn px-3 py-2 bg-red-50 text-red-700 rounded-lg text-sm">Remove</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-3 mt-3">
                                <div>
                                    <label class="block text-xs text-gray-600">Afternoon (A) qty</label>
                                    <input name="prescriptions[${idx}][times][A][qty]" type="number" min="0" value="${escapeHtml(times.A?.qty ?? '')}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600">Evening (E) qty</label>
                                    <input name="prescriptions[${idx}][times][E][qty]" type="number" min="0" value="${escapeHtml(times.E?.qty ?? '')}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                                </div>
                            </div>
                        </div>
                    `;
                }

                function addPrescriptionRow(p) {
                    const idx = presContainer.querySelectorAll('[data-pres-index]').length;
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = renderPrescriptionRow(p, idx);
                    presContainer.appendChild(wrapper.firstElementChild);
                    // attach remove handler
                    presContainer.querySelectorAll('.remove-prescription-btn').forEach(btn => {
                        btn.onclick = function(e) {
                            const row = e.target.closest('[data-pres-index]');
                            if (!row) return;
                            row.remove();
                            // reindex remaining rows' names
                            Array.from(presContainer.querySelectorAll('[data-pres-index]')).forEach((r, newIdx) => {
                                r.setAttribute('data-pres-index', newIdx);
                                // update all input names within r
                                r.querySelectorAll('input').forEach(input => {
                                    const name = input.getAttribute('name') || '';
                                    const newName = name.replace(/prescriptions\\[\\d+\\]/, 'prescriptions[' + newIdx + ']');
                                    input.setAttribute('name', newName);
                                });
                            });
                        };
                    });
                }

                // populate existing prescriptions
                try {
                    const prescriptions = disease.prescriptions ?? disease.prescription ?? null;
                    if (Array.isArray(prescriptions) && prescriptions.length > 0) {
                        presContainer.innerHTML = '';
                        prescriptions.forEach(p => addPrescriptionRow(p));
                    } else {
                        presContainer.innerHTML = '<div class="text-gray-400 italic">No prescriptions yet — add one below.</div>';
                    }
                } catch (e) {
                    presContainer.innerHTML = '<div class="text-red-500 text-sm">Unable to load prescriptions</div>';
                }

                // add new row handler
                if (addBtn) {
                    addBtn.onclick = function() { addPrescriptionRow({}); };
                }
            }
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // simple HTML escaper to avoid injecting raw values
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function closeEditModal() {
        const modal = document.getElementById('editDiseaseModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>


