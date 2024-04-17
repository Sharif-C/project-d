<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'warehouses';
    protected $fillable = ['name', 'address', 'city', 'zip_code', 'country', 'street', 'house_number'];

    public function GetAddress()
    {

        return "$this->street $this->house_number, $this->zip_code $this->city, $this->country";
    }

}
