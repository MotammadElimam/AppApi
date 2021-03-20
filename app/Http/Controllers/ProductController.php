<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products;

        return response()->json($products);
    }

    public function show($id)
    {
        $product = auth()->user()->product()->find($id);

        if (!$product) {
            return response()->json('sorry', 400);
        }

        return response()->json([$product->toArray()], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|min:1',
            'desc' => 'required',
            'image' => 'required'
        ]);


//        this code for base 64
        $image = $request->image;
        $path = storage_path("app/product");
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = md5(rand(11111, 99999)) . '_' . time() . '.png';
        $path = $path . '/'  . $imageName;
        $input = \File::put($path, base64_decode($image));

        $product = Product::create([
            'name' => $request->name,
            'price' => 20,
            'desc' => $request->desc,
            'image' => $path

        ]);

        if (auth()->user()->products()->save($product))
            return $product;
        else
            return response()->json('sorry', 500);
    }


    public function destroy($id)
    {
        $product = auth()->user()->product()->find($id);

        if (!$product) {
            return response()->json('sorry', 400);
        }

        if ($product->delete()) {
            return response()->json('done');
        } else {
            return response()->json('sorry', 500);
        }
    }
}
