<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Eloquent\Model;


/**
 * @mixin \Eloquent
 * Product Model
 * @property string $name The name of the product
 * @property string $description The description of the product
 * @property array $serial_numbers Array containing serial numbers and corresponding warehouse IDs
 *     [
 *        @type array [
 *             @type string $serial_number 'serial_number' => (string) The serial number of the product,
 *             @type string $warehouse_id 'warehouse_id' => (string) The ID of the warehouse where the product is stored
 *         ],
 *         ...
 *     ]
 */



class Product extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'products';
    protected $fillable = ['name', 'description', 'serial_numbers']; // serial_numbers [{serial_number: 'val', warehouse_id : 'id'}]

    public function addSerialNumber(string $serialNumber, string $warehouseID)
    {
        $serialNumbers = $this->serial_numbers ?? [];
        $serialNumbers[] = ['serial_number' => $serialNumber, 'warehouse_id' => $warehouseID];
        $this->serial_numbers = $serialNumbers;
    }

    public function deleteSerialNumber(string $serialNumber) : int{
        $serialNumbers = $this?->serial_numbers;

        if(empty($serialNumbers)){
            return false;
        }

        $deletedAmount = DB::collection('products')
            ->where('_id', $this->_id)
            ->pull('serial_numbers', ['serial_number' => $serialNumber]);

        return $deletedAmount;
    }

    public function getWarehouseName(string $warehouse_id){
        $warehouse = Warehouse::find($warehouse_id);
        if(!empty($warehouse)){
            return $warehouse->name;
        }
    }

}
