@extends('layout')

@section('titulo', 'Historial de Asistencia: ' . $cursos->nombreCurso)

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a href="javascript:history.back()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Historial de Asistencia</h6>
            <div class="d-flex align-items-center">
                <span class="mr-3 text-muted">
                    <i class="fas fa-calendar-day"></i> {{ now()->format('Y-m-d') }}
                </span>
                @if(auth()->user()->hasAnyRole(['Docente', 'Administrador']))
                    <a href="{{ route('repA', $cursos->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-export"></i> Generar Reporte
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body">


            <form action="{{ route('historialAsistenciasPost', $cursos->id) }}" method="POST" id="attendanceForm">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Estudiante</th>
                                <th width="25%">Tipo de Asistencia</th>
                                <th width="20%">Fecha</th>
                                @if(auth()->user()->hasAnyRole(['Docente', 'Administrador']))
                                    <th width="15%">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asistencias as $index => $asistencia)
                                @if($asistencia->curso_id == $cursos->id &&
                                   (auth()->user()->hasAnyRole(['Docente', 'Administrador']) ||
                                   (auth()->user()->hasRole('Estudiante') && auth()->user()->id == $asistencia->inscritos->estudiantes->id)))
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $asistencia->inscritos->estudiantes->name }}
                                            {{ $asistencia->inscritos->estudiantes->lastname1 }}
                                            {{ $asistencia->inscritos->estudiantes->lastname2 }}
                                        </td>

                                        @if(auth()->user()->hasAnyRole(['Docente', 'Administrador']))
                                            <td>
                                                <input type="hidden" name="asistencia[{{ $index }}][id]" value="{{ $asistencia->id }}">
                                                <select name="asistencia[{{ $index }}][tipo_asistencia]"
                                                        class="form-control form-control-sm attendance-select">
                                                    <option value="Presente" {{ $asistencia->tipoAsitencia == 'Presente' ? 'selected' : '' }}>Presente</option>
                                                    <option value="Retraso" {{ $asistencia->tipoAsitencia == 'Retraso' ? 'selected' : '' }}>Retraso</option>
                                                    <option value="Licencia" {{ $asistencia->tipoAsitencia == 'Licencia' ? 'selected' : '' }}>Licencia</option>
                                                    <option value="Falta" {{ $asistencia->tipoAsitencia == 'Falta' ? 'selected' : '' }}>Falta</option>
                                                </select>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge
                                                    @if($asistencia->tipoAsitencia == 'Presente') badge-success
                                                    @elseif($asistencia->tipoAsitencia == 'Retraso') badge-warning
                                                    @elseif($asistencia->tipoAsitencia == 'Licencia') badge-info
                                                    @else badge-danger
                                                    @endif">
                                                    {{ $asistencia->tipoAsitencia }}
                                                </span>
                                            </td>
                                        @endif

                                        <td>{{ $asistencia->fechaasistencia }}</td>

                                        @if(auth()->user()->hasAnyRole(['Docente', 'Administrador']))
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger delete-attendance"
                                                        data-id="{{ $asistencia->id }}" data-toggle="tooltip"
                                                        title="Eliminar registro">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->hasAnyRole(['Docente', 'Administrador']) ? 5 : 4 }}"
                                        class="text-center text-muted py-4">
                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                        <h5>No hay registros de asistencia</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(auth()->user()->hasRole('Docente') && (!$cursos->fecha_fin || now() <= $cursos->fecha_fin))
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar este registro de asistencia?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Búsqueda en tiempo real
    $("#searchInput").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $("#dataTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Cambiar color del select según la asistencia
    $('.attendance-select').change(function() {
        $(this).removeClass('border-success border-warning border-info border-danger');
        if($(this).val() === 'Presente') {
            $(this).addClass('border-success');
        } else if($(this).val() === 'Retraso') {
            $(this).addClass('border-warning');
        } else if($(this).val() === 'Licencia') {
            $(this).addClass('border-info');
        } else {
            $(this).addClass('border-danger');
        }
    }).trigger('change');

    // Manejar eliminación de asistencia
    $('.delete-attendance').click(function() {
        const id = $(this).data('id');
        const url = '{{ url("asistencia") }}/' + id;
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    });

    // Confirmar antes de salir si hay cambios
    let formChanged = false;
    $('#attendanceForm').on('change', 'select', function() {
        formChanged = true;
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'Tiene cambios sin guardar. ¿Está seguro de que quiere salir?';
            return e.returnValue;
        }
    });

    $('#attendanceForm').submit(function() {
        formChanged = false;
    });
});
</script>

<style>
.attendance-select.border-success {
    border-color: #28a745 !important;
}
.attendance-select.border-warning {
    border-color: #ffc107 !important;
}
.attendance-select.border-info {
    border-color: #17a2b8 !important;
}
.attendance-select.border-danger {
    border-color: #dc3545 !important;
}
</style>
@endsection