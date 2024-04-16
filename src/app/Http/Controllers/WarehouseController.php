<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function storeWarehouse(Request $request)
    {
        $newWarehouse = new Warehouse();
        $newWarehouse->name = "test";
        //$newWarehouse->save();

        return "Done";
    }
}
