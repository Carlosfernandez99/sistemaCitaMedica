@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')   
    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title">Paciente</h4>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ url('/paciente/create') }}" class="btn btn-sm btn-primary">Nuevo Paciente</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body">
                @if (session('notificacion'))
                    <div class="alert alert-success" role="alert">
                      {{ session('notificacion') }}
                    </div>
                @endif
            </div>                
            <div class="">
                <table class="table tablesorter " id="">
                    <thead class=" text-primary">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Nro de Identidad</th>
                            <th scope="col">Fecha Nacimiento</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paciente as $item)
                            <tr>
                                <th>{{ $item->nombre }}</th>
                                <td>{{ $item->apellidos }}</td> 
                                <td>{{ $item->ci }}</td> 
                                <td>{{ $item->fecha_nac }}</td> 
                                <td>{{ $item->telefono }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ url('/paciente/delete/'.$item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/paciente/edit/'.$item->id) }}" class="btn btn-sm btn-secondary">Modificar</a>
                                                <br>
                                                <button type="submit" class="btn btn-sm btn-secondary">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>                
        </div>
        <div class="card-footer py-4">                
            <nav class="d-flex justify-content-end" aria-label="...">                    
            </nav>
        </div>
    </div>
@endsection


