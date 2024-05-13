<?php

namespace App\Http\Controllers;

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
}
