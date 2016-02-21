<?php

namespace App\Http\Controllers;

use App\Events\OrderWasPlaced;
use App\User;
use Auth;
use Event;
use Cart;
use Illuminate\Http\Request;
use Response;
use Session;
use App\Product;
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

        //return Cart::content();
        return view('frontend.checkout.cart');
    }

    public function addItemToCart(Request $request) {
        $productId = $request->input('id');
        $product = Product::find($productId);
        $productImage = $product->getFirstMediaUrl('images', 'small');

        try {
            Cart::associate('Product', 'App')->add([
                'id'    => $productId,
                'name'  => $product->product_name,
                'qty'   => 1,
                'price' => $product->product_price,
                'options' => [
                    'imagePath' => $productImage
                ]
            ]);

        } catch(ShoppingcartInvalidItemException $e) {
            return $e->getMessage();
        }

        $cartTotal = Cart::count();

        return Response::json(['success' => true, 'message' => 'The product was added to your cart', 'data' => $cartTotal], 200);
    }

    public function removeCartItem(Request $request) {
        $rowId = $request->input('id');

        Cart::remove($rowId);

        return Response::json(['success' => true, 'message' => 'The product was removed from your cart'], 200);
    }

    public function updateCartItem(Request $request) {
        $rowId = $request->input('id');
        $newQuantity = $request->input('qty');

        try {
            Cart::update($rowId, $newQuantity);
        } catch(ShoppingcartInvalidItemException $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 200);
        }

        return Response::json(['success' => true, 'message' => 'Your cart was updated'], 200);
    }

    public function removeAllCartItems() {

        Cart::destroy();

        return Response::json(['success' => true, 'message' => 'All products were removed from your cart'], 200);
    }

    public function showCheckout() {

        return view('frontend.checkout.checkout');
    }

    public function verifyPayment(Request $request)
    {

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
        $sendSms = $request->input('sendSms');
        $countryCode = $request->input('country');

        $emailCheck = User::where('email', $email)->value('email');

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
            User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'zip' => $zip,
                'street' => $street,
                'stripe_customer_id' => $customerID,
            ]);
        } else {
            $customerID = User::where('email', $email)->value('stripe_customer_id');
            //$user = User::where('email', $email)->first();
        }

            // Get the carts content
            $cartTotal = Cart::total();

            // Get the amount total in the smallest denominator
            $amount = $this->calculateAmount($cartTotal, $countryCode);

            $billing_id = $customerID;

            Event::fire(new OrderWasPlaced($amount, $billing_id, $sendSms));

            return 'Your order is now pending. The money will not be taken from your account before the products has been shipped.';

    }

    public function calculateAmount($amount, $countryCode) {

        $grossPrice = \VatCalculator::calculate($amount, $countryCode);

        $amount = $grossPrice * 100;

        return $amount;
    }

}
