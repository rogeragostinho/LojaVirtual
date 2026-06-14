@extends('public.layout.index')

@section('title', 'Gerenciar Perfil - NexaStore')

@section('conteudo')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-3">
                <div class="text-center py-3 border-bottom mb-3">
                    <i class="fas fa-user-circle fa-3x text-secondary mb-2"></i>
                    <h6 class="fw-bold text-dark mb-0">{{ $user->name }}</h6>
                    <small class="text-muted">Cliente NexaStore</small>
                </div>
                <div class="nav flex-column nav-pills check-profile-nav">
                    <a href="{{ route('customer.orders.index') }}" class="nav-link text-secondary rounded-pill mb-2">
                        <i class="fas fa-box me-2"></i> As Minhas Encomendas
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link active rounded-pill mb-2">
                        <i class="fas fa-user-cog me-2"></i> Gerenciar Perfil
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="nav-link text-secondary rounded-pill">
                        <i class="fas fa-heart me-2"></i> Meus Favoritos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3 mb-4">
                <h4 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="fas fa-id-card text-muted me-2"></i> Dados Pessoais
                </h4>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold text-secondary small">Nome Completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold text-secondary small">Endereço de E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="fas fa-save me-1"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <h4 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="fas fa-lock text-muted me-2"></i> Alterar Palavra-passe
                </h4>

                @if(session('success_password'))
                    <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success_password') }}</div>
                @endif

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="current_password" class="form-label fw-bold text-secondary small">Palavra-passe Atual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold text-secondary small">Nova Palavra-passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold text-secondary small">Confirmar Nova Palavra-passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold">
                            <i class="fas fa-key me-1"></i> Atualizar Palavra-passe
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection