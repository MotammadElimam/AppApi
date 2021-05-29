<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Product;

class RatingController extends Controller
{
    public function ReateProduct(Product $product, Request $request){

      if (!$product) {
          return response()->json('sorry', 400);
      }

      if($request->rate < 1 || $request->rate > 5){
        return "its bigger than 5 or less than 1 ";
      }

       $rating = new Rating(
         [
           'rate' =>  $request->rate,
           'product_id' => $product->id
         ]
       );

       $rating->user_id = auth()->id();
       $rating->save();

       return "rating success";


    }


    public function RateAvg(Product $product){

      if (!$product) {
          return response()->json('sorry', 400);
      }

      return $product->Ratings->avg('rate');

    }

    // public function TopProductsRatings(){
    //   return Product::wherehas('Ratings' , function($query){
    //     $query->select('rate')->whereraw('avg(rate)>=4');
    //   })->get();
    // }
}
