@extends('layouts.admin')
@section('title')
    <h3>Productos</h3>
    <p class="text-subtitle text-muted">En este apartado puedes registrar nuevos productos</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar producto</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h4 class="card-title">Formulario de registro</h4>
                <h6 class="card-subtitle">Rellena los campos para registrar un nuevo producto</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="oem" class="form-label">Numero oem</label>
                                    <div class="input-group">
                                        <span class="input-group-text">OEM</span>
                                        <input name="oem" type="text" class="form-control" id="oem" placeholder="Numero oem"
                                        @error('oem') is-invalid @enderror required>
                                        @error('oem')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre del producto</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Nombre</span>
                                        <input name="name" type="text" class="form-control" id="nombre" placeholder="Nombre del producto"
                                        @error('name') is-invalid @enderror required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="price_buy" class="form-label">Precio de compra</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Bs</span>
                                        <input name="price_buy" type="number" class="form-control" id="price_buy" placeholder="Precio de compra"
                                        @error('price_buy') is-invalid @enderror required>
                                        @error('price_buy')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="price_sell" class="form-label">Precio de venta</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Bs</span>
                                        <input name="price_sell" type="number" class="form-control" id="price_sell" placeholder="Precio de venta"
                                        @error('price_sell') is-invalid @enderror required>
                                        @error('price_sell')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="stock" class="form-label">Stock</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Cantidad</span>
                                        <input name="stock" type="number" class="form-control" id="stock" placeholder="Stock"
                                        @error('stock') is-invalid @enderror required>
                                        @error('stock ')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="min_stock" class="form-label">Stock mínimo</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Cantidad</span>
                                        <input name="min_stock" type="number" class="form-control" id="min_stock" placeholder="Stock mínimo"
                                        @error('min_stock') is-invalid @enderror required>
                                        @error('min_stock')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>  
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="min_stock" class="form-label">Estado</label>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                        <select class="form-select" id="inputGroupSelect01" name="status" @error('status') is-invalid @enderror required>
                                            <option selected="">Seleccionar...</option>
                                            <option value="Disponible">Disponible</option>
                                            <option value="Agotado">Agotado</option>
                                            <option value="Descontinuado">Descontinuado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <label for="Compatibility" class="form-label">Compatibilidad</label>
                                    <div class="form-group with-title mb-3">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="compatibility_notes" @error('compatibility_notes') is-invalid @enderror required></textarea>
                                        <label>Elementos compatibles</label>
                                        @error('compatibility_notes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-12">
                                    <label for="Especificaciones" class="form-label">Especificaciones Técnicas</label>
                                    <div class="form-group with-title mb-3">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="technical_specs" @error('technical_specs') is-invalid @enderror required></textarea>
                                        <label>Características del producto</label>
                                        @error('technical_specs')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                                  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="imagen" class="form-label">Imagen del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text">imagen</span>
                                    <input type="file" name="image_main" id="" class="form-control" @error('image_main') is-invalid @enderror accept="image/*" onchange="mostrarImagen(event)" required >
                                    @error('image_main')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <img src="" alt="" id="imagen" class="img-fluid mt-3">
                                <script>
                                    const mostrarImagen = (event) => {
                                        const imagen = document.getElementById('imagen').src = URL.createObjectURL(event.target.files[0]);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Registrar producto</button>  
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection