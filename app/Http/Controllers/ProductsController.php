<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\Http\Controllers\Controller;
use App\Photo;
use App\Category;

class ProductsController extends Controller
{
    public function showFrontpage() {

        $products = Product::where('is_active', true)->get();

        return view('frontend.products.products', compact('products'));
    }

    public function showSingleProduct($slug) {
        $product = Product::findBySlug($slug);
        $productPhotos = $product->photos;

        return view('frontend.show', compact('product', 'productPhotos'));
    }

    public function showAllProductsAdmin() {
        $products = Product::all();

        return view('backend.products.index', compact('products'));
    }

    public function createNewProductPage() {

        $categories = Category::all();

        return view('backend.products.create', compact('categories'));
    }

    public function adminShowProduct($productId) {
        $product = Product::findOrFail($productId);

        $photos = $product->photos;

        return view('backend.products.show', compact('product', 'photos'));
    }

    public function storeNewProduct(StoreProductRequest $request) {
        $formData = $request->all();

        Product::create($formData);

        return response()->json(['success' => true, 'Message' => 'Your product was created.']);
    }

    public function storeNewImages(StorePhotoRequest $request) {
        $productId = $request->input('productId');
        $product = Product::findOrFail($productId);
        $photo = Photo::fromForm($request->file('photo'));

        $product->addPhoto($photo);

        return response()->json(['success' => true, 'Message' => 'Your images were successfully uploaded']);
    }
}
