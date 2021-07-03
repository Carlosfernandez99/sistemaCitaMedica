@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')   
    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title"> Nuevo Tipo Consulta</h4>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ url('/tipoconsulta') }}" class="btn btn-sm btn-primary">Cancelar y Volver</a>
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
            <form action="{{ url('/tipoconsulta/store') }}" method="post">
                @csrf
                <div class=form-group>
                    <label for="nombre">Tipo Consulta Medica</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>
                <div class=form-group>
                    <label for="precio">Precio Consulta</label>
                    <input type="number" name="precio" class="form-control" value="{{ old('precio') }}">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>               
        </div>
        <div class="card-footer py-4">                
            <nav class="d-flex justify-content-end" aria-label="...">                    
            </nav>
        </div>
    </div>
@endsection