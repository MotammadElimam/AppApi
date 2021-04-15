<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
         {
             \DB::transactionBegin();

             $order = new Order();

             $order->user_id = auth()->user->id;
             $order->address= $request->address;

             $order_save = $order->save();

             if(!$order_save){
                 \DB::Rollback();
                 return response()->json('sorry', 500);
             }

             $order_total_price = 0;

             foreach ($request->orderproducts as $key => $user_order_products) {
                 $product = Product::find($user_order_products['product_id']);

                 $order_product = new OrderProduct();

                 $order_product->order_id = $order->id;
                 $order_product->product_id = $product->id;
                 $order_product->seller_id = $product->seller_id;
                 $order_product->price = $product->price;
                 $order_product->quantity = $user_order_products['quantity'];
                 $order_product->total_price = $order_product->price * $order_product->quantity;

                 $order_total_price = $order_total_price + $order_product->total_price;

                 $order_product_save = $order->save();

                 if(!$order_product_save){
                     \DB::Rollback();
                     return response()->json('sorry', 500);
                 }
             }

             $order->total_price = $order_product_save;
             $order_save = $order->save();

             if(!$order_save){
                 \DB::Rollback();
                 return response()->json('sorry', 500);
             }

             \DB::commit();


             return response()->json('Ok');

         }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
