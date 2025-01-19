<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\OrderController;


Route::get('/hello', function (Request $request) {
    return "Hello world";
});

Route::post('/order', [OrderController::class, 'store']);
