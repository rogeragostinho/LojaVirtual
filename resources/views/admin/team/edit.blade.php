@extends('admin.layout')

@section('conteudo')
<div class="page-header">
    <h3 class="page-title">Editar Administrador</h3>
    <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i></a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a href="{{ route('admin.team.index') }}">Equipa</a></li>
        <li class="separator"><i class="text-muted fas fa-chevron-right"></i></li>
        <li class="nav-item"><a>Editar</a></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modificar Perfil: {{ $team->name }}</div>
            </div>
            <form action="{{ route('admin.team.update', $team->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $team->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Endereço de E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $team->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="role">Nível de Permissão <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="admin" {{ old('role', $team->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="super_admin" {{ old('role', $team->role) == 'super_admin' ? 'selected' : '' }}>Super Administrador</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="bg-light p-3 rounded mb-3 border-start border-warning border-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Deixa os campos de palavra-passe em branco se pretenderes **manter** a atual. Preenche apenas se desejares alterá-la.
                        </small>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="password">Nova Palavra-passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="password_confirmation">Confirmar Nova Palavra-passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success"><i class="fas fa-sync"></i> Atualizar Conta</button>
                    <a href="{{ route('admin.team.index') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection