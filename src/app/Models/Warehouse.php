<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'warehouses';
    protected $fillable = ['name', 'address', 'city', 'zip_code', 'country', 'street', 'house_number'];

    public function serialNumbers() : HasMany
    {
        return $this->hasMany(Product::class, 'serial_numbers.warehouse_id', '_id');
    }

    public function GetAddress(): string
    {
        return "$this->street $this->house_number, $this->zip_code $this->city, $this->country";
    }

    public function deleteRelatedSerialNumbers()
    {
        $products = Product::where('serial_numbers.warehouse_id', $this->_id)->get();

        foreach ($products as $product) {
            $collection = collect($product->serial_numbers);

            $filtered = $collection->reject(function ($value, $key) {
                $warehouseID = $value['warehouse_id'] ?? null;
                return !empty($warehouseID) && $warehouseID === $this->_id;
            });

            $product->serial_numbers = $filtered->all();
            $product->save();
        }
    }

}
