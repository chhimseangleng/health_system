<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'category' => 'Analgesics',
                'strength' => '500',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Pfizer',
                'description' => 'Pain reliever and fever reducer',
                'indications' => 'Used to treat mild to moderate pain and reduce fever',
                'contraindications' => 'Allergy to paracetamol, severe liver disease',
                'side_effects' => 'Nausea, stomach upset, allergic reactions',
                'dosage_instructions' => 'Take 1-2 tablets every 4-6 hours as needed',
                'storage_conditions' => 'Store in a cool, dry place below 25°C',
                'expiry_date' => now()->addYears(2),
                'batch_number' => 'BT2024001',
                'price' => 5.99,
                'stock_quantity' => 150,
                'minimum_stock' => 20,
                'is_active' => true,
                'requires_prescription' => false
            ],
            [
                'name' => 'Amoxicillin',
                'generic_name' => 'Amoxicillin',
                'category' => 'Antibiotics',
                'strength' => '250',
                'unit' => 'mg',
                'form' => 'Capsule',
                'manufacturer' => 'GlaxoSmithKline',
                'description' => 'Broad-spectrum antibiotic',
                'indications' => 'Used to treat bacterial infections',
                'contraindications' => 'Allergy to penicillin, mononucleosis',
                'side_effects' => 'Diarrhea, nausea, rash',
                'dosage_instructions' => 'Take 1 capsule 3 times daily',
                'storage_conditions' => 'Store in refrigerator, keep dry',
                'expiry_date' => now()->addYear(),
                'batch_number' => 'BT2024002',
                'price' => 12.50,
                'stock_quantity' => 75,
                'minimum_stock' => 15,
                'is_active' => true,
                'requires_prescription' => true
            ],
            [
                'name' => 'Ibuprofen',
                'generic_name' => 'Ibuprofen',
                'category' => 'Anti-inflammatory',
                'strength' => '400',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Bayer',
                'description' => 'Non-steroidal anti-inflammatory drug',
                'indications' => 'Used to reduce pain, fever, and inflammation',
                'contraindications' => 'Stomach ulcers, kidney disease, pregnancy (3rd trimester)',
                'side_effects' => 'Stomach upset, dizziness, headache',
                'dosage_instructions' => 'Take 1-2 tablets every 4-6 hours with food',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYears(3),
                'batch_number' => 'BT2024003',
                'price' => 8.75,
                'stock_quantity' => 200,
                'minimum_stock' => 25,
                'is_active' => true,
                'requires_prescription' => false
            ],
            [
                'name' => 'Vitamin C',
                'generic_name' => 'Ascorbic Acid',
                'category' => 'Vitamins',
                'strength' => '1000',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Nature Made',
                'description' => 'Essential vitamin for immune system support',
                'indications' => 'Used to prevent vitamin C deficiency',
                'contraindications' => 'Kidney stones, iron overload',
                'side_effects' => 'Diarrhea, stomach upset',
                'dosage_instructions' => 'Take 1 tablet daily with food',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYears(2),
                'batch_number' => 'BT2024004',
                'price' => 15.99,
                'stock_quantity' => 100,
                'minimum_stock' => 15,
                'is_active' => true,
                'requires_prescription' => false
            ],
            [
                'name' => 'Omeprazole',
                'generic_name' => 'Omeprazole',
                'category' => 'Antacids',
                'strength' => '20',
                'unit' => 'mg',
                'form' => 'Capsule',
                'manufacturer' => 'AstraZeneca',
                'description' => 'Proton pump inhibitor for acid reflux',
                'indications' => 'Used to treat acid reflux and stomach ulcers',
                'contraindications' => 'Allergy to omeprazole, pregnancy',
                'side_effects' => 'Headache, diarrhea, abdominal pain',
                'dosage_instructions' => 'Take 1 capsule daily before breakfast',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYear(),
                'batch_number' => 'BT2024005',
                'price' => 25.50,
                'stock_quantity' => 50,
                'minimum_stock' => 10,
                'is_active' => true,
                'requires_prescription' => true
            ],
            [
                'name' => 'Cetirizine',
                'generic_name' => 'Cetirizine',
                'category' => 'Antihistamines',
                'strength' => '10',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Johnson & Johnson',
                'description' => 'Non-drowsy antihistamine for allergies',
                'indications' => 'Used to treat seasonal allergies and hives',
                'contraindications' => 'Allergy to cetirizine, kidney disease',
                'side_effects' => 'Drowsiness, dry mouth, headache',
                'dosage_instructions' => 'Take 1 tablet daily',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYears(2),
                'batch_number' => 'BT2024006',
                'price' => 18.75,
                'stock_quantity' => 80,
                'minimum_stock' => 15,
                'is_active' => true,
                'requires_prescription' => false
            ],
            [
                'name' => 'Calcium Carbonate',
                'generic_name' => 'Calcium Carbonate',
                'category' => 'Supplements',
                'strength' => '500',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Nature\'s Bounty',
                'description' => 'Calcium supplement for bone health',
                'indications' => 'Used to prevent calcium deficiency',
                'contraindications' => 'High calcium levels, kidney stones',
                'side_effects' => 'Constipation, gas, bloating',
                'dosage_instructions' => 'Take 1-2 tablets daily with food',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYears(3),
                'batch_number' => 'BT2024007',
                'price' => 12.99,
                'stock_quantity' => 120,
                'minimum_stock' => 20,
                'is_active' => true,
                'requires_prescription' => false
            ],
            [
                'name' => 'Metformin',
                'generic_name' => 'Metformin',
                'category' => 'Other',
                'strength' => '500',
                'unit' => 'mg',
                'form' => 'Tablet',
                'manufacturer' => 'Merck',
                'description' => 'Oral diabetes medication',
                'indications' => 'Used to control blood sugar in type 2 diabetes',
                'contraindications' => 'Kidney disease, heart failure, pregnancy',
                'side_effects' => 'Nausea, diarrhea, stomach upset',
                'dosage_instructions' => 'Take 1 tablet twice daily with meals',
                'storage_conditions' => 'Store in a cool, dry place',
                'expiry_date' => now()->addYear(),
                'batch_number' => 'BT2024008',
                'price' => 35.00,
                'stock_quantity' => 60,
                'minimum_stock' => 10,
                'is_active' => true,
                'requires_prescription' => true
            ]
        ];

        foreach ($medicines as $medicineData) {
            Medicine::create($medicineData);
        }
    }
}
