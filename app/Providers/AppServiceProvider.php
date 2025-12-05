<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * As políticas do aplicativo.
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Registra qualquer serviço de autenticação/autorização.
     */
    public function boot(): void
    {
        //
    }
}

