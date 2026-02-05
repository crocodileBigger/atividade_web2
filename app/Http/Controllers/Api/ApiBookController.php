<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class ApiBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * GET /api/apiBooks
     */
    public function index()
    {
        $this->authorize('viewAny', Book::class);

        return response()->json(
            Book::with(['author', 'publisher', 'category'])->paginate(20)
        );
    }

    /**
     * POST /api/apiBooks
     */
    public function store(Request $request)
    {
        $this->authorize('create', Book::class);

        $validated = $request->validate([
            'capa'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'         => 'required|string|max:255',
            'publisher_id'  => 'required|exists:publishers,id',
            'author_id'     => 'required|exists:authors,id',
            'category_id'   => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('capa')) {
            $validated['capa'] = $request->file('capa')->store('capas', 'public');
        }

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Livro criado com sucesso',
            'data'    => $book
        ], 201);
    }

    /**
     * GET /api/apiBooks/{book}
     */
    public function show(Book $book)
    {
        $this->authorize('view', $book);

        return response()->json(
            $book->load(['author', 'publisher', 'category'])
        );
    }

    /**
     * PUT /api/apiBooks/{book}
     */
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'publisher_id'  => 'required|exists:publishers,id',
            'author_id'     => 'required|exists:authors,id',
            'category_id'   => 'required|exists:categories,id',
            'capa'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('capa')) {

            if ($book->capa && Storage::disk('public')->exists($book->capa)) {
                Storage::disk('public')->delete($book->capa);
            }

            $validated['capa'] = $request->file('capa')->store('capas', 'public');
        }

        $book->update($validated);

        return response()->json([
            'message' => 'Livro atualizado com sucesso',
            'data'    => $book
        ]);
    }

    /**
     * DELETE /api/apiBooks/{book}
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        if ($book->capa && Storage::disk('public')->exists($book->capa)) {
            Storage::disk('public')->delete($book->capa);
        }

        $book->delete();

        return response()->json([
            'message' => 'Livro removido com sucesso'
        ]);
    }
}
