@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Mis citas</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if (session('notificacion'))
      <div class="alert alert-success" role="alert">
        {{ session('notificacion') }}
      </div>
      @endif

      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="pill" href="#citamedica-confirmada" role="tab" aria-selected="true">
            Mis próximas citas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="pill" href="#citamedica-pendiente" role="tab" aria-selected="false">
            Citas por confirmar
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="pill" href="#citamedica-historial" role="tab" aria-selected="false">
            Historial de citas
          </a>
        </li>
      </ul>
    </div>    

    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="citamedica-confirmada" role="tabpanel">
        @include('citamedica.tables.confirmada')
      </div>
      <div class="tab-pane fade" id="citamedica-pendiente" role="tabpanel">
        @include('citamedica.tables.pendiente')
      </div>
      <div class="tab-pane fade" id="citamedica-historial" role="tabpanel">
        @include('citamedica.tables.historial')
      </div>
    </div>
    
  </div>
@endsection
