@extends('public.layout.index')

@section('title', 'Finalizar Pedido - NexaStore')

@section('conteudo')
<div class="container py-5">
    <h3 class="fw-bold mb-4 text-dark border-start border-primary border-4 ps-3">
        <i class="fas fa-truck me-2 text-primary"></i> FINALIZAR PEDIDO
    </h3>

    <form action="{{ route('checkout.processar') }}" method="POST">
        @csrf
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i> Dados para Contacto e Entrega
                    </h5>

                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="phone" class="form-label fw-bold text-secondary small">Telemóvel / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Ex: 923000000" value="{{ old('phone') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="province" class="form-label fw-bold text-secondary small">Província <span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="province" name="province" required>
                                <option value="Luanda">Luanda</option>
                                <option value="Benguela">Benguela</option>
                                <option value="Huambo">Huambo</option>
                                <option value="Huíla">Huíla</option>
                                <option value="Cabinda">Cabinda</option>
                                </select>
                        </div>

                        <div class="form-group col-12 mb-4">
                            <label for="address" class="form-label fw-bold text-secondary small">Endereço de Entrega e Ponto de Referência <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4" placeholder="Ex: Bairro Maculusso, Rua Comandante Gika, ao lado do Standard Bank." required>{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 p-3 shadow-sm d-flex align-items-start mb-0">
                        <i class="fas fa-hand-holding-usd fa-2x me-3 text-warning"></i>
                        <div>
                            <strong class="text-dark">Pagamento no Acto da Entrega!</strong><br>
                            <span class="small text-muted">Não precisa de pagar nada agora. A nossa equipa vai ligar para o seu número para confirmar o dia e a hora da entrega. Poderá pagar via Cash ou Multicaixa Express quando receber os produtos.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4 bg-white rounded-3 sticky-md-top" style="top: 90px;">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">Resumo do Pedido</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @foreach($cart as $item)
                                    <tr class="border-bottom">
                                        <td class="py-2" style="width: 70%;">
                                            <span class="fw-bold text-dark d-block text-truncate" style="max-width: 220px;">{{ $item['name'] }}</span>
                                            <small class="text-muted">{{ $item['quantity'] }}x @ {{ number_format($item['price'], 2, ',', '.') }} Kz</small>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }} Kz
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="pt-3 fs-5 fw-bold text-dark">Total Geral:</td>
                                    <td class="pt-3 fs-4 fw-extrabold text-success text-end">
                                        {{ number_format($total, 2, ',', '.') }} Kz
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold rounded-pill text-uppercase shadow">
                        <i class="fas fa-check-circle me-2"></i> Confirmar Encomenda
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection