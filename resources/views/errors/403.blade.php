@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-exclamation"></i> 
                        403 | Acesso Não Autorizado
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            Você não tem permissão para acessar este recurso
                        </h5>
                        <hr>
                        @if(isset($exception) && $exception->getMessage())
                            <p class="mb-0">
                                <strong>Detalhes:</strong><br>
                                {{ $exception->getMessage() }}
                            </p>
                        @else
                            <p class="mb-0">Esta ação não está autorizada.</p>
                        @endif
                    </div>

                    @auth
                        <div class="mt-3">
                            <p><strong>Informações do seu usuário:</strong></p>
                            <ul>
                                <li><strong>Nome:</strong> {{ auth()->user()->name }}</li>
                                <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                                <li><strong>Tipo:</strong> <span class="badge bg-info">{{ auth()->user()->user_type }}</span></li>
                            </ul>
                        </div>

                        @if(config('app.debug'))
                            <div class="alert alert-warning mt-3">
                                <strong><i class="bi bi-info-circle"></i> Modo Debug:</strong>
                                <p class="mb-0">
                                    Para mais detalhes sobre as permissões, acesse: 
                                    <a href="{{ url('/debug-auth') }}" class="alert-link">
                                        /debug-auth
                                    </a>
                                </p>
                            </div>
                        @endif
                    @endauth

                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="bi bi-house"></i> Ir para Lista de Livros
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
