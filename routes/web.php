<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/deposit', [PaymentController::class, 'processDeposit']);
Route::post('/easy-money/process', [PaymentController::class, 'processEasyMoney']);
Route::post('/super-walletz/pay', [PaymentController::class, 'processSuperWalletz']);
Route::post('/super-walletz/webhook', [PaymentController::class, 'handleWebhook']);
