<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'service_name',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

