<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Patient extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'first_name',
        'last_name',
        'carer',
        'carer_phone',
        'phone',
        'address',
        'date',
        'date_of_birth',
        'gender',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
