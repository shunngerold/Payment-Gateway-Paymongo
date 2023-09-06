<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pay',[PaymentController::class, 'pay'])->name('pay');
Route::get('/success',[PaymentController::class, 'success'])->name('success');

// Link payment
Route::get('/link-pay',[PaymentController::class, 'linkPay'])->name('link.pay');
Route::get('/link-status/{linkId}',[PaymentController::class, 'linkStatus'])->name('link.status');
