@extends('layouts.admin')
@section('title')
    <h3>Usuarios del Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado puede gestionar los usuarios del sistema y ver sus roles</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">USUARIOS DEL SISTEMA</h4>
                <!-- Botón para abrir el modal de creación de método de pago -->
                <div class="modal-primary me-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createuser">
                         <i class="bi bi-plus-square-fill"></i> CREAR
                    </button>
                    <!-- Modal de creación de método de pago -->
                    <div class="modal fade text-left" id="createuser" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="myModalLabel160">
                                        Crear nuevo usuario
                                    </h5>
                                    <!--Boton para cerrar el modal-->
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Los campos marcados con * son obligatorios</p>
                                     <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
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
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Rol de Usuario</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-people-fill"></i></i></span>
                                                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                                        <option value="">Seleccionar Rol</option>
                                                        @foreach($roles as $id => $name)
                                                            <option value="{{ $id }}" {{ old('role_id') == $id ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
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
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Teléfono del Usuario</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                    <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Teléfono del usuario"
                                                    value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Correo Electrónico*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico del usuario"
                                                    value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Contraseña*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text toggle-password" style="cursor: pointer;" data-target="password-create">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </span>
                                                    <input id="password-create" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña del usuario"
                                                    value="{{ old('password') }}" required>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="oem" class="form-label">Confirmar Contraseña*</label>
                                                <div class="input-group">
                                                    <span class="input-group-text toggle-password" style="cursor: pointer;" data-target="password-confirm-create">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </span>
                                                    <input id="password-confirm-create" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmar contraseña del usuario"
                                                    value="{{ old('password_confirmation') }}" required>
                                                    @error('password_confirmation')
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
                                    <th style="text-align: center;">Teléfono</th>
                                    <th style="text-align: center;">Rol</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users  as $user)
                                    <tr>
                                        <td>{{ $user->ci }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td style="text-align: center"><span class="badge bg-light-success">{{ $user->role_name }}</span></td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showuser{{ $user->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#edituser{{ $user->id }}">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $user->id }})"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach($users as $user)
                            <div class="modal fade text-left" id="edituser{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title white" id="editModalLabel{{ $user->id }}">
                                                Editar usuario
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="edit_id" value="{{ $user->id }}">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label for="oem" class="form-label">C.I.*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                            <input name="ci" type="text" class="form-control @error('ci') is-invalid @enderror" placeholder="C.I. del usuario"
                                                            value="{{ $user->ci }}" required>
                                                            @error('ci')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label for="oem" class="form-label">Rol de Usuario</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-people-fill"></i></i></span>
                                                            <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                                                <option value="">Seleccionar Rol</option>
                                                                @foreach($roles as $id_rol => $name_rol)
                                                                    <option value="{{ $id_rol }}" {{ $user->role_id == $id_rol ? 'selected' : '' }}>
                                                                        {{ $name_rol }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('role_id')
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
                                                            value="{{ $user->name }}" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label for="oem" class="form-label">Teléfono del Usuario</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                            <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Teléfono del usuario"
                                                            value="{{ $user->phone }}">
                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label for="oem" class="form-label">Correo Electrónico*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico del usuario"
                                                            value="{{ $user->email }}" required>
                                                            @error('email')
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

                             <div class="modal fade text-left" id="showuser{{ $user->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                            <h5 class="modal-title white" id="showModalLabel{{ $user->id }}">
                                                Información del usuario
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_id" value="{{ $user->id }}">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="oem" class="form-label">C.I.*</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                        <input name="ci" type="text" class="form-control"
                                                        value="{{ $user->ci }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="oem" class="form-label">Rol de Usuario</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-people-fill"></i></i></span>
                                                        <input name="role_id" type="text" class="form-control"
                                                        value="{{ $user->role->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="oem" class="form-label">Nombre Completo*</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control"
                                                        value="{{ $user->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="oem" class="form-label">Teléfono del Usuario</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input name="phone" type="text" class="form-control"
                                                        value="{{ $user->phone }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="oem" class="form-label">Correo Electrónico*</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                                                        <input name="email" type="email" class="form-control"
                                                        value="{{ $user->email }}" readonly>
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

                        @if ($users->hasPages())
                            <div class="d-flex justify-content-left">
                                {{ $users->links('pagination::bootstrap-5') }}
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
                var editModal = document.getElementById('edituser' + editId);
                if (editModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(editModal).show();
                }
            } else {
                var createCategoryModal = document.getElementById('createuser');
                if (createCategoryModal && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    new bootstrap.Modal(createCategoryModal).show();
                }
            }
        });
    </script>
@endif

<script>

document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
});

function confirmDelete(userId) {
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
            document.getElementById('delete-form-' + userId).submit();
            
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Tu usuario está a salvo :)",
                icon: "error"
            });
        }
    });
}
</script>

@endsection