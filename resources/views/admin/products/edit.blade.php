@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Editar Produto</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.products.index') }}">Produtos</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Editar</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modificar Produto: {{ $product->name }}</div>
            </div>
            
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-8 mb-3">
                            <label for="name">Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 mb-3">
                            <label for="categoria_id">Categoria <span class="text-danger">*</span></label>
                            <select class="form-select form-control @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('categoria_id', $product->categoria_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 mb-3">
                            <label for="price">Preço (Kz) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 mb-3">
                            <label for="stock">Quantidade em Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 mb-3">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Descrição do Produto</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="images">Adicionar Novas Imagens</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                        <small class="form-text text-muted">Selecione mais ficheiros se desejar expandir a galeria deste produto.</small>
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="card-action">
                    <button type="submit" class="btn btn-success"><i class="fas fa-sync"></i> Atualizar Produto</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </form>

            <div class="card-body border-top mt-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-images"></i> Imagens Atuais do Produto</h6>
                
                <div class="d-flex flex-wrap gap-3">
                    @forelse($product->images as $image)
                        <div class="position-relative border rounded p-1 text-center bg-light shadow-sm" style="width: 130px;">
                            <img src="{{ asset($image->url) }}" 
                                alt="Imagem de {{ $product->name }}" 
                                class="img-fluid rounded mb-1" 
                                style="width: 120px; height: 120px; object-fit: cover;">
                            
                            <form action="{{ route('admin.products.images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Deseja eliminar esta imagem permanentemente?');">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="btn btn-danger btn-sm w-100" title="Eliminar Foto">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-muted py-2">
                            <i class="fas fa-info-circle"></i> Este produto ainda não possui nenhuma imagem associada.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection