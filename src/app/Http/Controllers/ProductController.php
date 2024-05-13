<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'name' => $request->input('name'),
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

        return view('product.serial-number.manage', compact('products','warehouses'));
    }

    /**
     * @throws ValidationException
     */
    public function storeSerialNumber(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'serial_number' => 'required|string|lowercase',
            'warehouse_id' => 'required|string|exists:warehouses,_id',
        ]);

        $product_id = $request->input('product_id');
        $serial_number = $request->input('serial_number');

        $this->validateSerialNumber($product_id,$serial_number);

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
            'name' => 'required|string|unique:products,name|max:255',
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

            if($deleted <1){
                throw ValidationException::withMessages(['errors' => "Serial number '{$serial_number}' could not be deleted."]);
            }

            return redirect()->back()->with('success', "Serial number '$serial_number' deleted!");

        }catch(Exception $e){
            return "error occurred";
        }
    }

    public function updateSerialNumberView(Request $request){
        $productId = $request->product_id;
        $serialNumber = $request->serial_number;

        $product = Product::where('_id', $productId)
            ->where('serial_numbers.serial_number', $serialNumber)
            ->project([
                'name' => 1,
                'serial_numbers.$' => 1 ,
            ])
            ->first();

        if(!$product) return redirect()->back();

        $warehouses = Warehouse::all();


        return view('product.serial-number.update', compact('product', 'warehouses'));
    }

    /**
     * @throws ValidationException
     */
    public function updateSerialNumberAction(Request $r){
        $r->validate([
            'product_id' => 'required|exists:products,_id',
            'old_serial_number' => 'required|string|lowercase|exists:products,serial_numbers.serial_number',
            'new_serial_number' => 'required|string|lowercase',
            'warehouse_id' => 'required|string|exists:warehouses,_id',
        ]);

        $product_id = $r->product_id;
        $new_serial_number = Str::slug($r->new_serial_number);
        $old_serial_number = $r->old_serial_number;
        $warehouseId = $r->warehouse_id;

        if($old_serial_number !== $new_serial_number){
            $this->validateSerialNumber($product_id, $new_serial_number);
        }

        $updated = Product::where('_id', $product_id)
            ->where('serial_numbers.serial_number', $old_serial_number)
            ->update(
                ['$set' => [
                    'serial_numbers.$.warehouse_id' => $warehouseId,
                    'serial_numbers.$.serial_number' => $new_serial_number,
                    ]
                ]
            );

        if(empty($updated)){
            throw ValidationException::withMessages(['errors' => "Failed to update serial number."]);
        }

        return to_route('view.serial-number', ['product_id' => $product_id, 'serial_number' => $new_serial_number])->with('success', 'Serial number updated!');
    }

    /**
     * @throws ValidationException
     */
    private function validateSerialNumber(string $product_id, string $serial_number){
        $hasSerialNumber = Product::where('_id', $product_id)->where('serial_numbers.serial_number', $serial_number)->exists();
        if($hasSerialNumber){
            throw ValidationException::withMessages(['errors' => "Serial number $serial_number already exists in this product collection."]);
        }
    }
}
