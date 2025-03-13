<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function discounts(Request $request){

        $discounts = DiscountCoupon::latest();
        if (!empty($request->get('keyword'))) {
            # code...
            $discounts = $discounts->where('name','like','%'. $request->get('keyword') .'%');
        }

        $discounts = $discounts->paginate(8);
        return view('admin.discount-code.list', compact('discounts'));
    }

    public function create(){

        return view('admin.discount-code.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'            => 'required',
            'code'            => 'required',
            'discount_amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {
            # code...
            if (!empty($request->starts_at)) {
                # code...
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if($startAt->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors'  => ['starts_at' => 'Start date can not be less than current time'],
                    ]);
                }
            }

            //
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                # code...
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if($expiresAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors'  => ['expires_at' => 'Expiry date must be greator than start date'],
                    ]);
                }
            }

            $discount = new DiscountCoupon();
            $discount->name             = $request->name;
            $discount->code             = $request->code;
            $discount->description      = $request->description;
            $discount->max_uses         = $request->max_uses;
            $discount->max_uses_user    = $request->max_uses_user;
            $discount->type             = $request->type;
            $discount->discount_amount  = $request->discount_amount;
            $discount->starts_at        = $request->starts_at;
            $discount->expires_at       = $request->expires_at;
            $discount->status           = $request->status;
            $discount->save();

            Session()->flash('success','discount added successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'discount added successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function edit($discountId, Request $request){

        $discount = DiscountCoupon::find($discountId);
        if (empty($discount)) {
            # code...
            return redirect()->route('admin.discount');
        }
        return view('admin.discount-code.edit', compact('discount'));
    }

    public function updated($discountId, Request $request){

        $discount = DiscountCoupon::find($discountId);
        if ($discount == null) {
            # code...
            Session()->flash('error','discount not fount');
            return response()->json([
                'status'   => true,
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'            => 'required',
            'code'            => 'required',
            'discount_amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {
            # code...
            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                # code...
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if($expiresAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors'  => ['expires_at' => 'Expiry date must be greator than start date'],
                    ]);
                }
            }

            //
            if (!empty($request->starts_at)) {
                # code...
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);

                if($startAt->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors'  => ['starts_at' => 'Start date can not be less than current time'],
                    ]);
                }
            }

            $discount->name             = $request->name;
            $discount->code             = $request->code;
            $discount->description      = $request->description;
            $discount->max_uses         = $request->max_uses;
            $discount->max_uses_user    = $request->max_uses_user;
            $discount->type             = $request->type;
            $discount->discount_amount  = $request->discount_amount;
            $discount->starts_at        = $request->starts_at;
            $discount->expires_at       = $request->expires_at;
            $discount->status           = $request->status;
            $discount->save();

            Session()->flash('success','discount updated successfully');
            return response()->json([
                'status'    => true,
                'message'   => 'discount updated successfully',
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($discountId){

        $discount = DiscountCoupon::find($discountId);
        if (empty($discount)) {
            # code...
            Session()->flash('error','discount not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'discount not found'
            ]);
        }

        $discount->delete();

        Session()->flash('success','discount delete successfully');
        return response()->json([
            'status'    => true,
            'message'   => 'discount deleted successfully'
        ]);
    }
}
