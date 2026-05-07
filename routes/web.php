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