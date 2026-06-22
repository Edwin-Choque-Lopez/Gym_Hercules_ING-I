@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Encabezado de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h1 class="mb-2">Bienvenido</h1>
                    <p class="mb-0">Este es tu panel de control</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total de Ventas</h6>
                            <h3 class="mb-0">Bs100.00</h3>
                        </div>
                        <div class="text-primary" style="font-size: 2rem;">
                            <i class="bi bi-cart-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Productos Activos</h6>
                            <h3 class="mb-0">3</h3>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">
                            <i class="bi bi-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Clientes</h6>
                            <h3 class="mb-0">1</h3>
                        </div>
                        <div class="text-info" style="font-size: 2rem;">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Descuentos Activos</h6>
                            <h3 class="mb-0">10</h3>
                        </div>
                        <div class="text-warning" style="font-size: 2rem;">
                            <i class="bi bi-percent"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlaces Rápidos -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">Acciones Rápidas</h4>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3" style="font-size: 2.5rem; color: #007bff;">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h5 class="card-title">Nueva Venta</h5>
                    <p class="card-text text-muted small">Crear una nueva venta de productos</p>
                    <a href="{{ route('sale') }}" class="btn btn-primary btn-sm">Ir</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3" style="font-size: 2.5rem; color: #28a745;">
                        <i class="bi bi-box"></i>
                    </div>
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text text-muted small">Gestionar inventario de productos</p>
                    <a href="{{ route('products') }}" class="btn btn-success btn-sm">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3" style="font-size: 2.5rem; color: #17a2b8;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text text-muted small">Administrar lista de clientes</p>
                    <a href="{{ route('customers') }}" class="btn btn-info btn-sm">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3" style="font-size: 2.5rem; color: #ffc107;">
                        <i class="bi bi-percent"></i>
                    </div>
                    <h5 class="card-title">Descuentos</h5>
                    <p class="card-text text-muted small">Gestionar promociones</p>
                    <a href="{{ route('administration') }}" class="btn btn-warning btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Ventas -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header ">
                    <h5 class="card-title mb-0">Últimas Ventas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        No hay ventas registradas aún
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Información del Sistema</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <small class="text-muted">Versión del Sistema</small>
                            <p class="mb-0"><strong>1.0.0</strong></p>
                        </li>
                        <li class="mb-3">
                            <small class="text-muted">Usuario Actual</small>
                            <p class="mb-0"><strong>{{ Auth::user()->full_name ?? 'Admin' }}</strong></p>
                        </li>
                        <li class="mb-3">
                            <small class="text-muted">Rol</small>
                            <p class="mb-0"><strong>{{ Auth::user()->role->name ?? 'Sin rol' }}</strong></p>
                        </li>
                        <li>
                            <small class="text-muted">Última Sesión</small>
                            <p class="mb-0"><strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .border-left-warning {
        border-left: 4px solid #ffc107 !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
</style>
@endsection
