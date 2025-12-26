<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $currentUser)
    {
        return $currentUser->isAdmin() || $currentUser->isBibliotecario();
    }

    public function view(User $currentUser, User $user)
    {
        return true;
    }

    public function update(User $currentUser, User $user)
    {
        if ($currentUser->isAdmin()) {
            return true;
        }

        // Bibliotecário pode editar, mas NÃO pode elevar privilégios
        if ($currentUser->isBibliotecario()) {
            return $user->user_type !== 'admin'; // não pode mexer no admin
        }

        return false;
    }

    public function delete(User $currentUser, User $user)
    {
        if ($currentUser->isAdmin()) {
            return true;
        }

        // bibliotecário não pode deletar admins
        if ($currentUser->isBibliotecario()) {
            return $user->user_type !== 'admin';
        }

        return false;
    }

    public function create(User $currentUser)
    {
        return $currentUser->isAdmin();
    }


     public function pagarMulta(User $authUser, User $user): bool
     {
        return $authUser->isBibliotecario();
     }

}
