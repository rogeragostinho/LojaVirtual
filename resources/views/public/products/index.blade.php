@extends('public.layout.index')

@section('title', $title ?? 'Produtos - NexaStore')

@section('conteudo')

    <div class="row mb-4 align-items-center justify-content-between g-3">
        <div class="col-md-auto">
            <h3 class="fw-bold m-0 text-uppercase text-dark border-start border-primary border-4 ps-3">
                {{ $title ?? 'Todos os Produtos' }}
            </h3>
        </div>
        <div class="col-md-4">
            <form action="{{ route('produtos.search') }}" method="GET">
                <div class="input-group">
                    <input type="search" name="search" class="form-control" placeholder="O que procura hoje?..." value="{{ request('search') }}" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 position-relative transition-hover">
                    
                    @if($product->images->isNotEmpty())
                        <img src="{{ asset($product->images->first()->url) }}" class="card-img-top product-card-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://placehold.co/600x400/e9ecef/6c757d?text=Sem+Imagem" class="card-img-top product-card-img" alt="Sem Imagem">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <span class="text-muted small mb-1">{{ $product->category->name ?? 'Geral' }}</span>
                        <h5 class="card-title fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h5>
                        
                        <h4 class="text-primary fw-bold mb-3 mt-auto">
                            {{ number_format($product->price, 2, ',', '.') }} Kz
                        </h4>

                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('produtos.show', $product->slug) }}" class="btn btn-outline-primary btn-sm w-100 py-2">
                                    <i class="fas fa-eye me-1"></i> Detalhes
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('carrinho.adicionarUm') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2">
                                        <i class="fas fa-shopping-basket me-1"></i> Adicionar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted fs-4">
                    <i class="fas fa-box-open fa-2x mb-3 d-block text-secondary"></i>
                    Nenhum produto foi encontrado nesta listagem.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>

@endsection