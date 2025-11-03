<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class GynecologyDisease extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'gynecology_diseases';

    protected $fillable = [
        'name',
    ];
}
