<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'service_name',
        'patient_id',
        'service_date',
        'notes',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

