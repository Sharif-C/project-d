<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\post;


class GenerateController extends Controller
{
    public function createWarehouses()
    {
        $warehouses = json_decode(Storage::get('/test-data/warehouses.json'));
        foreach ($warehouses as $warehouse) {
            Warehouse::create([
                'name' => $warehouse->name,
                'city' => $warehouse->city,
                'zip_code' => $warehouse->zip_code,
                'country' => $warehouse->country,
                'street' => $warehouse->street,
                'house_number' => $warehouse->house_number,
            ]);
        }

        $products = json_decode(Storage::get('/test-data/products.json'));
        foreach ($products as $product){
            Product::create([
                'name' => $product->name,
                'description'  => $product->description,
            ]);
        }

        return 'done';
    }
}
