@extends('public.layout.index')
@section('title', 'Home')
@section('conteudo')

    <div class = "container-md pt-4">
        <div class="row my-3 justify-content-between">
            <div class="col-auto">
                <h3 class="fw-bold py-1" style="border-left: solid 7px #0d6efd">
                    <span class="ms-2">PRODUTOS</span>
                </h3>
            </div>
            <div class="col-auto">
                <form action="" method="post">
                    @csrf
                    <div class="row g-1">
                        <div class="col-auto">
                            <input type="search" name="" id="" class="form-control" placeholder="produto">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach ($produtos as $produto)
                <div class ="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('img/2.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"> {{ $produto->nome }}</h5>
                            <p class="card-text text-truncate">{{ $produto->preco }}</p>
                            <div>
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="{{ route('produtos.show', $produto->slug) }}" class="btn btn-primary">Ver
                                            Produto</a>
                                    </div>
                                    <div class="col-auto">
                                        <form action = "{{ route('carrinho.adicionarUm') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $produto->id }}">
                                            <input type="hidden" name="name" value="{{ $produto->nome }}">
                                            <input type="hidden" name="price" value="{{ $produto->preco }}">
                                            <input type="hidden" class="form-control mb-4" name="qnt" value="1"
                                                min="1">
                                            <input type="hidden" name="img" value="{{ $produto->imagem }}">
                                            <button class="btn btn-primary">Comprar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    <div class="container">
        <div class="row mt-4">
            {{ $produtos->links('custom.navigation') }}
        </div>
    </div>

@endsection
