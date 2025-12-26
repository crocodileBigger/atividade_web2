@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Gerenciar Cadastros</h3>

                    <div class="d-flex flex-wrap gap-3">
                        <!-- Botão Books -->
                        <a href="{{ route('books.index') }}"
                           class="btn btn-primary btn-lg">
                            <i class="bi bi-book me-2"></i> Books
                        </a>

                        <!-- Botão Authors -->
                        <a href="{{ route('authors.index') }}"
                           class="btn btn-success btn-lg">
                            <i class="bi bi-person-fill me-2"></i> Authors
                        </a>

                        <!-- Botão Publishers -->
                        <a href="{{ route('publisher.index') }}"
                           class="btn btn-success btn-lg">
                            <i class="bi bi-person-fill me-2"></i> Publishers
                        </a>

                        <!-- Botão Categories -->
                        <a href="{{ route('Category.index') }}"
                           class="btn btn-warning btn-lg text-dark">
                            <i class="bi bi-tags-fill me-2"></i> Categories
                        </a>

                        <!-- Botão Categories -->
                        <a href="{{ route('users.index') }}"
                           class="btn btn-secondary btn-lg btn-lg">
                            <i class="bi bi-tags-fill me-2"></i> Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
