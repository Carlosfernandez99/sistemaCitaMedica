@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')   
    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title"> Modificar Paciente</h4>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ url('/paciente') }}" class="btn btn-sm btn-primary">Cancelar y Volver</a>
                </div>
            </div>
        </div>
        <div class="card-body"> 
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif              
            <form action="{{ url('/paciente/update/'.$paciente->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre del Paciente</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $paciente->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos del Paciente</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $paciente->apellidos) }}" required>
                </div>
                <div class="form-group">
                    <label for="ci">Nro Carnet</label>
                    <input type="text" name="ci" class="form-control" value="{{ old('ci', $paciente->ci) }}">
                </div>
                <div class="form-group">
                    <label for="fechaNac">Fecha Nacimiento</label>
                    <input type="date" name="fecha_nac" class="form-control" value="{{ old('fecha_nac', $paciente->fecha_nac) }}">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono / móvil</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $paciente->telefono) }}">
                </div>
                <div class="form-group">
                    <label for="login">Nombre de Usuario</label>
                    <input type="text" name="login" class="form-control" value="{{ old('login', $paciente->login) }}">
                </div> 
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $paciente->email) }}">
                </div> 
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="text" name="password" class="form-control" value="">
                    <p>Ingrese un valor sólo si desea modificar la contraseña.</p>
                </div>
                <button type="submit" class="btn btn-primary">Modificar</button>
            </form>               
        </div>
        <div class="card-footer py-4">                
            <nav class="d-flex justify-content-end" aria-label="...">                    
            </nav>
        </div>
    </div>
@endsection