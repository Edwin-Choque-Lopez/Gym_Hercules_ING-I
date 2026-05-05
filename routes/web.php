<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/administration', [App\Http\Controllers\AdministrationController::class, 'index'])->name('administration');
Route::post('/categories', [App\Http\Controllers\AdministrationController::class, 'categorystore'])->name('categories.create');
Route::put('/categories/{id}', [App\Http\Controllers\AdministrationController::class, 'categoryupdate'])->name('categories.edit');
Route::delete('/categories/{id}', [App\Http\Controllers\AdministrationController::class, 'categorydestroy'])->name('categories.destroy');
