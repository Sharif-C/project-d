<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @mixin \Eloquent
 *
 **/

class Van extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vans';
    protected $fillable = ['licenceplate'];

}
