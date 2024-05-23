<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request; 
use Illuminate\Validation\ValidationException;

class WarehouseController extends Controller
{
    public function storeWarehouse(Request $request)
    {
        $newWarehouse = new Warehouse();
        $newWarehouse->name = $request->name;
        $newWarehouse->country = $request->country;
        $newWarehouse->zip_code = $request->zip_code;
        $newWarehouse->street = $request->street;
        $newWarehouse->house_number = $request->house_number;
        $newWarehouse->city = $request->city;
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

        $warehouse->deleteRelatedSerialNumbers();
        $warehouse->delete();
        return redirect()->back()->with("success_delete", "Warehouse deleted successfully");
    }

    public function manageWarehouseView()
    {
        $warehouses = Warehouse::all();
        return view('warehouse.manage', compact('warehouses'));
    }

    public function updateWarehouseView(Request $request, Warehouse $warehouse)
    {
        return view("warehouse.update", compact("warehouse"));
    }


    /**
     * @throws \Throwable
     */
    public function updateWarehouseAction(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            "warehouse_id" => "required|exists:warehouses,_id",
            "name" => "required|string",
            "country" => "required|string",
            "zip_code" => "required|string",
            "street" => "required|string",
            "house_number" => "required|string",
            "city" => "required|string"
        ]);
    
        // Check if the warehouse name already exists (excluding the current warehouse)
        $found = Warehouse::where("name", $request->name)
                          ->where("_id", '!=', $request->warehouse_id)
                          ->exists();
    
        // Throw an exception if the warehouse name is already in use
        throw_if($found, ValidationException::withMessages(["errors"=> "Cannot use this Warehouse name"]));
    
        // Find the warehouse by ID
        $updateWarehouse = Warehouse::find($request->warehouse_id);
    
        // Update the warehouse attributes
        $updateWarehouse->name = $request->name;
        $updateWarehouse->country = $request->country;
        $updateWarehouse->zip_code = $request->zip_code;
        $updateWarehouse->street = $request->street;
        $updateWarehouse->house_number = $request->house_number;
        $updateWarehouse->city = $request->city;
    
        // Save the updated warehouse data
        $updateWarehouse->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Warehouse updated!');
    }
    
}
