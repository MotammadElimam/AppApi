<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:60',
            'confirm_password' => 'required|min:6',
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'phone_number' => 'min:10',
            'address' => 'min:3',

        ]);
        $input = $request->all();

        $input['password'] = bcrypt($request->password);
        //  return response()->json([$input], 200);

        $seller = Seller::create([
            'email' =>  $request->email,
            'password' => \Hash::make($request->password),
            'confirm_password' => $request->confirm_password,
            'first_name' =>  $request->first_name,
            'last_name' =>  $request->last_name,
            'phone_number' =>  $request->phonenumber,
            'address' => $request->adress
        ]);

//        if($request->is_seller){
//            $user->attachRole("seller");
//        }


        $token = $seller->createToken('SellerSecret')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

       $seller = Seller::where('email', $request->email)->first();


        if (Hash::check($request->password, $seller->getAuthPassword())) {
            $token = $seller->createToken('SellerSecret')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->guard('seller_api')->user()], 200);
    }
}
