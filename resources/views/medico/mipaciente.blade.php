@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')   
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Mis Pacientes</h3>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <!-- Projects table -->
      <table class="table tablesorter">
        <thead class="text-primary">
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Fecha Reserva</th>
            <th scope="col">Fecha Consulta</th>
            <th scope="col">Hora Consulta</th>
            <th scope="col">Especialidad</th>
            <th scope="col">Tipo Consulta</th>
            <th scope="col">Estado</th>   
          </tr>
        </thead>
        <tbody>
          @foreach ($paciente as $item)
              <tr>
              <th scope="row">{{ $item->nombre }}</th>
              <td>{{ $item->apellidos }}</td> 
              <td>{{ $item->fecha_reserva }}</td> 
              <td>{{ $item->fecha_consulta }}</td>    
              <td>{{ \Carbon\Carbon::parse(strtotime($item->hora_consulta))->format('g:i A') }}</td>   
              <td>{{ $item->nombreEspecialidad }}</td>
              <td>{{ $item->tipoConsulta }}</td>  
              <td>{{ $item->estado }}</td>  
            </tr>
          @endforeach          
        </tbody>
      </table>
    </div>
  </div>
@endsection
