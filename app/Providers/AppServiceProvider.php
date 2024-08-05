<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Department\DepartmentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Subject\SubjectRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Student\StudentRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
