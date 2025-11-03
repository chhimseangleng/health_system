<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Gynecology extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'gynecology';

    protected $fillable = [
        'patient_id',
        'disease_id',
        'disease_name',
        'symptoms',
        'medication',
        'prescriptions',
        'notes',
        'treatment_date',
        'staff_name',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', '_id');
    }
}
