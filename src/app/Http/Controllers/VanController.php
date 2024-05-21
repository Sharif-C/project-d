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
        return view("van.update", compact("van"));
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
    public function allocatedSerialnumbersToVan(Request $request)
    {
        $request ->validate([
            "van_id" => "required|exists:vans,_id",
            "product_id" => "required|exists:products,_id",
            "serial_number"=> "required|exists:products.serial_numbers.serial_number",
        ]);
        $addProduct = Product::where("product_id", $request->_id)->where('serial_number', $request->serial_numbers)->exists();

        if(!$addProduct){
            throw ValidationException::withMessages(['errors' => 'Combination not found!']);
        }
        else{
            Product::where('product_id', $request->_id)
                ->where('serial_numbers.serial_number', $request->serial_number)
                ->update([
                    'serial_numbers.$.van_id' => $request->van_id
                ]);
        }
    }
}

