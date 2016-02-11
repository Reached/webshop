<?php

/*|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Show the frontpage
Route::get('/', 'ProductsController@showFrontpage');

Route::get('/amount/{amount}', 'CartController@calculateAmount');

// Show a single product
Route::get('/product/{slug}', 'ProductsController@showSingleProduct');

Route::get('/categories', 'CategoriesController@showAllProducts');
Route::get('/categories/{slug}', 'CategoriesController@showSingleCategory');

// Show the shopping cart
Route::get('/cart', 'CartController@showCart');

// Remove a cart item
Route::post('/cart/remove', 'CartController@removeCartItem');

// Remove all items from cart
Route::post('/cart/removeall', 'CartController@removeAllCartItems');

// Add a cart item
Route::post('/cart', 'CartController@addItemToCart');

// Update a cart item
Route::post('/cart/updateitem', 'CartController@updateCartItem');

// Checkout view
Route::get('/cart/checkout', 'CartController@showCheckout');

// Verify the payment
Route::post('/cart/checkout', 'CartController@verifyPayment');

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/dashboard', 'AdminController@showDashboard');
    Route::get('/orders', 'AdminController@showOrders');
    Route::post('/orders/approve', 'AdminController@approveOrder');

    Route::get('/products', 'ProductsController@showAllProductsAdmin');
    Route::get('/products/create', 'ProductsController@createNewProductPage');
    Route::post('/products/store', 'ProductsController@storeNewProduct');
    Route::get('/products/show/{productId}', 'ProductsController@adminShowProduct');
    Route::post('/products/show/{productId}/images', 'ProductsController@storeNewImages');

    Route::get('/categories/create', 'CategoriesController@createNewCategoryPage');
    Route::post('/categories/store', 'CategoriesController@storeNewCategory');

});

// Authentication routes
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

