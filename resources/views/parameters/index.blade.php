@extends('layouts.admin')
@section('title')
    <h3>Parametros del Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado puede gestionar los tipos de pagos para el sistema y ver los roles</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Parametros</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">MÉTODOS DE PAGO</h4>
                <!-- Botón para abrir el modal de creación de método de pago -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createpaymenttype">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de método de pago -->
                    <div class="modal fade text-left" id="createpaymenttype" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nuevo método de pago
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('paymenttypes.create') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="oem" class="form-label">Nombre del método de pago*</label>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentTypes  as $paymentType)
                                    <tr>
                                        <td>{{ Str::limit($paymentType->name , 20, '...') }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showpaymenttype{{ $paymentType->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editpaymenttype{{ $paymentType->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-form-{{ $paymentType->id }}" action="{{ route('paymenttypes.destroy', $paymentType->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $paymentType->id }})"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($paymentTypes as $paymentType)
                            <div class="modal fade text-left" id="editpaymenttype{{ $paymentType->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $paymentType->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $paymentType->id }}">
                                                Editar método de pago
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('paymenttypes.update', $paymentType->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_id" value="{{ $paymentType->id }}">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Nombre del método de pago</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre del método de pago" value="{{ old('edit_id') == $paymentType->id ? old('name') : $paymentType->name }}" required>
                                                            @error('name')
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

                             <div class="modal fade text-left" id="showpaymenttype{{ $paymentType->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $paymentType->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="editModalLabel{{ $paymentType->id }}">
                                                Información del método de pago
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_id" value="{{ $paymentType->id }}">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Nombre del método de pago</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input type="text" class="form-control" value="{{ old('edit_id') == $paymentType->id ? old('name') : $paymentType->name }}" readonly>
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

                        @if ($paymentTypes->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $paymentTypes->links('pagination::bootstrap-5') }}
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
                <h4 class="card-title mb-0">Roles del sistema</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>Estos son los roles disponibles en el sistema.</p>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td >{{ Str::limit($role->name , 20, '...') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                var editModal = document.getElementById('editpaymenttype' + editId);
                if (editModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(editModal).show();
                }
            } else {
                var createCategoryModal = document.getElementById('createcategory');
                if (createCategoryModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(createCategoryModal).show();
                }
            }
        });
    </script>
@endif

<script>
function confirmDelete(categoryId) {
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
            document.getElementById('delete-form-' + categoryId).submit();
            
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Tu categoría está a salvo :)",
                icon: "error"
            });
        }
    });
}
</script>

@endsection