@extends('layouts.master')

@section('title', 'Gestión de Usuarios')

@section('content')
<main class="container">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Gestión de Usuarios</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Administración</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
    </header>

    <section class="card shadow-sm">
        <header class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="h5 mb-0">Lista de Usuarios</h2>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar usuarios...">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="usersTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Último Acceso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->profile_photo_url }}"
                                        alt="Foto de {{ $user->name }}"
                                        class="rounded-circle me-2"
                                        width="32" height="32">
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role_color }}">
                                    {{ $user->role_name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->status_color }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td>
                                @if($user->last_login_at)
                                <time datetime="{{ $user->last_login_at }}">
                                    {{ $user->last_login_at->diffForHumans() }}
                                </time>
                                @else
                                <span class="text-muted">Nunca</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="confirmarEliminacion({{ $user->id }})"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <footer class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Mostrando {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}
                    de {{ $users->total() ?? 0 }} usuarios
                </div>
                {{ $users->links() }}
            </footer>
        </div>
    </section>
</main>

<!-- Modal de Confirmación -->
<dialog class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <article class="modal-content">
            <header class="modal-header">
                <h3 class="modal-title h5">Confirmar Eliminación</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </header>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar este usuario?</p>
                <p class="text-danger mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <footer class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </footer>
        </article>
    </div>
</dialog>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const table = document.getElementById('usersTable');

    window.confirmarEliminacion = function(userId) {
        deleteForm.action = `/admin/users/${userId}`;
        deleteModal.show();
    };

    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
    });
});
</script>
@endpush
