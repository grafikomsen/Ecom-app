<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            # code...
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
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
                $message = 'Requested qty('.$qty.') not available in stock';
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
            $errorMessage = 'Item not found in cart';
            session()->flash('error', $errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage,
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Item removed from cart successfully';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
