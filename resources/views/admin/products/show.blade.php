@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Detalhes do Produto</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.products.index') }}">Produtos</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Visualizar</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="card-title text-white">{{ $product->name }}</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="width: 35%">Preço de Venda:</th>
                                <td><h4 class="text-success mb-0 fw-bold">{{ number_format($product->price, 2, ',', '.') }} Kz</h4></td>
                            </tr>
                            <tr>
                                <th>Stock Atual:</th>
                                <td>
                                    <span class="badge {{ $product->stock > 10 ? 'badge-success' : 'badge-warning' }}">
                                        {{ $product->stock }} unidades
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Categoria:</th>
                                <td>{{ $product->category->name ?? 'Sem categoria' }}</td>
                            </tr>
                            <tr>
                                <th>Status na Loja:</th>
                                <td>
                                    @if($product->status == \App\Enums\ProductStatus::ACTIVE)
                                        <span class="badge badge-success">Visível / Ativo</span>
                                    @else
                                        <span class="badge badge-danger">Oculto / Inativo</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>URL Slug:</th>
                                <td><code>{{ $product->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>Cadastrado por:</th>
                                <td>ID do Administrador: #{{ $product->user_id }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="border rounded p-3 bg-light h-100" style="min-height: 200px;">
                            <h6 class="fw-bold border-bottom pb-2">Descrição do Catálogo:</h6>
                            <p class="text-muted" style="white-space: pre-line;">
                                {{ $product->description ?? 'Este produto não possui descrição cadastrada.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="border rounded p-3">
                            <h6 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-images"></i> Galeria de Imagens</h6>
                            
                            <div class="d-flex flex-wrap gap-3">
                                @forelse($product->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset($image->url) }}" 
                                             alt="Imagem de {{ $product->name }}" 
                                             class="img-thumbnail" 
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                @empty
                                    <div class="text-muted py-2 w-100">
                                        <i class="fas fa-exclamation-circle"></i> Este produto ainda não possui imagens associadas.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning text-white">
                    <i class="fas fa-edit"></i> Editar Produto
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Voltar para a Lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection