@extends('layouts.admin')
@section('title')
    <h3>Formulario de Venta</h3>
    <p class="text-subtitle text-muted">Complete los datos para realizar la venta</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Formulario de Venta</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-light p-3">
                    <!-- Extremo Izquierdo: Título del Formulario -->
                    <h4 class="card-title mb-0 text-secondary fw-bold">Formulario de Venta</h4>

                    <!-- Extremo Derecho: Número de Venta Notable -->
                    <div class="d-flex align-items-center">
                        <span class="fs-5 fw-bold text-dark me-2">Número de Venta:</span>
                        <span class="badge bg-primary fs-5 px-3 py-2 shadow-sm">
                            #{{ $sale->id }}
                        </span>
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Error!</h4>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Cliente -->
                        <div class="row mb-3">
                            <div class="col-12 my-3">
                                <div class="card border-0 bg-light-subtle shadow-sm rounded-3 overflow-hidden">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        
                                        <!-- Avatar Visual con las iniciales del cliente -->
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; min-width: 60px;">
                                            <span class="fs-3 fw-bold text-uppercase">
                                                {{ substr($user->full_name, 0, 1) }}
                                            </span>
                                        </div>

                                        <!-- Datos del Cliente -->
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                                <div>
                                                    <small class="text-uppercase text-muted fw-semibold tracking-wider font-monospace fs-7 block mb-1">Cliente Activo</small>
                                                    <h4 class="mb-1 text-dark fw-bold">{{ $user->full_name }}</h4>
                                                </div>
                                                <!-- Badge del Documento de Identidad -->
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis px-3 py-2 rounded-pill fs-6 mt-2 mt-sm-0 border border-secondary-subtle">
                                                    <i class="bi bi-card-text me-1"></i> C.I. {{ $user->ci }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="saleForm" action="{{ route('sale.additem') }}" method="POST">
                            @csrf

                            <!-- Campos Ocultos Requeridos -->
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="user_role" value="{{ $role }}">

                            <div class="row align-items-end mb-4">
                                <!-- Selector de Productos -->
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <label for="product_id" class="form-label fw-semibold">Seleccionar Producto</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                            <option value="" selected disabled>Seleccionar Producto...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Input de Cantidad -->
                                <div class="col-12 col-md-3 mb-3 mb-md-0">
                                    <label for="quantity" class="form-label fw-semibold">Cantidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calculator"></i></span>
                                        <input type="number" 
                                            name="quantity" 
                                            id="quantity" 
                                            min="1" 
                                            max="50" 
                                            value="{{ old('quantity', 1) }}" 
                                            class="form-control @error('quantity') is-invalid @enderror" 
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            oninput="if(this.value > 50) this.value = 50; if(this.value < 1 && this.value !== '') this.value = 1;"
                                            required>
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                 </div>

                                <!-- Botón de Acción -->
                                <div class="col-12 col-md-3">
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        <i class="bi bi-plus-circle me-1"></i> Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </form>
                         <div class="row mb-3">
                            <div class="col-12">
                                <h5 class="mb-3 fw-bold"><i class="bi bi-box-seam me-2"></i>Productos en esta Venta</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle" id="productsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Categoría</th>
                                                <th class="text-end">Precio Unitario</th>
                                                <th class="text-center">Stock Disponible</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Subtotal</th>
                                                <th class="text-center" style="width: 100px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productsBody">
                                            @php $total = 0; @endphp
                                            @forelse($saleDetails as $detail)
                                                @php $total += $detail->subtotal; @endphp
                                                <tr>
                                                    <!-- Nombre del Producto -->
                                                    <td class="fw-semibold">{{ $detail->product->name }}</td>
                                                    
                                                    <!-- Categoría del Producto (Validando que exista la relación) -->
                                                    <td>{{ $detail->product->category->name ?? 'Sin Categoría' }}</td>
                                                    
                                                    <!-- Precio Unitario -->
                                                    <td class="text-end">${{ number_format($detail->unit_price, 2) }}</td>
                                                    
                                                    <!-- Stock Disponible actual en tu inventario -->
                                                    <td class="text-center">
                                                        <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                                            {{ $detail->product->current_stock ?? 0 }} u.
                                                        </span>
                                                    </td>
                                                    
                                                    <!-- Cantidad Comprada -->
                                                    <td class="text-center fw-bold">{{ $detail->quantity }}</td>
                                                    
                                                    <!-- Subtotal del Item -->
                                                    <td class="text-end fw-bold text-success">${{ number_format($detail->subtotal, 2) }}</td>
                                                    
                                                    <!-- Única Acción: Botón Eliminar Item -->
                                                    <td class="text-center">
                                                        <form action="{{ route('sale.removeitem', $detail->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de remover este producto de la venta?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            
                                                            <!-- Campos ocultos requeridos -->
                                                            <input type="hidden" name="product_id" value="{{ $detail->product_id }}">
                                                            <input type="hidden" name="quantity" value="{{ $detail->quantity }}">

                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar Producto">
                                                                <i class="bi bi-trash3-fill"></i>
                                                            </button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            @empty
                                                <!-- Mensaje si la tabla está vacía -->
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4 fs-6">
                                                        <i class="bi bi-cart-x fs-4 d-block mb-2 text-secondary"></i>
                                                        No hay productos agregados a esta venta todavía. Use el formulario superior.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            
                            <!-- Campos Ocultos de Control de Venta -->
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="discount_id" class="form-label fw-semibold">Aplicar Descuento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                        <select class="form-select" id="discount_id" name="discount_id">
                                            <option value="" data-percentage="0">-- Sin Descuento --</option>
                                            @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}" data-percentage="{{ $discount->percentage }}" {{ old('discount_id', $sale->discount_id) == $discount->id ? 'selected' : '' }}>
                                                    {{ $discount->name }} ({{ $discount->percentage*100 }}%)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="text-muted d-block mt-1" id="discountInfo"></small>
                                </div>

                                <div class="col-md-6">
                                    <label for="payment_type_id" class="form-label fw-semibold">Método de Pago</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-credit-card-2-back"></i></span>
                                        <select class="form-select @error('payment_type_id') is-invalid @enderror" id="payment_type_id" name="payment_type_id" required>
                                            <option value="" selected disabled>-- Seleccione Método de Pago --</option>
                                            @foreach($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}" {{ old('payment_type_id', $sale->payment_type_id) == $paymentMethod->id ? 'selected' : '' }}>
                                                    {{ $paymentMethod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('payment_type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-block mt-1">Selecciona cómo liquidará el cliente la venta.</small>
                                </div>

                            </div>
                            
                            <!-- Totales -->
                            <div class="row mb-4">
                                <div class="col-md-6 ms-auto">
                                    <div class="card shadow-sm border-0 bg-light-subtle">
                                        <div class="card-body p-4">
                                            <!-- Fila Subtotal -->
                                            <div class="row align-items-center mb-2">
                                                <div class="col-7">
                                                    <span class="text-muted fw-semibold">Subtotal:</span>
                                                </div>
                                                <div class="col-5 text-end">
                                                    @php $dbSubtotal = $saleDetails->sum('subtotal'); @endphp
                                                    <span class="fs-5 fw-bold text-dark" id="subtotalLabel">${{ number_format($dbSubtotal, 2) }}</span>
                                                    <input type="hidden" id="subtotalValue" name="subtotal" value="{{ $dbSubtotal }}">
                                                </div>
                                            </div>

                                            <!-- Fila Descuento -->
                                            <div class="row align-items-center mb-2">
                                                <div class="col-7">
                                                    <span class="text-muted fw-semibold">Descuento Calculado:</span>
                                                </div>
                                                <div class="col-5 text-end">
                                                    <span class="fs-5 fw-bold text-danger" id="discountLabel">$0.00</span>
                                                    <!-- Coincide con tu columna discount_payment -->
                                                    <input type="hidden" name="discount_payment" id="discountPaymentHidden" value="0.00">
                                                </div>
                                            </div>

                                            <!-- Fila Total -->
                                            <div class="row align-items-center border-top pt-3 mt-2">
                                                <div class="col-7">
                                                    <span class="fs-5 fw-bold text-dark">Total Neto a Pagar:</span>
                                                </div>
                                                <div class="col-5 text-end">
                                                    <span class="fs-4 fw-bold text-primary" id="totalLabel">${{ number_format($dbSubtotal, 2) }}</span>
                                                    <!-- Coincide con tu columna total_amount -->
                                                    <input type="hidden" name="total_amount" id="totalAmountHidden" value="{{ $dbSubtotal }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4 py-2" id="submitBtn" {{ $saleDetails->isEmpty() ? 'disabled' : '' }}>
                                        <i class="bi bi-check-circle me-1"></i> Finalizar y Guardar Venta
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-light border px-4 py-2">
                                        <i class="bi bi-x-circle me-1"></i> Salir
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const discountSelect = document.getElementById('discount_id');
    const subtotalValue = parseFloat(document.getElementById('subtotalValue').value) || 0;
    
    const discountLabel = document.getElementById('discountLabel');
    const discountHidden = document.getElementById('discountPaymentHidden');
    
    const totalLabel = document.getElementById('totalLabel');
    const totalHidden = document.getElementById('totalAmountHidden');
    const discountInfo = document.getElementById('discountInfo');

    function calculateTotals() {
        // Obtener el porcentaje del atributo "data-percentage" de la opción seleccionada
        const selectedOption = discountSelect.options[discountSelect.selectedIndex];
        const percentage = parseFloat(selectedOption.getAttribute('data-percentage')) || 0;

        // Calcular montos
        const discountAmount = subtotalValue * (percentage);
        const finalTotal = subtotalValue - discountAmount;

        // Actualizar interfaz visual
        discountLabel.textContent = `$${discountAmount.toFixed(2)}`;
        totalLabel.textContent = `$${finalTotal.toFixed(2)}`;

        // Actualizar inputs ocultos que viajan al controlador
        discountHidden.value = discountAmount.toFixed(2);
        totalHidden.value = finalTotal.toFixed(2);

        // Mostrar texto descriptivo del descuento
        if (percentage > 0) {
            discountInfo.textContent = `Ahorro del ${percentage}% aplicado correctamente.`;
            discountInfo.className = "text-success small d-block mt-1 fw-medium";
        } else {
            discountInfo.textContent = "Ningún descuento seleccionado.";
            discountInfo.className = "text-muted small d-block mt-1";
        }
    }

    // Escuchar cambios en el selector de descuentos
    discountSelect.addEventListener('change', calculateTotals);
    
    // Ejecutar al cargar la página por si ya hay un descuento guardado de antes
    calculateTotals();
});
</script>
@endsection