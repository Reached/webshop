<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use App\Http\Controllers\CartController;
use App\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNewOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // Nothing goes here, put it in the Event instead.
    }

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

        Order::create([
           'amount' => $amount,
           'stripe_billing_id' => $billing_id
        ]);

    }
}
