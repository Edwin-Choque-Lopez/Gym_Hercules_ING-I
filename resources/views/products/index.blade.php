@extends('layouts.admin')
@section('title')
    <h3>Productos registrados en el Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado puede gestionar las registros  de los productos registrados en el sistema</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Productos</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">PRODUCTOS</h4>
                <!-- Botón para abrir el modal de creación de producto -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createproduct">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de producto -->
                    <div class="modal fade text-left" id="createproduct" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nuevo producto
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Nombre del producto*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre de la categoria"
                                                    value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Categoria*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-arrow-bar-down"></i></span>
                                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                                        <option value="">Seleccionar Categoria</option>
                                                        @foreach($categories as $id => $name)
                                                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <label class="form-label">Precio de compra*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Bs</span>
                                                    <input name="price_buy" type="number" step="0.01" class="form-control @error('price_buy') is-invalid @enderror" placeholder="Precio de compra"
                                                    value="{{ old('price_buy') }}" required>
                                                    @error('price_buy')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <label class="form-label">Precio de venta*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Bs</span>
                                                    <input name="price_sell" type="number" step="0.01" class="form-control @error('price_sell') is-invalid @enderror" placeholder="Precio de venta"
                                                    value="{{ old('price_sell') }}" required>
                                                    @error('price_sell')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <label class="form-label">Stock*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                                    <input name="current_stock" type="number" class="form-control @error('current_stock') is-invalid @enderror" placeholder="Stock"
                                                    value="{{ old('current_stock') }}" required>
                                                    @error('current_stock')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Fecha de vencimiento*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar-day"></i></span>
                                                    <input name="expiration_date" type="date" class="form-control @error('expiration_date') is-invalid @enderror" placeholder="Fecha de vencimiento"
                                                    value="{{ old('expiration_date') }}" required>
                                                    @error('expiration_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Stock mínimo*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-box2-fill"></i></span>
                                                    <input name="min_stock" type="number" class="form-control @error('min_stock') is-invalid @enderror" placeholder="Stock mínimo"
                                                    value="{{ old('min_stock') }}" required>
                                                    @error('min_stock')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="Especificaciones" class="form-label">Descripción</label>
                                                <div class="form-group with-title mb-3">
                                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ old('description') }}</textarea>
                                                    <label>Redacte una descripción del producto</label>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Cancelar</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Registrar</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>En este apartado puede gestionar las categorías de productos del sistema.</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Nombre</th>
                                    <th>Precio de venta</th>
                                    <th>Fecha de vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ Str::limit($product->category_name, 20, '...') }}</td>
                                        <td>{{ Str::limit($product->name, 20, '...') }}</td>
                                        <td>{{ $product->price_sell }}</td>
                                        <td>{{ $product->expiration_date }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showproduct{{ $product->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editproduct{{ $product->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $product->id }})"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($products as $product)
                            <div class="modal fade text-left" id="editproduct{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $product->id }}">
                                                Editar producto
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Los campos marcados con * son obligatorios</p>
                                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_id" value="{{ $product->id }}">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Nombre del producto*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre de la categoria"
                                                            value="{{ $product->name }}" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label for="oem" class="form-label">Categoria*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-arrow-bar-down"></i></span>
                                                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                                                <option value="">Seleccionar Categoria</option>
                                                                @foreach($categories as $id_cate => $name_cate)
                                                                    <option value="{{ $id_cate }}" {{ $product->category_id == $id_cate ? 'selected' : '' }}>
                                                                        {{ $name_cate }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3">
                                                        <label class="form-label">Precio de compra*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Bs</span>
                                                            <input name="price_buy" type="number" step="0.01" class="form-control @error('price_buy') is-invalid @enderror" placeholder="Precio de compra"
                                                            value="{{ $product->price_buy }}" required>
                                                            @error('price_buy')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3">
                                                        <label class="form-label">Precio de venta*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Bs</span>
                                                            <input name="price_sell" type="number" step="0.01" class="form-control @error('price_sell') is-invalid @enderror" placeholder="Precio de venta"
                                                            value="{{ $product->price_sell }}" required>
                                                            @error('price_sell')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mb-3">
                                                        <label class="form-label">Stock*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                                            <input name="current_stock" type="number" class="form-control @error('current_stock') is-invalid @enderror" placeholder="Stock"
                                                            value="{{ $product->current_stock }}" required>
                                                            @error('current_stock')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Fecha de vencimiento*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-calendar-day"></i></span>
                                                            <input name="expiration_date" type="date" class="form-control @error('expiration_date') is-invalid @enderror" placeholder="Fecha de vencimiento"
                                                            value="{{ $product->expiration_date }}" required>
                                                            @error('expiration_date')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Stock mínimo*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-box2-fill"></i></span>
                                                            <input name="min_stock" type="number" class="form-control @error('min_stock') is-invalid @enderror" placeholder="Stock mínimo"
                                                            value="{{ $product->min_stock }}" required>
                                                            @error('min_stock')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="Especificaciones" class="form-label">Descripción</label>
                                                        <div class="form-group with-title mb-3">
                                                            <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ $product->description }}</textarea>
                                                            <label>Redacte una descripción del producto</label>
                                                            @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Cancelar</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-success ms-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Actualizar</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="modal fade text-left" id="showproduct{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="editModalLabel{{ $product->id }}">
                                                Información del producto
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Nombre del producto</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control"
                                                        value="{{ $product->name }}" readonly> 
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="oem" class="form-label">Categoria</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-arrow-bar-down"></i></span>
                                                        <input name="name" type="text" class="form-control"
                                                        value="{{ $product->category_name}}" readonly> 
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label class="form-label">Precio de compra</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Bs</span>
                                                        <input name="price_buy" type="number" step="0.01" class="form-control" 
                                                        value="{{ $product->price_buy }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label class="form-label">Precio de venta</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Bs</span>
                                                        <input name="price_sell" type="number" step="0.01" class="form-control"
                                                        value="{{ $product->price_sell }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label class="form-label">Stock</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                                        <input name="current_stock" type="number" class="form-control"
                                                        value="{{ $product->current_stock }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Fecha de vencimiento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar-day"></i></span>
                                                        <input name="expiration_date" type="date" class="form-control"
                                                        value="{{ $product->expiration_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Stock mínimo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-box2-fill"></i></span>
                                                        <input name="min_stock" type="number" class="form-control"
                                                        value="{{ $product->min_stock }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Especificaciones" class="form-label">Descripción</label>
                                                    <div class="form-group with-title mb-3">
                                                        <textarea class="form-control" rows="3" readonly>{{ $product->description }}</textarea>
                                                        <label>Redacte una descripción del producto</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary col-md-12" data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Cerrar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($products->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editId = '{{ old('edit_id') }}';

            if (editId) {
                var editModal = document.getElementById('editproduct' + editId);
                if (editModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(editModal).show();
                }
            } else {
                var createCategoryModal = document.getElementById('createproduct');
                if (createCategoryModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(createCategoryModal).show();
                }
            }
        });
    </script>
@endif

<script>
function confirmDelete(productId) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminarlo!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + productId).submit();
            
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Tu producto está a salvo :)",
                icon: "error"
            });
        }
    });
}
</script>

@endsection