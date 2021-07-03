<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">PC</a>
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
                <a href="/citamedica/create">
                    <i class="tim-icons icon-badge"></i>
                    <p>Reservar Cita</p>
                </a>
            </li>
            <li @if ($pageSlug == 'maps') class="active " @endif>
                <a href="/citamedica">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Mis Citas Medicas</p>
                </a>
            </li>
        </ul>
    </div>
</div>