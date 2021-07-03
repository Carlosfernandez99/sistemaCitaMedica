@extends('layouts.app', ['class' => 'register-page', 'page' => _('Register Page'), 'contentClass' => 'register-page'])

@section('content')
    <div class="row">
        <div class="col-md-5 ml-auto">
            <img class="card-img" src="{{ asset('img/doctor.png') }}" alt="Card image">
        </div>
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-header">
                    <img class="card-img" src="{{ asset('img/card-primary.png') }}" alt="Card image">
                    <h4 class="card-title">Registro</h4>
                </div>
                <form class="form" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="card-body">
                        <div class="input-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="nombre" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="{{ _('Nombre') }}" value="{{ old('nombre') }}">
                            @include('alerts.feedback', ['field' => 'nombre'])
                        </div>
                        <div class="input-group{{ $errors->has('apellidos') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="apellidos" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" placeholder="{{ _('Apellidos') }}" value="{{ old('apellidos') }}">
                            @include('alerts.feedback', ['field' => 'apellidos'])
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>
                                </div>
                                <input type="text" name="ci" class="form-control{{ $errors->has('ci') ? ' is-invalid' : '' }}" placeholder="{{ _('Nro Identidad') }}" value="{{ old('ci') }}">
                                @include('alerts.feedback', ['field' => 'ci'])
                            </div>
                            <div class="input-group col-md-6">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>
                                </div>
                                <input type="date" name="fecha_nac" class="form-control{{ $errors->has('fecha_nac') ? ' is-invalid' : '' }}" value="{{ old('fecha_nac') }}">
                                @include('alerts.feedback', ['field' => 'fecha_nac'])
                            </div>
                        </div>                        
                        <div class="input-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="telefono" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="{{ _('Telefono') }}" value="{{ old('telefono') }}">
                            @include('alerts.feedback', ['field' => 'telefono'])
                        </div>
                        <div class="input-group{{ $errors->has('login') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" placeholder="{{ _('Nombre de usuario') }}" value="{{ old('login') }}">
                            @include('alerts.feedback', ['field' => 'login'])
                        </div>
                        <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-email-85"></i>
                                </div>
                            </div>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email') }}" value="{{ old('email') }}">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ _('Contraseña') }}">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-round btn-lg">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

