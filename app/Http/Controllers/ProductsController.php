<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function showAllProducts() {

        $products = Product::all();

        return view('frontend.products', compact('products'));

    }

    function money($amount, $symbol = 'DKK') {
        return $symbol . money_format('%i', $amount);
    }
}
