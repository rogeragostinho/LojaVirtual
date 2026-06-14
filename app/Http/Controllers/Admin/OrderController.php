<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Listar todas as encomendas no painel.
     */
    public function index(Request $request)
    {
        // Eager loading do utilizador para evitar o problema N+1 queries
        $query = Order::with('user');

        // Filtro por Estado (Status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por Pesquisa rápida (ID da encomenda ou nome do cliente)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mostrar os detalhes de uma encomenda específica e os seus produtos.
     */
    public function show(Order $order)
    {
        // Carrega as relações necessárias para mostrar na View
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Atualizar o estado da encomenda (pending, paid, shipped, cancelled).
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Estado da encomenda atualizado com sucesso!');
    }
}