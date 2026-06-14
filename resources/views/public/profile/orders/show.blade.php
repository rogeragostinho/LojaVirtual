@extends('public.layout.index')

@section('title', 'Detalhes do Pedido #' . $order->id . ' - NexaStore')

@section('conteudo')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-4">
                <a href="{{ route('customer.orders.index') }}" class="text-decoration-none text-muted smallfw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Voltar para os meus pedidos
                </a>
            </div>

            <div class="card border-0 shadow-sm p-4 bg-white rounded-3 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Encomenda #{{ $order->id }}</h4>
                        <span class="text-muted small">Realizada em {{ $order->created_at->format('d/m/Y \à\s H:i') }}</span>
                    </div>
                    <div>
                        @php $currentStatus = is_object($order->status) ? $order->status->value : $order->status; @endphp
                        @if($currentStatus === 'pending')
                            <div class="alert alert-warning border-0 mb-0 py-2 px-3 small shadow-sm">
                                <i class="fas fa-phone-alt me-1"></i> Aguarda telefonema de confirmação
                            </div>
                        @elseif($currentStatus === 'paid')
                            <div class="alert alert-success border-0 mb-0 py-2 px-3 small text-white shadow-sm" style="background-color: #198754;">
                                <i class="fas fa-check me-1"></i> Pedido validado pela administração!
                            </div>
                        @elseif($currentStatus === 'shipped')
                            <div class="alert alert-info border-0 mb-0 py-2 px-3 small text-white shadow-sm" style="background-color: #0dcaf0;">
                                <i class="fas fa-truck me-1"></i> O estafeta está a caminho do seu endereço
                            </div>
                        @else
                            <div class="alert alert-danger border-0 mb-0 py-2 px-3 small text-white shadow-sm">
                                <i class="fas fa-times me-1"></i> Esta encomenda foi anulada/cancelada
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-phone text-muted me-2"></i> Contacto Telefónico</h6>
                            <p class="text-primary fw-bold mb-0 fs-5">{{ $order->phone }}</p>
                            <small class="text-muted d-block mt-1">Este é o número que a nossa equipa usará para ligar.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i> Local de Entrega</h6>
                            <p class="text-dark mb-1 fw-medium">Província: {{ $order->province }}</p>
                            <p class="small text-secondary mb-0"><strong>Referência:</strong> {{ $order->address }}</p>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-3">Produtos da Encomenda</h5>
                <div class="table-responsive border rounded">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase text-muted">
                            <tr>
                                <th scope="col" class="ps-3">Produto</th>
                                <th scope="col" class="text-center">Preço</th>
                                <th scope="col" class="text-center">Qtd</th>
                                <th scope="col" class="text-end pe-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <span class="fw-bold text-dark d-block">{{ $item->product->name ?? 'Produto Indisponível' }}</span>
                                    </td>
                                    <td class="text-center text-secondary">{{ number_format($item->unit_price, 2, ',', '.') }} Kz</td>
                                    <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold text-dark">
                                        {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }} Kz
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table-light font-weight-bold fs-5">
                                <td colspan="3" class="text-end fw-bold py-3">Total Pago no Acto de Entrega:</td>
                                <td class="text-end pe-3 fw-extrabold text-success py-3">
                                    {{ number_format($order->total, 2, ',', '.') }} Kz
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection