<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Category;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;

use App\Policies\UserPolicy;
use App\Policies\ResourcePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Category::class => ResourcePolicy::class,
        Author::class => ResourcePolicy::class,
        Book::class => ResourcePolicy::class,
        Publisher::class => ResourcePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
