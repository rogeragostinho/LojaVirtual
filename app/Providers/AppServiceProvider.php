<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\Category;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partilha a variável $categoriesMenu com o layout da navbar automaticamente
        FacadesView::composer('public.layout.index', function ($view) {
            $view->with('categoriesMenu', Category::orderBy('name')->get());
        });


        Gate::define('access-super-admin', function ($user) {
            return $user->role === UserRole::SUPER_ADMIN;
        });

        // FORÇA O LARAVEL A USAR O COMPONENTE DE PAGINAÇÃO DO BOOTSTRAP 5
        Paginator::useBootstrapFive();
    }
}
