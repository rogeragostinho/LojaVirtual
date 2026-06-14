@extends('public.layout.index')

@section('title', 'O Meu Carrinho - NexaStore')

@section('conteudo')
<div class="container py-5">
    <h3 class="fw-bold mb-4 text-dark border-start border-primary border-4 ps-3">
        <i class="fas fa-shopping-cart me-2 text-primary"></i> O MEU CARRINHO
    </h3>

    @if(count($cart) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="table-responsive">
                        <table class="table table-align-middle mb-0">
                            <thead class="table-light text-uppercase fs-7 text-muted">
                                <tr>
                                    <th scope="col" class="ps-4">Produto</th>
                                    <th scope="col" class="text-center">Preço</th>
                                    <th scope="col" class="text-center" style="width: 15%;">Quantidade</th>
                                    <th scope="col" class="text-center">Subtotal</th>
                                    <th scope="col" class="pe-4 text-center">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($item['image'])
                                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="rounded me-3 border shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <img src="https://placehold.co/600x400/e9ecef/6c757d?text=Sem+Foto" alt="Sem Imagem" class="rounded me-3 border" style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <a href="{{ route('produtos.show', $item['slug']) }}" class="text-decoration-none fw-bold text-dark hover-primary d-block text-truncate" style="max-width: 200px;">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center fw-medium text-secondary">
                                            {{ number_format($item['price'], 2, ',', '.') }} Kz
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('carrinho.update', $id) }}" method="POST" class="d-flex justify-content-center">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm" style="max-width: 100px;">
                                                    <input type="number" name="quantity" class="form-control text-center px-1" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Atualizar">
                                                        <i class="fas fa-sync-alt fs-7"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>

                                        <td class="text-center fw-bold text-dark">
                                            {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }} Kz
                                        </td>

                                        <td class="pe-4 text-center">
                                            <form action="{{ route('carrinho.destroy', $id) }}" method="POST" onsubmit="return confirm('Deseja remover este produto do carrinho?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link link-danger p-0" title="Remover Produto">
                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">Resumo do Pedido</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span>Subtotal de itens:</span>
                        <span>{{ count($cart) }} {{ count($cart) === 1 ? 'produto' : 'produtos' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-4">
                        <span class="fw-bold text-dark fs-5">Total Estimado:</span>
                        <span class="fw-extrabold text-success fs-4">{{ number_format($total, 2, ',', '.') }} Kz</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 py-2.5 fw-bold shadow-sm rounded-pill text-uppercase fs-6">
                        <i class="fas fa-check-circle me-2"></i> Finalizar Compra
                    </a>
                    
                    <a href="{{ route('index') }}" class="btn btn-link text-center w-100 mt-3 text-decoration-none text-muted small">
                        <i class="fas fa-arrow-left me-1"></i> Continuar a comprar
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-3 text-center py-5 px-4 bg-white">
            <div class="mb-4">
                <i class="fas fa-shopping-basket fa-4x text-light bg-light rounded-circle p-4 border shadow-sm"></i>
            </div>
            <h4 class="fw-bold text-dark">O seu carrinho está vazio</h4>
            <p class="text-muted mb-4">Parece que ainda não adicionou nenhum produto ao seu cesto de compras.</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('index') }}" class="btn btn-primary px-5 py-2.5 fw-bold rounded-pill shadow-sm">
                    <i class="fas fa-store me-2"></i> Explorar Produtos
                </a>
            </div>
        </div>
    @endif
</div>
@endsection