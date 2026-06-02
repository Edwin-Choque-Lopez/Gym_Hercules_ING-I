<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/administration', [App\Http\Controllers\AdministrationController::class, 'index'])->name('administration');

Route::post('/categories', [App\Http\Controllers\AdministrationController::class, 'categorystore'])->name('categories.create');
Route::put('/categories/{id}', [App\Http\Controllers\AdministrationController::class, 'categoryupdate'])->name('categories.update');
Route::delete('/categories/{id}', [App\Http\Controllers\AdministrationController::class, 'categorydestroy'])->name('categories.destroy');

Route::post('/discounts', [App\Http\Controllers\AdministrationController::class, 'discountstore'])->name('discounts.create');
Route::put('/discounts/{id}', [App\Http\Controllers\AdministrationController::class, 'discountupdate'])->name('discounts.update');
Route::delete('/discounts/{id}', [App\Http\Controllers\AdministrationController::class, 'discountdestroy'])->name('discounts.destroy');

Route::get('/parameters', [App\Http\Controllers\ParameterController::class, 'index'])->name('parameters'); 

Route::post('/paymenttypes', [App\Http\Controllers\ParameterController::class, 'paymenttypestore'])->name('paymenttypes.create');
Route::put('/paymenttypes/{id}', [App\Http\Controllers\ParameterController::class, 'paymenttypeupdate'])->name('paymenttypes.update');
Route::delete('/paymenttypes/{id}', [App\Http\Controllers\ParameterController::class, 'paymenttypedestroy'])->name('paymenttypes.destroy'); 

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');  

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');  

Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
Route::post('/customers', [App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');   

Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members');

Route::get('/sale',[App\Http\Controllers\SaleController::class, 'index'])->name('sale');
Route::post('/sale/client',[App\Http\Controllers\SaleController::class, 'searchclient'])->name('searchclient');
Route::post('/sale/member',[App\Http\Controllers\SaleController::class, 'searchmember'])->name('searchmember');




