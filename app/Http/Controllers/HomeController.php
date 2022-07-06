<?php

namespace App\Http\Controllers;
use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $total_product=ProductModel::count();
        $order=new OrderModel;
        $pending_order=$order->where('order_status','2')->count();
        $dispatch_order=$order->where('order_status','3')->count();
        $completed_order=$order->where('order_status','4')->count();
        $total_order=$order->count();
        $user=new UserModel();
        $total_user=$user->count();
        $active_user=$user->where('status','1')->count();
        $blocked_user=$user->where('status','2')->count();
        return view('layouts.dashboard_index',compact('pending_order','dispatch_order','completed_order','total_order','total_user','active_user','blocked_user','total_product'));
    }
}
