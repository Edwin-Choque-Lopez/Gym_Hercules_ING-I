@extends('layouts.admin')
@section('title')
    <h3>Configuracion del Sistema</h3>
    <p class="text-subtitle text-muted">En este aparatado usted puede ver las configuraciones del sistema</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Configuraciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajustes</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h4 class="card-title">Formulario de registro
                     <a href="{{ route('categories.create') }}" style="float: right;" type="button" class="btn btn-outline-primary" type="button" class="btn btn-outline-primary"><i class="bi bi-pencil"> Crear nueva categoria</i></a>
                </h4>
                <h6 class="card-subtitle">Rellena los campos para registrar un nuevo producto</h6>
            </div>
            <div>
               
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->name }}</td>
                                <td>{{ $categoria->description_short }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('categories.edit', $categoria->id) }}" type="button" class="btn btn-outline-primary" type="button" class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                                    <form action="{{ route('categories.destroy', $categoria->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" class="btn btn-outline-primary" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($categorias->hasPages())
                    <div class="d-flex justify-content-left">
                        {{ $categorias->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection