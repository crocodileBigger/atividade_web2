@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Título --}}
    <h1 class="my-4">Detalhes do Usuário</h1>

    {{-- Card do usuário --}}
    <div class="card mb-4">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Multa:</strong> 
                @if(is_null($user->preco))
                    <span class="badge bg-success">Sem multa</span>
                @else
                    <span class="badge bg-danger">R$ {{ number_format($user->preco, 2, ',', '.') }}</span>
                @endif
            </p>

            {{-- Botão de quitar multa (apenas para quem pode) --}}
            @can('pagarMulta', $user)
                @if(!is_null($user->preco))
                    <form action="{{ route('user.zerar.multa', $user) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Quitar multa
                        </button>
                    </form>
                @endif
            @endcan
        </div>
    </div>

    {{-- Histórico de Empréstimos --}}
    <div class="card mb-4">
        <div class="card-header">
            Histórico de Empréstimos
        </div>

        <div class="card-body">
            @if($user->books->isEmpty())
                <p>Este usuário não possui empréstimos registrados.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->books as $book)
                            <tr>
                                <td>
                                    <a href="{{ route('books.show', $book->id) }}">
                                        {{ $book->title }}
                                    </a>
                                </td>

                                <td>{{ $book->pivot->borrowed_at }}</td>

                                <td>
                                    {{ $book->pivot->returned_at ?? 'Em Aberto' }}
                                </td>

                                <td>
                                    @if(is_null($book->pivot->returned_at))
                                        <form action="{{ route('borrowings.return', $book->pivot->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">
                                                Devolver
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Voltar --}}
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

</div>
@endsection
