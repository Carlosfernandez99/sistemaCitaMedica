<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">AD</a>
            <a href="#" class="simple-text logo-normal">CLINICA UNIMAX</a>
        </div>
        <ul class="nav">
            <li class="active">
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-settings" ></i>
                    <span class="nav-link-text" >Personal Sistema</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="/medico">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Medicos</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="/paciente">
                                <i class="fas fa-users"></i>
                                <p>Paciente</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="/especialidad">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <p>Especialidades</p>
                </a>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="/tipoconsulta">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <p>Tipo Consulta</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="/citamedica">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Citas Medicas</p>
                </a>
            </li>
        </ul>
        <div class="logo">
            <a href="#" class="simple-text logo-mini"><i class="fab fa-laravel" ></i></a>
            <a href="#" class="simple-text logo-normal">REPORTES UNIMAX</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ url('/charts/citamedica/line') }}">
                    <i class="tim-icons icon-sound-wave"></i>
                    <p>Frecuencia de Citas</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="{{ url('/charts/medico/column') }}">
                    <i class="tim-icons icon-send"></i>
                    <p>Medicos Activos</p>
                </a>
            </li>
        </ul>
    </div>
</div>