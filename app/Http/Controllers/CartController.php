<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
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

        // Get the price with VAT
        $withVat = \VatCalculator::calculate($cartTotal, 'DK');
        $taxRate = \VatCalculator::getTaxRate() * 100;

        return view('frontend.cart', compact('cartContent', 'cartTotal', 'withVat', 'taxRate'));
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
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY'));

        // Get the credit card details submitted by the form
        $token = Input::get('stripeToken');

        $user = Auth::user();

        $customer = \Stripe\Customer::create([
                "source" => $token,
                "description" => $user->email
            ]
        );
        $data = $customer->sources->data;

        foreach ($data as $item) {
            $user->card_brand = $item->brand;
            $user->card_last_four = $item->last4;
        }
        $user->billing_id = $customer->id;
        $user->save();

        return 'Your order is now pending. The money will not be taken from your account before the products has been shipped.';

    }
}
