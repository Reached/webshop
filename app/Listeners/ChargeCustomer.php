<?php

namespace App\Listeners;

use App\Events\OrderWasApproved;
use App\Http\Controllers\AdminController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChargeCustomer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderWasApproved  $event
     * @return void
     */
    public function handle(OrderWasApproved $event)
    {
        $order = $event->order;

        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));

        $charge = \Stripe\Charge::create([
                "amount" => $order->amount, // amount in cents, again
                "currency" => "dkk",
                "customer" => $order->stripe_billing_id,
                "description" => "Event charge"
            ]
        );
    }
}
