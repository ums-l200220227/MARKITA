<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        // $this->registerPolicies();
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
