<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use App\Order;
use Auth;

class CreateNewOrder
{
    /**
     * Handle the event.
     *
     * @param  OrderWasPlaced $event
     * @return void
     */
    public function handle(OrderWasPlaced $event)
    {
        $amount = $event->amount;
        $billing_id = $event->billing_id;
        $sendSms = $event->sendSms;
        $checkUser = (Auth::check() ? Auth::user()->id : 1);

        Order::create([
           'amount' => $amount,
           'stripe_billing_id' => $billing_id,
           'sendSms' => $sendSms,
           'user_id' => $checkUser
        ]);

    }
}
