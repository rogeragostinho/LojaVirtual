<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('created_at', 'desc')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required'
        ], [
            'nome.required' => 'Um nome é obrigatório'
        ]);
        try {
            Categoria::create($request->all());
            return redirect()->route('adminCategoria.index')->with('success', 'Categoria criada com sucesso');;
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('adminCategoria.index')->with('erro', 'Ocorreu um erro ao realizar a operação');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($categoria = Categoria::find($id)) {
            return view('admin.categorias.show', compact('categoria'));
        }
        return redirect()->route('adminCategoria.index')->with('erro', 'Categoria inexistente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if ($categoria = Categoria::find($id)) {
            return view('admin.categorias.edit', compact('categoria'));
        }
        return redirect()->route('adminCategoria.index')->with('erro', 'Categoria inexistente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required'
        ], [
            'nome.required' => 'Um nome é obrigatório'
        ]);
        try {
            $categoria = Categoria::find($id);
            $categoria->update($request->all());
            return redirect()->route('adminCategoria.index')->with('success', 'Categoria atualizada com sucesso');;
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('adminCategoria.index')->with('erro', 'Ocorreu um erro ao realizar a operação');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $categoria = Categoria::find($id);
            $categoria->delete();
            return redirect()->route('adminCategoria.index')->with('success', 'Categoria eliminada com sucesso');;
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('adminCategoria.index')->with('erro', 'Ocorreu um erro ao realizar a operação');
        }
    }
}
