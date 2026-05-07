@extends('layouts.admin')
@section('title')
    <h3>Administración del Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado puede gestionar las registros más importantes del sistema</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administración</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">CATEGORÍAS</h4>
                <!-- Botón para abrir el modal de creación de categoría -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createcategory">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de categoría -->
                    <div class="modal fade text-left" id="createcategory" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nueva categoría
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('categories.create') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="create_type" value="category">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="oem" class="form-label">Nombre de la categoria*</label>
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
                                            <div class="col-md-12 mb-3">
                                                <label for="Especificaciones" class="form-label">Descripción</label>
                                                <div class="form-group with-title mb-3">
                                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ old('description') }}</textarea>
                                                    <label>Redacte una descripción de la categoria</label>
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
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ Str::limit($category->description, 20, '...') }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showcategory{{ $category->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editcategory{{ $category->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="confirmDelete('delete-category-{{ $category->id }}', 'esta categoría')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($categories as $category)
                            <div class="modal fade text-left" id="editcategory{{ $category->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $category->id }}">
                                                Editar categoría
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Los campos marcados con * son obligatorios</p>
                                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_id" value="{{ $category->id }}">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Nombre de la categoria*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre de la categoria" value="{{ old('edit_id') == $category->id ? old('name') : $category->name }}" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Descripción</label>
                                                        <div class="form-group with-title mb-3">
                                                            <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{ old('edit_id') == $category->id ? old('description') : $category->description }}</textarea>
                                                            <label>Redacte una descripción de la categoria</label>
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

                             <div class="modal fade text-left" id="showcategory{{ $category->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="editModalLabel{{ $category->id }}">
                                                Información de la categoría
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_id" value="{{ $category->id }}">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Nombre de la categoria</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input type="text" class="form-control" value="{{ old('edit_id') == $category->id ? old('name') : $category->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <div class="form-group with-title mb-3">
                                                        <textarea class="form-control" rows="3" readonly>{{ old('edit_id') == $category->id ? old('description') : $category->description }}</textarea>
                                                        <label>Descripción de la categoria</label>
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

                        @if ($categories->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">DESCUENTOS</h4>
                <!-- Botón para abrir el modal de creación de categoría -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#creatediscount">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de categoría -->
                    <div class="modal fade text-left" id="creatediscount" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nuevo descuento
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('discounts.create') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="create_type" value="discount">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-3">
                                                <label class="form-label">Nombre del descuento*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre del descuento"
                                                    value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Porcentaje del descuento*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                                    <input name="percentage" type="number" step="0.01" class="form-control @error('percentage') is-invalid @enderror" placeholder="Valor del descuento"
                                                    value="{{ old('percentage') }}" required>
                                                    @error('percentage')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Destino de descuento</label>
                                                <div class="d-flex align-items-center" style="height: 38px;"> <!-- Alinea los radios a la altura del input -->
                                                    <ul class="list-unstyled mb-0 d-flex gap-3">
                                                        <!-- Opción Activo -->
                                                        <li>
                                                            <div class="form-check">
                                                                <input type="radio" 
                                                                        class="form-check-input form-check-primary form-check-glow" 
                                                                        name="for_members" value="1" 
                                                                        {{ old('for_members', 1) == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label cursor-pointer" for="status_active">Miembros</label>
                                                            </div>
                                                        </li>

                                                        <!-- Opción Inactivo -->
                                                        <li>
                                                            <div class="form-check">
                                                                <input type="radio" 
                                                                        class="form-check-input form-check-secondary form-check-glow" 
                                                                        name="for_members" value="0" 
                                                                        {{ old('for_members') === '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label cursor-pointer" for="status_inactive">Clientes</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @error('for_members')
                                                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Fecha de inicio*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                    <input name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Fecha de inicio"
                                                    value="{{ old('start_date') }}" required>
                                                    @error('start_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">Fecha de finalización*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                    <input name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" placeholder="Fecha de finalización"
                                                    value="{{ old('end_date') }}" required>
                                                    @error('end_date')
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
                                                    <label>Redacte una descripción del descuento</label>
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
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Descuento</th>
                                    <th style="text-align: center;">Aplica a</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discounts as $discount)
                                    <tr>
                                        <td>{{ Str::limit($discount->name, 10, '...')  }}</td>
                                        <td>{{ $discount->percentage }}%</td>
                                        <td>
                                            {!! $discount->for_members 
                                                ? '<span class="badge bg-light-success">Miembro</span>' 
                                                : '<span class="badge bg-light-danger">Cliente</span>' 
                                            !!}
                                        </td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showdiscount{{ $discount->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editdiscount{{ $discount->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-discount-{{ $discount->id }}" action="{{ route('discounts.destroy', $discount->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="confirmDelete('delete-discount-{{ $discount->id }}', 'este descuento')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($discounts as $discount)
                            <div class="modal fade text-left" id="editdiscount{{ $discount->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $discount->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $discount->id }}">
                                                Editar descuento
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Los campos marcados con * son obligatorios</p>
                                            <form action="{{ route('discounts.update', $discount->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_discount_id" value="{{ $discount->id }}">
                                                <div class="row">
                                                    <div class="col-12 col-md-12 mb-3">
                                                        <label class="form-label">Nombre del descuento*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre del descuento"
                                                            value="{{ $discount->name }}" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Porcentaje del descuento*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                                            <input name="percentage" type="number" step="0.01" class="form-control @error('percentage') is-invalid @enderror" placeholder="Valor del descuento"
                                                            value="{{ $discount->percentage *100}}" required>
                                                            @error('percentage')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Destino de descuento</label>
                                                        <div class="d-flex align-items-center" style="height: 38px;"> <!-- Alinea los radios a la altura del input -->
                                                            <ul class="list-unstyled mb-0 d-flex gap-3">
                                                                <!-- Opción Activo -->
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="radio" 
                                                                                class="form-check-input form-check-primary form-check-glow" 
                                                                                name="for_members" value="1" 
                                                                                @checked($discount->for_members == 1)>
                                                                        <label class="form-check-label cursor-pointer" for="status_active">Miembros</label>
                                                                    </div>
                                                                </li>

                                                                <!-- Opción Inactivo -->
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input type="radio" 
                                                                                class="form-check-input form-check-secondary form-check-glow" 
                                                                                name="for_members" value="0" 
                                                                                @checked($discount->for_members == 0)>
                                                                        <label class="form-check-label cursor-pointer" for="status_inactive">Clientes</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @error('for_members')
                                                            <small class="text-danger"><strong>{{ $message }}</strong></small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Fecha de inicio*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                            <input name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Fecha de inicio"
                                                            value="{{ $discount->start_date }}" required>
                                                            @error('start_date')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Fecha de finalización*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                            <input name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" placeholder="Fecha de finalización"
                                                            value="{{ $discount->end_date }}" required>
                                                            @error('end_date')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="Especificaciones" class="form-label">Descripción</label>
                                                        <div class="form-group with-title mb-3">
                                                            <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description">{{$discount->description}}</textarea>
                                                            <label>Redacte una descripción del descuento</label>
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

                             <div class="modal fade text-left" id="showdiscount{{ $discount->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $discount->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="editModalLabel{{ $discount->id }}">
                                                Información del descuento
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_id" value="{{ $discount->id }}">
                                            <div class="row">
                                                <div class="col-12 col-md-12 mb-3">
                                                    <label class="form-label">Nombre del descuento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre del descuento"
                                                        value="{{ $discount->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Porcentaje del descuento</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                                        <input name="percentage" type="number" step="0.01" class="form-control @error('percentage') is-invalid @enderror" placeholder="Valor del descuento"
                                                        value="{{ $discount->percentage *100}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Destino de descuento</label>
                                                    <div class="d-flex align-items-center" style="height: 38px;"> <!-- Alinea los radios a la altura del input -->
                                                        {!! $discount->for_members 
                                                            ? '<span class="badge bg-light-success">Miembro</span>' 
                                                            : '<span class="badge bg-light-danger">Cliente</span>' 
                                                        !!}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Fecha de inicio</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                        <input name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Fecha de inicio"
                                                        value="{{ $discount->start_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="form-label">Fecha de finalización*</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                        <input name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" placeholder="Fecha de finalización"
                                                        value="{{ $discount->end_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Especificaciones" class="form-label">Descripción</label>
                                                    <div class="form-group with-title mb-3">
                                                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" readonly>{{$discount->description}}</textarea>
                                                        <label>Redacte una descripción del descuento</label>
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

                        @if ($discounts->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $discounts->links('pagination::bootstrap-5') }}
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
        // --- Variables de Categorías ---
        const editCategoryId = '{{ old('edit_id') }}'; // ID de edición
        const isCreatingCategory = '{{ old('create_type') }}' === 'category';

        // --- Variables de Descuentos (Ejemplo) ---
        const editDiscountId = '{{ old('edit_discount_id') }}'; 
        const isCreatingDiscount = '{{ old('create_type') }}' === 'discount';

        // Lógica de apertura
        if (editCategoryId) {
            abrirModal('editcategory' + editCategoryId);
        } else if (isCreatingCategory) {
            abrirModal('createcategory');
        } else if (editDiscountId) {
            abrirModal('editdiscount' + editDiscountId);
        } else if (isCreatingDiscount) {
            abrirModal('creatediscount');
        }

        function abrirModal(id) {
            const el = document.getElementById(id);
            if (el && window.bootstrap) {
                new bootstrap.Modal(el).show();
            }
        }
    });
</script>
@endif

<script>
    function confirmDelete(formId, itemName) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2", // Añadí margen para que no se peguen
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro?",
            text: "Vas a eliminar " + itemName + ". ¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar!",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Envía el formulario que recibió por parámetro
                document.getElementById(formId).submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "El registro está a salvo :)",
                    icon: "error"
                });
            }
        });
    }
</script>

@endsection