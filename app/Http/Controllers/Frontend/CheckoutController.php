<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Country;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;

class CheckoutController extends MainController
{
    public function index(Request $request){

        $data =[];
        $data = array_merge($data, $this->frontendItems($request));
        $data['address'] = null;
        if(auth()->user()){
            $data['address'] = Address::where('user_id', auth()->user()->id)->where('is_default', 1)->first();
        }

        $data['DeliveryFees'] = DeliveryFee::where('status', 'active')->where('isDeleted', 'no')->get();
        $data['Countries'] = Country::where('status', 'active')->where('isDeleted', 'no')->get();


        return view('Frontend.checkout.index')->with('data', $data);
    }
}
