<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{

    var $branch;
    function __construct(Request $request)
    {
        $this->branch = $request->header('branch');
    }
    public function index()
    {
        $products = Auth::user()->company->products()->get();
        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {
        $res = $request->validate([
            'name' => ['required', 'max:255'],
            //'image' => ['nullable', 'image', 'max:5000'],
            'costprice' => ['integer', 'min:0'],
            'sellingprice' => ['integer', 'min:0'],
            'alert_level' => ['integer', 'min:0', 'required']
        ]);

        // if (!is_string($request->image) && !empty($request->image)) {
        //     $image_path = $request->image->store('public/products');
        // } else {
        //     $image_path = '';
        // }

        $user = Auth::user();

        $newProduct = $user->company->products()->create([

            'name' => $request->name,
            'sku' => $request->sku,
            'costprice' => $request->costprice,
            'sellingprice' => $request->sellingprice,
            'alert_level' => $request->alert_level,
            //'type' => $request->type,
            'units' => $request->unit,
            'image' => $request->image

        ]);

        if ($request->addStock) {
            $payload = [
                'qty' => $request->new_quantity,
                'type' => 1,
                'reason' => 'Stock added from product page'
            ];

            $stock = Stock::newStock($payload, $newProduct->id, $this->branch);
        }else{
            $stock = [];
        }

        //$stock = Stock::getQuantity($newProduct->id);
        return response(['product' => $newProduct, 'stock'=>$stock]);
    }


    public function updateProduct(Request $request)
    {     
        //return response()->json(['data' => $request->new_quantity]);
        $product = Product::find($request->id);

        if ($request->updatePrice) {
            $product->update([
                'sellingprice' => $request->sellingprice,
                'costprice' => $request->costprice
            ]);
        }
        
        if ($request->update) {

            // if (!is_string($request->image) && !empty($request->image)) {
            //     $image_path = $request->image->store('public/products');
            // } else {
                $image_path = $request->image;
            //}
    
            $product->update([
                'sku' => $request->sku,
                'name' => $request->name,
                'costprice' => $request->costprice,
                'sellingprice' => $request->sellingprice,
                'alert_level' => $request->alert_level,
                'type' => $request->type,
                'units' => $request->unit,
                'image' => $image_path,
            ]);
        }

       //return response($product->stocks()->create());
        if ($request->addStock) {
            $stockId = '#' . Auth::user()->company->id . substr(time(), 0, 5);
            $product->stocks()->create([
                'qty' => $request->new_quantity,
                'branch_id' => Auth::user()->branch->id,
                'company_id' => Auth::user()->company->id,
                'type' => 1,
                'stockId' => $stockId,
                'registered_by' => Auth::user()->id
            ]);
        }
        
        //$stock = Stock::getQuantity($product->id);
        return response(['product' => $product]);
    }

    public function destroy(Request $request, Product $product)
    {

        $product->delete();
        return response()->json('Deleted successfully');
    }

    public function changePrice(Request $request){

        $output = [];
        $products = $request->products;
      //  if(is_array($products) && count($products) > 0){
            foreach($products as $product){
                $change = Product::find($product['id']);
                $change->costprice = $product['costprice'];
                $change->sellingprice = $product['sellingprice'];
                $change->save();

                $output[] = $change->refresh();
            }
        //}

        return response(['message'=>'updated Suceessfully', 'products'=>$output], 200);
    }

    public function search(Request $request){
        $term = $request->searchTerm;

        $products = Auth::user()->company->products()
        ->where('name', 'like', "%$term%")
        ->orWhere('sku', 'LIKE', "%$term%")
        ->orWhere('costprice', 'LIKE', "%$term%")
        ->orWhere('sellingprice', 'LIKE', "%$term%")
        ->orWhere('units', 'LIKE', "%$term%")
        ->orWhere('sku', 'LIKE', "%$term%")
->get();

// if(count($products) < 0){
//     return $this->index();
// }

return response(['products' => $products]);
    }
}
