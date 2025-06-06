@php
    $reports = \App\Models\Cursos::with('docente')->latest()->paginate(10);
@endphp

<div class="row mb-3">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control search-input" placeholder="Buscar cursos...">
        </div>
    </div>
    <div class="col-md-4">
        <select class="form-select filter-select">
            <option value="all">Todos los cursos</option>
            <option value="Activo">Activos</option>
            <option value="Inactivo">Inactivos</option>
            <option value="Finalizado">Finalizados</option>
        </select>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-outline-primary btn-sm" data-action="export-courses">
            <i class="bi bi-download"></i> Exportar Cursos
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Instructor</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $curso)
                <tr class="course-row" data-course-id="{{ $curso->id }}">
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $curso->imagen ? asset('storage/' . $curso->imagen) : asset('images/default-course.jpg') }}"
                                 alt="Thumbnail"
                                 class="me-2"
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <span>{{ $curso->nombreCurso }}</span>
                        </div>
                    </td>
                    <td>{{ $curso->docente->name }}</td>
                    <td>
                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                            {{ $curso->descripcionC }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $curso->estado === 'Activo' ? 'bg-success' : ($curso->estado === 'Finalizado' ? 'bg-secondary' : 'bg-warning') }}">
                            {{ $curso->estado }}
                        </span>
                    </td>
                    <td>
                        <span data-bs-toggle="tooltip" title="Inicio: {{ $curso->fecha_ini }} - Fin: {{ $curso->fecha_fin }}">
                            {{ \Carbon\Carbon::parse($curso->fecha_ini)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-action="view-course"
                                    data-id="{{ $curso->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm"
                                    data-action="edit-course"
                                    data-id="{{ $curso->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Editar curso">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm"
                                    data-action="delete-course"
                                    data-id="{{ $curso->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar curso">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="empty-state">
                            <i class="bi bi-journal-x display-4 text-muted"></i>
                            <p class="mt-3 mb-0">No hay cursos para mostrar</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Mostrando {{ $reports->firstItem() ?? 0 }} -
        {{ $reports->lastItem() ?? 0 }} de
        {{ $reports->total() }} cursos
    </div>
    <div>
        {{ $reports->links('vendor.pagination.custom') }}
    </div>
</div>
