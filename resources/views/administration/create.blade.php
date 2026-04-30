@extends('layouts.admin')
@section('title')
    <h3>Configuracion</h3>
    <p class="text-subtitle text-muted">En este apartado podra registrar nuevos estados de productos, reservaciones, registrar nuevas marcas y categorias.</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Configuración</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajustes</li>
            <li class="breadcrumb-item active" aria-current="page">Registro</li>
        </ol>
    </nav>
@endsection
@section('content')
<div class="row">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h4 class="card-title">Formularios de registro</h4>
                <h6 class="card-subtitle">Solo rellene los campos del formulario de su interes.</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <div class="list-group" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#category_form" role="tab" aria-selected="true" tabindex="-1"><i class="bi bi-inboxes-fill"></i> Categorias</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#brand_form" role="tab" aria-selected="false" tabindex="-1"><i class="bi bi-bag-fill"></i> Marcas</a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#status_product_form" role="tab" aria-selected="false" tabindex="-1"><i class="bi bi-ui-radios"></i> Estado de producto</a>
                            <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#status_reservation_form" role="tab" aria-selected="false"><i class="bi bi-ui-checks"></i> Estado de reservación</a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 mt-1">
                        <div class="tab-content text-justify" id="nav-tabContent">
                            <div class="tab-pane active show" id="category_form" role="tabpanel" aria-labelledby="list-home-list">
                                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="oem" class="form-label">Nombre de la categoria</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text @error('name') is-invalid @enderror "><i class="bi bi-pen"></i></span>
                                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="oem" placeholder="Nombre de la categoria"
                                                        required>
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
                                                        <textarea class="form-control @error('cat_description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" name="cat_description" ></textarea>
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
                            <div class="tab-pane" id="brand_form" role="tabpanel" aria-labelledby="list-profile-list">
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="oem" class="form-label">Numero oem</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-pen"></i></span>
                                                        <input name="oem" type="text" class="form-control" id="oem" placeholder="Numero oem"
                                                        @error('oem') is-invalid @enderror required>
                                                        @error('oem')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="nombre" class="form-label">Nombre del producto</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-justify"></i></span>
                                                        <input name="name" type="text" class="form-control" id="nombre" placeholder="Nombre del producto"
                                                        @error('name') is-invalid @enderror required>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="status_reservatin_form" role="tabpanel" aria-labelledby="list-messages-list">Ut ut
                                do pariatur aliquip aliqua aliquip exercitation do nostrud commodo
                                reprehenderit
                                aute ipsum
                                voluptate.
                                Irure Lorem et laboris nostrud amet cupidatat cupidatat anim do ut velit
                                mollit
                                consequat enim
                                tempor.
                                Consectetur est minim nostrud nostrud consectetur irure labore voluptate
                                irure.
                                Ipsum id Lorem sit
                                sint voluptate est pariatur eu ad cupidatat et deserunt culpa sit eiusmod
                                deserunt. Consectetur et
                                fugiat anim do eiusmod aliquip nulla laborum elit adipisicing pariatur
                                cillum.
                            </div>
                            <div class="tab-pane" id="status_product_form" role="tabpanel" aria-labelledby="list-settings-list">Irure
                                enim occaecat labore sit qui aliquip reprehenderit amet velit. Deserunt
                                ullamco
                                ex elit nostrud ut
                                dolore nisi officia magna sit occaecat laboris sunt dolor. Nisi eu minim
                                cillum
                                occaecat aute est
                                cupidatat aliqua labore aute occaecat ea aliquip sunt amet. Aute mollit
                                dolor ut
                                exercitation irure
                                commodo non amet consectetur quis amet culpa. Quis ullamco nisi amet qui
                                aute
                                irure eu. Magna labore
                                dolor quis ex labore id nostrud deserunt dolor eiusmod eu pariatur culpa
                                mollit
                                in irure</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection