<?php
namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe uma lista de categorias
    public function index()
    {
        $publisher = Publisher::all();
        return view('publisher.index', compact('publisher'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        $this->authorize('create', Publisher::class);
        return view('publisher.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $this->authorize('create', Publisher::class);
        
        $request->validate([
            'name' => 'required|string|unique:publishers|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publisher.index')->with('success', 'publisher criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Publisher $publisher)
    {
        $this->authorize('view', $publisher);
        return view('publisher.show', compact('publisher'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(Publisher $publisher)
    {
        $this->authorize('update', $publisher);
        return view('publisher.edit', compact('publisher'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, Publisher $publisher)
    {
        $this->authorize('update', $publisher);
        
        $request->validate([
            'name' => 'required|string|unique:publishers,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publisher.index')->with('success', 'publisher atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Publisher $publisher)
    {
        $this->authorize('delete', $publisher);
        $publisher->delete();

        return redirect()->route('publisher.index')->with('success', 'publisher excluída com sucesso.');
    }
}

