<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/confirmation', function () {
    return view('confirmation');
})->name('confirmation');

Route::post('/deposit', [PaymentController::class, 'processDeposit']);
Route::post('/easy-money/process', [PaymentController::class, 'processEasyMoney']);
Route::post('/super-walletz/pay', [PaymentController::class, 'processSuperWalletz']);
Route::get('/super-walletz/webhook', [PaymentController::class, 'handleWebhook']);
