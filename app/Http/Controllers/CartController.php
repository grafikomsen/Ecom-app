<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            # code...
            return response()->json([
                'status' => false,
                'message' => 'Enregistrement introuvable'
            ]);
        }

        if (Cart::count() > 0) {
            # code...

            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                # code...
                if ($item->id == $product->id) {
                    # code...
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                # code...
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' =>
                (!empty($product->product_images)) ? $product->product_images->first() : '']);

                $status = true;
                $message = $product->title.' ajouté au panier avec succés';
                session()->flash('success',$message);
            } else {
                # code...
                $status = false;
                $message = $product->title.' Produit déjà dans le panier';
            }

        } else {
            # Cart is empty
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            $status = true;
            $message = $product->title.' ajouté au panier avec succés';
            session()->flash('success',$message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function cart(){

        $cartContent = cart::content();
        return view('cart', compact('cartContent'));
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);

        // check qty available in stock
        if ($product->track_qty == 'Yes') {
            # code...
            if ($qty <= $product->qty) {
                # code...
                Cart::update($rowId,$qty);
                $message = 'Mis à jour au panier avec succés';
                $status = true;
                session()->flash('success', $message);
            } else {
                # code...
                $message = 'Quantité demandée('.$qty.') non disponible en stock';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            # code...
            Cart::update($rowId,$qty);
            $message = 'Mis à jour au panier avec succés';
            $status = true;
            session()->flash('success', $message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function deleteItem(Request $request){

        $itemInfo = Cart::get($request->rowId);

        if ($itemInfo == null) {
            # code...
            $errorMessage = 'Article introuvable dans le panier';
            session()->flash('error', $errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage,
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Article supprimé du panier avec succès';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function checkout(){

        //-- if user is empty redirect to cart page
        if (Cart::count() == 0) {
            # code...
            return redirect()->route('cart');
        }

        //-- if user is empty redirect to cart page
        if (Auth::check() == false) {
            # code...
            if (!session()->has('url.intended')) {
                # code...
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('account.login');
        }

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        session()->forget(['url.intended']);
        $countries = Country::orderBy('name','ASC')->get();

        //Calculate shipping here
        if ($customerAddress != '') {
            # code...
            $userCountry = $customerAddress->country_id;

            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();

            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;
            foreach (Cart::content() as $item) {
                # code...
                $totalQty += $item->qty;
            }

            $totalShippingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = Cart::subtotal(2,'.','')+$totalShippingCharge;
        } else {
            # code...
            $grandTotal = Cart::subtotal(2,'.','');
            $totalShippingCharge = 0;
        }

        return view('checkout', compact('countries','customerAddress','totalShippingCharge','grandTotal'));
    }

    public function processCheckout(Request $request){

        $rules = [
            'first_name'    => 'required|min:4',
            'last_name'     => 'required|min:2',
            'email'         => 'required',
            'country'       => 'required',
            'address'       => 'required|min:15',
            'city'          => 'required',
            'state'         => 'required',
            'zip'           => 'required',
            'mobile'        => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            # code...

            return response()->json([
                'message'   => 'Please fix the errors',
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }

        // Step 2 save user address
        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'country_id'    => $request->country,
                'address'       => $request->address,
                'apartment'     => $request->apartment,
                'city'          => $request->city,
                'state'         => $request->state,
                'zip'           => $request->zip,
                'mobile'        => $request->mobile,
                'notes'         => $request->notes,
            ]
        );

        // Step 3 store data in orders table
        if ($request->payment_method == 'cod') {
            # Calculate shipping
            $shipping   = 0;
            $discount   = 0;
            $subTotal   = Cart::subtotal(2,'.','');
            $grandTotal = $subTotal+$shipping;

            $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                # code...
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {
                # code...
                $shipping   = $totalQty*$shippingInfo->amount;
                $grandTotal = $subTotal+$shipping;
            } else {
                # code...
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $shipping   = $totalQty*$shippingInfo->amount;
                $grandTotal = $subTotal+$shipping;
            }

            //
            $order = new Order();
            $order->subtotal    = $subTotal;
            $order->shipping    = $shipping;
            $order->grand_total = $grandTotal;
            $order->user_id     = $user->id;

            //
            $order->first_name  = $request->first_name;
            $order->last_name   = $request->last_name;
            $order->email       = $request->email;
            $order->country_id  = $request->country;
            $order->address     = $request->address;
            $order->apartment   = $request->apartment;
            $order->city        = $request->city;
            $order->state       = $request->state;
            $order->zip         = $request->zip;
            $order->mobile      = $request->mobile;
            $order->notes       = $request->notes;
            $order->save();

            // Step 4 store order items in orders items table
            foreach (Cart::content() as $item) {
                # code...
                $orderItem = new OrderItem();
                $orderItem->product_id  = $item->id;
                $orderItem->order_id    = $order->id;
                $orderItem->name        = $item->name;
                $orderItem->qty         = $item->qty;
                $orderItem->price       = $item->price;
                $orderItem->total       = $item->price*$item->qty;
                $orderItem->save();
            }

            session()->flash('success','You have successfully placed you order');
            Cart::destroy();
            return response()->json([
                'message'   => 'Order saved successfully',
                'orderId'   => $order->id,
                'status'    => true,
            ]);
        } else {
            # code...
        }
    }

    public function thankyou($id){

        return view('thankyou',compact('id'));
    }

    public function getOrderSummery(Request $request){

        $subTotal = Cart::subtotal(2,'.','');
        if ($request->country_id > 0) {
            # code...
            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                # code...
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {
                # code...
                $shippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal     = $subTotal+$shippingCharge;

                return response()->json([
                    'status'            => true,
                    'grandTotal'        => number_format($grandTotal,0) ,
                    'shippingCharge'    => number_format($shippingCharge,0),
                ]);
            } else {
                # code...
                $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();

                $shippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal     = $subTotal+$shippingCharge;

                return response()->json([
                    'status'            => true,
                    'grandTotal'        => number_format($grandTotal,0) ,
                    'shippingCharge'    => number_format($shippingCharge,0),
                ]);
            }
        } else {
            # code...
            return response()->json([
                'status'            => true,
                'grandTotal'        => number_format($subTotal,0) ,
                'shippingCharge'    => number_format(0,0),
            ]);
        }
    }
}
