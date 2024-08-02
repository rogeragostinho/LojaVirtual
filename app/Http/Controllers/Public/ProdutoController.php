<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produtos = Produto::paginate(6);
        return view('public.produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produto = $request->all();

        if($request->imagem){
            $produto['imagem'] = $request->imagem->store('produtos');
        }

        $produto['slug'] = Str::slug($request->nome);
        $produto = Produto::create($produto);
        
        return redirect()->route('admin.produtos')->with('sucesso', "Produto cadastrado com sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        //
        $produto = Produto::where('slug', $slug)->first();
        return view('public.produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::find($id);
        $produto->delete();
        return redirect()->route('admin.produtos');
    }

    /**
     * Apresenta produtos por categoria
     */
    public function byCategoria(string $id){
        $produtos = Produto::where('id_categoria', $id)->paginate(6);
        return view('public.produtos.index', compact('produtos'));
    }
}
