<?php

namespace App\Providers;

use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings.
     */
    protected $policies = [
        Book::class => BookPolicy::class,
    ];

    /**
     * Register policies.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}