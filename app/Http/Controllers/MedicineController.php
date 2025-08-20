<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $stockStatus = $request->input('stock_status');

        $query = Medicine::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('generic_name', 'like', '%' . $search . '%')
                  ->orWhere('manufacturer', 'like', '%' . $search . '%')
                  ->orWhere('batch_number', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if (!empty($category)) {
            $query->where('category', $category);
        }

        // Apply stock status filter
        if (!empty($stockStatus)) {
            switch ($stockStatus) {
                case 'low_stock':
                    $query->lowStock();
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '<=', 0);
                    break;
                case 'expiring_soon':
                    $query->expiringSoon();
                    break;
            }
        }

        $medicines = $query->orderBy('name')->paginate(15)->appends($request->query());

        // Get unique categories for filter
        $categories = Medicine::distinct('category')->pluck('category')->filter()->sort()->values();

        return view('workspace.medicine.index', compact('medicines', 'categories', 'search', 'category', 'stockStatus'));
    }

    public function create()
    {
        $categories = [
            'Antibiotics',
            'Analgesics',
            'Anti-inflammatory',
            'Antihistamines',
            'Antacids',
            'Vitamins',
            'Supplements',
            'Other'
        ];

        $forms = [
            'Tablet',
            'Capsule',
            'Syrup',
            'Injection',
            'Cream',
            'Ointment',
            'Drops',
            'Inhaler',
            'Other'
        ];

        $units = [
            'mg',
            'g',
            'ml',
            'mcg',
            'IU',
            'units'
        ];

        return view('workspace.medicine.create', compact('categories', 'forms', 'units'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'strength' => 'required|string|max:100',
            'unit' => 'required|string|max:20',
            'form' => 'required|string|max:100',
            'manufacturer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'indications' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'dosage_instructions' => 'nullable|string',
            'storage_conditions' => 'nullable|string',
            'expiry_date' => 'required|date|after:today',
            'batch_number' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'requires_prescription' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['requires_prescription'] = $request->has('requires_prescription');

        Medicine::create($data);

        return redirect()->route('workspace.medicine.index')->with('success', 'Medicine added successfully!');
    }

    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('workspace.medicine.show', compact('medicine'));
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);

        $categories = [
            'Antibiotics',
            'Analgesics',
            'Anti-inflammatory',
            'Antihistamines',
            'Antacids',
            'Vitamins',
            'Supplements',
            'Other'
        ];

        $forms = [
            'Tablet',
            'Capsule',
            'Syrup',
            'Injection',
            'Cream',
            'Ointment',
            'Drops',
            'Inhaler',
            'Other'
        ];

        $units = [
            'mg',
            'g',
            'ml',
            'mcg',
            'IU',
            'units'
        ];

        return view('workspace.medicine.edit', compact('medicine', 'categories', 'forms', 'units'));
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'strength' => 'required|string|max:100',
            'unit' => 'required|string|max:20',
            'form' => 'required|string|max:100',
            'manufacturer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'indications' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'dosage_instructions' => 'nullable|string',
            'storage_conditions' => 'nullable|string',
            'expiry_date' => 'required|date',
            'batch_number' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'requires_prescription' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['requires_prescription'] = $request->has('requires_prescription');

        $medicine->update($data);

        return redirect()->route('workspace.medicine.index')->with('success', 'Medicine updated successfully!');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('workspace.medicine.index')->with('success', 'Medicine deleted successfully!');
    }

    public function updateStock(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'stock_quantity' => 'required|integer|min:0',
            'batch_number' => 'required|string|max:100',
            'expiry_date' => 'required|date|after:today'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medicine->update([
            'stock_quantity' => $request->stock_quantity,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date
        ]);

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }

    public function dashboard()
    {
        $totalMedicines = Medicine::count();
        $activeMedicines = Medicine::active()->count();
        $lowStockMedicines = Medicine::lowStock()->count();
        $expiringSoonMedicines = Medicine::expiringSoon()->count();
        $totalValue = Medicine::sum(DB::raw('price * stock_quantity'));

        $recentMedicines = Medicine::latest()->take(5)->get();
        $lowStockList = Medicine::lowStock()->take(10)->get();
        $expiringList = Medicine::expiringSoon()->take(10)->get();

        return view('workspace.medicine.dashboard', compact(
            'totalMedicines',
            'activeMedicines',
            'lowStockMedicines',
            'expiringSoonMedicines',
            'totalValue',
            'recentMedicines',
            'lowStockList',
            'expiringList'
        ));
    }
}
