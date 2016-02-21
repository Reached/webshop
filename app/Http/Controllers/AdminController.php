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
use Mail;
use Twilio;

class AdminController extends Controller
{
    public function showDashboard() {
        return view('backend.dashboard');
    }

    public function showOrders() {
        $orders = Order::paginate(50);

        return view('backend.orders', compact('orders'));
    }

    public function approveOrder(Request $request) {
        $order_id = $request->input('order_id');
        $order = Order::findOrFail($order_id);

        try {
            $order->confirmed = true;
            $order->save();

            Event::fire(new OrderWasApproved($order));

        } catch(Exception $e) {
            return 'There was an error';
        }

        return response()->json(['success' => true, 'message' => 'The card was successfully charged'], 200);
    }


}
