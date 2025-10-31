<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('author', authorController::class);
Route::resource('publisher', PublisherController::class);
Route::resource('categories', CategoryController::class);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
