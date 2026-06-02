@extends('layouts.admin')
@section('title')
    <h3>Realizar venta de productos</h3>
    <p class="text-subtitle text-muted">En esta apartado usted debe buscar al C.I del cliente para registar una venta.</p>
@endsection
@section('navegacion')
    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
             <li class="breadcrumb-item active" aria-current="page">Registrar Venta</li>
        </ol>
    </nav>
@endsection
@section('content')

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <img class="card-img-top img-fluid" 
                 src="{{asset('/assets/static/images/samples/card_clients.jpg')}}" 
                 alt="Card image cap" 
                 style="height: 200px; object-fit: cover; width: 100%;">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">Buscar Cliente</h4>
                    <div class="card-body px-4 py-4-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class=""><i class="bi bi-people"></i></i>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('searchclient')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group input-group-lg">
                                    <input type="text" 
                                        name="client" 
                                        class="form-control border-start-0 @error('client') is-invalid @enderror" 
                                        placeholder="Escriba el C.I...">
                                    <button class="btn btn-primary d-flex align-items-center px-4" type="submit">
                                        Buscar
                                    </button>
                                    @error('client')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                   
                            </form>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card">
            <img class="card-img-top img-fluid" 
                 src="{{asset('/assets/static/images/samples/card_members.jpg')}}" 
                 alt="Card image cap" 
                 style="height: 200px; object-fit: cover; width: 100%;">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">Buscar Miembro</h4>
                    <div class="card-body px-4 py-4-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class=""><i class="bi bi-person-vcard"></i></i>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('searchmember')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group input-group-lg">
                                    <input type="text" 
                                        name="member" 
                                        class="form-control border-start-0 @error('member') is-invalid @enderror" 
                                        placeholder="Escriba el C.I...">
                                    
                                    <button class="btn btn-primary d-flex align-items-center px-4" type="submit">
                                        Buscar
                                    </button>
                                    @error('member')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection