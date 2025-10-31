<?php
namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Exibe uma lista de categorias
    public function index()
    {
        $categories = Publisher::all();
        return view('Publisher.index', compact('Publisher'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        return view('Publisher.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:Publisher|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('Publisher.index')->with('success', 'Publisher criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Publisher $publisher)
    {
        return view('Publisher.show', compact('publisher'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(Publisher $publisher)
    {
        return view('publisher.edit', compact('publisher'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|unique:publisher,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publisher.index')->with('success', 'publisher atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Publisher $publisher)
    {
        $category->delete();

        return redirect()->route('publisher.index')->with('success', 'publisher excluída com sucesso.');
    }
}

