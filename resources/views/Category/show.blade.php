@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes da Categoria</h1>

    <div class="card">
        <div class="card-header">
            Categoria: {{ $Category->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $Category->id }}</p>
            <p><strong>Nome:</strong> {{ $Category->name }}</p>
        </div>
    </div>

    <a href="{{ route('Category.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>
@endsection


