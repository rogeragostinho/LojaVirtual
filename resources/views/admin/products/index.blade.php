@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Produtos</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Catálogo</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Produtos</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Lista de Produtos</div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i> Novo Produto
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
                                <th style="width: 5%">ID</th>
                                <th style="width: 30%">Produto</th>
                                <th style="width: 15%">Categoria</th>
                                <th style="width: 15%">Preço</th>
                                <th style="width: 10%">Stock</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br><small class="text-muted">{{ $product->slug }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name ?? 'Sem categoria' }}</span>
                                    </td>
                                    <td>{{ number_format($product->price, 2, ',', '.') }} Kz</td>
                                    <td>
                                        <span class="{{ $product->stock == 0 ? 'text-danger fw-bold' : '' }}">
                                            {{ $product->stock }} un.
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->status == \App\Enums\ProductStatus::ACTIVE)
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-danger">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Visualizar">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem a certeza que deseja eliminar este produto?');">
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
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum produto registado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection