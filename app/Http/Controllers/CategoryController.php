<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe uma lista de categorias
    public function index()
    {
        $categories = Category::all();
        return view('Category.index', compact('categories'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        $this->authorize('create', Category::class);
        return view('Category.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('Category.index')->with('success', 'Categoria criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Category $Category)
    {
        $this->authorize('view', $Category);
        return view('Category.show', compact('Category'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(Category $Category)
    {
        $this->authorize('update', $Category);
        return view('Category.edit', compact('Category'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, Category $Category)
    {
        $this->authorize('update', $Category);
        
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $Category->id . '|max:255',
        ]);
        $Category->update($request->all());

        return redirect()->route('Category.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Category $Category)
    {
        $this->authorize('delete', $Category);
        $Category->delete();

        return redirect()->route('Category.index')->with('success', 'Categoria excluída com sucesso.');
    }
}


