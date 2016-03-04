<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use App\Order;
use Auth;
use App\Webshop\Providers\BillysBilling;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

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
        $country = $event->order['country'];
        $vatRate = 25;
        $billing_id = $event->billing_id;
        $customerName = $event->order['first_name'] . ' ' . $event->order['last_name'];
        $customerAddress = $event->order['street'];
        $customerCity = $event->order['city'];
        $customerZip = $event->order['zip'];
        $customerEmail = $event->order['email'];
        $customerPhone = $event->order['phone'];
        $sendSms = $event->order['sendSms'];
        $checkUser = (Auth::check() ? Auth::user()->id : 1);
        $products = Cart::content();

        // Specific for saving an invoice
        $date = Carbon::now()->format('Y-m-d');

        $lines = [];
        foreach($products as $product) {
            $lines[] = [
                'productId' => $product->options->billys_product_id,
                'unitPrice' => $product->price / 100
            ];
        }

        $billy = new BillysBilling(env('BILLYS_KEY'));

        $billyContact = $billy->makeBillyRequest('POST', '/contacts', [
            'contact' => [
                'type' => 'person',
                'organizationId' => env('BILLY_ORGANIZATION'),
                'name' => $customerName,
                'countryId' => $country,
                'street' => $customerAddress,
                'cityText' => $customerCity,
                'zipcodeText' => $customerZip,
                'phone' => $customerPhone,
                'isCustomer' => true
            ]
        ]);

        $billyContactId = $billyContact->body->contacts[0]->id;

        $order = Order::create([
           'amount' => $amount,
           'vat_rate' => $vatRate,
           'stripe_billing_id' => $billing_id,
           'customer_name' => $customerName,
           'customer_address' => $customerAddress,
           'customer_city' => $customerCity,
           'customer_country' => $country,
           'customer_zip' => $customerZip,
           'customer_email' => $customerEmail,
           'customer_phone_number' => $customerPhone,
           'sendSms' => $sendSms,
           'user_id' => $checkUser,
           'billys_contact_id' => $billyContactId
        ]);

        $billyInvoice = $billy->makeBillyRequest('POST', '/invoices', [
            'invoice' => [
                'organizationId' => env('BILLY_ORGANIZATION'),
                'contactId' => $billyContactId,
                'entryDate' => $date,
                'paymentTermsDays' => 5,
                'state' => 'approved',
                'sentState' => 'unsent',
                'invoiceNo' => $order->id,
                'currencyId' => 'DKK',
                'lines' => $lines
            ]
        ]);

        $order->billys_invoice_id = $billyInvoice->body->invoices[0]->id;
        $order->save();

    }

}
