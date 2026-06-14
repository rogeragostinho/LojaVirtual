<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Listar todos os clientes do sistema.
     */
    public function index(Request $request)
    {
        // Criamos uma consulta base filtrando apenas clientes comuns
        $query = User::where('role', 'user');

        // Opcional: Adiciona uma barra de pesquisa para encontrar clientes por nome ou e-mail
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Visualizar o perfil do cliente e o seu histórico (futuro).
     */
    public function show(User $customer)
    {
        // Segurança: Garante que não estão a tentar ver um admin por esta rota
        if ($customer->role !== UserRole::USER) {
            abort(404);
        }

        // No futuro, podes carregar os pedidos dele aqui: $customer->load('orders')
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Eliminar (ou banir) a conta de um cliente.
     */
    public function destroy(User $customer)
    {
        if ($customer->role !== 'user') {
            abort(403);
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Conta do cliente removida com sucesso!');
    }
}