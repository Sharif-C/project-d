<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Utils\MongoDB\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function addComment(Request $request, Product $product){

        $request->validate([
            'text' => 'required|string|max:255',
            'serial_number' => 'required|string|lowercase'
            ]);

        $this->validateSerialNumber(product_id: $product->id, serial_number: $request->input('serial_number'), mustExist: true);

        $product->where('serial_numbers.serial_number', $request->input('serial_number'))
            ->push('serial_numbers.$.comments', [
                'id' => Str::uuid()->toString(),
                'user' => env('USER_NAME', "HR user"),
                'role' => env('USER_ROLE', "Admin"),
                'text' => $request->input('text'),
                'created_at' => DateTime::current()
            ]);

        return redirect()->back()->with('success_comment_add', 'Comment added successfully.');
    }
    public function deleteComment(Request $request){
        $product_id = $request->product_id;
        $comment_id = $request->comment_id;
        $serial_number = $request->serial_number;

        $delete_to_mongodb = Product::where('_id', $product_id)
            ->where('serial_numbers.serial_number', $serial_number)
            ->pull('serial_numbers.$.comments', ['id' => $comment_id]);

        if($delete_to_mongodb < 1){
            return "nothing found";
        }

        return redirect()->back()->with('success_comment', 'Comment deleted!');
    }

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

    /**
     * @throws ValidationException
     */
    public function editProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $found = Product::where("name",$request->name)->whereNot("_id",$product->_id)->exists();
        if ($found){
            throw ValidationException::withMessages(["errors"=> "Can not use this name!"]);
        }

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

        $product = Product::where('_id', $product_id)
        ->where('serial_numbers.serial_number', $old_serial_number)
        ->project([
            'name' => 1,
            'serial_numbers.$' => 1,
        ])
        ->first();

        $old_warehouse_id = $product->serial_numbers[0]['warehouse_id'] ?? null;

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

        //TODO:  Loggen van warehouse if old_warehouse_id != new_warehouse_id
        if ($old_warehouse_id != null && $old_warehouse_id != $warehouseId) {
            $warehouse = Warehouse::find($warehouseId);
            $old_warehouse = Warehouse::find($old_warehouse_id);
            $log = "{$product->name} with serial number {$new_serial_number} moved from {$old_warehouse->name} to {$warehouse->name}";
            Product::historyLog($log, $new_serial_number, $product_id);
        }
        return to_route('view.serial-number', ['product_id' => $product_id, 'serial_number' => $new_serial_number])->with('success', 'Serial number updated!');
    }

    /**
     * @throws ValidationException
     */

    private function validateSerialNumber(string $product_id, string $serial_number, bool $mustExist = false){
        $hasSerialNumber = Product::where('_id', $product_id)->where('serial_numbers.serial_number', $serial_number)->exists();

//        throws error when serial numbers exists
        if($hasSerialNumber && $mustExist === false){
            throw ValidationException::withMessages(['errors' => "Serial number $serial_number already exists in this product collection."]);
        }
//      throws error when serial number does not exist
        if(!$hasSerialNumber && $mustExist === true){
            throw ValidationException::withMessages(['errors' => "Given serial number not found in product collection."]);
        }
    }
}
