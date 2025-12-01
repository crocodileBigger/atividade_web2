<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');
// Rotas para criação de livros
Route::get('/books/create-id-number', [BookController::class, 'createWithId'])->name('books.create.id');
Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])->name('books.store.id');
Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('books.borrow');

// Rota para listar o histórico de empréstimos de um usuário
Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])->name('users.borrowings');

// Rota para registrar a devolução
Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

// Rotas RESTful para index, show, edit, update, delete (tem que ficar depois das rotas /books/create-id-number e /books/create-select)
Route::resource('books', BookController::class)->except(['create', 'store']);
Route::resource('authors', authorController::class);
Route::resource('publisher', PublisherController::class);
Route::resource('Category', CategoryController::class);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
