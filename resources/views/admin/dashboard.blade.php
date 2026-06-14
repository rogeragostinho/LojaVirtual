@extends('admin.layout') {{-- Ajusta para o caminho exato do teu layout master do painel --}}

@section('title', 'Dashboard - NexaStore')

@section('conteudo')

    <!-- Cards de Métricas Principais -->
    <div class="row mb-4">
        <!-- Card Faturamento -->
        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
            <div class="card p-3 shadow-sm border-0 bg-success bg-gradient text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50 text-uppercase small fw-bold">Faturamento Total</p>
                        <h3 class="fw-bold mb-0">{{ number_format($faturamento, 2, ',', '.') }} Kz</h3>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Usuários -->
        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
            <div class="card p-3 shadow-sm border-0 bg-primary bg-gradient text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50 text-uppercase small fw-bold">Usuários Cadastrados</p>
                        <h3 class="fw-bold mb-0">{{ $usuarios }}</h3>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pedidos do Mês -->
        <div class="col-sm-12 col-lg-4 mb-3 mb-lg-0">
            <div class="card p-3 shadow-sm border-0 bg-warning bg-gradient text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50 text-uppercase small fw-bold">Pedidos Este Mês</p>
                        <h3 class="fw-bold mb-0">{{ $pedidosMes }}</h3>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Gráficos Analíticos -->
    <div class="row">
        <!-- Gráfico de Linha: Usuários -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fas fa-chart-line text-primary me-2"></i>Aquisição de Usuários
                    </h5>
                    <div style="position: relative; height:300px;">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Pizza: Categorias -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fas fa-chart-pie text-danger me-2"></i>Produtos por Categoria
                    </h5>
                    <div style="position: relative; height:300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('graficos')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // 💡 Dados injetados com segurança via JSON nativo do Laravel
            const userLabels = {!! $userAno !!};
            const userDataValues = {!! $userTotal !!};
            
            const categoryLabels = {!! $categorias !!};
            const categoryDataValues = {!! $produtosTotal !!};

            /* --- Gráfico 01: Linha (Usuários) --- */
            const ctxUser = document.getElementById('userChart').getContext('2d');
            new Chart(ctxUser, {
                type: 'line',
                data: {
                    labels: userLabels,
                    datasets: [{
                        label: 'Novos Usuários por Ano',
                        data: userDataValues,
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderColor: '#0d6efd',
                        borderWidth: 3,
                        pointBackgroundColor: '#0d6efd',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });

            /* --- Gráfico 02: Pizza / Donut (Categorias) --- */
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCategory, {
                type: 'doughnut', // Formato Donut deixa a UI mais moderna do que a pizza cheia
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryDataValues,
                        backgroundColor: [
                            '#fd7e14', // Laranja Nexa
                            '#0d6efd', // Azul
                            '#dc3545', // Vermelho
                            '#198754', // Verde
                            '#6f42c1', // Roxo
                            '#0dcaf0'  // Ciano
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 15 }
                        }
                    }
                }
            });
            
        });
    </script>
@endpush