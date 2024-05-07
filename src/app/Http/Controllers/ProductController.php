<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function addProductView(){
        $products = Product::select('_id', 'name', 'description', 'created_at', 'updated_at')->get();
        return view('product.manage', compact('products'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|unique:products,name',
            'description' => 'string|nullable',
        ]);

        $data = [
            'name' => strtolower($request->input('name')),
        ];

        if($request->filled('description')){
            $data['description'] = $request->input('description');
        }

        Product::create($data);

        return redirect()->back()->with('success', 'Product added!');
    }

    public function addSerialNumberView(){
        $products = Product::select('_id', 'name', 'serial_numbers')->get();
        $warehouses = Warehouse::select('_id', 'name')->get();

        return view('product.add-serial-number', compact('products','warehouses'));
    }

    public function storeSerialNumber(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'serial_number' => 'required|string|lowercase|unique:products,serial_numbers.serial_number', // TODO
            'warehouse_id' => 'required|string|exists:warehouses,_id',
        ]);

        $product = Product::find($request->input('product_id'));
        $product->addSerialNumber($request->input('serial_number'), $request->input('warehouse_id'));
        $product->save();

        return redirect()->back()->with('success', 'Serial number added!');

    }
    public function deleteProduct(Request $request)
    {
        $productID = $request->input('product_id');
        $product = Product::find($productID);
        if(!$product)
        {
            return "Product not Found";
        }
        $product->delete();
            return redirect()->back()->with("success_delete","Product deleted successful");
    }

    /**
     * @throws ValidationException
     */
    public function deleteSerialNumber(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,_id',
        ]);

        $product_id = $request->input('product_id');
        $serial_number = $request->input('serial_number');

        $serialNumberExists= Product::where('_id',$product_id)->where('serial_numbers.serial_number', $serial_number)->first();
        if(!$serialNumberExists){
            throw ValidationException::withMessages(['errors' => "Serial number '{$serial_number}' not found with the selected product not found."]);
        }

        try {
            $product = Product::find($product_id);
            $deleted = $product->deleteSerialNumber($serial_number);
            if(!$deleted){
                throw ValidationException::withMessages(['errors' => "Serial number '{$serial_number}' could not be deleted."]);
            }

            return redirect()->back()->with('success', "Serial number '$serial_number' deleted!");

        }catch(Exception $e){
            return "error occurred";
        }
    }
}
