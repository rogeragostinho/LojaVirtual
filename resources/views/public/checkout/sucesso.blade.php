@extends('public.layout.index')

@section('title', 'Pedido Confirmado! - NexaStore')

@section('conteudo')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-5 bg-white rounded-3">
                <div class="mb-4">
                    <i class="fas fa-phone-volume fa-4x text-success bg-success-subtle rounded-circle p-4 shadow-sm border border-success-subtle animate-pulse"></i>
                </div>
                
                <h2 class="fw-bold text-dark mb-2">Pedido Registado com Sucesso!</h2>
                <p class="text-secondary fs-5 mb-4">O identificador do seu pedido é o **#{{ $order->id }}**.</p>

                <div class="bg-light p-4 rounded-3 mb-4 text-start border-start border-primary border-4 shadow-sm">
                    <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle me-2 text-primary"></i> Próximos Passos:</h6>
                    <ol class="small text-muted ps-3 mb-0">
                        <li class="mb-2">A nossa equipa de apoio ao cliente vai analisar o seu pedido técnico.</li>
                        <li class="mb-2"><strong>Ligaremos para o número {{ $order->phone }}</strong> nas próximas horas para validar o ponto de referência e agendar o horário de entrega.</li>
                        <li>O pagamento será feito comodamente quando o estafeta chegar até si (via Express ou Cash).</li>
                    </ol>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary w-100 py-2.5 fw-bold rounded-pill">
                        <i class="fas fa-box me-1"></i> Meus Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection