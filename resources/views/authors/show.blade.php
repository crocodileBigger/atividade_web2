@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes da Categoria</h1>

    <div class="card">
        <div class="card-header">
            Categoria: {{ $category->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $author->id }}</p>
            <p><strong>Nome:</strong> {{ $author->name }}</p>
        </div>
    </div>

    <a href="{{ route('author.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection

