<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'roles'; // Optional if collection name differs from 'roles'

    protected $fillable = ['name'];
}
