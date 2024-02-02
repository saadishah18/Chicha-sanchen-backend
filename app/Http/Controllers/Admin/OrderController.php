<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(){
        return view('admin.pages.orders.index');
    }

    public function datatable(Request $request)
    {
        $orders = Order::orderBy('created_at','Desc')->get();
        dd($orders);
    }
}
