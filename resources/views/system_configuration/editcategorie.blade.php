@extends('layouts.admin')
@section('title')
    <h3>Actualizar Categoría</h3>
    <p class="text-subtitle text-muted">En este apartado podra actualizar los datos de una categoría existente.</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Configuración</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajustes</li>
            <li class="breadcrumb-item active" aria-current="page">Registro</li>
            <li class="breadcrumb-item active" aria-current="page">Actualizacion</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row" style="d-flex; justify-content: center;">
    <div class="card col-lg-7 col-md-12">
        <div class="card-content">
            <div class="card-body">
                <h4 class="card-title">Formularios de actualización</h4>
                <h6 class="card-subtitle">Complete los campos del formulario para actualizar la categoría.</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="oem" class="form-label">Nombre de la categoria</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text @error('name') is-invalid @enderror "><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control" value="{{$category->name}}">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-12">
                                                    <label for="Especificaciones" class="form-label">Descripción</label>
                                                    <div class="form-group with-title mb-3">
                                                        <textarea class="form-control @error('cat_description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" name="cat_description" >{{ $category->description_short }}</textarea>
                                                        <label>Redacte una descripción de la categoria</label>
                                                        @error('cat_description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div> 
                                                <div class="col-md-12 mb-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" type="submit">Registrar categoria</button>  
                                                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection