<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Listar os produtos favoritos do cliente.
     */
    public function index()
    {
        // Pega os produtos favoritos do utilizador logado com as imagens carregadas
        $favorites = auth()->user()->favoriteProducts()->with('images')->latest()->paginate(12);

        return view('public.profile.wishlist', compact('favorites'));
    }

    /**
     * Adicionar ou remover um produto dos favoritos (Toggle).
     */
    public function toggle(Product $product)
    {
        $user = auth()->user();
        
        // O método toggle() adiciona se não existir, e remove se já existir na tabela pivot
        $resultado = $user->favoriteProducts()->toggle($product->id);

        // Verifica se foi anexado (adicionado) ou detetado (removido)
        if (count($resultado['attached']) > 0) {
            $mensagem = 'Produto adicionado aos teus favoritos!';
        } else {
            $mensagem = 'Produto removido dos teus favoritos.';
        }

        return redirect()->back()->with('success', $mensagem);
    }
}