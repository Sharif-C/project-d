<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function storeWarehouse(Request $request)
    {
        $newWarehouse = new Warehouse();
        $newWarehouse->name = "TESt";
        $newWarehouse->save();
        
        return "Warehouse created";
    }

    public static function deleteWarehouse($warehouseName)
    {
        $warehouse = Warehouse::where('name', $warehouseName)->first();
        if(!$warehouse) {
            return "Warehouse not found!";
        }

        $warehouse->delete();
        return "Warehouse deleted!";
    }
}
