@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Gestão da Equipa</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Administradores</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Membros com Acesso ao Painel</div>
                <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Novo Administrador
                </a>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Nível de Acesso</th>
                                <th>Criado em</th>
                                <th style="width: 15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>#{{ $member->id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>
                                        @if($member->role === \App\Enums\UserRole::SUPER_ADMIN)
                                            <span class="badge bg-danger text-white">Super Admin</span>
                                        @else
                                            <span class="badge bg-info text-white">Administrador</span>
                                        @endif
                                    </td>
                                    <td>{{ $member->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-warning btn-xs text-white" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($member->id !== auth()->id())
                                                <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja remover este administrador?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection