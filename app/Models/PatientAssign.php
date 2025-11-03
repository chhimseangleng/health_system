<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PatientAssign extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'patient_id',
        'assigned_to',
        'assigned_user_id', // New: track which user is assigned
        'assigned_date',
        'payment_type',
        'read_at',          // New: when user first read the assignment
        'processed_at',     // New: when user processed the assignment
        'status',           // New: assignment status
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
        'read_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the patient that this assignment belongs to
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the user that this assignment is assigned to
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Check if the assignment has been read
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if the assignment has been processed
     */
    public function isProcessed()
    {
        return !is_null($this->processed_at);
    }

    /**
     * Mark the assignment as read
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Mark the assignment as processed
     */
    public function markAsProcessed()
    {
        $this->update(['processed_at' => now()]);
    }

    /**
     * Get available assignment types
     */
    public static function getAssignmentTypes()
    {
        return [
            'vaccine',
            'common disease',
            'gynecology',
            'medicine'
        ];
    }

    /**
     * Get available payment types
     */
    public static function getPaymentTypes()
    {
        return [
            'nssf' => 'NSSF Member',
            'cash' => 'Cash',
            'health equity fund' => 'Health Equity Fund',
        ];
    }

    /**
     * Get available statuses
     */
    public static function getStatuses()
    {
        return [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
    }

    /**
     * Clean up orphaned assignments (assignments without valid patients)
     */
    public static function cleanupOrphanedAssignments()
    {
        $orphanedAssignments = self::whereDoesntHave('patient')->get();

        if ($orphanedAssignments->count() > 0) {
            Log::warning('Found orphaned assignments, cleaning up', [
                'count' => $orphanedAssignments->count(),
                'ids' => $orphanedAssignments->pluck('_id')->toArray()
            ]);

            // Delete orphaned assignments
            $orphanedAssignments->each(function ($assignment) {
                $assignment->delete();
            });
        }

        return $orphanedAssignments->count();
    }

    /**
     * Check if this assignment has a valid patient
     */
    public function hasValidPatient()
    {
        return $this->patient !== null;
    }
}
