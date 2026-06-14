@extends('public.layout.index')

@section('title', 'Meus Pedidos - NexaStore')

@section('conteudo')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                <div class="text-center py-3 border-bottom mb-3">
                    <i class="fas fa-user-circle fa-3x text-secondary mb-2"></i>
                    <h6 class="fw-bold text-dark mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">Cliente NexaStore</small>
                </div>
                <div class="nav flex-column nav-pills check-profile-nav">
                    <a href="{{ route('customer.orders.index') }}" class="nav-link active rounded-pill mb-2">
                        <i class="fas fa-box me-2"></i> As Minhas Encomendas
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link text-secondary rounded-pill mb-2">
                        <i class="fas fa-user-cog me-2"></i> Gerenciar Perfil
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="nav-link text-secondary rounded-pill">
                        <i class="fas fa-heart me-2"></i> Meus Favoritos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <h4 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="fas fa-history text-muted me-2"></i> Histórico de Encomendas
                </h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7 text-muted">
                            <tr>
                                <th scope="col" class="ps-3">Nº Pedido</th>
                                <th scope="col">Data</th>
                                <th scope="col">Total</th>
                                <th scope="col" class="text-center">Estado</th>
                                <th scope="col" class="text-end pe-3">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="ps-3 py-3"><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y \à\s H:i') }}</td>
                                    <td class="fw-bold text-dark">{{ number_format($order->total, 2, ',', '.') }} Kz</td>
                                    <td class="text-center">
                                        @php $currentStatus = is_object($order->status) ? $order->status->value : $order->status; @endphp
                                        
                                        @if($currentStatus === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Aguardando Confirmação</span>
                                        @elseif($currentStatus === 'paid')
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill">Pedido Confirmado</span>
                                        @elseif($currentStatus === 'shipped')
                                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">A caminho / Entregue</span>
                                        @else
                                            <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Cancelado</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Ver Detalhes
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-box-open fa-3x mb-3 text-light d-block"></i>
                                        Ainda não realizou nenhuma encomenda na nossa loja.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection