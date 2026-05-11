@extends('layouts.admin')
@section('title')
    <h3>Clientes Registrados en el Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado puede gestionar los clientes del sistema y ver sus datos</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">CLIENTES DEL SISTEMA</h4>
                <!-- Botón para abrir el modal de creación de método de pago -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createcustomer">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de método de pago -->
                    <div class="modal fade text-left" id="createcustomer" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nuevo cliente
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-13 mb-3">
                                                <label for="oem" class="form-label">C.I.*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                    <input name="ci" type="text" class="form-control @error('ci') is-invalid @enderror" placeholder="C.I. del usuario"
                                                    value="{{ old('ci') }}" required>
                                                    @error('ci')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-12 mb-3">
                                                <label for="oem" class="form-label">Nombre Completo*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo del usuario"
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
                                    <th style="text-align: center;">Cédula</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->ci }}</td>
                                        <td>{{ $customer->full_name }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showcustomer{{ $customer->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editcustomer{{ $customer->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $customer->id }})"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($customers as $customer)
                            <div class="modal fade text-left" id="editcustomer{{ $customer->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $customer->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $customer->id }}">
                                                Editar cliente
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_id" value="{{ $customer->id }}">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="oem" class="form-label">C.I.*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                            <input name="ci" type="text" class="form-control @error('ci') is-invalid @enderror" placeholder="C.I. del usuario"
                                                            value="{{ $customer->ci }}" required>
                                                            @error('ci')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="oem" class="form-label">Nombre Completo*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo del usuario"
                                                            value="{{ $customer->full_name }}" required>
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

                            <div class="modal fade text-left" id="showcustomer{{ $customer->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $customer->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="showModalLabel{{ $customer->id }}">
                                                Información del usuario
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_id" value="{{ $customer->id }}">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="oem" class="form-label">C.I.</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                        <input name="ci" type="text" class="form-control @error('ci') is-invalid @enderror" placeholder="C.I. del usuario"
                                                        value="{{ $customer->ci }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="oem" class="form-label">Nombre Completo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo del usuario"
                                                        value="{{ $customer->full_name }}" readonly>
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

                        @if ($customers->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $customers->links('pagination::bootstrap-5') }}
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
                var editModal = document.getElementById('editcustomer' + editId);
                if (editModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(editModal).show();
                }
            } else {
                var createCategoryModal = document.getElementById('createcustomer');
                if (createCategoryModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(createCategoryModal).show();
                }
            }
        });
    </script>
@endif

<script>

function confirmDelete(customerId) {
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
            document.getElementById('delete-form-' + customerId).submit();
            
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "La información está a salvo :)",
                icon: "error"
            });
        }
    });
}
</script>

@endsection