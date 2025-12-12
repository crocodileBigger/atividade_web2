<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    public function viewAny(User $user)
    {
        return Response::allow();
    }

    public function view(User $user, $model)
    {
        return Response::allow();
    }

    public function create(User $user)
    {
        if ($user->isAdmin() || $user->isBibliotecario()) {
            return Response::allow();
        }

        return Response::denyWithStatus(
            403,
            "[CRIAR] Acesso negado para o usuário '{$user->name}' (ID: {$user->id}). "
            . "Tipo de usuário atual: '{$user->user_type}'. "
            . "Apenas usuários do tipo 'admin' ou 'bibliotecario' podem criar recursos."
        );
    }

    public function update(User $user, $model)
    {
        if ($user->isAdmin() || $user->isBibliotecario()) {
            return Response::allow();
        }

        $modelType = class_basename($model);
        $modelId = $model->id ?? 'N/A';
        
        return Response::denyWithStatus(
            403,
            "[ATUALIZAR] Acesso negado para o usuário '{$user->name}' (ID: {$user->id}). "
            . "Tipo de usuário atual: '{$user->user_type}'. "
            . "Tentando atualizar: {$modelType} (ID: {$modelId}). "
            . "Apenas usuários do tipo 'admin' ou 'bibliotecario' podem atualizar recursos."
        );
    }

    public function delete(User $user, $model)
    {
        if ($user->isAdmin() || $user->isBibliotecario()) {
            return Response::allow();
        }

        $modelType = class_basename($model);
        $modelId = $model->id ?? 'N/A';
        
        return Response::denyWithStatus(
            403,
            "[DELETAR] Acesso negado para o usuário '{$user->name}' (ID: {$user->id}). "
            . "Tipo de usuário atual: '{$user->user_type}'. "
            . "Tentando deletar: {$modelType} (ID: {$modelId}). "
            . "Apenas usuários do tipo 'admin' ou 'bibliotecario' podem deletar recursos."
        );
    }
}
