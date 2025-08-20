<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Patient;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some patients to assign services to
        $patients = Patient::all();

        if ($patients->count() > 0) {
            $services = [
                'General Checkup',
                'Vaccination',
                'Blood Test',
                'X-Ray',
                'Dental Cleaning',
                'Eye Exam',
                'Physical Therapy',
                'Consultation',
                'Follow-up Visit',
                'Emergency Care'
            ];

            foreach ($patients as $patient) {
                // Create 2-4 random services for each patient
                $numServices = rand(2, 4);
                $selectedServices = array_rand(array_flip($services), $numServices);

                if (!is_array($selectedServices)) {
                    $selectedServices = [$selectedServices];
                }

                foreach ($selectedServices as $serviceName) {
                    Service::create([
                        'service_name' => $serviceName,
                        'patient_id' => $patient->_id,
                        'service_date' => now()->subDays(rand(1, 30)),
                        'status' => ['pending', 'completed', 'cancelled'][rand(0, 2)],
                        'notes' => rand(0, 1) ? 'Sample notes for ' . $serviceName : null
                    ]);
                }
            }
        }
    }
}
