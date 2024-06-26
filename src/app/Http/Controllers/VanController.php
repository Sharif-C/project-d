<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Van;
use App\Models\Warehouse;
use App\Utils\Product\Enums\Status;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VanController extends Controller
{
    public function storeVan(Request $request)
    {
        $request->validate([
            'licenceplate' => 'required|string',
        ]);
        $newVan = new Van();
        $newVan->licenceplate = strtoupper($request->licenceplate);

        $newVan->save();
        return redirect()->back()->with("success_van", "Van created successfully");
    }

    /**
     * @throws ValidationException
     */
    public function deleteVan(Request $request)
    {
        $vanId = $request->van_id;
        $van = Van::find($vanId);

        if(!$van) {
            throw ValidationException::withMessages(['errors' => 'ID not found.']);
        }
        // TODO -> delete related serialnumbers
        $van->delete();
        return redirect()->back()->with("success_delete", "Van deleted successfully!");
    }

    public function manageVanView()
    {
        $vans = Van::get();
        return view('van.manage', compact('vans'));
    }

    public function updateVanView(Request $request, Van $van)
    {
        $vanId = $van->_id;
        $relatedProducts = Product::where('serial_numbers.van_id', $vanId)
            ->project([
                '_id' => 1,
                'created_at' => 1,
                'updated_at' => 1,
                'name' => 1,
                'description' => 1,
                'serial_numbers' => [
                    '$filter' => [
                        'input' => '$serial_numbers',
                        'as' => 'serial',
                        'cond' => [
                            '$and' => [
                                ['$ne' => ['$$serial.status', Status::INSTALLED->value]],
                            ]
                        ]
                    ]
                ]
            ])
            ->get();
        $warehouses = Warehouse::all();


        $products = Product::whereNot('serial_numbers', null)
            ->project([
                '_id' => 1,
                'created_at' => 1,
                'updated_at' => 1,
                'name' => 1,
                'description' => 1,
                'serial_numbers' => [
                    '$filter' => [
                        'input' => '$serial_numbers',
                        'as' => 'serial',
                        'cond' => [
                            '$or' => [
                                ['$eq' => ['$$serial.status', Status::STORED->value]],
                                ['$eq' => ['$$serial.status', Status::DISPATCHED->value]],
                            ]
                        ]
                    ]
                ]
            ])
            ->get()
            ->take(100);
        return view("van.update", compact("van", "relatedProducts", "products", "warehouses"));
    }

    /**
     * @throws \Throwable
     */
    public function updateVanAction(Request $request)
    {
        $request ->validate([
            "van_id" => "required|exists:vans,_id",
            "license_plate" => "required|string"
        ]);

        $found = Van::where("licenceplate", $request->license_plate)->whereNot("_id",$request->van_id)->exists();

        throw_if($found, ValidationException::withMessages(["errors"=> "Can not use this license plate!"]));

        $updateVan = Van::find($request->van_id);
        $updateVan->licenceplate = strtoupper($request->license_plate);
        $updateVan->save();

        return redirect()->back()->with('success', 'Van updated!');
    }

    public function moveProductToWarehouse(Request $request){
        $request->validateWithBag('moveProductToWarehouse',[
            'warehouse_id' => "required|string|exists:warehouses,_id",
            'serial_number' => "required|string|exists:products,serial_numbers.serial_number",
            'product_id' => "required|string|exists:products,_id",
        ]);


        $saved = $this->detachProductFromVan($request->product_id, $request->serial_number, $request->warehouse_id);
        throw_if(empty($saved), ValidationException::withMessages(["moveProductToWarehouse" => "Failed to move product to warehouse."])->errorBag('moveProductToWarehouse'));


        return redirect()->back()->with('success', "Moved product to warehouse.");
    }

    /**
     * @throws \Throwable
     */
    private function detachProductFromVan(string $product_id, string $serial_number, string $warehouse_id) : bool|int{
        Product::throwIfInstalled($product_id, $serial_number);

        $product = Product::where('_id', $product_id)
        ->where('serial_numbers.serial_number', $serial_number)
        ->project([
            'name' => 1,
            'serial_numbers.$' => 1,
            ])
        ->first();
        $old_van_id = $product->serial_numbers[0]['van_id'];

        $updatedRows = Product::where('_id', $product_id)
            ->where('serial_numbers.serial_number', $serial_number)
            ->update([
                '$unset' => [
                    'serial_numbers.$.van_id' => 1
                ],
                '$set' => [
                    'serial_numbers.$.warehouse_id' => $warehouse_id,
                    'serial_numbers.$.status' => Status::STORED->value,
                ]
            ]);

        $saved = !empty($updatedRows);

        if($saved)
        {
            $warehouse = Warehouse::select('name')->find($warehouse_id);
            $old_van = Van::select('licenceplate')->find($old_van_id);
            $log = "$product->name with serial number $serial_number moved from $old_van->licenceplate to $warehouse->name 🚚➡️📦";
            Product::historyLog($log,$serial_number,$product_id);
        }

        return $updatedRows;
    }

    /**
     * @throws ValidationException
     * @throws \Throwable
     */
    public function allocateProductsToVan(Request $request, Van $van)
    {
        $request->validate([
            "selection" => "required|array",
            "selection.product_id" => "required|array",
            "selection.serial_number" => "required|array",
            "selection.product_id.*" => "required|exists:products,_id",
            "selection.serial_number.*" => "required|exists:products,serial_numbers.serial_number",
        ]);

        $selection = $request->input('selection');
        $product_ids = $selection['product_id'];
        $serial_numbers = $selection['serial_number'];
        $iterations = count($product_ids);

        for ($i=0; $i<$iterations; $i++){
            $product_id = $product_ids[$i];
            $serial_number = $serial_numbers[$i];

            $found = Product::where("_id", $product_id)->where('serial_numbers.serial_number', $serial_number)->exists();
            throw_if(!$found, ValidationException::withMessages(['errors' => 'Combination not found!']));
        }

        for ($i=0; $i<$iterations; $i++){
            $product_id = $product_ids[$i];
            $serial_number = $serial_numbers[$i];

            $stored = $this->allocateToVan(product_id: $product_id, serial_number: $serial_number, van_id: $van->_id);
            throw_if(!$stored, ValidationException::withMessages(['errors' => 'Could not move serial-number to van.']));
        }

        return redirect()->back()->with('success', 'Products added to van.');
    }

    /**
     * @throws ValidationException
     * @throws \Throwable
     */
    private function allocateToVan(string $product_id, string $serial_number, string $van_id) : bool{
        Product::throwIfInstalled($product_id, $serial_number);

        // Check if van_id is present
        $product = Product::where('_id', $product_id)
        ->where('serial_numbers.serial_number', $serial_number)
        ->project(['serial_numbers.$' => 1])
        ->first();

        $old_van_id = $product->serial_numbers[0]['van_id'] ?? null;

        $updatedRows = Product::where('_id', $product_id)
            ->where('serial_numbers.serial_number', $serial_number)
            ->update([
                'serial_numbers.$.van_id' => $van_id,
                'serial_numbers.$.status' => Status::DISPATCHED->value,
            ]);

        $saved = !empty($updatedRows);

        if($saved){
            $product = Product::where('_id', $product_id)
                ->where('serial_numbers.serial_number', $serial_number)
                ->project([
                    'name' => 1,
                    'serial_numbers.$' => 1 ,
                ])
                ->first();

            $warehouseId = $product->serial_numbers[0]['warehouse_id'];
            $new_van = Van::select('licenceplate')->find($van_id);

            // FROM VAN TO VAN | IF OLD_VAN != NEW_VAN
            if(!empty($old_van_id) && $old_van_id !== $van_id)
            {
                $old_van = Van::find($old_van_id);
                $log = "$product->name with serial number $serial_number moved from $old_van->licenceplate to $new_van->licenceplate 🚚➡️🚚";
                Product::historyLog($log, $serial_number, $product_id);
            }

            // FROM WAREHOUSE TO VAN | IF VAN_ID == EMPTY
            if(empty($old_van_id))
            {
                $warehouse = Warehouse::select('name')->find($warehouseId);
                $log = "$product->name with serial number $serial_number moved from $warehouse->name to $new_van->licenceplate 📦➡️🚚";
                Product::historyLog($log,$serial_number,$product_id);
            }

        }

        return $saved;
    }

    // API POST ENDPOINT

    // warehouse|van to van
    public function moveProductToVanAPI(Request $request){
        try{
            $request->validate([
                'product_id' => "required|string|exists:products,_id",
                'serial_number' => "required|string|exists:products,serial_numbers.serial_number",
                "van_id" => "required|string|exists:vans,_id",
            ]);
        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }
        try{
            $product_id = $request->product_id;
            $serial_number = $request->serial_number;
            $van_id = $request->van_id;

            Product::throwIfInstalled($product_id, $serial_number);

            $product = Product::find($product_id);
            $van = Van::find($van_id);

            // Check if the product is already in the specified van
            $productInVan = Product::where('_id', $product_id)
                ->where('serial_numbers.serial_number', $serial_number)
                ->where('serial_numbers.van_id', $van_id)
                ->exists();

            if($productInVan){
                return response()->json([
                    "status" => "error",
                    "message" => "Product with serial-number $serial_number is already in van {$van->licenceplate}.",
                    "code" => 422,
                ], 422);
            }

            $stored = $this->allocateToVan(product_id: $product_id, serial_number: $serial_number, van_id: $van_id);
            if(empty($stored)){
                return response()->json([
                    "status" => "error",
                    "message" => "Could not move serial-number to van.",
                    "code" => 422,
                ], 422);
            }

            return response()->json([
                "status" => "success",
                "message" => "Moved {$product->name} with serial-number $serial_number to {$van->licenceplate}",
                "product" => $product->name,
                "serial_number" => $serial_number,
                "located_at_van" => $van_id,
                "code" => 200,
            ]);

        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An unexpected error occurred. Please try again later.",
                "code" => 500,
            ], 500);
        }
    }

    // van to warehouse
    public function moveProductToWarehouseAPI(Request $request)
    {
        try{
            $request->validate([
                'product_id' => "required|string:exists:products,_id",
                'serial_number'=> "required|string|exists:products,serial_numbers.serial_number",
                'warehouse_id'=>"required|string|exists:warehouses,_id",
            ]);
        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }

        try{
            $product_id = $request->product_id;
            $serial_number = $request->serial_number;
            $warehouse_id = $request->warehouse_id;

            Product::throwIfInstalled($product_id, $serial_number);

            $product = Product::where('_id', $product_id)
                ->where('serial_numbers.serial_number', $serial_number)
                ->project([
                    'name' => 1,
                    'serial_numbers.$' => 1 ,
                ])
                ->first();


            if(empty($product->serial_numbers[0]['van_id'] ?? null)){
                return response()->json([
                    "status" => "error",
                    "message" => "In order to transfer serial number '{$serial_number}' to a warehouse, it must first be placed in a van.",
                    "located_at_warehouse" => $product->serial_numbers[0]['warehouse_id'],
                    "code" => 422,
                ], 422);
            }

            $stored = $this->detachProductFromVan(product_id: $product_id, serial_number: $serial_number, warehouse_id: $warehouse_id);
            if(empty($stored)){
                return response()->json([
                    "status" => "error",
                    "message" => "Could not transfer product $product_id with serialnumber $serial_number to warehouse",
                    "code" => 422,
                ], 422);
            }

            $new_located_warehouse = Warehouse::select('name')->find($warehouse_id);

            return response()->json([
                "status" => "success",
                "message" => "Moved product {$product->name} with serial-number {$serial_number} to warehouse {$new_located_warehouse->name}",
                "product" => $product->name,
                "serial_number" => $serial_number,
                "located_at_warehouse" => $warehouse_id,
                "code" => 200,
            ]);
        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An unexpected error occurred. Please try again later",
                "code" => 500,
            ], 500);
        }

    }

    // van to van
    /*
    public function moveProductFromVanToVanAPI(Request $request)
    {
        try{
            $request->validate([
                'product_id' => "required|string|exists:products,_id",
                'serial_number' => "required|string|exists:products,serial_numbers.serial_number",
                "van_id" => "required|string|exists:vans,_id",
            ]);
        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }

        try{
            $product_id = $request->product_id;
            $serial_number = $request->serial_number;
            $van_id = $request->van_id;

            $product = Product::find($product_id);
            $van = Van::find($van_id);

            // Check if the product is already in the specified van
            $productInVan = Product::where('_id', $product_id)
                ->where('serial_numbers.serial_number', $serial_number)
                ->where('serial_numbers.van_id', $van_id)
                ->exists();

            if($productInVan){
                return response()->json([
                    "status" => "error",
                    "message" => "{$product->name} with serial-number $serial_number is already in van {$van->licenceplate}.",
                    "located_at_van" => $van_id,
                    "code" => 422,
                ], 422);
            }

            $stored = $this->allocateToVan(product_id: $product_id, serial_number: $serial_number, van_id: $van_id);
            if(empty($stored)){
                return response()->json([
                    "status" => "error",
                    "message" => "Could not move {$product->name} with serial-number $serial_number to van {$van->licenceplate}.",
                    "code" => 422,
                ], 422);
            }

            return response()->json([
                "status" => "success",
                "message" => "Moved product {$product->name} with serialnumber $serial_number to van {$van->licenceplate}",
                "product" => $product->name,
                "serial_number" => $serial_number,
                "located_at_van" => $van_id,
                "code" => 200,
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An unexpected error occured. Please try again later",
                "code" => 500,
            ], 500);
        }
    }
    */
}
