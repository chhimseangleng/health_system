<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\VaccineCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    public function vaccineCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dose' => 'required|integer|min:1',
        ]);

        // Create and save new VaccineCategory
        $category = VaccineCategory::create([
            'name' => $validated['name'],
            'dose' => $validated['dose'],
        ]);

        // Redirect or return response
        return redirect()->back()->with('success', 'Vaccine category added successfully!');
    }

    public function vaccineList()
    {
        $categories = VaccineCategory::all();


        return view('workspace.vaccine.vaccineList', compact('categories'));
    }

    public function addDose(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'id' => 'required|string',
            'comeback' => 'nullable|string',
        ]);

        $vaccineDose = Vaccine::find($data['id']); // find vaccine record

        if (!$vaccineDose) {
            return redirect()->back()->withErrors(['id' => 'Vaccine record not found']);
        }

        // Increment comeback_count by 1
        $vaccineDose->comeback_count = ($vaccineDose->comeback_count ?? 0) + 1;

        // Get max dose from related vaccine category
        $maxDose = 0;
        if ($vaccineDose->vaccineCategory) {
            $maxDose = (int) $vaccineDose->vaccineCategory->dose;
        }

        // If comeback_count >= maxDose, set comeback to false
        if ($vaccineDose->comeback_count >= $maxDose) {
            $vaccineDose->comeback = false;
        } else {
            // Otherwise, set comeback based on checkbox input (optional)
            $vaccineDose->comeback = (isset($data['comeback']) && $data['comeback'] === 'on');
        }

        $vaccineDose->save();

        return redirect()->back()->with('success', 'Dose updated successfully.');
    }


    public function comeback(Request $request)
    {
        $search = $request->input('search');

        $query = Vaccine::where('comeback', true);

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // paginate, 10 items per page
        $vaccinesComeback = $query->paginate(10)->appends(['search' => $search]);

        return view('workspace.vaccine.comeback', compact('vaccinesComeback', 'search'));
    }


    public function vaccineStore(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bod' => 'required|date|before_or_equal:today',
            'age' => 'required|integer|min:0',
            'father_name' => 'required|string|max:255',
            'father_phone' => 'required|string|max:20',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'required|string|max:20',
            'carer' => 'nullable|string|max:255',
            'carer_phone' => 'nullable|string|max:20',
            'birth_location' => 'required|string|max:255',
            'current_location' => 'required|string|max:255',
            'vaccine_category_id' => 'required|string',
            'description' => 'required|string',
            'currentDate' => 'required|date',
            'comeback' => 'nullable|string', // checkbox - 'on' or null
        ]);

        // dd("dol");

        $validated['comeback_count'] = 1;

        // Normalize comeback to boolean
        $validated['comeback'] = !empty($validated['comeback']) && $validated['comeback'] === 'on';

        // Create new model instance to bypass mass assignment restrictions
        $vaccine = new Vaccine();
        $vaccine->fill($validated);

        // If comeback is true, set first_come to today
        if ($validated['comeback']) {
            $vaccine->first_come = now()->toDateString(); // e.g., "2025-08-10"
        }

        // Save in Mongo
        $vaccine->save();

        return redirect()->back()->with('success', 'Vaccine record saved successfully.');
    }


    public function index()
    {
        return view('workspace.index');
    }

    public function vaccineIndex(Request $request)
    {
        $search = $request->input('search');

        $query = Vaccine::query();

        // Apply search filter if search term is provided
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('father_name', 'like', '%' . $search . '%')
                  ->orWhere('mother_name', 'like', '%' . $search . '%');
            });
        }

        // Fetch vaccines with pagination, 10 items per page, sorted by latest date
        $vaccines = $query->orderBy('currentDate', 'desc')->paginate(10)->appends(['search' => $search]);

        // Fetch all vaccine categories
        $categories = VaccineCategory::all();

        // Pass both to the view
        return view('workspace.vaccine.index', compact('vaccines', 'categories', 'search'));
    }



    public function commonDiseasesIndex()
    {
        return view('workspace.common-diseases.index');
    }

    public function gynecologyIndex()
    {
        return view('workspace.gynecology.index');
    }

    public function medicineIndex()
    {
        return redirect()->route('workspace.medicine.index');
    }
}
