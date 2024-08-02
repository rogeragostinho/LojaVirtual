<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <style>
        .custom-background {
            background-image: url(' {{ asset('img/office.jpg') }} ');
            background-size: cover;
            background-position: center;
        }
    </style>

</head>

<body>

    <!-- Painel externo chamado pelo botão menu localizado no navbar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header p-0"></div>
        <div class="offcanvas-body p-0">
            <div class="container-fluid custom-background pt-5 h-25">

                <div class="row justify-content-center mb-3">
                    <div class="col-3">
                        <img src="{{ asset('img/user3.jpg') }}" class="img-fluid rounded-circle" alt="...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <a href="#name" class="text-white text-decoration-none fw-bold">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }} </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <a href="#email" class="text-white text-decoration-none">{{ auth()->user()->email }}</a>
                    </div>
                </div>

            </div>
            <div class="container-fluid mt-3">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}"
                        class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="{{ route('admin.produtos') }}" class="list-group-item list-group-item-action">Produtos</a>
                    <a href="#" class="list-group-item list-group-item-action">Pedidos</a>
                    <a href="#" class="list-group-item list-group-item-action">Categorias</a>
                    <a href="#" class="list-group-item list-group-item-action">Usuários</a>
                </div>
            </div>
        </div>
    </div>

    <!-- navbar -->
    <nav class="navbar bg-danger py-3 ">
        <div class="container-md justify-content-bet">

            <div class="col-4 text-start">
                <!-- Botão menu que chama o painel externo -->
                <button class="btn btn-pdanger " type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="36" viewBox="0 -960 960 960"
                        width="36">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg>
                </button>
            </div>
            <div class="col-4 text-center">
                <a href="{{route('index')}}" class="h2 text-decoration-none text-white">{{--<img src="{{ asset('img/logo.png') }}">--}}LaravelShop</a>
            </div>
            <div class="col-4 text-end">
                @auth
                    <div class="dropdown ">
                        <button class="btn text-white text-decoration-none dropdown-toggle btn-link " type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Ola {{ auth()->user()->firstName}}
                        </button>

                        <ul class="dropdown-menu  dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('login.logout') }}">Sair</a></li>
                        </ul>

                    </div>
                @endauth
            </div>

        </div>
    </nav>
    Tas bomm
    @yield('conteudo')
    cassule

    <!-- Compiled and minified JavaScript -->
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }} "></script>
    <script src=" {{ asset('js/main.js') }}"></script>
    @stack('graficos')



</body>

</html>
