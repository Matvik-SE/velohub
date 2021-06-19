<?php

Route::namespace('Api')->group(function () {
    // Cart Products
    Route::post('/cart', 'CartController@index');
    Route::patch('/cart/add', 'CartController@add');
    Route::patch('/cart/update', 'CartController@update');
    Route::patch('/cart/remove', 'CartController@remove');

    // Order
    Route::post('/order', 'OrderController');
});

Route::prefix('admin')->namespace('Admin')->group(function () {
    // Settings
    Route::get('/settings', 'SettingController@index');

    // Categories
    Route::get('/categories', 'CategoryController@index');
//    Route::get('/categories/{id}', 'CategoryController@edit');
//    Route::post('/categories', 'CategoryController@store');
//    Route::patch('/categories/{id}', 'CategoryController@update');
//    Route::delete('/categories/{id}', 'CategoryController@destroy');
//    Route::post('/categories/{id}/upload-images', 'CategoryController@uploadImages');

    // Orders
    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/{id}', 'OrderController@get');
    Route::post('/orders', 'OrderController@post');
    Route::patch('/orders/{id}', 'OrderController@patch');
    Route::delete('/orders/{id}', 'OrderController@delete');

    // Products
    Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@get');
    Route::post('/products', 'ProductController@post');
    Route::patch('/products/{id}', 'ProductController@patch');
    Route::delete('/products/{id}', 'ProductController@delete');
    Route::post('/products/{id}/upload-images', 'ProductController@uploadImages');
    Route::post('/products/{id}/update-images', 'ProductController@updateImages');

//    // Variants
//    Route::get('/variants/{product_id}', 'VariantController@index');
//    Route::post('/variants/{product_id}', 'VariantController@store');
//    Route::patch('/variants/{id}', 'VariantController@update');
//    Route::delete('/variants/{id}', 'VariantController@destroy');
//    Route::post('/variants/{id}/upload-images', 'VariantController@uploadImages');
});


