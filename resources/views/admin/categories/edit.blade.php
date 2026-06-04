@extends('admin.layout')
@section('titulo', 'Categorias')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Editar Categoria</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.categories.index') }}">Categorias</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Editar</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modificar Categoria: {{ $category->name }}</div>
            </div>
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Nome da Categoria <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Descrição (Opcional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success"><i class="fas fa-sync"></i> Atualizar</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection