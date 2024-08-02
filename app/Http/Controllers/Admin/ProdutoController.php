<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        return view('admin.produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoRequest $request)
    {
        try {
            $produto = $request->all();
            if ($request->imagem) {
                $produto['imagem'] = $request->imagem->store('produtos');
            }
            $produto['slug'] = Str::slug($produto);
            Produto::create($request->all());
            return redirect()->route('admin.produtos.index')->with('success', 'Produto criado com sucesso');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.produtos.index')->with('error', 'Ocorreu um erro ao criar o produto');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($produto = Produto::find($id)) {
            return view('admin.produtos.show', compact('produto'));
        }
        return redirect()->route('admin.produtos.index')->with('error', 'Produto inexistente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if ($produto = Produto::find($id)) {
            return view('admin.produtos.edit', compact('produto'));
        }
        return redirect()->route('admin.produtos.index')->with('error', 'Produto inexistente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoRequest $request, string $id)
    {
        try {
            $produtoAtualizado = $request->all();
            $produtoAntigo = Produto::find($id);
            if ($request->imagem) {
                $produtoAtualizado['imagem'] = $request->imagem->store('produtos');
                /**
                 * eliminar imagem antiga
                 * $produto->imagem->delete;
                 */
            }
            $produtoAtualizado['slug'] = Str::slug($produtoAtualizado);
            $produtoAntigo->update($produtoAtualizado);
            return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado com sucesso');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.produtos.index')->with('error', 'Ocorreu um erro ao realizar a operação');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $produto = Produto::find($id);
            $produto->delete();
            return redirect()->route('admin.produtos.index')->with('success', 'Produto eliminado com sucesso');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.produtos.index')->with('error', 'Ocorreu um erro ao realizar a operação');
        }
    }
}
