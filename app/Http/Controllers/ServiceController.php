<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Patient; // <-- Import Patient model

class AppointmentController extends Controller
{
    public function storeService(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'service_name' => 'required|string',
            // 'patient_id' not needed here because you have $patient from route model binding
        ]);

        $service = new Service();
        $service->service_name = $validated['service_name'];
        $service->patient_id = $patient->_id;  // link to patient
        $service->save();

        return redirect()->back()->with('success', 'Service added successfully!');
    }
}
