<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Van;
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
                        'cond' => ['$eq' => ['$$serial.van_id', $vanId]]
                    ]
                ]
            ])
            ->get();


        $products = Product::whereNot('serial_numbers', null)->get()->take(100);
        return view("van.update", compact("van", "relatedProducts", "products"));
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

    /**
     * @throws ValidationException
     */
    public function allocateProductsToVanTest(Request $request, Van $van)
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

            if(!$found){
                throw ValidationException::withMessages(['errors' => 'Combination not found!']);
            }
        }


        for ($i=0; $i<$iterations; $i++){
            $product_id = $product_ids[$i];
            $serial_number = $serial_numbers[$i];
            Product::where('_id', $product_id)
                ->where('serial_numbers.serial_number', $serial_number)
                ->update([
                    'serial_numbers.$.van_id' => $van->_id
                ]);
        }

        return redirect()->back()->with('success', 'Products added to van.');
    }
}

