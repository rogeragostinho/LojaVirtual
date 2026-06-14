<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Visualizar a página do carrinho.
     */
    public function index()
    {
        // Vai buscar o carrinho da sessão (se não existir, assume um array vazio)
        $cart = session()->get('cart', []);
        
        // Calcula o valor total acumulado no carrinho
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('public.cart.index', compact('cart', 'total'));
    }

    /**
     * Adicionar (ou incrementar) um produto no carrinho.
     */
    public function adicionar(Request $request)
    {
        $product = Product::with('images')->findOrFail($request->product_id);
        $quantity = (int) $request->input('quantity', 1);

        // Captura o carrinho atual da sessão
        $cart = session()->get('cart', []);

        // Se o produto já existe no carrinho, apenas incrementa a quantidade
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Se for um produto novo, adiciona as informações seguras no array
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->images->first()->url ?? null,
                "slug" => $product->slug
            ];
        }

        // Grava o carrinho atualizado de volta na sessão do utilizador
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Atualizar a quantidade de um item diretamente na página do carrinho.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('carrinho.index')->with('success', 'Carrinho atualizado!');
        }

        return redirect()->route('carrinho.index')->with('error', 'Produto não encontrado.');
    }

    /**
     * Remover um produto específico do carrinho.
     */
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('carrinho.index')->with('success', 'Produto removido com sucesso!');
    }

    /**
     * Adiciona apenas uma unidade diretamente a partir da listagem de produtos.
     */
    public function adicionarUm(Request $request)
    {
        // Força a quantidade para 1 e reaproveita a lógica do método principal
        $request->merge(['quantity' => 1]);
        return $this->adicionar($request);
    }
}