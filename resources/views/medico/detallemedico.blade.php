@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
  <div class="card shadow">    
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Detalles del Medico</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
        <h4 class="mb-0">Datos personales:</h4>
      <ul>
        <li><strong>Nombre:</strong> {{ $medico->nombre }}</li>
        <li><strong>Apellidos:</strong> {{ $medico->apellidos }}</li>
        <li><strong>Telefono:</strong> {{ $medico->telefono }}</li>
      </ul>
      
      <h4 class="mb-0">Especialidades médicas:</h4>
      <ul>
        @foreach($especialidad as $item)
            <li>{{$item->nombre}}</li>
        @endforeach
       </ul>

       <h4 class="mb-0">Horario de Trabajo:</h4>
       <div class="table-responsive">
        <table class="table tablesorter">
         <thead class="text-primary">
           <tr>
             <th scope="col">Día</th>
             <th scope="col">Turno mañana</th>
             <th scope="col">Turno tarde</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($horariotrabajo as $key => $item)
                <tr>
                    <th>{{ $dias[$key] }}</th>
                    <td>
                    <div class="row">
                        <div class="col">
                            {{ \Carbon\Carbon::parse(strtotime($item->dia_start))->format('g:i A') }}
                        </div>
                        <div class="col">
                            {{ \Carbon\Carbon::parse(strtotime($item->dia_end))->format('g:i A') }}
                        </div>
                    </div>
                    </td>
                    <td>
                    <div class="row">
                        <div class="col">
                            {{ \Carbon\Carbon::parse(strtotime($item->tarde_start))->format('g:i A') }}
                        </div>
                        <div class="col">
                            {{ \Carbon\Carbon::parse(strtotime($item->tarde_end))->format('g:i A') }}
                        </div>
                    </div>
                    </td>
                </tr>
           @endforeach
         </tbody>
       </table>
     </div>

     <br>
     <br>
      <a href="{{ url('/medico') }}" class="btn btn-default">
        Volver
      </a>
    </div>   
  </div>
@endsection
