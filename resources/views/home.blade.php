<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
    <h2>Bem-vindo à Página Inicial</h2>

    <!-- Usando o componente Alert -->
    <x-alert type="danger">
        Ocorreu um erro! <!-- Esse conteúdo vai para $slot do componente -->
    </x-alert>

    <x-alert type="success">
        Operação realizada com sucesso!
    </x-alert>
@endsection

