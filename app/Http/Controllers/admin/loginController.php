<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->passes()) {
            # code...
            if (Auth::guard('admin')->attempt([
                'email'    => $request->email,
                'password' => $request->password,
            ], $request->get('remember')
            )) {
                # code...
                $admin = Auth::guard('admin')->user();
                if ($admin->role == 2) {
                    # code...
                    return redirect()->route('admin.dashboard');
                } else {
                    # code...
                    $admin = Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')
                        ->with('error','You have not authorized to access admin panel');
                }
            } else {
                # code...
                return redirect()->route('admin.login')
                    ->withErrors('error','Either Email/Password is incorrect');
            }
        } else {
            # code...
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}
