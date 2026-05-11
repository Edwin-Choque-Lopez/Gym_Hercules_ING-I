@extends('layouts.admin')
@section('title')
    <h3>Miembros del Sistema</h3>
    <p class="text-subtitle text-muted">En este apartado podra ver la informacion de los miembros del gimnasio</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Miembros</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="d-flex justify-content-center">
    <div class="row ">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">MÉTODOS DE PAGO</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p>En este apartado puede gestionar las categorías de productos del sistema.</p>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">C.I.</th>
                                        <th style="text-align: center;">Nombre</th>
                                        <th style="text-align: center;">Teléfono</th>
                                        <th style="text-align: center;">Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $member)
                                        <tr>
                                            <td>{{ $member->ci }}</td>
                                            <td>{{ Str::limit($member->full_name , 20, '...') }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $member->is_active ? 'Activo' : 'Inactivo' }}</span>
                                            </td>
                                            <td class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showmember{{ $member->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @foreach($members as $member)
                                <div class="modal fade text-left" id="showmember{{ $member->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title white" id="editModalLabel{{ $member->id }}">
                                                    Información del miembro
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="edit_id" value="{{ $member->id }}">
                                                <div class="row">
                                                    <div class="col-12 col-md-5 mb-3">
                                                        <label class="form-label">Cedula de identidad</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                                            <input type="text" class="form-control" value="{{  $member->ci}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-7 mb-3">
                                                        <label class="form-label">Nombre del miembro</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                            <input type="text" class="form-control" value="{{  $member->full_name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Teléfono</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                                            <input type="text" class="form-control" value="{{  $member->phone }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">Estado</label>
                                                        <div class="input-group" style="display: flex; justify-content: center; align-items: center; ">
                                                            <span class="badge bg-primary">{{ $member->is_active ? 'Activo' : 'Inactivo' }}</span>
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

                            @if ($members->hasPages())
                                <div class="d-flex justify-content-left">
                                    {{ $members->links('pagination::bootstrap-5') }}
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