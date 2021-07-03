@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('styles')
  <link type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Registrar nueva cita</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('paciente') }}" class="btn btn-sm btn-default">
            Cancelar y volver
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ url('/citamedica/store') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <input name="descripcion" value="{{ old('descripcion') }}" id="descripcion" type="text" class="form-control" placeholder="Describe brevemente la consulta" required>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="specialty">Especialidad</label>
            <select name="id_especialidad" id="especialidad" class="form-control" required>
              <option value="">Seleccionar Especialidad</option>
              @foreach ($especialidad as $item)
                <option value="{{ $item->id }}" @if(old('id_especialidad') == $item->id) selected @endif>{{ $item->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="email">Médico</label>
            <select name="id_medico" id="medico" class="form-control" required>
              @foreach ($medico as $items)
                <option value="{{ $items->id }}" @if(old('id_medico') == $items->id) selected @endif>{{ $items->nombre }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="fecha_consulta">Fecha</label>
          <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              </div>
              <input class="form-control datepicker" placeholder="Seleccionar fecha" 
                id="date" name="fecha_consulta" type="text" 
                value="{{ old('fecha_consulta', date('Y-m-d')) }}" 
                data-date-format="yyyy-mm-dd" 
                data-date-start-date="{{ date('Y-m-d') }}" 
                data-date-end-date="+30d">
          </div>
        </div>
        <div class="form-group">
          <label for="hora_consulta">Hora de atención</label>
          <div id="hours">
            @if ($intervalo)
              @foreach ($intervalo['turno1'] as $key => $interval)
                <div class="custom-control custom-radio mb-3">
                  <input class="form-check-input" name="hora_consulta" value="{{ $interval['inicio'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                  <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['inicio'] }} - {{ $interval['fin'] }}</label>
                </div>
              @endforeach
              @foreach ($intervalo['turno2'] as $key => $interval)
                <div class="custom-control custom-radio mb-3">
                  <input class="form-check-input" name="hora_consulta" value="{{ $interval['inicio'] }}" class="custom-control-input" id="intervalAfternoon{{ $key }}" type="radio" required>
                  <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['inicio'] }} - {{ $interval['fin'] }}</label>
                </div>
              @endforeach
            @else
              <div class="alert alert-info" role="alert">
                Seleccione un médico y una fecha, para ver sus horas disponibles.
              </div>
            @endif
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="tipo_consulta">Tipo de Consulta</label>
          <select name="id_tipo_consulta" id="tipo_consulta" class="form-control" required>
            <option value="">Seleccionar Tipo Consulta</option>
            @foreach ($tipoconsulta as $item)
              <option value="{{ $item->id }}" @if(old('id_tipo_consulta') == $item->id) selected @endif>{{ $item->nombre }} ( {{ $item->precio }} bs)</option>
            @endforeach
          </select>
        </div>        
        <button type="submit" class="btn btn-primary">
          Guardar
        </button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('/js/citamedica/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('/js/citamedica/create.js') }}"></script>
@endsection