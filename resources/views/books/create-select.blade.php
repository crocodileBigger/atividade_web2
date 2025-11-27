@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('books.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> voltar
    </a>

    <h1 class="my-4">Adicionar Livro (Com Select)</h1>

<form action="{{ route('books.store.select') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="capa" class="form-label">Capa</label>
        <input type="file" class="form-control @error('capa') is-invalid @enderror" id="capa" name="capa" accept="image/*">
        @error('capa')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="publisher_id" class="form-label">Editora</label>
            <select class="form-select @error('publisher_id') is-invalid @enderror" id="publisher_id" name="publisher_id" required>
                <option value="" selected>Selecione uma editora</option>
                @foreach($publisher as $publishers)
                    <option value="{{ $publishers->id }}">{{ $publishers->name }}</option>
                @endforeach
            </select>
            @error('publisher_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="author_id" class="form-label">Autor</label>
            <select class="form-select @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
                <option value="" selected>Selecione um autor</option>
                @foreach($author as $authors)
                    <option value="{{ $authors->id }}">{{ $authors->name }}</option>
                @endforeach
            </select>
            @error('author_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                <option value="" selected>Selecione uma categoria</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection
