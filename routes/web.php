<?php

use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\CarrinhoController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\CustomerOrderController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\WishlistController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/produto/{slug}', [ProductController::class, 'show'])->name('produtos.show');
Route::get('/categoria/{category}', [ProductController::class, 'byCategory'])->name('produtos.byCategoria');
Route::get('/pesquisa', [ProductController::class, 'search'])->name('produtos.search');

//Route::get('/produtos/categoria/{id}', [PublicProdutoController::class, 'byCategoria'])->name('produtos.byCategoria');
//Route::resource('produtos', PublicProdutoController::class)->only(['index', 'show']);

Route::controller(CarrinhoController::class)->prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/adicionar', 'adicionar')->name('adicionar');
    Route::post('/adicionarUm', 'adicionarUm')->name('adicionarUm');
    Route::post('/remover', 'remover')->name('remover');
    Route::post('/atualizar', 'atualizar')->name('atualizar');
    Route::get('/limpar', 'limpar')->name('limpar');
});

// Rotas do Carrinho de Compras (Sessão Nativa)
Route::get('/carrinho', [CartController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/adicionar', [CartController::class, 'adicionar'])->name('carrinho.adicionar');
Route::post('/carrinho/adicionar-um', [CartController::class, 'adicionarUm'])->name('carrinho.adicionarUm');
Route::put('/carrinho/atualizar/{id}', [CartController::class, 'update'])->name('carrinho.update');
Route::delete('/carrinho/remover/{id}', [CartController::class, 'destroy'])->name('carrinho.destroy');

// Rotas que exigem que o cliente esteja logado
Route::middleware(['auth'])->group(function () {
    
    // Páginas do Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/processar', [CheckoutController::class, 'processar'])->name('checkout.processar');
    Route::get('/checkout/sucesso/{order}', [CheckoutController::class, 'sucesso'])->name('checkout.sucesso');

    Route::get('/meus-pedidos', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/meus-pedidos/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil/atualizar', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/senha', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    Route::get('/favoritos', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/favoritos/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
