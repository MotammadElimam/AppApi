<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderProductsResource;
use App\Http\Resources\OrderSummaryResource;

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
    $order->address = $request->address;
    $order->payment_type = $request->payment_type;

    $order_save = $order->save();

    if (!$order_save) {
      \DB::Rollback();
      return response()->json('sorry', 500);
    }

    $order_status = new OrderStatus();
    $order_status->status = 'ACCEPTED';
    $order_status->order_id = $order->id;
    $order_status->user_id = auth()->user()->id;
    $order_status_save = $order_status->save();


    $order_total_price = 0;



    // var_dump($request);die();

    if (gettype($request->order_products) == "string") {
      $request->order_products = json_decode($request->order_products, true);
    }
    //
    // foreach (  $request->order_products  as $value) {
    //   // code...
    //     $request->order_products[] = (array) $value;
    // }

    foreach ($request->order_products as $user_order_products) {

      $user_order_products_type = gettype($user_order_products);

      $product_id = 0;
      switch ($user_order_products_type) {
        case 'object':


          $product_id =  $user_order_products->product_id;
          break;

        case 'array':
          $product_id =  $user_order_products['product_id'];
          break;
        default:
          return response()->json(gettype($user_order_products));
          break;
      }







      // return response()->json($product_id);

      $product = Product::find($product_id);

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

      if (!$order_product_save) {
        \DB::Rollback();
        return response()->json('sorry', 500);
      }
    }

    $order->total_price = $order_total_price;
    $order_save = $order->save();

    if (!$order_save) {
      \DB::Rollback();
      return response()->json('sorry', 500);
    }

    \DB::commit();


    return response()->json('Order added Successfully');
  }


  public function cencelOrder(Request $request, Order $order)
  {

    //   $order = Order::find($request->order_id);
    $order->status = OrderStatus::CANCELED;
    $order_save = $order->save();


    if (!$order_save) {
      \DB::Rollback();
      return response()->json('sorry', 500);
    }

    $order_status = new OrderStatus();
    $order_status->status = OrderStatus::CANCELED;
    $order_status->order_id = $order->id;
    $order_status->user_id = auth()->user()->id;
    $order_status_save = $order_status->save();

    return "Ordered cenceled successfuly";
  }



  public function showAllOrders()
  {
    return OrderResource::collection(Order::all());
  }




  public function ShowBuyeritemsOfOrder(Request $request)
  {
    info($request);
    info(auth()->user()->id);
    $order = Order::where('id', $request->id)
      ->where('user_id', auth()->user()->id)
      ->firstOrFail();

    $order_product = $order->product()->get();

    return OrderProductsResource::collection($order_product);
  }






  public function ShowSellerOrders()
  {
    $orders = OrderProduct::with(['order', 'product', 'order.user'])->where('seller_id', auth()->user()->id)->whereHas('order', function ($query) {
      $query->where('status', 'ACCEPTED');
    })->get();


    return response()->json($orders);
  }


  public function ShowBuyerOrders()
  {
    $orders = auth()->user()->orders;

    return OrderSummaryResource::collection($orders);
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
