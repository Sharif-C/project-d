<?php

namespace App\Http\Controllers;

use App\Utils\Api\Enums\ProductLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function moveProductParser(Request $request){
        try{
            $request->validate([
                'location' => "required|string",
            ]);

            $location = $request?->location;

            if(ProductLocation::stringExists($location) === false){
                return response()->json([
                    "status" => "error",
                    "message" => "Please select between locations: warehouse or van",
                    "code" => 422,
                ], 422);
            }

            $vanController = new VanController();

            // from warehouse|van -> van
            if($location === ProductLocation::VAN->value){
                return $vanController->moveProductToVanAPI($request);
            }

            // from van -> warehouse
            if($location === ProductLocation::WAREHOUSE->value)
            {
               return $vanController->moveProductToWarehouseAPI($request);
            }

        }
        catch(ValidationException $ve){
            return response()->json([
                "status" => "error",
                "message" => $ve->validator->errors(),
                "code" => 422,
            ], 422);
        }
    }
}
