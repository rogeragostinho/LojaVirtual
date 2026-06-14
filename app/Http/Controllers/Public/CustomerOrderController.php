<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Listar todas as encomendas do cliente logado.
     */
    public function index()
    {
        // Pega apenas as encomendas que pertencem ao ID do utilizador autenticado
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('public.profile.orders.index', compact('orders'));
    }

    /**
     * Mostrar os detalhes de uma encomenda específica do cliente.
     */
    public function show(Order $order)
    {
        // 🔒 SEGURANÇA MÁXIMA: Se a encomenda não for deste cliente, bloqueia com erro 403
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Não tens permissão para visualizar esta encomenda.');
        }

        // Carrega os itens da encomenda e os respetivos produtos de forma otimizada
        $order->load('items.product');

        return view('public.profile.orders.show', compact('order'));
    }
}