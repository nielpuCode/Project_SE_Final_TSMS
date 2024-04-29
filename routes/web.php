<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompComponentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;



Route::get('/', function () {
    return view('welcome');
});

// Route::redirect('/', '/compComponents');


// ----------- ACCOUNT ROUTES -----------
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('password.forgot');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete', [AccountController::class, 'delete'])->name('account.delete');


    Route::get('/account/user-account', [AccountController::class, 'userAccount'])->name('admin.user-account');
    Route::delete('/account/user-account/{id}', [AccountController::class, 'deleteUser'])->name('admin.delete-user');
    Route::get('/account/user-account/{id}/edit', [AccountController::class, 'editUser'])->name('admin.edit-user');

});

// ----------- COMPOUTER COMPONENT ROUTES -----------
Route::get('/compComp', function() {
    return view('showCompComponents');
});
Route::get('/compComponents', [CompComponentController::class, 'showList'])->name('showCompComponents');

Route::get('/compComponents/create', [CompComponentController::class, 'create'])->name('create_compComponent');
Route::post('/compComponents', [CompComponentController::class, 'store'])->name('store_compComponent');
Route::get('/compComponent/{compComponent}/edit', [CompComponentController::class, 'edit'])->name('edit_compComponent');
Route::put('/compComponents/{compComponent}', [CompComponentController::class, 'update'])->name('update_compComponent');

Route::delete('/comp-component/{compComponent}', [CompComponentController::class, 'destroy'])->name('delete_compComponent');


// ----------- CART ROUTES -----------
Route::get('/cart', [CartController::class, 'index'])->name('showCart');
Route::post('/add-to-cart', [CartController::class, 'addItemToCart'])->name('addItemToCart');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');


Route::post('/payment', [CartController::class, 'toPayment'])->name('toPayment');

Route::post('/confirm-payment', [CartController::class, 'storeOrder'])->name('storeOrder');

Route::get('/orders', [CartController::class, 'showOrders'])->name('showOrders');

Route::delete('/orders/{id}', [CartController::class, 'deleteOrder'])->name('deleteOrder');


// ----------- PAYMENT METHOD ROUTES -----------
Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('payment-methods.create');
Route::post('/payment-methods/store', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
Route::get('/payment-methods/{id}/edit', [PaymentMethodController::class, 'edit'])->name('payment-methods.edit');
Route::put('/payment-methods/{id}/update', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
Route::delete('/payment-methods/{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');
