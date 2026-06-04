<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

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
        $categoriasMenu = Category::all();
        view()->share('categoriasMenu', $categoriasMenu);
    }
}
