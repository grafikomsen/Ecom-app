<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){

        return view('account.login');
    }

    public function register(){

        return view('account.register');
    }

    public function processRegister(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {
            # code...

            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','Vous avez été inscrit avec succès');
            return response()->json([
                'status' => true,
            ]);
        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors'  => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            # code...
            if (Auth::attempt([
                # code...
                'email' => $request->email,
                'password' => $request->password],
                $request->get('remember'))) {

                    if (session()->has('url.intended')) {
                        # code...
                        return redirect(session()->get('url.intended'));
                    }
                    return redirect()->route('account.profile');

            } else {
                # code...
                return redirect()->route('account.login')
                ->withInput($request->only('email'))
                ->with('error', 'E-mail/mot de passe est incorrect.');
            }
        } else {
            # code...
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile(){
        $userId = Auth::user()->id;
        $user = User::where('id',Auth::user()->id)->first();
        $countries = Country::orderBy('name','ASC')->get();
        $customerAddress = CustomerAddress::where('user_id',$userId)->first();
        return view('account.profile', compact('user','customerAddress','countries'));
    }

    public function updateProfile(Request $request){

        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            $user = User::find($userId);
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;
            $user->save();

            session()->flash('success','Votre profile a été modifié avec succès');
            return response()->json([
                'status' => true,
            ]);
        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors'  => $validator->errors()
            ]);
        }

        return view('account.profile');
    }

    public function updateAddress(Request $request){

        $customerId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:4',
            'last_name'  => 'required|min:2',
            'email'      => 'required',
            'country'    => 'required',
            'address'    => 'required|min:15',
            'city'       => 'required',
            'state'      => 'required',
            'zip'        => 'required',
            'mobile'     => 'required',
        ]);

        if ($validator->passes()) {
            # code...
            CustomerAddress::updateOrCreate(
                ['user_id' => $customerId],
                [
                    'user_id'       => $customerId,
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

            session()->flash('success','Votre adresse a été modifiée avec succès');
            return response()->json([
                'status' => true,
            ]);
        } else {
            # code...
            return response()->json([
                'status' => false,
                'errors'  => $validator->errors()
            ]);
        }

        return view('account.profile');
    }

    public function logout(){

        Auth::logout();
        return redirect()->route('account.login')
        ->with('success', 'Vous vous êtes déconnecté avec succès!');
    }

    public function orders(){

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at','DESC')->paginate(10);
        return view('account.order', compact('orders'));
    }

    public function ordersId($orderId){
        $user = Auth::user();
        $order = Order::where('user_id',$user->id)->where('id',$orderId)->first();
        $orderItems = OrderItem::where('order_id',$orderId)->get();
        $orderItemsCount = OrderItem::where('order_id',$orderId)->count();
        return view('account.order-detail', compact('order','orderItems','orderItemsCount'));
    }

    public function wishlist(){
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        return view('account.wishlist', compact('wishlists'));
    }

    public function removeProductFromWishlist(Request $request){

        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();
        if ($wishlist == null) {
            # code...
            session()->flash('error','Product already removed');
            return response()->json([
                'status' => true,
            ]);
        } else {
            # code...
            Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
            session()->flash('success','Product removed successfully');
            return response()->json([
                'status' => true,
            ]);
        }
    }
}
