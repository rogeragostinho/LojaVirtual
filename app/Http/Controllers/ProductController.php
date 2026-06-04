<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Exibe a listagem dos produtos no painel administrativo.
     */
    public function index()
    {
        // Carrega a relação 'category' automaticamente para evitar o problema de N+1 consultas na BD
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Mostra o formulário para criar um novo produto.
     */
    public function create()
    {
        // Precisamos listar as categorias para preencher o <select> do formulário
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Guarda um novo produto na base de dados.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // 1. Gera o slug automaticamente baseado no nome do produto
        $data['slug'] = Str::slug($request->name);

        // 2. Associa automaticamente o id do Admin/Super Admin que está a criar o produto
        $data['user_id'] = Auth::id();

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um produto específico (Útil para a loja ou preview).
     */
    public function show(Product $product)
    {
        // Carrega as relações necessárias se fores exibir na view
        $product->load(['category', 'images']);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Mostra o formulário para editar um produto existente.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Atualiza o produto na base de dados.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Se o nome foi alterado, regenera o slug
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove o produto da base de dados.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto eliminado com sucesso!');
    }
}