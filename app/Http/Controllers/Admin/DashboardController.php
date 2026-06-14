<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Order; // Certifica-te de que tens o Model Order criado
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Métricas dos Cards Principais
        $totalUsuarios = User::count();
        
        // Exemplo de agregação de faturamento real baseado nos teus Pedidos (ajusta se usares outro campo)
        $faturamento = Order::where('status', OrderStatus::PAID)->sum('total') ?? 0;
        
        // Pedidos criados no mês atual
        $pedidosMes = Order::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // 2. Gráfico 1 - Aquisição de Usuários por Ano (Formatado nativamente para JSON)
        $usersData = User::select([
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('COUNT(*) as total')
        ])
        ->groupBy('ano')
        ->orderBy('ano', 'asc')
        ->get();

        $userAno = $usersData->pluck('ano')->toArray();
        $userTotal = $usersData->pluck('total')->toArray();
        
        // 3. Gráfico 2 - Distribuição de Produtos por Categoria
        // Contamos os produtos diretamente via banco usando withCount para não sobrecarregar a memória
        $catData = Category::withCount('products')->get();
        
        $categoriasLabels = $catData->pluck('name')->toArray(); // Alterado de 'nome' para 'name'
        $produtosTotais = $catData->pluck('products_count')->toArray();

        return view('admin.dashboard', [
            'usuarios'      => $totalUsuarios,
            'faturamento'   => $faturamento,
            'pedidosMes'    => $pedidosMes,
            'userAno'       => json_encode($userAno),
            'userTotal'     => json_encode($userTotal),
            'categorias'    => json_encode($categoriasLabels),
            'produtosTotal' => json_encode($produtosTotais),
        ]);
    }
}