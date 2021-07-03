<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">DR</a>
            <a href="#" class="simple-text logo-normal">CLINICA UNIMAX</a>
        </div>
        <ul class="nav">
            <li class="active">
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>            
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="/horariotrabajo">
                    <i class="tim-icons icon-badge"></i>
                    <p>Gestionar Horario</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="/citamedica">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Mis Citas Medicas</p>
                </a>
            </li>

            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="/mispacientes">
                    <i class="fas fa-users"></i>
                    <p>Mis Pacientes</p>
                </a>
            </li>
        </ul>
    </div>
</div>