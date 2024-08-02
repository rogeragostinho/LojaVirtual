@extends('public.layout.index')
@section('title', 'Categoria')
@section('conteudo')

    <div class = "container-md pt-4">

        @include('includes.mensagem')

        @if ($itens->count() != 0)
            <h3>Seu carrinho possui {{ $itens->count() }} produto(s).</h3>

            <table class = "table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="text-white"> Imagem </th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade </th>
                        <th scope="col" class="text-white"> Opções</th>
                    </tr>
                </thead>

                <tbody class="bg-success">
                    @foreach ($itens as $item)
                        <tr>
                            <td><img src="{{ asset('img/3.jpg') }}" width="70" class="img-fluid rounded-circle"></td>
                            <td class="align-middle">{{ $item->name }} </td>
                            <td class="align-middle">R$ {{ number_format($item->price, 2, ',', '.') }} </td>

                            <form action = "{{ route('carrinho.atualizar') }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                <td class="align-middle">
                                    <input style="width: 70px; font-weight:900" class="form-control" type="number"
                                        name="quantity" value="{{ $item->quantity }}" min="1">

                                </td>
                                <td class="align-middle">
                                    <input type="hidden" name ="id" value="{{ $item->id }}">
                                    <button type="submit" class="btn  btn-warning me-1 rounded-circle"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="white" height="24"
                                            viewBox="0 -960 960 960" width="24">
                                            <path
                                                d="M479.043-151.869q-137.108 0-232.619-95.511T150.913-480q0-137.109 95.511-232.62t232.619-95.511q71.153 0 135.707 29.218 64.554 29.217 110.511 83.891v-113.109h83.826v291.718H517.13V-600h166.566q-32-54.565-86.424-85.848-54.424-31.282-118.229-31.282-98.804 0-167.967 69.163Q241.913-578.804 241.913-480q0 98.804 69.163 167.967 69.163 69.163 167.967 69.163 75.566 0 136.729-43.282Q676.935-329.435 702.174-400h95.239q-28.239 109.348-116.63 178.739-88.392 69.392-201.74 69.392Z" />
                                        </svg></button>
                            </form>

                            <form action = "{{ route('carrinho.remover') }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name ="id" value="{{ $item->id }}">
                                <button class="btn btn-danger rounded-circle"><svg xmlns="http://www.w3.org/2000/svg"
                                        height="24" fill="white" viewBox="0 -960 960 960" width="24">
                                        <path
                                            d="M277.37-111.869q-37.783 0-64.392-26.609-26.609-26.609-26.609-64.392v-514.5h-45.5v-91H354.5v-45.5h250.522v45.5h214.109v91h-45.5v514.5q0 37.783-26.609 64.392-26.609 26.609-64.392 26.609H277.37ZM682.63-717.37H277.37v514.5h405.26v-514.5ZM355.696-280.239h85.5v-360h-85.5v360Zm163.108 0h85.5v-360h-85.5v360ZM277.37-717.37v514.5-514.5Z" />
                                    </svg></button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card">
                <div class="card-body bg-primary text-white">
                    <h5 class="card-title">R$ {{ number_format(\Cart::getTotal(), 2, ',', '.') }}</h5>
                    <p class="card-text">Pague em 12x Sem juros!</p>
                </div>
            </div>
        @else
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="gray"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Warning:">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    <strong> carrinho está vazio! </strong> Aproveite nossas promoções!
                </div>
            </div>
        @endif

        <div class="container d-flex justify-content-center my-5">
            <div class="btn-group ms-1" role="group" aria-label="Basic mixed styles example">
                <a href="{{ route('index') }}" class="btn btn-primary me-1">Continuar comprando</a>
                <a href ="{{ route('carrinho.limpar') }}" class="btn btn-primary me-1">Limpar carrinho</a>
                <button type="button" class="btn btn-success">Finalizar pedido</button>
            </div>
        </div>

    @endsection
