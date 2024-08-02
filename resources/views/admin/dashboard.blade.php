@extends('admin.layout')
@section('titulo', 'Dashboard')
@section('conteudo')




    <div class="container py-4">
        <section class="row">

            <div class="col-sm-10 mx-auto col-md-6 col-lg-4 mb-4 m-lg-0">
                <div class="bg-success bg-gradient card p-3 shadow-lg text-white">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="50" viewBox="0 -960 960 960"
                            width="50">
                            <path
                                d="M444-200h70v-50q50-9 86-39t36-89q0-42-24-77t-96-61q-60-20-83-35t-23-41q0-26 18.5-41t53.5-15q32 0 50 15.5t26 38.5l64-26q-11-35-40.5-61T516-710v-50h-70v50q-50 11-78 44t-28 74q0 47 27.5 76t86.5 50q63 23 87.5 41t24.5 47q0 33-23.5 48.5T486-314q-33 0-58.5-20.5T390-396l-66 26q14 48 43.5 77.5T444-252v52Zm36 120q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                        </svg>
                        <p class="card-title">Faturamento</p>
                        <h3 class="card-text">150,00 Kz</h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-10 mx-auto col-md-6 col-lg-4 mb-4 m-lg-0">
                <div class="card bg-primary bg-gradient p-3 shadow-lg text-white">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="50" viewBox="0 -960 960 960"
                            width="50">
                            <path
                                d="M360-390q-21 0-35.5-14.5T310-440q0-21 14.5-35.5T360-490q21 0 35.5 14.5T410-440q0 21-14.5 35.5T360-390Zm240 0q-21 0-35.5-14.5T550-440q0-21 14.5-35.5T600-490q21 0 35.5 14.5T650-440q0 21-14.5 35.5T600-390ZM480-160q134 0 227-93t93-227q0-24-3-46.5T786-570q-21 5-42 7.5t-44 2.5q-91 0-172-39T390-708q-32 78-91.5 135.5T160-486v6q0 134 93 227t227 93Zm0 80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-54-715q42 70 114 112.5T700-640q14 0 27-1.5t27-3.5q-42-70-114-112.5T480-800q-14 0-27 1.5t-27 3.5ZM177-581q51-29 89-75t57-103q-51 29-89 75t-57 103Zm249-214Zm-103 36Z" />
                        </svg>
                        <p class="card-title">Usuários</p>
                        <h3 class="card-text"> {{ $usuarios }} </h3>
                    </div>
                </div>
            </div>

            <div class="col-sm-10 mx-auto col-md-12 col-lg-4 mb-4 m-lg-0">
                <div class="bg-warning bg-gradient p-3 card shadow-lg text-white">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="50" viewBox="0 -960 960 960"
                            width="50">
                            <path
                                d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                        </svg>
                        <p class="card-title">Pedidos este mês</p>
                        <h3 class="card-text">0</h3>
                    </div>
                </div>
            </div>

        </section>
    </div>


    <div class="container-md ">
        <div class="row">
            <section class="col-lg-6 text-center">
                <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-body">
                        <h5 class="center"> Aquisição de usuários</h5>
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </section>

            <section class="col-lg-6 text-center">
                <div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-body">
                        <h5 class="card-title"> Produtos </h5>
                        <canvas id="myChart2" width="400" height="200"></canvas>
                    </div>
                </div>
            </section>
        </div>

    </div>




    </div>

@endsection

@push('graficos')
    <script>
        /* Gráfico 01 */
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [{{ $userAno }}],
                datasets: [{
                    label: [{!! $userLabel !!}],
                    data: [{{ $userTotal }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        /* Gráfico 02 */
        var ctx = document.getElementById('myChart2');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [{!! $categorias !!}],
                datasets: [{
                    label: 'Visitas',
                    data: [{{ $produtosTotal }}],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 159, 64)',
                        'rgba(54, 112,183)',
                        'rgba(54, 162, 39)'
                    ]
                }]
            }
        });
    </script>
@endpush
