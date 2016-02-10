<?php

namespace App\Http\Controllers;

use App\Events\OrderWasPlaced;
use App\Setting;
use App\User;
use App;
use Auth;
use Event;
use Cart;
use Illuminate\Http\Request;
use Response;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;

class CartController extends BaseController
{
    /**
     * CartController constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    public function showCart() {

        return view('frontend.cart');
    }

    public function addItemToCart() {
        $productId = Input::get('id');
        $product = Product::find($productId);

        Cart::add([
            'id'    => $productId,
            'name'  => $product->product_name,
            'price' => $product->product_price,
            'qty'   => 1
        ]);

        $cartTotal = Cart::count();

        return Response::json(['success' => true, 'message' => 'The product was added to your cart', 'data' => $cartTotal], 200);
    }

    public function removeCartItem() {
        $rowId = Input::get('id');

        Cart::remove($rowId);

        return Response::json(['success' => true, 'message' => 'The product was removed from your cart'], 200);
    }

    public function updateCartItem() {
        $rowId = Input::get('id');
        $newQuantity = Input::get('qty');

        Cart::update($rowId, $newQuantity);

        return Response::json(['success' => true, 'message' => 'Your cart was updated'], 200);
    }

    public function removeAllCartItems() {

        Cart::destroy();

        return Response::json(['success' => true, 'message' => 'All products were removed from your cart'], 200);
    }

    public function showCheckout() {
        return view('frontend.checkout');
    }

    public function verifyPayment(Request $request) {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey(env('STRIPE_API_KEY'));

        // Get the credit card details submitted by the form
        $token = $request->input('stripeToken');
        $email = $request->input('email');
        $first_name = $request->input('first_name');
        $last_name = $request->input('first_last');
        $zip = $request->input('zip');
        $street = $request->input('street');

        $emailCheck = User::where('email', $email)->value('email');
        $setting = Setting::find(1);
        $chargeUser =  $setting->charge_directly;

        if ($chargeUser === false) {
            // If the email doesn't exist in the database create new customer and user record
            if (!isset($emailCheck)) {
                // Create a new Stripe customer
                try {
                    $customer = Customer::create([
                        'source' => $token,
                        'email' => $email,
                        'metadata' => [
                            "First Name" => $first_name,
                            "Last Name" => $last_name,
                            '>ip' => $zip,
                            'Street' => $street
                        ]
                    ]);
                } catch (Card $e) {
                    return redirect()->back()
                        ->withErrors($e->getMessage())
                        ->withInput();
                }

                $customerID = $customer->id;

                // Create a new user in the database with Stripe
                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'zip' => $zip,
                    'street' => $street,
                    'stripe_customer_id' => $customerID,
                ]);
            } else {
                $customerID = User::where('email', $email)->value('stripe_customer_id');
                $user = User::where('email', $email)->first();
            }

            // Get the carts content
            $cartTotal = Cart::total();

            // Look up the users ip, and put the right amount of tax according to this
            $countryCode = VatCalculator::getIPBasedCountry();
            $grossPrice = \VatCalculator::calculate($cartTotal, 'DK');

            // Get the amount total in the smallest denominator
            $amount = $grossPrice * 100;

            $billing_id = $customerID;

            Event::fire(new OrderWasPlaced($amount, $billing_id));

            return 'Your order is now pending. The money will not be taken from your account before the products has been shipped.';

        } else {
            return 'The money has been taken from your account, HAHA!';
        }



    }
}
