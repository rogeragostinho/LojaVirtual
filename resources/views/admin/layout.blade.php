<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Painel Administrativo - NexaStore')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }} "></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <!-- 💡 Mudança: Nome NexaStore textual e estilizado -->
                    <a href="{{ route('admin.index') }}" class="logo text-white fw-bold fs-4 text-decoration-none">
                        <i class="fas fa-cubes text-primary me-2"></i>NexaStore
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        
                        <!-- Link rápido para a Loja Pública -->
                        <li class="nav-item">
                            <a href="{{ route('index') }}">
                                <i class="fas fa-shopping-basket text-info"></i>
                                <p class="text-info">Ir para a Loja</p>
                            </a>
                        </li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestão Geral</h4>
                        </li>

                        <!-- 💡 Destaque Dinâmico com request()->routeIs -->
                        <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.index') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box-open"></i>
                                <p>Produtos</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-bag"></i>
                                <p>Pedidos</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.customers.index') }}">
                                <i class="fas fa-users"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                        
                        @if(Auth::user()->role === \App\Enums\UserRole::SUPER_ADMIN)
                            <li class="nav-item {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.team.index') }}">
                                    <i class="fas fa-users-cog"></i>
                                    <p>Equipe</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header para Mobile -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('admin.index') }}" class="logo text-white fw-bold fs-4 text-decoration-none">
                            <i class="fas fa-cubes text-primary me-2"></i>NexaStore
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid" data-background-color="blue">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"></nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('assets/img/user.png') }}" alt="User Avatar" class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7 ">Olá,</span>
                                        <span class="fw-bold ">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="{{ asset('assets/img/user.png') }}" alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{ Auth::user()->name }}</h4>
                                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <!-- Formulário de Logout Ajustado para o Layout -->
                                            <form action="{{ route('logout') }}" method="POST" id="admin-logout-form">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger fw-bold">
                                                    <i class="fas fa-sign-out-alt me-2"></i>Terminar Sessão
                                                </button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <!-- Conteúdo Principal -->
            <div class="container">
                <div class="page-inner">
                    @yield('conteudo')
                </div>
            </div>
        </div>

        <!-- 💡 Nota: Mantive a aba de configurações de cores do template original (Custom Template) caso pretendas usar para mudar as cores do painel em tempo real. -->
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS & Sparklines -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('graficos')
</body>

</html>