@extends('admin.layout')
@section('titulo', 'Categorias')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Categorias</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Catálogo</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Categorias</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Lista de Categorias</div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Nova Categoria
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-head-bg-primary table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th style="width: 30%">Nome</th>
                                <th style="width: 40%">Descrição</th>
                                <th style="width: 20%" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td><strong>{{ $category->name }}</strong><br><small class="text-muted">{{ $category->slug }}</small></td>
                                    <td>{{ Str::limit($category->description, 60, '...') ?? 'Sem descrição.' }}</td>
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem a certeza que deseja eliminar esta categoria?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Nenhuma categoria registada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection