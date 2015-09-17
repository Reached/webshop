<?php namespace App\Http\Controllers;

use View;

class BaseController extends Controller {

    /**
     * BaseController constructor.
     */
    public function __construct() {

       $cartTotal = \Cart::total();
       $cartContent = \Cart::content();
       $withVat = \VatCalculator::calculate($cartTotal, 'DK');
       $taxRate = \VatCalculator::getTaxRate() * 100;

       View::share('cartTotal', $cartTotal);
       View::share('withVat', $withVat);
       View::share('taxRate', $taxRate);
       View::share('cartContent', $cartContent);
    }

}