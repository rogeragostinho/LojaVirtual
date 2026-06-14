@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Gestão de Clientes</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Clientes</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="card-title">Clientes Registados na Loja</div>
                
                <form action="{{ route('admin.customers.index') }}" method="GET" style="max-width: 300px; width: 100%;">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar cliente..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Cliente</th>
                                <th>E-mail</th>
                                <th>Data de Cadastro</th>
                                <th style="width: 12%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>#{{ $customer->id }}</td>
                                    <td><strong>{{ $customer->name }}</strong></td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at->format('d/m/Y \à\s H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-info btn-xs text-white" title="Ver Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Atenção! Deseja remover permanentemente este cliente do sistema?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar Cliente">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-users-slash fa-2x mb-2 d-block"></i>
                                        Nenhum cliente encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $customers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection