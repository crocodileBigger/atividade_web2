<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Exibe uma lista de autores
    public function index()
    {
        $authors = Author::all();
        return view('author.index', compact('authors'));
    }

    // Mostra o formulário para criar um novo autor
    public function create()
    {
        return view('author.create');
    }

    // Armazena um novo autor no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:authors|max:255',
        ]);

        Author::create($request->all());

        return redirect()->route('author.index')->with('success', 'Autor criado com sucesso.');
    }

    // Exibe um autor específico
    public function show(Author $author)
    {
        return view('author.show', compact('author'));
    }

    // Mostra o formulário para editar um autor existente
    public function edit(Author $author)
    {
        return view('author.edit', compact('author'));
    }

    // Atualiza um autor no banco de dados
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|unique:authors,name,' . $author->id . '|max:255',
        ]);

        $author->update($request->all());

        return redirect()->route('author.index')->with('success', 'Autor atualizado com sucesso.');
    }

    // Remove um autor do banco de dados
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('author.index')->with('success', 'Autor excluído com sucesso.');
    }
}
