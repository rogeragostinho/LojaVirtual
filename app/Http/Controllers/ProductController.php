<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $product = Product::create($data);

        // 4. 💡 PROCESSAR E SALVAR AS IMAGENS (Se forem enviadas)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Guarda a imagem física na pasta 'storage/app/public/products'
                // O Laravel gera um nome único e seguro para o ficheiro automaticamente
                $path = $image->store('products', 'public');

                // Salva o caminho (URL de acesso relativo) na tabela product_images
                $product->images()->create([
                    'url' => 'storage/' . $path
                ]);
            }
        }

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

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'url' => 'storage/' . $path
                ]);
            }
        }

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

    public function destroyImage(ProductImage $image)
{
        // 1. Descobrir o caminho real no disco eliminando o prefixo 'storage/'
        // Se a URL for 'storage/products/imagem.jpg', o path fica 'products/imagem.jpg'
        $relativePath = str_replace('storage/', '', $image->url);

        // 2. Eliminar o ficheiro físico da pasta storage/app/public/products
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        // 3. Eliminar o registo na tabela product_images
        $image->delete();

        // 4. Redirecionar de volta para a página de edição com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Imagem eliminada com sucesso!');
    }
}