@extends('public.layout.index')

@section('title', $product->name . ' - NexaStore')

@section('conteudo')

<div class="container py-5">
    <div class="row g-5">
        
        <!-- Coluna da Imagem / Carrossel -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-3 bg-white sticky-md-top" style="top: 90px; z-index: 1;">
                @if($product->images->isNotEmpty())
                    @if($product->images->count() == 1)
                        <img src="{{ asset($product->images->first()->url) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 500px; width: 100%; object-fit: contain;">
                    @else
                        <div id="productCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($product->images as $index => $image)
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image->url) }}" class="d-block w-100 rounded" alt="Foto {{ $index + 1 }} de {{ $product->name }}" style="max-height: 500px; object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>
                    @endif
                @else
                    <img src="https://placehold.co/600x600/e9ecef/6c757d?text=Sem+Imagem" class="img-fluid rounded" alt="Sem Imagem">
                @endif
            </div>
        </div>

        <!-- Coluna dos Detalhes e Compra -->
        <div class="col-lg-6 d-flex flex-column justify-content-between">
            <div>
                <div class="mb-2">
                    <span class="badge bg-secondary text-uppercase px-3 py-2 fs-7 rounded-pill">
                        <i class="fas fa-tags me-1"></i> {{ $product->category->name ?? 'Geral' }}
                    </span>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2 fs-7 rounded-pill ms-1">
                        {{ $product->stock > 0 ? 'Em Stock (' . $product->stock . ')' : 'Esgotado' }}
                    </span>
                </div>

                <h1 class="fw-bold text-dark display-6 mb-3">{{ $product->name }}</h1>

                <h2 class="text-primary fw-extrabold display-5 mb-4">
                    {{ number_format($product->price, 2, ',', '.') }} Kz
                </h2>

                <hr class="text-muted my-4">

                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="fas fa-align-left me-2"></i>Descrição do Produto</h5>
                    <p class="text-secondary lh-lg" style="white-space: pre-line;">
                        {{ $product->description ?? 'Este produto não possui detalhes ou descrição cadastrada.' }}
                    </p>
                </div>

                <div class="bg-light rounded p-3 mb-4 border-start border-primary border-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-user-edit me-2"></i> Vendedor / Admin: <strong>{{ $product->user->name ?? 'Sistema' }}</strong>
                    </small>
                    <small class="text-muted d-block">
                        <i class="fas fa-calendar-alt me-2"></i> Publicado em: {{ $product->created_at->format('d/m/Y \à\s H:i') }}
                    </small>
                </div>
            </div>

            <!-- Zona de Ação (Carrinho e Favoritos) -->
            <div>
                @if($product->stock > 0)
                    <div class="card p-3 shadow-sm border-0 bg-white">
                        <div class="row align-items-end g-3">
                            
                            <!-- Formulário do Carrinho -->
                            <div class="col-md-10">
                                <form action="{{ route('carrinho.adicionar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="row align-items-end g-2">
                                        <div class="col-4">
                                            <label for="quantity" class="form-label fw-bold text-secondary small">Qtd:</label>
                                            <input type="number" id="quantity" name="quantity" class="form-control text-center py-2" value="1" min="1" max="{{ $product->stock }}" required>
                                        </div>
                                        <div class="col-8">
                                            <button type="submit" class="btn btn-primary btn-lg w-100 py-2 fw-bold shadow-sm" style="font-size: 1.05rem;">
                                                <i class="fas fa-shopping-cart me-2"></i> Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Formulário de Favoritos Lado a Lado -->
                            <div class="col-md-2 text-center">
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    @php
                                        $isFavorited = auth()->check() && auth()->user()->favoriteProducts->contains($product->id);
                                    @endphp
                                    <button type="submit" class="btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} btn-lg w-100 py-2 shadow-sm" title="{{ $isFavorited ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}">
                                        <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @else
                    <!-- Estado Esgotado -->
                    <div class="alert alert-warning border-0 p-3 shadow-sm d-flex align-items-center mb-3">
                        <i class="fas fa-bell fa-lg me-3"></i>
                        <div>
                            <strong>Produto Temporariamente Indisponível!</strong><br>
                            Este item encontra-se esgotado no momento.
                        </div>
                    </div>

                    <!-- Botão de Favoritos mantido ativo mesmo sem Stock -->
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="text-end">
                        @csrf
                        @php
                            $isFavorited = auth()->check() && auth()->user()->favoriteProducts->contains($product->id);
                        @endphp
                        <button type="submit" class="btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} w-100 py-2.5 rounded-pill fw-bold shadow-sm">
                            <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart me-2"></i>
                            {{ $isFavorited ? 'Remover dos Meus Favoritos' : 'Guardar nos Favoritos' }}
                        </button>
                    </form>
                @endif
            </div>
            
        </div>
    </div>
</div>

@endsection