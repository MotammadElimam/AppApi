<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
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
             \DB::beginTransaction();

             $order = new Order();

             $order->user_id = auth()->user()->id;
             $order->address= $request->address;
             $order->payment_type= $request->payment_type;

             $order_save = $order->save();

             if(!$order_save){
                 \DB::Rollback();
                 return response()->json('sorry', 500);
             }

             $order_status = new OrderStatus();
             $order_status->status = 'pending';
             $order_status->order_id = $order->id;
             $order_status->user_id = auth()->user()->id;
             $order_status_save = $order_status->save();


             $order_total_price = 0;

             foreach ($request->order_products as $key => $user_order_products) {
                 $product = Product::find($user_order_products['product_id']);

                 $order_product = new OrderProduct();

                 $order_product->order_id = $order->id;
                 $order_product->product_id = $product->id;
                 $order_product->seller_id = $product->seller_id;
                 $order_product->price = $product->price;
                 $order_product->quantity = $user_order_products['quantity'];
                 $order_product->total_price = $order_product->price * $order_product->quantity;
                 info($order_product->total_price);
                 $order_total_price = $order_total_price + $order_product->total_price;
                 info($order_total_price);

                 $order_product_save = $order_product->save();

                 if(!$order_product_save){
                     \DB::Rollback();
                     return response()->json('sorry', 500);
                 }
             }

             $order->total_price = $order_total_price;
             $order_save = $order->save();

             if(!$order_save){
                 \DB::Rollback();
                 return response()->json('sorry', 500);
             }

             \DB::commit();


             return response()->json('Ok');

         }


         public function changeStatus(Request $request){

           $order = Order::find($request->order_id);
           $order->status = $request->status;
           $order_save = $order->save();


            if(!$order_save){
               \DB::Rollback();
               return response()->json('sorry', 500);
           }

           $order_status = new OrderStatus();
           $order_status->status = $request->status;
           $order_status->order_id = $order->id;
           $order_status->user_id = auth()->user()->id;
           $order_status_save = $order_status->save();


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
