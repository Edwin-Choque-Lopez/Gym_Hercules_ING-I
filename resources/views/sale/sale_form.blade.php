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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Formulario de Venta</h4>
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

                        <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
                            @csrf

                            <!-- Cliente -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label">Nombre del Cliente</label>
                                    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                    <input type="text" class="form-control" readonly value="{{ $user->full_name }}" placeholder="Cliente">
                                </div>
                                <div class="col-md-6">
                                    <label for="user_info" class="form-label">C.I. Del Cliente</label>
                                    <input type="text" class="form-control" id="user_info" readonly value="CI: {{ $user->ci }}">
                                </div>
                                <input type="hidden" name="user_role" value="{{ $role }}">
                            </div>

                            <!-- Productos -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5 class="mb-3">Productos</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="productsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Categoría</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Stock Disponible</th>
                                                    <th>Cantidad</th>
                                                    <th>Subtotal</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productsBody">
                                                <tr class="text-center text-muted">
                                                    <td colspan="7">Agregar productos usando el botón inferior</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success" id="addProductBtn" data-bs-toggle="modal" data-bs-target="#productModal">
                                        <i class="bi bi-plus-circle"></i> Agregar Producto
                                    </button>
                                </div>
                            </div>

                            <!-- Descuentos -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="discount_id" class="form-label">Aplicar Descuento</label>
                                    <select class="form-select" id="discount_id" name="discount_id">
                                        <option value="">-- Sin Descuento --</option>
                                        @foreach($discounts as $discount)
                                            <option value="{{ $discount->id }}" data-percentage="{{ $discount->percentage }}">
                                                {{ $discount->name }} ({{ $discount->percentage }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted" id="discountInfo"></small>
                                </div>
                            </div>

                            <!-- Totales -->
                            <div class="row mb-3">
                                <div class="col-md-6 ms-auto">
                                    <div class="card ">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-8">
                                                    <label class="form-label">Subtotal:</label>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <input type="text" class="form-control form-control-plaintext text-end" id="subtotal" readonly value="0.00">
                                                    <input type="hidden" name="subtotal" id="subtotalHidden">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-8">
                                                    <label class="form-label">Descuento:</label>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <input type="text" class="form-control form-control-plaintext text-end" id="discountAmount" readonly value="0.00">
                                                    <input type="hidden" name="discount_amount" id="discountAmountHidden">
                                                </div>
                                            </div>
                                            <div class="row border-top pt-2">
                                                <div class="col-8">
                                                    <label class="form-label fw-bold">Total:</label>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <input type="text" class="form-control form-control-plaintext text-end fw-bold" id="total" readonly value="0.00">
                                                    <input type="hidden" name="total" id="totalHidden">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="bi bi-check-circle"></i> Realizar Venta
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                </div>
                            </div>

                            <!-- Array de productos para envío -->
                            <div id="productsArrayContainer"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar productos -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="text" class="form-control" id="productSearch" placeholder="Buscar por nombre o categoría...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="availableProductsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="availableProductsBody">
                                @foreach($products as $product)
                                    <tr data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" 
                                        data-category="{{ $product->categorie->name ?? 'Sin categoría' }}" 
                                        data-price="{{ $product->price_sell }}" 
                                        data-stock="{{ $product->current_stock }}">
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->categorie->name ?? 'Sin categoría' }}</td>
                                        <td>${{ number_format($product->price_sell, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $product->current_stock > $product->min_stock ? 'bg-success' : 'bg-warning' }}">
                                                {{ $product->current_stock }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary selectProductBtn" 
                                                    data-product-id="{{ $product->id }}">
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ingresar cantidad -->
    <div class="modal fade" id="quantityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingrese Cantidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="quantityProductName"></p>
                    <label for="quantityInput" class="form-label">Cantidad:</label>
                    <input type="number" class="form-control" id="quantityInput" min="1" value="1">
                    <small class="text-muted" id="stockInfo"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmQuantityBtn">Agregar</button>
                </div>
            </div>
    </div>

@endsection

@section('scripts')
    <script>
        let selectedProducts = [];
        let currentProductData = null;

        // Búsqueda de productos
        document.getElementById('productSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#availableProductsTable tbody tr');
            
            rows.forEach(row => {
                const productName = row.cells[0].textContent.toLowerCase();
                const category = row.cells[1].textContent.toLowerCase();
                const matches = productName.includes(searchTerm) || category.includes(searchTerm);
                row.style.display = matches ? '' : 'none';
            });
        });

        // Seleccionar producto
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('selectProductBtn')) {
                const row = e.target.closest('tr');
                currentProductData = {
                    id: row.getAttribute('data-product-id'),
                    name: row.getAttribute('data-product-name'),
                    price: parseFloat(row.getAttribute('data-price')),
                    stock: parseInt(row.getAttribute('data-stock'))
                };

                document.getElementById('quantityProductName').textContent = currentProductData.name;
                document.getElementById('stockInfo').textContent = `Stock disponible: ${currentProductData.stock}`;
                document.getElementById('quantityInput').value = 1;
                document.getElementById('quantityInput').max = currentProductData.stock;

                const productModal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                if (productModal) productModal.hide();

                const quantityModal = new bootstrap.Modal(document.getElementById('quantityModal'));
                quantityModal.show();
            }
        });

        // Confirmar cantidad
        document.getElementById('confirmQuantityBtn').addEventListener('click', function() {
            const quantity = parseInt(document.getElementById('quantityInput').value);

            if (quantity <= 0 || quantity > currentProductData.stock) {
                alert('Cantidad inválida');
                return;
            }

            // Buscar si el producto ya existe
            const existingProduct = selectedProducts.find(p => p.id === currentProductData.id);
            
            if (existingProduct) {
                if (existingProduct.quantity + quantity > currentProductData.stock) {
                    alert('No hay suficiente stock');
                    return;
                }
                existingProduct.quantity += quantity;
            } else {
                selectedProducts.push({
                    id: currentProductData.id,
                    name: currentProductData.name,
                    price: currentProductData.price,
                    quantity: quantity,
                    stock: currentProductData.stock
                });
            }

            renderProducts();
            calculateTotals();

            const quantityModal = bootstrap.Modal.getInstance(document.getElementById('quantityModal'));
            quantityModal.hide();
        });

        // Renderizar productos en la tabla
        function renderProducts() {
            const tbody = document.getElementById('productsBody');
            
            if (selectedProducts.length === 0) {
                tbody.innerHTML = '<tr class="text-center text-muted"><td colspan="7">Agregar productos usando el botón inferior</td></tr>';
                return;
            }

            tbody.innerHTML = selectedProducts.map((product, index) => `
                <tr>
                    <td>${product.name}</td>
                    <td>-</td>
                    <td>$${product.price.toFixed(2)}</td>
                    <td>${product.stock}</td>
                    <td><input type="number" class="form-control form-control-sm quantityInput" value="${product.quantity}" min="1" max="${product.stock}" data-index="${index}"></td>
                    <td>$${(product.price * product.quantity).toFixed(2)}</td>
                    <td><button type="button" class="btn btn-sm btn-danger removeProductBtn" data-index="${index}">Eliminar</button></td>
                </tr>
            `).join('');

            // Event listeners para cambiar cantidad
            document.querySelectorAll('input[data-index]').forEach(input => {
                input.addEventListener('change', function() {
                    const index = this.getAttribute('data-index');
                    const newQuantity = parseInt(this.value);
                    
                    if (newQuantity <= 0 || newQuantity > selectedProducts[index].stock) {
                        alert('Cantidad inválida');
                        this.value = selectedProducts[index].quantity;
                        return;
                    }
                    
                    selectedProducts[index].quantity = newQuantity;
                    renderProducts();
                    calculateTotals();
                });
            });

            // Event listeners para eliminar
            document.querySelectorAll('.removeProductBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    selectedProducts.splice(index, 1);
                    renderProducts();
                    calculateTotals();
                });
            });
        }

        // Calcular totales
        function calculateTotals() {
            const subtotal = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
            const discountSelect = document.getElementById('discount_id');
            const discountPercentage = discountSelect.value ? parseFloat(discountSelect.options[discountSelect.selectedIndex].getAttribute('data-percentage')) : 0;
            const discountAmount = subtotal * (discountPercentage / 100);
            const total = subtotal - discountAmount;

            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('subtotalHidden').value = subtotal.toFixed(2);
            document.getElementById('discountAmount').value = discountAmount.toFixed(2);
            document.getElementById('discountAmountHidden').value = discountAmount.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('totalHidden').value = total.toFixed(2);

            // Actualizar información del descuento
            if (discountPercentage > 0) {
                document.getElementById('discountInfo').textContent = `Descuento: ${discountPercentage}%`;
            } else {
                document.getElementById('discountInfo').textContent = '';
            }
        }

        // Cambiar descuento
        document.getElementById('discount_id').addEventListener('change', calculateTotals);

        // Validar antes de enviar
        document.getElementById('saleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!document.getElementById('user_id').value) {
                alert('Por favor selecciona un cliente');
                return;
            }

            if (selectedProducts.length === 0) {
                alert('Por favor agrega al menos un producto');
                return;
            }

            // Agregar productos como hidden inputs
            const container = document.getElementById('productsArrayContainer');
            container.innerHTML = '';
            
            selectedProducts.forEach((product, index) => {
                container.innerHTML += `<input type="hidden" name="products[${index}][id]" value="${product.id}">`;
                container.innerHTML += `<input type="hidden" name="products[${index}][quantity]" value="${product.quantity}">`;
            });

            this.submit();
        });
    </script>
@endsection