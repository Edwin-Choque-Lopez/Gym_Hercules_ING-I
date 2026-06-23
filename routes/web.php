<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/administration', [AdministrationController::class, 'index'])->name('administration');

Route::post('/categories', [AdministrationController::class, 'categorystore'])->name('categories.create');
Route::put('/categories/{id}', [AdministrationController::class, 'categoryupdate'])->name('categories.update');
Route::delete('/categories/{id}', [AdministrationController::class, 'categorydestroy'])->name('categories.destroy');

Route::post('/discounts', [AdministrationController::class, 'discountstore'])->name('discounts.create');
Route::put('/discounts/{id}', [AdministrationController::class, 'discountupdate'])->name('discounts.update');
Route::delete('/discounts/{id}', [AdministrationController::class, 'discountdestroy'])->name('discounts.destroy');

Route::get('/parameters', [ParameterController::class, 'index'])->name('parameters');

Route::post('/paymenttypes', [ParameterController::class, 'paymenttypestore'])->name('paymenttypes.create');
Route::put('/paymenttypes/{id}', [ParameterController::class, 'paymenttypeupdate'])->name('paymenttypes.update');
Route::delete('/paymenttypes/{id}', [ParameterController::class, 'paymenttypedestroy'])->name('paymenttypes.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::get('/members', [MemberController::class, 'index'])->name('members');

Route::get('/sale', [SaleController::class, 'index'])->name('sale');
Route::post('/sale/client', [SaleController::class, 'searchclients'])->name('searchclient');
Route::post('/sale/member', [SaleController::class, 'searchmembers'])->name('searchmember');

Route::get('/sales/client/{ci}', [SaleController::class, 'searchclient'])->name('search.client');
Route::get('/sales/member/{ci}', [SaleController::class, 'searchmember'])->name('search.member');

Route::post('/sales/additem',[SaleController::class, 'additem'])->name('sale.additem');
Route::delete('/sales/removeitem/{id}',[SaleController::class, 'removeitem'])->name('sale.removeitem');

Route::post('/sale/save', [SaleController::class, 'store'])->name('sales.store');
