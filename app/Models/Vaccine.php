<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Vaccine extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'vaccines'; // Optional if collection name differs from 'roles'

    protected $fillable = [
        'name',
        'bod',
        'age',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'carer',
        'carer_phone',
        'birth_location',
        'current_location',
        'vaccine_category_id',
        'description',
        'currentDate',
        'comeback', // Add this line
        'comeback_count',
        'complete',
    ];

   // In Vaccine model
public function vaccineCategory()
{
    return $this->belongsTo(VaccineCategory::class, 'vaccine_category_id', '_id');
}

}
