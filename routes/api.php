<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_product', [ProductController::class, 'get_all_product']);
Route::post('/add_product', [ProductController::class, 'add_product']);
Route::delete('/delete_product/{id}', [ProductController::class, 'delete']);
Route::get('/get_edit_product/{id}', [ProductController::class, 'get_edit_product']);
Route::post('/update_product/{id}', [ProductController::class, 'update_product']);
Route::post('/search_product', [ProductController::class, 'search_product']);
