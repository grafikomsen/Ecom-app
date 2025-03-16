<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(Request $request){

        $orders = Order::latest('orders.created_at')->select('orders.*','users.name','users.email');
        $orders = $orders->leftJoin('users','users.id','orders.user_id');

        if ($request->get('keyword') != "") {
            # code...
            $orders = $orders->where('users.name','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('users.email','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('orders.id','like','%'.$request->keyword.'%');
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.list', compact('orders'));
    }

    public function detail($orderId){

        $order = Order::select('orders.*','countries.name as countryName')
                    ->where('orders.id',$orderId)
                    ->leftJoin('countries','countries.id','orders.country_id')->first();

        $orderItems = OrderItem::where('order_id', $orderId)->get();

        return view('admin.orders.order-detail', compact('order','orderItems'));
    }

    public function changeOrderStatus(Request $request, $orderId){

        $order = Order::find($orderId);
        $order->status       = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Statut de la commande mis à jour avec succès';
        session()->flash('success', $message);
        return response()->json([
            'status'  => false,
            'message' => $message
        ]);
    }

    public function sendInvoiceEmail(Request $request, $orderId){

        orderEmail($orderId, $request->userType);
        $message = "E-mail de commande envoyé avec succès";
        session()->flash('success',$message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
