<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create(){

        $countries = Country::get();
        $shippingCharges = ShippingCharge::select('shipping_charges.*','countries.name',)
        ->leftJoin('countries','countries.id','shipping_charges.country_id',)->get();

        Session::put('page', 'create');
        return view('admin.shippings.create', compact('countries','shippingCharges'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount'  => 'required|numeric'
        ]);

        if ($validator->passes()) {
            # code...

            $count = ShippingCharge::where('country_id', $request->country)->count();
            if ($count > 0) {
                # code...
                session()->flash('success', 'Shipping already added');
                return response()->json([
                    'status' => true,
                ]);
            }

            $shipping = new ShippingCharge;
            $shipping->country_id = $request->country;
            $shipping->amount  = $request->amount;
            $shipping->save();

            session()->flash('success', 'Shipping added successfully');
            return response()->json([
                'status' => true,
            ]);

        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id){

        $countries = Country::get();
        $shipping = ShippingCharge::find($id);
        return view('admin.shippings.edit', compact('shipping','countries'));
    }

    public function updated($id, Request $request){

        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount'  => 'required|numeric'
        ]);

        if ($validator->passes()) {
            # code...

            $shipping = ShippingCharge::find($id);
            $shipping->country_id = $request->country;
            $shipping->amount  = $request->amount;
            $shipping->save();

            session()->flash('success', 'Shipping updated successfully');
            return response()->json([
                'status' => true,
            ]);

        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function destroy($id){

        $shipping = ShippingCharge::find($id);
        if ($shipping == null) {
            # code...
            session()->flash('error','Shipping not found');
            return response()->json([
                'status' => true,
            ]);
        }

        $shipping->delete();
        session()->flash('success','Shipping deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
