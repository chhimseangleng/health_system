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
            $query->where(function ($q) use ($search) {
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
                case 'out of stock':
                    $query->where('stock_quantity', '<=', 0);
                    break;
                case 'expiring_soon':
                    $query->expiringSoon();
                    break;
            }
        }

        $medicines = Medicine::orderBy('created_at', 'desc')->paginate(10);
        // Get unique categories for filter
        $categories = Medicine::distinct('category')->pluck('category')->filter()->sort()->values();

        // For bulk dispense suggestions
        $allMedicines = Medicine::orderBy('name')->get(['_id', 'name', 'stock_quantity']);

        return view('workspace.medicine.index', compact('medicines', 'categories', 'search', 'category', 'stockStatus', 'allMedicines'));
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
        // Ensure numeric storage for stock-related fields
        if (isset($data['stock_quantity'])) {
            $data['stock_quantity'] = (int) $data['stock_quantity'];
        }
        if (isset($data['minimum_stock'])) {
            $data['minimum_stock'] = (int) $data['minimum_stock'];
        }

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




    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('workspace.medicine.index')->with('success', 'Medicine deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'manufacturer' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:50',
            'unit' => 'nullable|string|max:50',
            'form' => 'nullable|string|max:50',
            'stock_quantity' => 'required|numeric|min:0',
            'minimum_stock' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $medicine->update($validated);

        return redirect()->route('workspace.medicine.index')->with('success', 'Medicine updated successfully!');
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

    public function dispense(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $qty = (int) $request->input('quantity');

        if ($qty > $medicine->stock_quantity) {
            return redirect()->back()->withErrors([
                'quantity' => 'Insufficient stock. Available: ' . (int) $medicine->stock_quantity
            ])->withInput();
        }

        // Normalize stock to integer before atomic decrement to avoid $inc on string type
        Medicine::where('_id', (string) $medicine->_id)->update(['stock_quantity' => (int) $medicine->stock_quantity]);
        // Atomically decrement
        Medicine::where('_id', (string) $medicine->_id)->decrement('stock_quantity', $qty);

        return redirect()->back()->with('success', 'Dispensed ' . $qty . ' from ' . $medicine->name . '.');
    }

    public function bulkDispense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $items = $request->input('items', []);

        // Aggregate quantities per medicine
        $requiredByMedicineId = [];
        foreach ($items as $item) {
            $id = (string) ($item['medicine_id'] ?? '');
            $qty = (int) ($item['quantity'] ?? 0);
            if ($id === '' || $qty <= 0) {
                continue;
            }
            if (!isset($requiredByMedicineId[$id])) {
                $requiredByMedicineId[$id] = 0;
            }
            $requiredByMedicineId[$id] += $qty;
        }

        if (empty($requiredByMedicineId)) {
            return redirect()->back()->withErrors(['items' => 'Please add at least one medicine to dispense.'])->withInput();
        }

        // Fetch stocks
        $medicineIds = array_keys($requiredByMedicineId);
        $medicines = Medicine::whereIn('_id', $medicineIds)->get(['_id', 'name', 'stock_quantity']);
        $availableById = [];
        foreach ($medicines as $m) {
            $availableById[(string) $m->_id] = (int) ($m->stock_quantity ?? 0);
        }

        $errors = [];
        foreach ($requiredByMedicineId as $id => $req) {
            $available = $availableById[$id] ?? null;
            if ($available === null) {
                $errors[] = 'Medicine not found: #' . $id;
                continue;
            }
            if ($available < $req) {
                $name = optional($medicines->firstWhere('_id', $id))->name ?? ('#' . $id);
                $errors[] = 'Insufficient stock for ' . $name . ' (need ' . $req . ', available ' . $available . ').';
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Decrement stocks with normalization to integer first
        foreach ($requiredByMedicineId as $id => $req) {
            $current = $availableById[$id] ?? 0;
            Medicine::where('_id', $id)->update(['stock_quantity' => (int) $current]);
            Medicine::where('_id', $id)->decrement('stock_quantity', (int) $req);
        }

        return redirect()->back()->with('success', 'Medicines dispensed successfully.');
    }

    public function updateStock(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $qty = (int) $request->input('quantity');

        // Normalize current stock to integer to avoid $inc on string type in Mongo
        Medicine::where('_id', (string) $medicine->_id)->update(['stock_quantity' => (int) ($medicine->stock_quantity ?? 0)]);
        // Atomically increment stock
        Medicine::where('_id', (string) $medicine->_id)->increment('stock_quantity', $qty);

        return redirect()->back()->with('success', 'Added ' . $qty . ' to ' . $medicine->name . '.');
    }
}
