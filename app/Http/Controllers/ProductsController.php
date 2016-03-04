<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests;
use App\Product;
use App\Category;
use App\Webshop\Providers\BillysBilling;

class ProductsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFrontpage() {
        $products = Product::where('is_active', true)->get();

        return view('frontend.products.productList', compact('products'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSingleProduct($slug) {
        $product = Product::findBySlug($slug);
        $images = $product->getMedia();

        return view('frontend.products.show', compact('product', 'images'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllProductsAdmin() {
        $products = Product::all();

        return view('backend.products.index', compact('products'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createNewProductPage() {

        $categories = Category::all();

        return view('backend.products.create', compact('categories'));
    }

    /**
     * @param $productId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminShowProduct($productId) {
        $product = Product::findOrFail($productId);

        $photos = $product->photos;

        return view('backend.products.show', compact('product', 'photos'));
    }

    /**
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNewProduct(StoreProductRequest $request) {
        $formData = $request->all();

        $product = Product::create([
            'product_name' => $formData['product_name'],
            'product_price' => $formData['product_price'] * 100,
            'long_description' => $formData['long_description'],
            'short_description' => $formData['short_description'],
            'meta_description' => $formData['meta_description'],
            'category_id' => $formData['category_id'],
            'is_active' => $formData['is_active'],

        ]);
        $this->addToBillys($product);

        return response()->json(['success' => true, 'Message' => 'Your product was created.']);
    }

    /**
     * @param StorePhotoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNewImages(StorePhotoRequest $request) {
        $productId = $request->input('productId');
        $product = Product::findOrFail($productId);

        $path = $request->file('photo');

        $product->addMedia($path)->toCollection('images');

        return response()->json(['success' => true, 'Message' => 'Your images were successfully uploaded']);
    }

    public function addToBillys($product) {
        $billys = new BillysBilling(env('BILLYS_KEY'));

        $result = $billys->makeBillyRequest('POST', '/products', [
            'product' => [
                'organizationId' => env('BILLY_ORGANIZATION'),
                'name' => $product->product_name,
                'productNo' => $product->id,
                'prices' => [
                    [
                        'unitPrice' => $product->product_price / 100,
                        'currencyId' => 'DKK'
                    ],
                ]
            ]
        ]);

        if ($result->status !== 200) {
            return response()->json(['message' => $result->body]);
        }

        // Save the billy id to the product model, so we can use it later
        $billyId = $product->billys_product_id = $result->body->products[0]->id;
        $product->push($billyId);
    }
}
