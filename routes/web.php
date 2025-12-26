<?php

// Importa controllers usados nas rotas
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\BookController;

/*
| Rota inicial do sistema
| Quando alguém acessa "/", mostra a view welcome.blade.php
*/
Route::get('/', function () {
    return view('welcome');
});

/*
| Dashboard
| Página principal do usuário logado
| Só pode acessar quem estiver autenticado e verificado
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
| Rotas protegidas por autenticação
| Tudo aqui dentro exige login
*/
Route::middleware('auth')->group(function () {

    // Exibe o formulário de edição do perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Atualiza os dados do perfil
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Remove a conta do usuário
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
| Criação de livros com SELECT (autor, editora etc.)
*/
Route::get('/books/create-select', [BookController::class, 'createWithSelect'])
    ->name('books.create.select');

Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])
    ->name('books.store.select');

/*
| Criação de livros informando ID manualmente
*/
Route::get('/books/create-id-number', [BookController::class, 'createWithId'])
    ->name('books.create.id');

Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])
    ->name('books.store.id');

/*
| Rotas REST de usuários
| Gera index, show, edit e update
| NÃO gera create, store e destroy
*/
Route::resource('users', UserController::class)
    ->except(['create', 'store', 'destroy']);

/*
| Empréstimo de livro
| Cria um empréstimo para um livro específico
*/
Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])
    ->name('books.borrow');

/*
| Pagamento de multa
| Somente usuários autorizados pela Policy (ex: bibliotecário)
*/
Route::post('/users/{user}/pagar-multa', [UserController::class, 'pagarMulta'])
    ->middleware('auth')
    ->name('user.zerar.multa');

/*
| Histórico de empréstimos de um usuário
*/
Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])
    ->name('users.borrowings');

/*
| Devolução de livro
| Atualiza o campo returned_at do empréstimo
*/
Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return');

/*
| Rotas REST de livros
| Gera index, show, edit, update e destroy
| NÃO gera create e store (já tratados acima)
|
| IMPORTANTE:
| Deve ficar depois das rotas /books/create-*
*/
Route::resource('books', BookController::class)
    ->except(['create', 'store']);

/*
| Rotas REST de autores
*/
Route::resource('authors', AuthorController::class);

/*
| Rotas REST de editoras
*/
Route::resource('publisher', PublisherController::class);

/*
| Rotas REST de categorias
*/
Route::resource('Category', CategoryController::class);

/*
| Rotas padrão de autenticação (login, registro, senha)
*/
Auth::routes();

/*
| Rota /home (gerada por Auth::routes)
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

/*
| Rotas de autenticação adicionais (Breeze / Jetstream)
*/
require __DIR__.'/auth.php';

/*
| Rotas de debug
| Só carregam quando APP_DEBUG=true
| Nunca devem ir para produção
*/
if (config('app.debug')) {
    require __DIR__.'/debug.php';
}
