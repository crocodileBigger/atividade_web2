<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Borrowing extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos
    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at', 'due_date'];

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //calculo da multa
    public function calcularMulta(): float
    {
        // Se ainda não foi devolvido, não calcula multa
        if (!$this->returned_at) {
            return 0;
        }

        $dueDate = Carbon::parse($this->due_date);
        $returnedAt = Carbon::parse($this->returned_at);

        // Se devolveu no prazo ou antes
        if ($returnedAt->lessThanOrEqualTo($dueDate)) {
            return 0;
        }

        $diasAtraso = $dueDate->diffInDays($returnedAt);

        return $diasAtraso * 0.50;
    }

    // Relacionamento com Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
