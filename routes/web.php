<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProdutoController as AdminProdutoController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Public\CarrinhoController;
use App\Http\Controllers\Public\ProdutoController as PublicProdutoController;
use App\Http\Controllers\Public\SiteController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * PUBLIC
 */
Route::get('/', [SiteController::class, 'index'])->name('index');

/**
 * Produtos
 */
Route::get('/produtos/categoria/{id}', [PublicProdutoController::class, 'byCategoria'])->name('produtos.byCategoria');
Route::resource('produtos', PublicProdutoController::class)->only(['index', 'show']);

/**
 * Carrinho
 */
Route::controller(CarrinhoController::class)->prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/adicionar', 'adicionar')->name('adicionar');
    Route::post('/adicionarUm', 'adicionarUm')->name('adicionarUm');
    Route::post('/remover', 'remover')->name('remover');
    Route::post('/atualizar', 'atualizar')->name('atualizar');
    Route::get('/limpar', 'limpar')->name('limpar');
});

/**
 * Admin
 */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('index')->middleware(['auth', 'checkemail']);    
    });

    /**
     * Produtos
     */
    Route::resource('produtos', AdminProdutoController::class); 

    /**
     * Categorias
     */
    Route::resource('categorias', AdminCategoriaController::class);
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

/**
 * Auth
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
