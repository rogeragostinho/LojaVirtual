<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usuarios = User::all()->count();

        //grafico 1 - usuarios
        $usersData = User::select([
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('COUNT(*) as total')
        ])
        ->groupBy('ano')
        ->orderBy('ano', 'asc')
        ->get();

        foreach($usersData as $user)
        {
            $ano[] = $user->ano;
            $totalU[] = $user->total;
        }

        //dd($usersData);
        //formatar para chartjs

        $userLabel = "'Comparativo de cadastros de usuários'";
        $userAno = implode(',', $ano);
        $userTotal = implode(',', $totalU);
        
        //grafico 2 - categorias
        $catData = Category::with('products')->get();
        
        foreach($catData as $categoria)
        {
            $nome[] = "'".$categoria->nome."'";
            $totalP[] = $categoria->products->count();
        }


        // formatar para chartjs
        $categorias = implode(',', $nome ?? []);
        $produtosTotal = implode(',', $totalP ?? []);

        //dd($produtosTotal);

        return view('admin.dashboard', compact('usuarios', 'userLabel', 'userAno', 'userTotal', 'categorias', 'produtosTotal'));
    }
}
