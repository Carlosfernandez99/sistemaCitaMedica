{{-- @extends('layouts.app') --}}
@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
<form action="{{ url('/horariotrabajo/store') }}" method="post">
  @csrf  
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Gestionar horario</h3>
        </div>
        <div class="col text-right">
          <button type="submit" class="btn btn-sm btn-success">
            Guardar cambios
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if (session('notificacion'))
        <div class="alert alert-success" role="alert">
          {{ session('notificacion') }}
        </div>
      @endif

      @if (session('errors'))
        <div class="alert alert-danger" role="alert">
          Los cambios se han guardado pero tener en cuenta que:
          <ul>
          @foreach (session('errors') as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
        </div>
      @endif      
    </div>    
    <div class="table-responsive">
       <table class="table tablesorter">
        <thead class="text-primary">
          <tr>
            <th scope="col">Día</th>
            <th scope="col">Activo</th>
            <th scope="col">Turno mañana</th>
            <th scope="col">Turno tarde</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($horariotrabajo as $key => $item)
          <tr>
            <th>{{ $dias[$key] }}</th>
            <td>
                <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" name="estado[]" value="{{ $key }}"
                    @if($item->estado) checked @endif>
                    <span class="form-check-sign"></span>
                </label>
                </div>
            </td>
            <td>
              <div class="row">
                <div class="col">
                  <select class="form-control" name="dia_start[]">
                    @for ($i=5; $i<=11; $i++)
                      <option value="{{ ($i<10 ? '0' : '') . $i }}:00" 
                        @if($i.':00 AM' == $item->dia_start) selected @endif>
                        {{ $i }}:00 AM
                      </option>
                      <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                        @if($i.':30 AM' == $item->dia_start) selected @endif>
                        {{ $i }}:30 AM
                      </option>
                    @endfor
                  </select>
                </div>
                <div class="col">
                  <select class="form-control" name="dia_end[]">
                    @for ($i=5; $i<=11; $i++)
                    <option value="{{ ($i<10 ? '0' : '') . $i }}:00"
                      @if($i.':00 AM' == $item->dia_end) selected @endif>
                      {{ $i }}:00 AM
                    </option>
                    <option value="{{ ($i<10 ? '0' : '') . $i }}:30"
                      @if($i.':30 AM' == $item->dia_end) selected @endif>
                      {{ $i }}:30 AM
                    </option>
                    @endfor
                  </select>
                </div>
              </div>
            </td>
            <td>
              <div class="row">
                <div class="col">
                  <select class="form-control" name="tarde_start[]">
                    @for ($i=1; $i<=11; $i++)
                      <option value="{{ $i+12 }}:00"
                        @if($i.':00 PM' == $item->tarde_start) selected @endif>
                        {{ $i }}:00 PM
                      </option>
                      <option value="{{ $i+12 }}:30"
                        @if($i.':30 PM' == $item->tarde_start) selected @endif>
                        {{ $i }}:30 PM
                      </option>
                    @endfor
                  </select>
                </div>
                <div class="col">
                  <select class="form-control" name="tarde_end[]">
                    @for ($i=1; $i<=11; $i++)
                      <option value="{{ $i+12 }}:00"
                        @if($i.':00 PM' == $item->tarde_end) selected @endif>
                        {{ $i }}:00 PM
                      </option>
                      <option value="{{ $i+12 }}:30"
                        @if($i.':30 PM' == $item->tarde_end) selected @endif>
                        {{ $i }}:30 PM
                      </option>
                    @endfor
                  </select>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</form>
@endsection