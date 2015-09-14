<?php

namespace App\Http\Controllers;

use App\Events\OrderWasApproved;
use App\Order;
use Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function showDashboard() {
        return view('backend.dashboard');
    }

    public function showOrders() {

        $orders = Order::paginate(50);

        return view('backend.orders', compact('orders'));
    }

    public function approveOrder() {

        $order_id = Input::get('order_id');

        $order = Order::findOrFail($order_id);

        $order->confirmed = 1;
        $order->save();

        Event::fire(new OrderWasApproved($order));

        return response()->json('success', 200);
    }


}
