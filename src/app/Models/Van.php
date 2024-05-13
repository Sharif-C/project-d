<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;



class Van extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vans';
    protected $fillable = ['licenceplate', 'serialnumber-list'];

}
