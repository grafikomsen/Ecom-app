<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function users(Request $request){

        $users = User::latest();
        if (!empty($request->get('keyword'))) {
            # code...
            $users = $users->where('name','like','%'. $request->get('keyword') .'%');
            $users = $users->orWhere('email','like','%'. $request->get('keyword') .'%');
        }

        $users = $users->paginate(8);
        Session::put('page', 'users');
        return view('admin.users.list', compact('users'));
    }

    public function create(){

        return view('admin.users.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            'phone'     => 'required',
        ]);

        if ($validator->passes()) {
            # code...
            $user = new User();
            $user->name        = $request->name;
            $user->email       = $request->email;
            $user->password    = Hash::make($request->password);
            $user->phone       = $request->phone;
            $user->status      = $request->status;
            $user->save();

            $message = 'User added successfully';
            Session()->flash('success',$message);
            return response()->json([
                'status'    => true,
                'message'   => $message,
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function edit($userId, Request $request){

        $user = User::find($userId);
        return view('admin.users.edit', compact('user'));
    }

    public function updated($userId, Request $request){

        $user = User::find($userId);
        if ($user == NULL) {
            # code...
            Session()->flash('error','Record not found');
            return response()->json([
                'status'    => false,
                'notFound'  => true,
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$userId.',id',
            'phone'     => 'required',
        ]);

        if ($validator->passes()) {
            # code...
            $user->name        = $request->name;
            $user->email       = $request->email;
            if ($request->password != '') {
                # code...
                $user->password    = Hash::make($request->password);
            }
            $user->phone       = $request->phone;
            $user->status      = $request->status;
            $user->save();

            $message = 'User updated successfully';
            Session()->flash('success',$message);
            return response()->json([
                'status'    => true,
                'message'   => $message,
            ]);

        } else {
            # code...
            return response()->json([
                'status'    => false,
                'errors'    => $validator->errors(),
            ]);
        }
    }

    public function destroy($userId){

        $user = User::find($userId);
        if (empty($user)) {
            # code...
            Session()->flash('error','User not fount');
            return response()->json([
                'status'    => true,
                'message'   => 'User not found'
            ]);
        }

        $user->delete();
        $message = 'User delete successfully';
        Session()->flash('success', $message);
        return response()->json([
            'status'    => true,
            'message'   => $message
        ]);
    }
}
