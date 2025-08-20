<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VaccineCategory extends Model
{
     protected $connection = 'mongodb';

    protected $collection = 'vaccineCategory';

    protected $fillable = [
        'name',
        'dose',
    ];

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class, 'vaccine_category_id', '_id');
    }
}
