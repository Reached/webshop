<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use Response;
use Session;
use App\Product;


class CartController extends BaseController
{

    /**
     * CartController constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCart() {
        return view('frontend.checkout.cart');
    }

    /**
     * @param Request $request
     * @return string
     */
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
                    'imagePath' => $productImage,
                    'billys_product_id' => $product->billys_product_id
                ]
            ]);

        } catch(ShoppingcartInvalidItemException $e) {
            return $e->getMessage();
        }

        $cartTotal = Cart::count();

        return Response::json(['success' => true, 'message' => 'The product was added to your cart', 'data' => $cartTotal], 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeCartItem(Request $request) {
        $rowId = $request->input('id');

        Cart::remove($rowId);

        return Response::json(['success' => true, 'message' => 'The product was removed from your cart'], 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function removeAllCartItems() {

        Cart::destroy();

        return Response::json(['success' => true, 'message' => 'All products were removed from your cart'], 200);
    }

}