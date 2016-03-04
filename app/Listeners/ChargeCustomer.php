<?php

namespace App\Listeners;

use App\Events\OrderWasApproved;
use App\Http\Controllers\OrdersController;
use App\Webshop\Providers\BillysBilling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Response;
use Guzzle;
use Stripe\Charge;
use Stripe\Stripe;
use Twilio;
use Carbon\Carbon;

class ChargeCustomer
{
    /**
     * Handle the event.
     *
     * @param  OrderWasApproved  $event
     * @return void
     */
    public function handle(OrderWasApproved $event)
    {

        $billingId = $event->order['stripe_billing_id'];
        $amount = $event->order['amount'];

        Stripe::setApiKey(env('STRIPE_API_KEY'));

            $data = Charge::create([
                    'amount' => $amount, // amount in cents, again
                    'currency' => 'dkk',
                    'customer' => $billingId,
                    'description' => 'Event charge'
                ]
            );

        Mail::send('emails.orderConfirmation', ['data' => $data], function($message)
        {
            $message->to('casper.aarby.sorensen@gmail.com')
                ->from('casper.aarby.sorensen@gmail.com')
                ->subject('Welcome!');
        });

        // Send an SMS if the user has allowed it
        if ($event->order['sendSms'] == true) {
            Twilio::message('+4528559088', 'Your order was shipped!');
        }

        $billy = new BillysBilling(env('BILLY_KEY'));

        $date = Carbon::now()->format('Y-m-d');

        $billy->makeBillyRequest('POST', '/bankPayments', [
            'bankPayment' => [
                'organizationId' => env('BILLY_ORGANIZATION'),
                'contactId' => $event->order['billys_contact_id'],
                'entryDate' => $date,
                'cashAmount' => $amount,
                'cashSide' => 'debit',
                'cashAccountId' => 'YYYHJlZ4Rceu0ApFuoVBWQ',
                'associations' => [
                    [
                        'subjectReference' => 'invoice:' . $event->order['billys_invoice_id'],
                    ]
                ],
            ]
        ]);
    }
}
