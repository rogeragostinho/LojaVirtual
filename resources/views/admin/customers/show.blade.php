@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Ficha do Cliente</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.customers.index') }}">Clientes</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Detalhes</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-header bg-primary text-white text-center py-4">
                <div class="avatar avatar-xl mb-3">
                    <i class="fas fa-user-circle fa-4x text-white-50"></i>
                </div>
                <h4 class="mb-1 text-white fw-bold">{{ $customer->name }}</h4>
                <span class="badge bg-white text-primary rounded-pill px-3">Cliente da Loja</span>
            </div>
            <div class="card-body">
                <div class="user-profile-text">
                    <p class="text-muted mb-2"><strong>E-mail:</strong> <br>{{ $customer->email }}</p>
                    <p class="text-muted mb-0"><strong>Membro desde:</strong> <br>{{ $customer->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary btn-sm w-100">
                    <i class="fas fa-arrow-left"></i> Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-shopping-bag me-2"></i>Histórico de Encomendas</div>
            </div>
            <div class="card-body py-5 text-center text-muted">
                <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i>
                <p class="mb-0 fs-6">Quando o sistema de checkout estiver pronto, as compras realizadas por este cliente aparecerão listadas aqui de forma automática.</p>
            </div>
        </div>
    </div>
</div>
@endsection