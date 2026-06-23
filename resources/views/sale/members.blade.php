@extends('layouts.admin')
@section('title')
    <h3>Ventas de Miembros</h3>
    <p class="text-subtitle text-muted">Aquí puedes revisar todas las ventas registradas para los miembros del gimnasio y abrir el detalle de cada transacción.</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ventas de Miembros</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="d-flex justify-content-center">
    <div class="row w-100">
        <div class="col-12 col-md-12">
            <div class="card shadow-sm">
                <!-- Cabecera de la Tarjeta al estilo de tu modelo -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Historial de Ventas (Miembros)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p>Esta es la lista de ventas registradas para los miembros del gimnasio.</p>
                        <div class="table-responsive">
                            <!-- Tabla con las clases exactas de tu modelo -->
                            <table class="table table-hover table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID Venta</th>
                                        <th style="text-align: center;">C.I. Miembro</th>
                                        <th style="text-align: center;">Nombre Miembro</th>
                                        <th style="text-align: center;">Fecha</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td class="text-center fw-bold text-secondary">#{{ $sale->id }}</td>
                                            
                                            <!-- C.I. obtenido de la relación embebida 'member' -->
                                            <td class="text-center">{{ $sale->member?->ci ?? 'N/A' }}</td>
                                            
                                            <!-- Nombre limitado a 20 caracteres como en tu modelo -->
                                            <td>{{ Str::limit($sale->member?->full_name ?? 'Sin Miembro', 20, '...') }}</td>
                                            
                                            <td class="text-center">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                                            <td class="text-end fw-bold">${{ number_format($sale->total_amount, 2) }}</td>
                                            
                                            <!-- Control de estados (1: Abierta / 0: Terminada) -->
                                            <td class="text-center">
                                                @if($sale->state == 1)
                                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill">Abierta</span>
                                                @else
                                                    <span class="badge bg-success px-3 py-1.5 rounded-pill">Terminada</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Acción directa sin modal (Enlace de visualización) -->
                                            <td class="text-center">
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-info btn-sm" title="Ver Detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Paginación idéntica a tu modelo -->
                            @if ($sales->hasPages())
                                <div class="d-flex justify-content-start mt-3">
                                    {{ $sales->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection