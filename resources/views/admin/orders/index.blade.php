@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Gestão de Encomendas</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Encomendas</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="card-title">Histórico de Vendas da Loja</div>
                
                <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    <select name="status" class="form-select form-control-sm" style="max-width: 150px;" onchange="this.form.submit()">
                        <option value="">Todos os Estados</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pago</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Enviado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>

                    <div class="input-group input-group-sm" style="max-width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Nº da encomenda ou cliente..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>Nº Encomenda</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Data de Criação</th>
                                <th style="width: 10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->user->name ?? 'Cliente Removido' }}</td>
                                    <td><span class="text-success fw-bold">{{ number_format($order->total, 2, ',', '.') }} Kz</span></td>
                                    <td>
                                        @if($order->status->value === 'pending' || $order->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        @elseif($order->status->value === 'paid' || $order->status === 'paid')
                                            <span class="badge bg-success text-white">Pago</span>
                                        @elseif($order->status->value === 'shipped' || $order->status === 'shipped')
                                            <span class="badge bg-info text-white">Enviado</span>
                                        @else
                                            <span class="badge bg-danger text-white">Cancelado</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-xs" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i> Detalhes
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                        Nenhuma encomenda registada no sistema.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $orders->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection