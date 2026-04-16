<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
Route::get('/setting/create', [App\Http\Controllers\SettingController::class, 'CreateCategory'])->name('categories.create');
Route::post('/setting/categories', [App\Http\Controllers\SettingController::class, 'StoreCategory'])->name('categories.store');
Route::get('/setting/categories/{id}', [App\Http\Controllers\SettingController::class, 'EditCategory'])->name('categories.edit');
Route::put('/setting/categories/{id}', [App\Http\Controllers\SettingController::class, 'UpdateCategory'])->name('categories.update');
Route::delete('/setting/categories/{id}', [App\Http\Controllers\SettingController::class, 'DeleteCategory'])->name('categories.destroy');
Route::resource('/products', App\Http\Controllers\ProductController::class);

