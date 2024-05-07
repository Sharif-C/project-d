<?php

namespace App\Http\Controllers;

use App\Models\Van;
use Illuminate\Http\Request;

class VanController extends Controller
{ 
    public function storeVan(Request $request)
    {
        $newVan = new Van();
        $newVan->licenceplate = $request->licenceplate;

        $newVan->save();
        return redirect()->back()->with("success_van", "Van created successfully");
    }

    public function deleteVan(Request $request)
    {
        $vanId = $request->van_id;
        $van = Van::find($vanId);

        if(!$van) {
            return "Van not found!";
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
