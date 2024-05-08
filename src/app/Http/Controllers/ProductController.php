<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

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
            'serial_number' => 'required|string|lowercase|unique:products,serial_numbers.serial_number',
            'warehouse_id' => 'required|string|exists:warehouses,_id',
        ]);

        $product = Product::find($request->input('product_id'));
        $product->addSerialNumber($request->input('serial_number'), $request->input('warehouse_id'));
        $product->save();

        return redirect()->back()->with('success', 'Serial number added!');

    }
    public function editProductView(Product $product)
    {
        return view('product.edit-product', compact('product'));
    }
    public function editProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->save();

        return redirect()->back()->with('success', 'Product Update succes!');
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
}
