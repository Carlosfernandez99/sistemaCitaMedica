@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')   
    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title">Tipo Consulta</h4>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ url('/tipoconsulta/create') }}" class="btn btn-sm btn-primary">Nuevo Tipo Consulta</a>
                </div>
            </div>
        </div>
        <div class="card-body">   
            @if (session('notificacion'))
                <div class="alert alert-primary" role="alert">
                    {{ session('notificacion') }}
                </div>
            @endif              
            <div class="">
                <table class="table tablesorter" id="">
                    <thead class="text-primary">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipoconsulta as $item)
                            <tr>
                                <th>{{ $item->nombre }}</th>
                                <td>{{ $item->precio }}</td> 
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ url('/tipoconsulta/delete/'.$item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ url('/tipoconsulta/edit/'.$item->id) }}" class="btn btn-sm btn-secondary">Modificar</a>
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