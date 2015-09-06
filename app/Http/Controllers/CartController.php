<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Response;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function showCart() {
        $cartContent = Cart::content();
        $cartTotal = Cart::total();

        return view('frontend.cart', compact('cartContent', 'cartTotal'));
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

        $cartContent = Cart::content();
        $cartTotal = Cart::total();

        return view('frontend.checkout', compact('cartContent', 'cartTotal'));
    }

    public function verifyPayment() {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_4VelQ1AOsxYcZYGZFQeb2DfL");

        // Get the credit card details submitted by the form
        $token = Input::get('stripeToken');
        $data = Input::all();
        $amount = Cart::total() * 100;

        // Create the charge on Stripe's servers - this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                    "amount" => $amount, // amount in cents, again
                    "currency" => "dkk",
                    "source" => $token,
                    "description" => "Example charge")
            );

            return Response::json(['success', 200, 'message' => 'Your card was successfully charged.']);

        } catch(\Stripe\Error\Card $e) {
            return Response::json(['error', 'message' => $e->getMessage() ]);
        }
    }


}
