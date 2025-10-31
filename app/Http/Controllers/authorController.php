<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class authorController extends Controller
{
    // Exibe uma lista de categorias
    public function index()
    {
        $author = Author::all();
        return view('author.index', compact('author'));
    }
    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        return view('author.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:author|max:255',
        ]);

        author::create($request->all());

        return redirect()->route('author.index')->with('success', 'Categoria criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(author $author1)
    {
        return view('author.show', compact('author'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(author $author1)
    {
        return view('author.edit', compact('author'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, author $author1)
    {
        $request->validate([
            'name' => 'required|string|unique:author,name,' . $author->id . '|max:255',
        ]);

        $author->update($request->all());

        return redirect()->route('author.index')->with('success', 'author atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(author $author1)
    {
        $category->delete();

        return redirect()->route('author.index')->with('success', 'author excluída com sucesso.');
    }
}

