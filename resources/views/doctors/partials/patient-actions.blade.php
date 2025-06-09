<div class="btn-group" role="group">
    <a href="{{ route('doctor.historial', $pacienteId) }}" class="btn btn-sm btn-info" title="Ver Historial">
        <i class="fas fa-history"></i>
    </a>
    <a href="{{ route('doctor.consulta.iniciar', $citaId) }}" class="btn btn-sm btn-primary" title="Iniciar Consulta">
        <i class="fas fa-stethoscope"></i>
    </a>
</div>
