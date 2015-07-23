<?php namespace Webshop\Billing;

use Stripe\Stripe;
use Stripe\Charge;

class StripeBilling implements BillingInterface {

    public function __construct(array $data)
    {
        Stripe::setApiKey(Config::get('stripe.secret_key'));
    }

    public function charge(array $data)
    {
        try {
            return Charge::create([
                'amount' => 1000,
                'currency' => 'usd',
                'description' => $data['email'],
                'card' => $data['token']
            ]);
        } catch(Stripe_CardError $e) {
            dd('Card was declined');
        }

    }
}

