@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Detalhes da Encomenda #{{ $order->id }}</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.orders.index') }}">Encomendas</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Visualizar</a></li>
    </ul>
</div>

<div class="row">
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="card-title text-white"><i class="fas fa-shopping-basket me-2"></i> Produtos Comprados</div>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Produto</th>
                            <th class="text-center" style="width: 15%">Preço Unitário</th>
                            <th class="text-center" style="width: 15%">Quantidade</th>
                            <th class="text-center" style="width: 20%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name ?? 'Produto Removido do Catálogo' }}</strong>
                                </td>
                                <td class="text-center">{{ number_format($item->unit_price, 2, ',', '.') }} Kz</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center fw-bold text-dark">
                                    {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }} Kz
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-light fs-5">
                            <td colspan="3" class="text-end fw-bold">Valor Total Geral:</td>
                            <td class="text-center fw-bold text-success">
                                {{ number_format($order->total, 2, ',', '.') }} Kz
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <div class="card-title text-white"><i class="fas fa-user me-2"></i> Dados para Entrega e Contacto</div>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Cliente:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p class="mb-2"><strong>E-mail:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                
                <p class="mb-2"><strong>Telefone de Contacto:</strong> <span class="text-primary fw-bold fs-5">{{ $order->phone }}</span></p>
                <p class="mb-2"><strong>Província:</strong> {{ $order->province }}</p>
                <p class="mb-3"><strong>Endereço / Referência:</strong> <br><span class="text-dark bg-light p-2 rounded d-block mt-1 border">{{ $order->address }}</span></p>
                
                <p class="mb-0 small text-muted"><strong>Data do Pedido:</strong> {{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom">
                <div class="card-title"><i class="fas fa-sync-alt me-2"></i> Atualizar Estado</div>
            </div>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group p-0 mb-3">
                        <label for="status" class="form-label fw-bold mb-2">Estado Atual da Venda:</label>
                        
                        @php $currentStatus = is_object($order->status) ? $order->status->value : $order->status; @endphp
                        
                        <select name="status" id="status" class="form-select form-control" required>
                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pendente (Aguardar pagamento)</option>
                            <option value="paid" {{ $currentStatus === 'paid' ? 'selected' : '' }}>Pago (Pronto a processar)</option>
                            <option value="shipped" {{ $currentStatus === 'shipped' ? 'selected' : '' }}>Enviado (Em trânsito/Entregue)</option>
                            <option value="cancelled" {{ $currentStatus === 'cancelled' ? 'selected' : '' }}>Cancelado (Estornado/Anulado)</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2 bg-light">
                    <button type="submit" class="btn btn-success btn-sm flex-grow-1">
                        <i class="fas fa-save"></i> Guardar Alteração
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection