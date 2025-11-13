<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CommonDisease extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'common_diseases';

    protected $fillable = [
        'name',
        'physician',
        'age',
        'gender',
        'drug_diagnosis',
        'village',
        'commune',
        'staff_name',
    ];
}


