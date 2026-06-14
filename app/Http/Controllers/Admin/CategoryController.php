<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Exibe a listagem das categorias.
     */
    public function index()
    {
        // Paginação para evitar sobrecarregar a página caso haja muitas categorias
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Mostra o formulário para criar uma nova categoria.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Guarda uma nova categoria na base de dados.
     */
    public function store(StoreCategoryRequest $request)
    {
        // Pega nos dados validados do Request
        $data = $request->validated();

        // Gera o slug automaticamente baseado no nome enviado
        $data['slug'] = Str::slug($request->name);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma categoria específica (geralmente opcional no admin de categorias).
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Mostra o formulário para editar uma categoria existente.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Atualiza a categoria na base de dados.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        // Se o nome mudou, atualiza o slug também
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove a categoria da base de dados.
     */
    public function destroy(Category $category)
    {
        // O Laravel lida com a integridade referencial automaticamente se usaste 'cascade' na migration
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria eliminada com sucesso!');
    }
}