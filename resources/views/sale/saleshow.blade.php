@extends('layouts.admin')

@section('title')
    <h3>Detalle de Venta #{{ $sale->id }}</h3>
    <p class="text-subtitle text-muted">Revisa los datos de la venta, los productos, el descuento y el monto final pagado.</p>
@endsection

@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sale') }}">Ventas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detalle de Venta</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <h4 class="card-title mb-1">Venta #{{ $sale->id }}</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sale') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left-circle me-1"></i> Nueva venta
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="bi bi-house-door me-1"></i> Salir
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-12 col-lg-6">
                            <div class="border rounded-3 p-4 h-100  shadow-sm">
                                <h5 class="mb-3">Cliente / Miembro</h5>
                                @if ($sale->customer)
                                    <p class="mb-1"><strong>Rol:</strong> Cliente</p>
                                    <p class="mb-1"><strong>Nombre:</strong> {{ $sale->customer->full_name }}</p>
                                    <p class="mb-1"><strong>C.I.:</strong> {{ $sale->customer->ci }}</p>
                                @elseif ($sale->member)
                                    <p class="mb-1"><strong>Rol:</strong> Miembro</p>
                                    <p class="mb-1"><strong>Nombre:</strong> {{ $sale->member->full_name }}</p>
                                    <p class="mb-1"><strong>C.I.:</strong> {{ $sale->member->ci }}</p>
                                    <p class="mb-0"><strong>Teléfono:</strong> {{ $sale->member->phone ?? 'No registrado' }}</p>
                                @else
                                    <p class="mb-0 text-muted">No hay cliente ni miembro asignado a esta venta.</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="border rounded-3 p-4 h-100  shadow-sm">
                                <h5 class="mb-3">Información de la Venta</h5>
                                <p class="mb-1"><strong>Método de pago:</strong> {{ $sale->paymentType?->name ?? 'No asignado' }}</p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    <span class="badge {{ $sale->state == 1 ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ $sale->state == 1 ? 'Abierta' : 'Terminada' }}
                                    </span>
                                </p>
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $sale->user?->name ?? 'Sin usuario' }}</p>
                                <p class="mb-0"><strong>Registrado en:</strong> {{ optional($sale->created_at)->format('d/m/Y H:i') ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-4  shadow-sm">
                                <h5 class="mb-4">Resumen de Descuento</h5>
                                <div class="row row-cols-1 row-cols-md-3 g-3">
                                    <div class="col">
                                        <div class="border rounded-3 p-3 h-100 ">
                                            <p class="text-uppercase text-muted mb-1">Descuento aplicado</p>
                                            <h4 class="mb-0">{{ $sale->discount?->name ?? 'Ninguno' }}</h4>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded-3 p-3 h-100 ">
                                            <p class="text-uppercase text-muted mb-1">Porcentaje</p>
                                            <h4 class="mb-0">{{ $sale->discount ? number_format($sale->discount->percentage * 100, 0) . '%' : '0%' }}</h4>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border rounded-3 p-3 h-100 ">
                                            <p class="text-uppercase text-muted mb-1">Monto de descuento</p>
                                            <h4 class="mb-0">${{ number_format($sale->discount_payment, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                                @if ($sale->discount && $sale->discount->description)
                                    <div class="mt-3 text-muted">{{ $sale->discount->description }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-4 shadow-sm">
                                <h5 class="mb-4">Detalle de Productos</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Categoría</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio unitario</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($sale->saleDetails as $detail)
                                                <tr>
                                                    <td>{{ $detail->product?->name ?? 'Producto desconocido' }}</td>
                                                    <td>{{ $detail->product?->category?->name ?? 'Sin categoría' }}</td>
                                                    <td class="text-center">{{ $detail->quantity }}</td>
                                                    <td class="text-end">${{ number_format($detail->unit_price, 2) }}</td>
                                                    <td class="text-end">${{ number_format($detail->subtotal, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No se encontraron productos en esta venta.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 offset-lg-6">
                            <div class="border rounded-3 p-4  shadow-sm">
                                <h5 class="mb-4">Totales</h5>
                                @php
                                    $subtotal = $sale->saleDetails->sum('subtotal');
                                    $totalPago = max(0, $subtotal - $sale->discount_payment);
                                @endphp
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <strong>${{ number_format($subtotal, 2) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Descuento</span>
                                    <strong>-${{ number_format($sale->discount_payment, 2) }}</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fs-5 fw-semibold">
                                    <span>Total a pagado</span>
                                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                                <div class="mt-2 text-muted small">Monto calculado: ${{ number_format($totalPago, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection