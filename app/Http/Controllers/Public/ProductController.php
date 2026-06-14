<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Página Inicial - Listar todos os produtos ativos.
     */
    public function index()
    {
        // Carrega os produtos ativos, com as suas imagens ( eager loading para performance) paginados
        $products = Product::where('status', 'active')
            ->with('images')
            ->latest()
            ->paginate(9);

        return view('public.products.index', compact('products'));
    }

    /**
     * Detalhes de um Produto Específico.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'category'])
            ->firstOrFail();

        // Buscar produtos relacionados (mesma categoria) para sugerir ao cliente
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('public.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Filtrar produtos por Categoria.
     */
    public function byCategory(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->with('images')
            ->latest()
            ->paginate(9);

        return view('public.products.index', [
            'products' => $products,
            'title' => 'Categoria: ' . $category->name
        ]);
    }

    /**
     * Pesquisa de produtos.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('images')
            ->paginate(9)
            ->appends(['search' => $query]); // Mantém o termo da pesquisa na paginação

        return view('public.products.index', [
            'products' => $products,
            'title' => 'Resultados para: "' . $query . '"'
        ]);
    }
}
