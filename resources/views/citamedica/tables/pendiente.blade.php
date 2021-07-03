<div class="table-responsive">
    <table class="table tablesorter">
      <thead class="text-primary">
        <tr>
          <th scope="col">Descripción</th>
          <th scope="col">Especialidad</th>
          @if ($rol_usuario == 'paciente')
            <th scope="col">Médico</th>
          @elseif ($rol_usuario == 'doctor')
            <th scope="col">Paciente</th>
          @endif
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($consultaPendiente as $item)
        <tr>
          <th scope="row">{{ $item->descripcion }}</th>
          <td>{{ $item->nombreEspecialidad }}</td>
          @if ($rol_usuario == 'paciente')
            <td>{{ $item->nombreMedico }}</td>
          @elseif ($rol_usuario == 'doctor')
            <td>{{ $item->nombrePaciente }}</td>
          @endif
          <td>{{ $item->fecha_consulta }}</td>
          <td>{{ \Carbon\Carbon::parse(strtotime($item->hora_consulta))->format('g:i A') }}</td>
          <td>{{ $item->tipoConsulta }}</td>
          <td>
            @if ($rol_usuario == 'administrador')
              <a class="btn btn-sm btn-primary" title="Ver cita" 
                href="{{ url('/citamedica/verConsulta/'.$item->id) }}">
                  Ver
              </a>
            @endif
  
            @if ($rol_usuario == 'doctor' || $rol_usuario == 'administrador')
              <form action="{{ url('/citamedica/confirmar/'.$item->id) }}"
                method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-sm btn-success" type="submit" data-toggle="tooltip" title="Confirmar cita">
                  <i class="tim-icons icon-check-2"></i>
                </button>
              </form>
            @endif
            
            <form action="{{ url('/citamedica/cancelar/'.$item->id) }}" 
              method="POST" class="d-inline-block">
              @csrf
              <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="Cancelar cita">
                <i class="tim-icons icon-simple-delete"></i>
              </button>
            </form>          
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  
  <div class="card-body">
    {{ $consultaPendiente->links() }}
  </div>