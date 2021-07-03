@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Editar Perfil') }}</h5>
                </div>
                <form method="post" action="{{ url('/user/update/login/'.$user->id) }}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @method('put')
                            @if (session('notificacion'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('notificacion') }}
                                </div>
                            @endif
                            <div class="form-group{{ $errors->has('login') ? ' has-danger' : '' }}">
                                <label>{{ _('Nombre de Usuario') }}</label>
                                <input type="text" name="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" placeholder="{{ _('Usuario') }}" value="{{ old('login', auth()->user()->login) }}">
                                @include('alerts.feedback', ['field' => 'login'])
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label>{{ _('Correo Electrónico') }}</label>
                                <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ _('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Guardar') }}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('Contraseña') }}</h5>
                </div>
                <form method="post" action="{{ url('/user/update/password/'.$user->id) }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        @if (session('notification'))
                            <div class="alert alert-primary" role="alert">
                                {{ session('notification') }}
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                            <label>{{ __('Contraseña Actual') }}</label>
                            <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Contraseña actual') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'old_password'])
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label>{{ __('Nueva Contraseña') }}</label>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Nueva contraseña') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirmar Nueva Contraseña') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirmar nueva contraseña') }}" value="" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Cambiar Contraseña') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <a href="#">
                                <img class="avatar" src="/img/emilyz.jpg" alt="">
                                <h5 class="title">{{ auth()->user()->login }}</h5>
                            </a>
                            <p class="description">
                                {{ _('CF/Unimax') }}
                            </p>
                        </div>
                    </p>
                    <div class="card-description">
                        {{ _('Do not be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...') }}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="button-container">
                        <button class="btn btn-icon btn-round btn-facebook">
                            <i class="fab fa-facebook"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="btn btn-icon btn-round btn-google">
                            <i class="fab fa-google-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection