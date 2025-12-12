<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Formulário com input de ID
    public function createWithId()
    {
        $this->authorize('create', Book::class);
        return view('books.create-id');
    }

    // Salvar livro com input de ID

    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class);
        $request->validate([
            'capa' => 'required|image|mimes:jpg,jpeg,png,webp',
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas', 'public');
            // Isso salva em: storage/app/public/capas/xxxx.jpg
        }
        Book::create($data);
        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }


    // Formulário com input select
    public function createWithSelect()
    {
        $this->authorize('create', Book::class);
        $publisher = Publisher::all();
        $author = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publisher', 'author', 'categories'));
    }

    // Salvar livro com input select
    public function storeWithSelect(Request $request)
    {
        $this->authorize('create', Book::class);
        $request->validate([
            'capa' => 'required|image|mimes:jpg,jpeg,png,webp',
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only([
            'title',
            'publisher_id',
            'author_id',
            'category_id',
        ]);

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas', 'public');
        }

        Book::create($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro criado com sucesso.');
    }


    public function edit(Book $book)
    {
        $this->authorize('update', $book);

        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'capa' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'title',
            'publisher_id',
            'author_id',
            'category_id'
        ]);

        // Se o usuário enviou uma nova capa
    if ($request->hasFile('capa')) {

        // Apaga a capa antiga se existir
        if ($book->capa && \Storage::disk('public')->exists($book->capa)) {
            \Storage::disk('public')->delete($book->capa);
        }

        // Salva a nova capa
        $data['capa'] = $request->file('capa')->store('capas', 'public');
    }

    $book->update($data);

    return redirect()->route('books.index')
        ->with('success', 'Livro atualizado com sucesso.');
    }

    public function index()
    {
        // Carregar os livros com autores usando eager loading e paginação
        $books = Book::with('author')->paginate(20);

        return view('books.index', compact('books'));

    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

    // Se existir capa, remove do storage
    if ($book->capa && Storage::disk('public')->exists($book->capa)) {
        Storage::disk('public')->delete($book->capa);
    }

    // Apaga o livro do BD
    $book->delete();

    return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso.');
    }

    public function show(Book $book)
    {
        $this->authorize('view', $book);

    // Carregando autor, editora e categoria do livro com eager loading
    $book->load(['author', 'publisher', 'category']);

    // Carregar todos os usuários para o formulário de empréstimo
    $users = User::all();

    return view('books.show', compact('book','users'));
    }
}

