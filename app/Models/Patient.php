<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Patient extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'vaccine_info_complete',
        'common_disease_info_complete',
        'vaccine_additional_data',
        'common_disease_additional_data',
        'history',
    ];

    // Role constants for consistency (moved to PatientAssign)
    const ROLE_VACCINE = 'vaccine';
    const ROLE_COMMON_DISEASE = 'common disease';
    const ROLE_GYNECOLOGY = 'gynecology';
    const ROLE_MEDICINE = 'medicine';

    // Available roles
    public static function getRoles()
    {
        return [
            self::ROLE_VACCINE,
            self::ROLE_COMMON_DISEASE,
            self::ROLE_GYNECOLOGY,
            self::ROLE_MEDICINE,
        ];
    }

    /**
     * Check if a patient already exists based on basic information
     */
    public static function findExistingPatient($firstName, $lastName, $phone, $dateOfBirth)
    {
        return self::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('phone', $phone)
            ->where('date_of_birth', $dateOfBirth)
            ->first();
    }

    /**
     * Search patients by name or phone
     */
    public static function searchPatients($searchTerm)
    {
        return self::where(function($query) use ($searchTerm) {
            $query->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
        })->get();
    }

    /**
     * Debug method to check if patient exists and has data
     */
    public static function debugPatient($id)
    {
        try {
            $patient = self::find($id);

            if (!$patient) {
                return [
                    'exists' => false,
                    'message' => 'Patient not found in database',
                    'id' => $id
                ];
            }

            return [
                'exists' => true,
                'id' => $patient->_id,
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
                'phone' => $patient->phone,
                'address' => $patient->address,
                'date_of_birth' => $patient->date_of_birth,
                'gender' => $patient->gender,
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at
            ];
        } catch (\Exception $e) {
            return [
                'exists' => false,
                'error' => $e->getMessage(),
                'id' => $id
            ];
        }
    }

    /**
     * Get all assignments for this patient
     */
    public function assignments()
    {
        return $this->hasMany(PatientAssign::class);
    }

    /**
     * Get the current active assignment
     */
    public function currentAssignment()
    {
        return $this->assignments()->latest()->first();
    }

    /**
     * Get the current role from the latest assignment
     */
    public function getCurrentRoleAttribute()
    {
        $assignment = $this->currentAssignment();
        return $assignment ? $assignment->assigned_to : null;
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Add a history entry to the patient's history array
     */
    public function addHistoryEntry($type, $data, $staffName = null)
    {
        $history = $this->history ?? [];

        $entry = [
            'id' => uniqid(),
            'type' => $type, // 'vaccine' or 'common_disease'
            'date' => now()->toDateString(),
            'timestamp' => now()->toISOString(),
            'staff_name' => $staffName ?? 'Unknown',
            'data' => $data
        ];

        $history[] = $entry;

        $this->update(['history' => $history]);

        return $entry;
    }

    /**
     * Get history entries by type
     */
    public function getHistoryByType($type)
    {
        $history = $this->history ?? [];
        return array_filter($history, function($entry) use ($type) {
            return $entry['type'] === $type;
        });
    }

    /**
     * Get all history entries sorted by date (newest first)
     */
    public function getHistory()
    {
        $history = $this->history ?? [];
        usort($history, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        return $history;
    }

    /**
     * Get the latest history entry
     */
    public function getLatestHistoryEntry()
    {
        $history = $this->getHistory();
        return !empty($history) ? $history[0] : null;
    }
}
