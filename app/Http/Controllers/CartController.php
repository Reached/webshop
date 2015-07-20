<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Product;
use Response;
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

        return Response::json(['success', 200]);
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


}
