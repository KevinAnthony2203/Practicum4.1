<!-- Menú Lateral -->
<aside class="sidebar bg-white shadow-sm">
    <div class="sidebar-header p-3 border-bottom">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6fqKFRJ92vL42UElzb1mo5MUFAtVmiu_jHQ&s" alt="Logo Hospital" class="sidebar-logo" width="40" height="40">
        <span class="sidebar-title ms-2">Hospital Isidro Ayora</span>
    </div>

    <nav class="sidebar-nav p-3">
        <ul class="nav flex-column">
            @role('admin')
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Gestión de Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.create') }}" class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Crear Usuario</span>
                </a>
            </li>
            @endrole

            @role('doctor')
            <li class="nav-item">
                <a href="{{ route('doctor.dashboard') }}" class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.agenda') }}" class="nav-link {{ request()->routeIs('doctor.agenda') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Mi Agenda</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.horario') }}" class="nav-link {{ request()->routeIs('doctor.horario.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>Gestión de Horarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.pacientes.data') }}" class="nav-link {{ request()->routeIs('doctor.pacientes.*') ? 'active' : '' }}">
                    <i class="fas fa-user-injured"></i>
                    <span>Mis Pacientes</span>
                </a>
            </li>
            @endrole

            @role('patient')
            <li class="nav-item">
                <a href="{{ route('patients.dashboard') }}" class="nav-link {{ request()->routeIs('patients.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('patients.appointments.index') }}" class="nav-link {{ request()->routeIs('patients.appointments.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Mis Citas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('patients.historial.index') }}" class="nav-link {{ request()->routeIs('patients.historial.*') ? 'active' : '' }}">
                    <i class="fas fa-notes-medical"></i>
                    <span>Historial Médico</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('patients.recordatorios.index') }}" class="nav-link {{ request()->routeIs('patients.recordatorios.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Recordatorios</span>
                </a>
            </li>
            @endrole

            @role('secretaria')
            <li class="nav-item">
                <a href="{{ route('secretaria.dashboard') }}" class="nav-link {{ request()->routeIs('secretaria.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('secretaria.citas.create') }}" class="nav-link {{ request()->routeIs('secretaria.citas.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Gestión de Citas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('secretaria.pacientes.create') }}" class="nav-link {{ request()->routeIs('secretaria.pacientes.*') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Registro de Pacientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('secretaria.citas.eventos') }}" class="nav-link {{ request()->routeIs('secretaria.citas.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-week"></i>
                    <span>Agenda General</span>
                </a>
            </li>
            @endrole

            @role('gerencia')
            <li class="nav-item">
                <a href="{{ route('gerencia.dashboard') }}" class="nav-link {{ request()->routeIs('gerencia.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('estadisticas.index') }}" class="nav-link {{ request()->routeIs('estadisticas.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Estadísticas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gerencia.reportes') }}" class="nav-link {{ request()->routeIs('gerencia.reportes.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Reportes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gerencia.configuracion') }}" class="nav-link {{ request()->routeIs('gerencia.configuracion.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </li>
            @endrole
        </ul>
    </nav>
</aside>
