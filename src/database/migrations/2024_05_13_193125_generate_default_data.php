<?php

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
