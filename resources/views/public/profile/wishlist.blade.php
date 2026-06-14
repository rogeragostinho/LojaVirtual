@extends('public.layout.index')

@section('title', 'Meus Favoritos - NexaStore')

@section('conteudo')
<div class="container py-5">
    <div class="row g-4">
        
        <!-- Menu Lateral do Perfil -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                <div class="text-center py-3 border-bottom mb-3">
                    <i class="fas fa-user-circle fa-3x text-secondary mb-2"></i>
                    <h6 class="fw-bold text-dark mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">Cliente NexaStore</small>
                </div>
                <div class="nav flex-column nav-pills check-profile-nav">
                    <a href="{{ route('customer.orders.index') }}" class="nav-link text-secondary rounded-pill mb-2">
                        <i class="fas fa-box me-2"></i> As Minhas Encomendas
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link text-secondary rounded-pill mb-2">
                        <i class="fas fa-user-cog me-2"></i> Gerenciar Perfil
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="nav-link active rounded-pill">
                        <i class="fas fa-heart me-2"></i> Meus Favoritos
                    </a>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal: Grelha de Produtos Favoritos -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <h4 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="fas fa-heart text-danger me-2"></i> Os Meus Favoritos
                </h4>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
                @endif

                @if($favorites->count() > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @foreach($favorites as $product)
                            <div class="col">
                                <div class="card h-100 border rounded-3 shadow-sm position-relative">
                                    
                                    <!-- Botão de Remover dos Favoritos diretamente no Card -->
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="position-absolute top-0 end-0 m-2 z-3">
                                        @csrf
                                        <button type="submit" class="btn btn-white bg-white rounded-circle shadow-sm p-2 text-danger border-0" title="Remover dos favoritos">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>

                                    <!-- Imagem do Produto -->
                                    @if($product->images->first())
                                        <img src="{{ asset($product->images->first()->url) }}" class="card-img-top rounded-top-3" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                                    @else
                                        <img src="https://placehold.co/600x400/e9ecef/6c757d?text=Sem+Foto" class="card-img-top rounded-top-3" alt="Sem Foto" style="height: 180px; object-fit: cover;">
                                    @endif

                                    <!-- Detalhes do Card -->
                                    <div class="card-body d-flex flex-column justify-content-between p-3">
                                        <div>
                                            <h6 class="fw-bold text-dark text-truncate mb-1">{{ $product->name }}</h6>
                                            <p class="text-success fw-bold mb-3 fs-5">{{ number_format($product->price, 2, ',', '.') }} Kz</p>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <!-- Reaproveita a rota de adicionar 1 unidade ao carrinho que criámos no início -->
                                            <form action="{{ route('carrinho.adicionarUm') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold">
                                                    <i class="fas fa-shopping-cart me-1"></i> Comprar
                                                </button>
                                            </form>
                                            <a href="{{ route('produtos.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm rounded-pill text-center">
                                                Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $favorites->links() }}
                    </div>
                @else
                    <!-- Estado Vazio -->
                    <div class="text-center py-5 text-muted">
                        <i class="far fa-heart fa-3x mb-3 text-light d-block"></i>
                        Ainda não guardaste nenhum produto como favorito.
                        <div class="mt-3">
                            <a href="{{ route('index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                Explorar Loja
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection