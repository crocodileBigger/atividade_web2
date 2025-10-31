<?php
namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Exibe uma lista de categorias
    public function index()
    {
        $publisher = Publisher::all();
        return view('publisher.index', compact('publisher'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        return view('publisher.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:publisher|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publisher.index')->with('success', 'publisher criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Publisher $publisher)
    {
        return view('publisher.show', compact('publisher'));
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
            'name' => 'required|string|unique:publishers,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publisher.index')->with('success', 'publisher atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('publisher.index')->with('success', 'publisher excluída com sucesso.');
    }
}

