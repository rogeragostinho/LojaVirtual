@extends('admin.layout')
@section('titulo', 'Produtos')
@section('conteudo')

    @include('admin.produtos.create')

    <div class="container-md pt-4">
        @include('includes.mensagem')


        <div class="row align-items-center mb-3">
            <div class="col">
                <h1 class="left">Produtos</h1>
            </div>
            <div class="col text-end">
                <a href="#create" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    class="btn btn-primary fw-bold text-white btn-lg"type="button">Adicionar</a>
            </div>
        </div>
        <div class="row">
            <div class="col text-end">
                <p class="">{{ $produtos->count() }} produtos apresentados nesta secção</p>
            </div>

        </div>

        <form>
            <div class="row my-5 justify-content-center">
                <div class="col-8">
                    <div class="input-group">
                        <div class="form-floating is-invalid">
                            <input type="search" class="form-control" id="floatingInputGroup2" placeholder="Username"
                                required>
                            <label class="text-muted" for="floatingInputGroup2">Pesquisar produto</label>
                        </div>
                        <button class="btn btn-primary input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="30" viewBox="0 -960 960 960"
                                width="30">
                                <path
                                    d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th scope="col" class="text-white">Imagem</th>
                        <th scope="col">ID</th>
                        <th scope="col">Produto</th>

                        <th scope="col">Preço</th>
                        <th scope="col">Categoria</th>
                        <th scope="col" class="text-white">Opções</th>
                    </tr>
                </thead>

                <tbody class="align-middle">
                    @foreach ($produtos as $produto)
                        <tr>
                            <td><img src="{{-- $item->attributes->img --}} {{ asset('img/2.jpg') }}" width="70"
                                    class="img-fluid rounded-circle"></td>
                            <td> {{ $produto->id }} </td>
                            <td> {{ $produto->nome }} </td>
                            <td>{{ number_format($produto->preco, 2, ',', '.') }} Kz</td>
                            <td>{{ $produto->categoria->nome }}</td>
                            <td><button
                                    href="{{ route('site.atualizacarrinho') }}"class="btn  btn-warning me-1 rounded-circle"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="white" height="24"
                                        viewBox="0 -960 960 960" width="24">
                                        <path
                                            d="M479.043-151.869q-137.108 0-232.619-95.511T150.913-480q0-137.109 95.511-232.62t232.619-95.511q71.153 0 135.707 29.218 64.554 29.217 110.511 83.891v-113.109h83.826v291.718H517.13V-600h166.566q-32-54.565-86.424-85.848-54.424-31.282-118.229-31.282-98.804 0-167.967 69.163Q241.913-578.804 241.913-480q0 98.804 69.163 167.967 69.163 69.163 167.967 69.163 75.566 0 136.729-43.282Q676.935-329.435 702.174-400h95.239q-28.239 109.348-116.63 178.739-88.392 69.392-201.74 69.392Z" />
                                    </svg></button>
                                <button class="btn btn-danger rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                                        height="24" fill="white" viewBox="0 -960 960 960" width="24">
                                        <path
                                            d="M277.37-111.869q-37.783 0-64.392-26.609-26.609-26.609-26.609-64.392v-514.5h-45.5v-91H354.5v-45.5h250.522v45.5h214.109v91h-45.5v514.5q0 37.783-26.609 64.392-26.609 26.609-64.392 26.609H277.37ZM682.63-717.37H277.37v514.5h405.26v-514.5ZM355.696-280.239h85.5v-360h-85.5v360Zm163.108 0h85.5v-360h-85.5v360ZM277.37-717.37v514.5-514.5Z" />
                                    </svg></button>
                            </td>

                            @include('admin.produtos.delete')
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class = "row center">
            {{ $produtos->links('custom.navigation') }}
        </div>
    </div>

@endsection
