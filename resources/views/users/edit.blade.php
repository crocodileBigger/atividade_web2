@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="mb-3">
            <label for="user_type" class="form-label">Papel/Role</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="cliente" {{ old('user_type', $user->user_type) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                <option value="bibliotecario" {{ old('user_type', $user->user_type) == 'bibliotecario' ? 'selected' : '' }}>Bibliotecário</option>
                <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        @endif

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection


