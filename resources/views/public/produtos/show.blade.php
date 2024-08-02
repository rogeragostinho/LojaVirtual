@extends('public.layout.index')
@section('title', 'Detalhes')
@section('conteudo')

    <div class="container-md pt-4">
        <div class="row">
            <div class = "col-lg-6 text-center text-start-lg">
                <img src = "{{-- $produto->imagem --}}{{ asset('img/3.jpg') }}" class = "img-fluid rounded mx-auto">
            </div>

            <div class = "col-lg-6 my-5 m-lg-0">
                <h2 class="mb-4">{{ $produto->nome }} </h2>
                <h2 class="mb-3">$ {{ number_format($produto->preco, 2, ',', '.') }} </h2>
                <p>{{ $produto->descricao }} <br>
                    Postado por: {{ $produto->user->firstName }}<br>
                    Categoria: {{ $produto->Categoria->nome }}
                </p>
                <form action = "{{ route('carrinho.adicionar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $produto->id }}">
                    <input type="hidden" name="name" value="{{ $produto->nome }}">
                    <input type="hidden" name="price" value="{{ $produto->preco }}">
                    <input type="number" class="form-control mb-4" name="qnt" value="1" min="1">
                    <input type="hidden" name="img" value="{{ $produto->imagem }}">
                    <button class="btn btn-primary btn-lg">Comprar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
