@if ($mensagem = Session::get('sucesso'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Parabéns!</strong>
        {{ $mensagem }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($mensagem = Session::get('aviso'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Tudo Certo!</strong> {{ $mensagem }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
