<div class="table-responsive">
    <table class="table tablesorter">
      <thead class="text-primary">
        <tr>
          <th scope="col">Especialidad</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($consultaHistorial as $item)
          <tr>
            <th scope="row">{{ $item->nombreEspecialidad }}</td>
            <td>{{ $item->fecha_consulta }}</td>
            <td>{{ \Carbon\Carbon::parse(strtotime($item->hora_consulta))->format('g:i A') }}</td>
            <td>{{ $item->estado }}</td>
            <td><a href="{{ url('/citamedica/verConsulta/'.$item->id) }}" class="btn btn-primary btn-sm">Ver</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  
  <div class="card-body">
    {{ $consultaHistorial->links() }}
  </div>