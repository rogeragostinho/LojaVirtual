<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NexaStore')</title>
    <!-- FontAwesome para ícones modernos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        main {
            flex: 1;
        }
        .product-card-img {
            height: 240px;
            object-fit: cover;
        }
        /* Melhorias visuais na Navbar */
        .navbar-brand {
            letter-spacing: 0.5px;
        }
        .nav-link {
            transition: color 0.2s ease-in-out;
        }
        .dropdown-menu {
            border: none;
            border-radius: 10px;
        }
        .dropdown-item {
            padding: 0.6rem 1.2rem;
            transition: background-color 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f1f3f5;
        }
        /* Customização para os links ativos no menu lateral do perfil quando integrados */
        .check-profile-nav .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>
<body>

    <header class="sticky-top shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('index') }}">
                    <i class="fas fa-cubes me-1"></i>NexaStore
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('index') ? 'active fw-bold text-white' : '' }}" href="{{ route('index') }}">Home</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </a>
                            <ul class="dropdown-menu shadow">
                                @forelse ($categoriesMenu as $categoria)
                                    <li>
                                        <a class="dropdown-item fw-medium" href="{{ route('produtos.byCategoria', $categoria->id) }}">
                                            {{ $categoria->name }}
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item text-muted">Nenhuma categoria</span></li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        <!-- Ícone do Carrinho com Badge Dinâmico -->
                        <li class="nav-item me-2">
                            <a class="nav-link position-relative btn btn-outline-light text-white border-0 px-3 py-2" href="{{ route('carrinho.index') }}" title="Ver Carrinho">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                    <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger shadow-sm border border-2 border-primary" style="font-size: 0.75rem;">
                                        {{ count(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        @auth
                            <!-- Dropdown Unificado do Utilizador Autenticado -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-outline-primary text-white px-3 fw-bold border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> 
                                    <!-- Exibe apenas o primeiro nome para manter a navbar limpa e harmoniosa -->
                                    Olá, {{ explode(' ', auth()->user()->name)[0] }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg mt-2">
                                    
                                    @if(auth()->user()->isAdmin())
                                        <!-- Opções Exclusivas para o Administrador -->
                                        <div class="px-3 py-1 small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Gestão Interna</div>
                                        <li>
                                            <a class="dropdown-item fw-semibold text-primary" href="{{ route('admin.index') }}">
                                                <i class="fas fa-chart-line me-2"></i>Painel Administrativo
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif

                                    <!-- Opções Padrão para Clientes (E acessíveis também pelo admin se quiser navegar na loja) -->
                                    <div class="px-3 py-1 small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Minha Conta</div>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customer.orders.index') }}">
                                            <i class="fas fa-box me-2 text-muted"></i>As Minhas Encomendas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-cog me-2 text-muted"></i>Gerenciar Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                            <i class="fas fa-heart me-2 text-danger"></i>Meus Favoritos
                                        </a>
                                    </li>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    
                                    <!-- Logout -->
                                    <li>
                                        <a class="dropdown-item text-danger fw-semibold" href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Terminar Sessão
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <!-- Estado Desconectado: Login / Registo -->
                            <li class="nav-item">
                                <a class="btn btn-link text-white text-decoration-none px-3 py-2 fw-medium" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-light text-primary px-4 py-2 rounded-pill fw-bold shadow-sm" href="{{ route('register') }}">Criar Conta</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            <!-- Mensagens de Alerta Globais de Sucesso -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Mensagens de Alerta Globais de Erro -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('conteudo')
        </div>
    </main>

    <footer class="bg-dark text-white-50 py-4 mt-auto border-top border-secondary">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <p class="mb-0">&copy; {{ date('Y') }} <span class="text-white fw-bold">NexaStore</span>. Todos os direitos reservados.</p>
                    <p class="mb-0 small mt-2 mt-md-0"><i class="fas fa-shield-alt me-1"></i> Compra Segura - Pagamento na Entrega</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/js.js') }}"></script>
</body>
</html>