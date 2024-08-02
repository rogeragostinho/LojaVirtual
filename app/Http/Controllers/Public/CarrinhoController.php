<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function index()
    {
        $itens = \Cart::getContent();
        return view('public.carrinho', compact('itens'));
    }

    public function adicionar(Request $request)
    {
        
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => abs($request->qnt),
            'attributes' => array(
                'image' => $request->img
            ),
       ]);
       return redirect()->route('carrinho.index')->with('sucesso', 'Produto adicionado no carrinho com sucesso');
    }

    public function adicionarUm(Request $request)
    {
        
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => abs($request->qnt),
            'attributes' => array(
                'image' => $request->img
            ),
       ]);
       return redirect()->back()->with('sucesso', 'Produto adicionado no carrinho com sucesso');
    }

    public function remover(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->route('carrinho.index')->with('sucesso', 'Produto removido com sucesso');
    }

    public function atualizar(Request $request)
    {
        \Cart::update($request->id, array(
            'quantity' => [
                'relative' => false,
                'value' => abs($request->quantity),
            ]
        ));
        return redirect()->route('carrinho.index')->with('sucesso', 'Produto atualizado com sucesso');
    }

    public function limpar()
    {
        \Cart::clear();
        return redirect()->route('carrinho.index')->with('aviso', 'Seu carrinho está vazio');
    }
}