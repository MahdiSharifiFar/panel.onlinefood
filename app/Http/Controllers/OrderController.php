<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->with( [ 'address' , 'items' , 'user'])->paginate(4);
        //dd($orders);
        return view('orders.index', compact('orders'));
    }

    public function sent(Order $order)
    {
        $order->update(['status' => 2]);
        return back()->with(['success'=>'وضعیت سفارش به ارسال شده تغییر کرد']);
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 3]);
        return back()->with(['success'=>'وضعیت سفارش به لغو شده تغییر کرد']);
    }

    public function return(Order $order)
    {
        $order->update(['status' => 4]);
        return back()->with(['success'=>'وضعیت سفارش به لغو شده تغییر کرد']);
    }

}
