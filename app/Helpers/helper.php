<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

function getCategories(){

    return Category::orderBy('name','ASC')
                    ->with('sub_categories')
                    ->orderBy('id','DESC')
                    ->where('status',1)
                    ->where('showHome','Yes')
                    ->get();
}

function getProductImage($productId){
    return ProductImage::where('product_id',$productId)->first();
}

function orderEmail($orderId, $userType = "Client"){
    $order = Order::where('id', $orderId)->with('items')->first();

    if ($userType == "Client") {
        # code...
        $subject = 'Merci pour votre commande';
        $email = $order->email;
    } else {
        # code...
        $subject = 'Vous avez reçu une commande';
        $email = env('ADMIN_EMAIL');
    }

    $mailData = [
        'subject'  => $subject,
        'order'    => $order,
        'userType' => $userType
    ];
    Mail::to($email)->send(new OrderEmail($mailData));
}

function getCountryInfo($id){
    return Country::where('id',$id)->first();
}
