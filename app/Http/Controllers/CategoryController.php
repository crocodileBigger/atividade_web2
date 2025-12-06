<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Exibe uma lista de categorias
    public function index()
    {
        $categories = Category::all();
        return view('Category.index', compact('categories'));
    }

    // Mostra o formulário para criar uma nova categoria
    public function create()
    {
        return view('Category.create');
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:category|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('Category.index')->with('success', 'Categoria criada com sucesso.');
    }

    // Exibe uma categoria específica
    public function show(Category $Category)
    {
        return view('Category.show', compact('Category'));
    }

    // Mostra o formulário para editar uma categoria existente
    public function edit(Category $Category)
    {
        return view('Category.edit', compact('Category'));
    }

    // Atualiza uma categoria no banco de dados
    public function update(Request $request, Category $Category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('Category.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    // Remove uma categoria do banco de dados
    public function destroy(Category $Category)
    {
        $Category->delete();

        return redirect()->route('Category.index')->with('success', 'Categoria excluída com sucesso.');
    }
}


