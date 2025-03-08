<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return view('account.profile');
    }

    public function logout(){

        Auth::logout();
        return redirect()->route('account.login')
        ->with('success', 'Vous vous êtes déconnecté avec succès !');
    }
}
