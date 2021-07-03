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
        @foreach ($consultaConfirmada as $item)
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
              <a class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver cita" 
                href="{{ url('/citamedica/verConsulta/'.$item->id) }}">
                  Ver
              </a>
            @endif
            @if ($rol_usuario == 'doctor')
              <form action="{{ url('/citamedica/consultaAtend/'.$item->id) }}" 
                method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-sm btn-success" type="submit" data-toggle="tooltip" title="Marcar atendida">Atendida</button>
              </form>
            @endif
            <a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar cita" 
              href="{{ url('/citamedica/cancelarConfir/'.$item->id) }}">
                Cancelar
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  
  <div class="card-body">
    {{ $consultaConfirmada->links() }}
  </div>