<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Category;
use App\Product;

class CategoriesController extends Controller
{
    public function showAllProducts() {

        $categories = Category::with('products')
            ->where('is_active', true)
            ->has('products')->get();
        //$categories = Category::all();

        $products = Product::where('is_active', true)->get();

        return view('frontend.categories.products', compact('products', 'categories'));
    }

    public function showSingleCategory($slug) {
        $categories = Category::with('products')
            ->where('is_active', true)
            ->has('products')->get();

        $category = Category::findBySlug($slug);
        $products = $category->products;

        return view('frontend.categories.showCategory', compact('categories', 'category', 'products'));
    }

    public function createNewCategoryPage() {
        return view('backend.categories.create');
    }

    public function storeNewCategory(StoreCategoryRequest $request) {
        $formData = $request->all();

        Category::create($formData);

        return response()->json(['success' => true, 'Message' => 'Your category was created.']);
    }

}
