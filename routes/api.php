<?php
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/users',              [CustomerController::class, 'index']);
Route::post('/users',             [CustomerController::class, 'store']);
Route::get('/users/{id}',         [CustomerController::class, 'show']);
Route::get('/users/{id}/orders',  [CustomerController::class, 'getOrders']);