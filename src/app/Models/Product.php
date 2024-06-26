<?php

namespace App\Models;

use App\Utils\MongoDB\DateTime;
use App\Utils\Product\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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
        $serialNumbers[] = ['serial_number' => $serialNumber, 'warehouse_id' => $warehouseID, 'status' => Status::STORED->value,];
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

    public function getVanLicensePlate(string $van_id){
        $van = Van::find($van_id);
        if(!empty($van)){
            return $van->licenceplate;
        }
    }

    public function warehouse(): Warehouse|null
    {
        $warehouse_id = $this?->serial_numbers[0]['warehouse_id'] ?? null;
        if (empty($warehouse_id)) return null;

        return Warehouse::find($warehouse_id);
    }

    // TODO: implement for multiple selection
    private function futureFeature($product_id){

//        Single first update
        //        DB::collection('products')
        //            ->where('_id', $product_id)
        //            ->whereIn('serial_numbers.serial_number', ["2"])
        //            ->update(
        //                ['$set' => ['serial_numbers.$.warehouse_id' => 8888]]
        //            );


        $newWarehouseId = 78;

        $update = ['$set' => ['serial_numbers.$[sid].warehouse_id' => $newWarehouseId]];
        $filters = ['arrayFilters' => [['sid.serial_number' => ['$in' => ["3", "2"]]]]];

        $result = Product::where('_id', $product_id)
            ->update(
                $update,
                $filters
            );
    }

    public static function historyLog(string $log, string $serialNumber, string $p_Id)
    {
        self::where('_id', $p_Id)->where('serial_numbers.serial_number', $serialNumber)
        ->push('serial_numbers.$.history', [
            'text' => $log,
            'created_at' => DateTime::current()
        ]);
    }

    /**
     * @throws \Throwable
     */
    public static function throwIfInstalled(string $product_id, string $serial_number){

        $product = self::where('_id', $product_id)
            ->where('serial_numbers.serial_number', $serial_number)
            ->project([
                'name' => 1,
                'serial_numbers.$' => 1 ,
            ])
            ->first();
        $status = $product['serial_numbers'][0]['status'] ?? false;

        throw_if($status === Status::INSTALLED->value, ValidationException::withMessages(['errors' => 'This product is already installed. It can no longer be updated.']));

    }
}
