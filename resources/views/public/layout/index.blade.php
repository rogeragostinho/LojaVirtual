<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'produtos')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <style>
        .conteudo {
            min-height: calc(100vh - (72px + 136px));
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-primary bg-gradiente py-3 shadow">
            <div class="container-md ">
                <div class="col-4">
                    <a class="navbar-brand me-5 text-white" href="{{ route('index') }}">Loja Virtual</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <div class="col-8 ">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-5 ">
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page"
                                    href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Categoria
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($categoriasMenu as $categoria)
                                        <li><a class="dropdown-item"
                                                href="{{ route('produtos.byCategoria', $categoria->id) }}">{{ $categoria->nome }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('carrinho.index') }}">Carrinho<span
                                        class="badge bg-danger">{{ \Cart::getContent()->count() }}</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4 text-end">
                        <ul class="navbar-nav mb-2 mb-lg-0 ms-5 justify-content-end">
                            @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Ola {{ auth()->user()->firstName }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('login.logout') }}">Logout</a></li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link active text-white" aria-current="page"
                                        href="{{ route('login.form') }}">Login</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="conteudo">
        @yield('conteudo')
    </main>

    <footer>
        <div class="container-fluid bg-dark text-white">
            <div class="row p-5">
                <div class="col text-center">
                    <p>Copyright</p>
                </div>

            </div>
        </div>
    </footer>
    <script src="{{ asset('js/js.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
