<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\StoreCategoryRequest;
use App\Category;
use App\Product;

class CategoriesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllProducts() {

        $categories = Category::with('products')
            ->where('is_active', true)
            ->has('products')->get();
        //$categories = Category::all();

        $products = Product::where('is_active', true)->get();

        return view('frontend.categories.products', compact('products', 'categories'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSingleCategory($slug) {
        $categories = Category::with('products')
            ->where('is_active', true)
            ->has('products')->get();

        $category = Category::findBySlug($slug);
        $products = $category->products;

        return view('frontend.categories.showCategory', compact('categories', 'category', 'products'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createNewCategoryPage() {
        return view('backend.categories.create');
    }

    /**
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNewCategory(StoreCategoryRequest $request) {
        $formData = $request->all();

        Category::create($formData);

        return response()->json(['success' => true, 'Message' => 'Your category was created.']);
    }

}
