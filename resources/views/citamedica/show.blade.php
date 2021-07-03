@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
  <div class="card shadow">    
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Cita #{{ $citamedica->id }}</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
      <ul>
        <li><strong>Fecha:</strong> {{ $citamedica->fecha_consulta }}</li>
        <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse(strtotime($citamedica->hora_consulta))->format('g:i A') }}</li>
        
        @if ($rol_usuario == 'paciente' || $rol_usuario == 'administrador')
          <li><strong>Médico:</strong> {{ $citamedica->nombreMedico }}</li>
        @endif
        @if ($rol_usuario == 'doctor' || $rol_usuario == 'administrador')
          <li><strong>Paciente:</strong> {{ $citamedica->nombrePaciente }}</li>
        @endif

        <li><strong>Especialidad:</strong> {{ $citamedica->nombreEspecialidad }}</li>
        <li><strong>Tipo:</strong> {{ $citamedica->tipoConsulta }}</li>
        <li>
          <strong>Estado:</strong> 
          @if ($citamedica->estado == 'Cancelada')
            <span class="badge badge-danger">Cancelada</span>
          @else
            <span class="badge badge-success">{{ $citamedica->estado }}</span>
          @endif
        </li>
      </ul>

      @if ($citamedica->estado == 'Cancelada')
        <div class="alert alert-warning">
          <p>Acerca de la cancelación:</p>
          <ul>
            @if ($consultaCancelada)
              <li>
                <strong>Fecha de cancelación:</strong>
                {{ $consultaCancelada->fecha_cancelada }}
              </li>
              <li>
                <strong>¿Quién canceló la cita?:</strong>
                @if (Auth::user()->id == $consultaCancelada->id_usuario)
                  Tú
                @else
                  Nombre: {{ $consultaCancelada->nombreAbrogador }}, Correo: {{ $consultaCancelada->email }}
                @endif
              </li>
              <li>
                <strong>Justificación:</strong>
                {{ $consultaCancelada->justificacion }}
              </li>
            @else
              <li>Esta cita fue cancelada antes de su confirmación.</li>
            @endif
          </ul>
        </div>
      @endif

      <a href="{{ url('/citamedica') }}" class="btn btn-default">
        Volver
      </a>
    </div>   
  </div>
@endsection
