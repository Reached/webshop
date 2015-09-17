<?php

namespace App\Http\Controllers;

use App\Events\OrderWasPlaced;
use Auth;
use Event;
use Cart;
use Response;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

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

        return Response::json(['success', 200, 'data' => $cartTotal]);
    }

    public function removeCartItem() {
        $rowId = Input::get('id');

        Cart::remove($rowId);

        return Response::json(['success', 200]);
    }

    public function updateCartItem() {
        $rowId = Input::get('id');
        $newQty = Input::get('qty');

        Cart::update($rowId, $newQty);

        return Response::json(['success', 200]);
    }

    public function removeAllCartItems() {

        Cart::destroy();

        return Response::json(['success', 200]);
    }

    public function showCheckout() {

        return view('frontend.checkout');
    }

    public function verifyPayment() {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));

        // Get the credit card details submitted by the form
        $token = Input::get('stripeToken');

        $user = Auth::user();

        // Get the carts content (serverside)
        $cartTotal = Cart::total();

        $grossPrice = \VatCalculator::calculate($cartTotal, 'DK');

        // Get the amount total in the smallest denominator
        $amount = $grossPrice * 100;

        $customer = \Stripe\Customer::create([
                "source" => $token,
                "description" => $user->email
            ]
        );

        $billing_id = $customer->id;

        $user->save();

        Event::fire(new OrderWasPlaced($amount, $billing_id));

        return 'Your order is now pending. The money will not be taken from your account before the products has been shipped.';

    }
}
