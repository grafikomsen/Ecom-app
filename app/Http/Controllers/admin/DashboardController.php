<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){

        $totalRevenue  = Order::where('status','!=','cancelled')->sum('grand_total');
        $totalOrders   = Order::where('status','!=','cancelled')->count();
        $userOrders    = User::where('role',1)->count();
        $totalProducts = Product::count();

        //This month revenue
        $startOfMounth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate  = Carbon::now()->format('Y-m-d');

        $revenueThisMounth = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$startOfMounth)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total');

        //Last mouth revenue
        $lastMounthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMounthEndDate   = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMounthName      = Carbon::now()->subMonth()->startOfMonth()->format('M');

        $revenueLastMounth = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$lastMounthStartDate)
                        ->whereDate('created_at','<=',$lastMounthEndDate)
                        ->sum('grand_total');

        //Last 30 days sale
        $lastThirtyDayStartDate = Carbon::now()->subDays(30)->format('Y-m-d');

        $revenueLastThirtyDays = Order::where('status','!=','cancelled')
                        ->whereDate('created_at','>=',$lastThirtyDayStartDate)
                        ->whereDate('created_at','<=',$currentDate)
                        ->sum('grand_total');

        return view('admin.dashboard', compact('totalOrders','totalProducts','userOrders','totalRevenue','revenueThisMounth','revenueLastMounth','revenueLastThirtyDays','lastThirtyDayStartDate','lastMounthName'));
    }

    public function logout(){
       Auth::guard('admin')->logout();
       return redirect()->route('admin.login');
    }
}
