<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function storeWarehouse(Request $request)
    {
        $newWarehouse = new Warehouse();
        $newWarehouse->name = $request->name;
        $newWarehouse->save();
        
        return redirect()->back()->with("success_add", "Warehouse created successfully");    
    }

    public function deleteWarehouse(Request $request)
    {
        $warehouseId = $request->warehouse_id; 
        $warehouse = Warehouse::find($warehouseId); 
        if(!$warehouse) {
            return "Warehouse not found!";
        }
    
        $warehouse->delete();
        return redirect()->back()->with("success_delete", "Warehouse deleted successfully");
    }

    public function manageWarehouseView()
    {
        $warehouses = Warehouse::all();
        return view('warehouse.manage', compact('warehouses'));
    }
}
