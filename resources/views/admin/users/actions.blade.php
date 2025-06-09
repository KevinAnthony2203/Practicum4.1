<div class="btn-group">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})">
        <i class="fas fa-trash"></i>
    </button>
</div>

@push('scripts')
<script>
function deleteUser(userId) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.ok) {
                // Recargar la tabla
                $('#usersTable').DataTable().ajax.reload();
            }
        });
    }
}
</script>
@endpush
