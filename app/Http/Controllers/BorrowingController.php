<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);

        $total = Borrowing::whereNull('returned_at')
            ->where('user_id', $request->user_id)
            ->count();

        if ($total >= 5) {
            return redirect()->route('books.show', $book)
                ->with('error', 'O usuário já atingiu o limite de 5 livros emprestados simultaneamente.');
        }

        $emprestimoEmAberto = Borrowing::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if ($emprestimoEmAberto) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Este livro já possui um empréstimo em aberto.');
        }

        $user = User::find($request->user_id);

        if (!$user->podeEmprestar()) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Não pode pegar um livro enquanto tem uma multa em aberto.');
        }

        Borrowing::create([
            'user_id'     => $request->user_id,
            'book_id'     => $book->id,
            'borrowed_at' => now(),
            'due_date'    => $request->due_date, // 👈 vem do Blade
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Empréstimo realizado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        // Registra a devolução
        $borrowing->update([
            'returned_at' => now(),
        ]);

        // Calcula a multa
        $multa = $borrowing->calcularMulta();

        // Se houver multa, soma ao usuário
        if ($multa > 0) {
            $borrowing->user->increment('preco', $multa);
        }

        return redirect()
            ->route('books.show', $borrowing->book_id)
            ->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
{
    $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

    return view('users.borrowings', compact('user', 'borrowings'));
    }
}
