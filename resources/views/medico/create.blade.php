@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
@endsection

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Nuevo Médico</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('/medico') }}" class="btn btn-sm btn-default">
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

      <form action="{{ url('/medico/store') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="name">Nombre del médico</label>
          <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="form-group">
          <label for="apellidos">Apellidos del Médico</label>
          <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono / móvil</label>
          <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="form-group">
            <label for="login">Nombre de Usuario</label>
            <input type="text" name="login" class="form-control" value="{{ old('login') }}">
        </div>           
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="text" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="text" name="password" class="form-control" value="{{ Str::random(9) }}">
        </div>
        <div class="form-group">
          <label for="especialidad">Especialidades</label>
          <select name="especialidad[]" id="especialidad" class="form-control selectpicker" data-style="btn-default" multiple title="Seleccione una o varias">
            @foreach ($especialidad as $item)
              <option value="{{ $item->id }}">{{ $item->nombre }}</option>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
@endsection