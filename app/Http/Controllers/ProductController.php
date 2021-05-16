<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\models\Seller;
use App\Models\Order;


class ProductController extends Controller
{


  public function showAllProducts()
  {
    return Product::all();
  }





    public function ShowSellerProducts()
    {
        $products = auth()->user()->products;

        return response()->json($products);
    }




    public function ShowCustomProduct(Product $product)
    {

        if (!$product) {
            return response()->json('sorry', 400);
        }

          return $product;
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|min:1',
            'desc' => 'required',
            'image' => 'required'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'desc' => $request->desc,
            'image' => $request->image

        ]);

        if (auth()->user()->products()->save($product))
            return $product;
        else
            return response()->json('sorry', 500);
    }



    public function update(Request $request, Product $product)
    {

      if(auth()->id() != $product->seller_id){
        return response()->json('access denied', 403);
      }

        $updated = $product->fill($request->all())->save();

        if ($updated)
            return response()->json('done'
            //     [
            //     'success' => true
            // ]
        );
        else
            return response()->json('sorry'
            //     [
            //     'success' => false,
            //     'message' => 'Product could not be updated'
            // ]
            , 500);
    }







    public function destroy(Product $product)
    {
      //  $product = auth()->user()->products()->find($id);
      //  return $product;



        if(auth()->id() != $product->seller_id){
          return response()->json('access denied', 403);
        }
        if ($product->delete()) {
            return response()->json('Product deleted');
        } else {
            return response()->json('sorry you didnt delete', 500);
        }
    }


}
