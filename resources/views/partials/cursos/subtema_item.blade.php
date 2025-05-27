<div class="subtema-content">
    <h2>{{ $subtema->titulo_subtema }}</h2>

    @if ($subtema->imagen)
        <img class="img-fluid rounded mb-3" src="{{ asset('storage/' . $subtema->imagen) }}" alt="Imagen del subtema"
            style="max-width: 100%; height: auto;">
    @endif

    <div class="modal fade" id="modalEditarSubtema-{{ $subtema->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Editar Subtema: {{ $subtema->titulo_subtema }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('subtemas.update', $subtema->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título*</label>
                            <input type="text" class="form-control" name="titulo"
                                value="{{ $subtema->titulo_subtema }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3">{{ $subtema->descripcion }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagen Actual</label>
                            @if ($subtema->imagen)
                                <img src="{{ asset('storage/' . $subtema->imagen) }}" class="img-thumbnail mb-2"
                                    style="max-height: 150px;">
                            @endif
                            <input type="file" class="form-control" name="imagen" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#descripcionSubtema-{{ $subtema->id }}" aria-expanded="false"
            aria-controls="descripcionSubtema-{{ $subtema->id }}">
            <i class="fas fa-chevron-down me-1"></i> Ver Descripción
        </button>
        <div class="collapse" id="descripcionSubtema-{{ $subtema->id }}">
            <div class="card card-body bg-light">
                {!! nl2br(e($subtema->descripcion)) !!}
            </div>
        </div>
    </div>

    @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
        <div class="mb-4">
            <button class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal"
                data-bs-target="#modalActividad-{{ $subtema->id }}">
                <i class="fas fa-tasks me-1"></i> Agregar Actividad
            </button>
            <button class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal"
                data-bs-target="#modalRecurso-{{ $subtema->id }}">
                <i class="fas fa-file-alt me-1"></i> Agregar Recurso
            </button>
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                data-bs-target="#modalEditarSubtema-{{ $subtema->id }}">
                <i class="fas fa-edit me-1"></i> Editar Subtema
            </button>
        </div>
    @endif

    <!-- Sección de Recursos -->
    <div class="mb-4">
        <h4 class="border-bottom pb-2">
            <i class="fas fa-folder-open me-2"></i>Recursos
        </h4>

        @forelse($subtema->recursos as $recurso)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $recurso->nombreRecurso }}
                    </h5>

                    @if (Str::contains($recurso->descripcionRecursos, ['<iframe', '<video', '<img']))
                        <div class="ratio ratio-16x9 mb-3">
                            {!! $recurso->descripcionRecursos !!}
                        </div>
                    @else
                        <p class="card-text">{!! nl2br(e($recurso->descripcionRecursos)) !!}</p>
                    @endif

                    @if ($recurso->archivoRecurso)
                        <a href="{{ asset('storage/' . $recurso->archivoRecurso) }}" class="btn btn-sm btn-primary"
                            target="_blank">
                            <i class="fas fa-download me-1"></i> Descargar Recurso
                        </a>
                    @endif

                    @if (auth()->user()->hasRole('Estudiante'))
                        <div class="mt-2">
                            @if ($recurso->isViewedByInscrito($inscritos2->id))
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i> Visto
                                </span>
                            @else
                                <form method="POST" action="{{ route('recurso.marcarVisto', $recurso->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="inscritos_id" value="{{ $inscritos2->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check-circle me-1"></i> Marcar como visto
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>


            <div class="modal fade" id="modalEditarRecurso-{{ $recurso->id }}" tabindex="-1"
                aria-labelledby="modalEditarRecursoLabel-{{ $recurso->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarRecursoLabel-{{ $recurso->id }}">
                                Editar Recurso
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('editarRecursosSubtemaPost', $recurso->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="tituloRecurso" class="form-label">Título del Recurso</label>
                                    <input type="text" name="tituloRecurso" class="form-control"
                                        value="{{ $recurso->nombreRecurso }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcionRecurso" class="form-label">Descripción</label>
                                    <textarea name="descripcionRecurso" class="form-control" required>{{ $recurso->descripcionRecursos }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="archivoRecurso" class="form-label">Archivo Actual</label>
                                    @if ($recurso->archivoRecurso)
                                        <a href="{{ asset('storage/' . $recurso->archivoRecurso) }}" target="_blank"
                                            class="d-block mb-2">
                                            <i class="fas fa-download me-1"></i> Descargar Archivo
                                        </a>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="eliminarArchivo"
                                                name="eliminarArchivo" value="1">
                                            <label class="form-check-label" for="eliminarArchivo">Eliminar archivo
                                                actual</label>
                                        </div>
                                    @endif
                                    <input type="file" name="archivo" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="tipoRecurso" class="form-label">Tipo de Recurso</label>
                                    <select class="form-select" name="tipoRecurso" required>
                                        <option value="word"
                                            {{ $recurso->tipoRecurso == 'word' ? 'selected' : '' }}>Word</option>
                                        <option value="excel"
                                            {{ $recurso->tipoRecurso == 'excel' ? 'selected' : '' }}>Excel</option>
                                        <option value="powerpoint"
                                            {{ $recurso->tipoRecurso == 'powerpoint' ? 'selected' : '' }}>PowerPoint
                                        </option>
                                        <option value="pdf" {{ $recurso->tipoRecurso == 'pdf' ? 'selected' : '' }}>
                                            PDF</option>
                                        <option value="youtube"
                                            {{ $recurso->tipoRecurso == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                        <option value="imagen"
                                            {{ $recurso->tipoRecurso == 'imagen' ? 'selected' : '' }}>Imagen</option>
                                        <option value="video"
                                            {{ $recurso->tipoRecurso == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="audio"
                                            {{ $recurso->tipoRecurso == 'audio' ? 'selected' : '' }}>Audio</option>
                                        <option value="enlace"
                                            {{ $recurso->tipoRecurso == 'enlace' ? 'selected' : '' }}>Enlace</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No hay recursos disponibles para este subtema.
            </div>
        @endforelse
    </div>

    <!-- Sección de Actividades -->
    <div class="mb-4">
        <h4 class="border-bottom pb-2">
            <i class="fas fa-tasks me-2"></i>Actividades
        </h4>

        @forelse($subtema->actividades as $actividad)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">
                                <i class="fas fa-tasks me-2"></i>{{ $actividad->titulo }}
                            </h5>
                            <p class="text-muted small mb-1">
                                <i class="far fa-calendar-alt me-1"></i>
                                Publicado: {{ $actividad->created_at->format('d/m/Y') }}
                            </p>
                            <p class="text-muted small">
                                <i class="far fa-clock me-1"></i>
                                Vence:
                                {{ $actividad->fecha_limite ? $actividad->fecha_limite->format('d/m/Y') : 'Sin fecha límite' }}
                            </p>
                            <p class="text-muted small">
                                <i class="fas fa-tag me-1"></i>
                                Tipo: {{ $actividad->tipoActividad->nombre }}
                            </p>
                        </div>
                        <span class="badge bg-primary">{{ $actividad->tipoActividad->nombre }}</span>
                    </div>

                    <div class="mt-3">
                        <!-- Botón para ver la actividad -->

                        @if ($actividad->tiposEvaluacion->contains('nombre', 'Cuestionario'))
                            @role('Docente')
                                <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalCuestionario-{{ $actividad->id }}">
                                    @if ($actividad->cuestionario)
                                        <i class="fas fa-edit me-1"></i> Editar Cuestionario
                                    @else
                                        <i class="fas fa-plus me-1"></i> Crear Cuestionario
                                    @endif
                                </button>
                                @if ($actividad->cuestionario)
                                    <a href="{{ route('cuestionarios.index', $actividad->cuestionario->id) }}"
                                        class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="fas fa-cog me-1"></i> Administrar
                                    </a>

                                    <a href="{{ route('rankingQuizz', $actividad->cuestionario->id) }}"
                                        class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="fas fa-chart-bar me-1"></i> Ver Resultados
                                    </a>
                                @endif



                                <!-- Modal para Crear/Editar Cuestionario -->
                                <div class="modal fade" id="modalCuestionario-{{ $actividad->id }}" tabindex="-1"
                                    aria-labelledby="modalCuestionarioLabel-{{ $actividad->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCuestionarioLabel-{{ $actividad->id }}">
                                                    @if ($actividad->cuestionario)
                                                        Editar Cuestionario
                                                    @else
                                                        Crear Cuestionario
                                                    @endif
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ $actividad->cuestionario ? route('cuestionarios.update', $actividad->cuestionario->id) : route('cuestionarios.store', $actividad->id) }}">
                                                    @csrf
                                                    @if ($actividad->cuestionario)
                                                        @method('PUT')
                                                    @endif

                                                    <!-- Mostrar Resultados -->
                                                    <div class="mb-3">
                                                        <label for="mostrar_resultados" class="form-label">Mostrar
                                                            Resultados</label>
                                                        <select name="mostrar_resultados" class="form-select" required>
                                                            <option value="1"
                                                                {{ $actividad->cuestionario && $actividad->cuestionario->mostrar_resultados ? 'selected' : '' }}>
                                                                Sí</option>
                                                            <option value="0"
                                                                {{ $actividad->cuestionario && !$actividad->cuestionario->mostrar_resultados ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </div>

                                                    <!-- Número Máximo de Intentos -->
                                                    <div class="mb-3">
                                                        <label for="max_intentos" class="form-label">Número Máximo de
                                                            Intentos</label>
                                                        <input type="number" name="max_intentos" class="form-control"
                                                            value="{{ $actividad->cuestionario ? $actividad->cuestionario->max_intentos : 3 }}"
                                                            min="1" required>
                                                    </div>

                                                    <!-- Tiempo Límite -->
                                                    <div class="mb-3">
                                                        <label for="tiempo_limite" class="form-label">Tiempo Límite (en
                                                            minutos)</label>
                                                        <input type="number" name="tiempo_limite" class="form-control"
                                                            value="{{ $actividad->cuestionario ? $actividad->cuestionario->tiempo_limite : '' }}"
                                                            min="1" placeholder="Opcional">
                                                    </div>

                                                    <button type="submit" class="btn btn-success">
                                                        @if ($actividad->cuestionario)
                                                            Guardar Cambios
                                                        @else
                                                            Crear Cuestionario
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($actividad->es_publica)
                                    <form method="POST" action="{{ route('actividades.ocultar', $actividad->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-eye-slash"></i> Ocultar
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('actividades.mostrar', $actividad->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i> Mostrar
                                        </button>
                                    </form>
                                @endif
                            @endrole
                            @role('Estudiante')
                                @if ($actividad->cuestionario)
                                    <a href="{{ route('cuestionario.mostrar', $actividad->cuestionario->id) }}"
                                        class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-play me-1"></i> Responder
                                    </a>

                                    <a href="{{ route('rankingQuizz', $actividad->cuestionario->id) }}"
                                        class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="fas fa-chart-bar me-1"></i> Ver Resultados
                                    </a>
                                @endif
                            @endrole
                        @else
                            @hasrole('Docente')
                                <a href="{{ route('calificarT', $actividad->id) }}"
                                    class="btn btn-sm btn-outline-info me-2">
                                    <i class="fas fa-calculator"></i> Calificar Tarea
                                </a>
                                @if ($actividad->es_publica)
                                    <form method="POST" action="{{ route('actividades.ocultar', $actividad->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-eye-slash"></i> Ocultar
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('actividades.mostrar', $actividad->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i> Mostrar
                                        </button>
                                    </form>
                                @endif
                            @endhasrole

                            @role('Estudiante')
                                <a href="{{ route('actividad.show', $actividad->id) }}"
                                    class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-eye me-1"></i> Ver Actividad
                                </a>
                            @endrole
                        @endif
                        @role('Estudiante')
                            <!-- Opciones para estudiantes -->
                            @if ($actividad->isCompletedByInscrito($inscritos2->id))
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i> Completada
                                </span>
                            @else
                                <form method="POST" action="{{ route('actividad.completar', $actividad->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="inscritos_id" value="{{ $inscritos2->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check-circle me-1"></i> Marcar como completada
                                    </button>
                                </form>
                            @endif
                        @endrole
                        <!-- Opciones para docentes -->
                        @if (auth()->user()->hasRole('Docente'))
                            <a href="#" class="btn btn-sm btn-outline-info me-2" data-bs-toggle="modal"
                                data-bs-target="#modalEditarActividad-{{ $actividad->id }}">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <div class="modal fade" id="modalEditarActividad-{{ $actividad->id }}" tabindex="-1"
                                aria-labelledby="modalEditarActividadLabel-{{ $actividad->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="modalEditarActividadLabel-{{ $actividad->id }}">
                                                Editar Actividad: {{ $actividad->titulo }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST"
                                                action="{{ route('actividades.update', $actividad->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <!-- Título de la Actividad -->
                                                <div class="mb-3">
                                                    <label for="titulo" class="form-label">Título de la
                                                        Actividad</label>
                                                    <input type="text" name="titulo" class="form-control"
                                                        value="{{ $actividad->titulo }}" required>
                                                </div>

                                                <!-- Descripción -->
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control" required>{{ $actividad->descripcion }}</textarea>
                                                </div>

                                                <!-- Fecha de Habilitación -->
                                                <div class="mb-3">
                                                    <label for="fecha_inicio" class="form-label">Fecha de
                                                        Habilitación</label>
                                                    <input type="date" name="fecha_inicio" class="form-control"
                                                        value="{{ $actividad->fecha_inicio ? $actividad->fecha_inicio->format('Y-m-d') : '' }}"
                                                        required>
                                                </div>

                                                <!-- Fecha de Vencimiento -->
                                                <div class="mb-3">
                                                    <label for="fecha_limite" class="form-label">Fecha de
                                                        Vencimiento</label>
                                                    <input type="date" name="fecha_limite" class="form-control"
                                                        value="{{ $actividad->fecha_limite ? $actividad->fecha_limite->format('Y-m-d') : '' }}"
                                                        required>
                                                </div>

                                                <!-- Tipo de Actividad -->
                                                <div class="mb-3">
                                                    <label for="tipo_actividad_id" class="form-label">Tipo de
                                                        Actividad</label>
                                                    <select name="tipo_actividad_id" class="form-select" required>
                                                        @foreach ($tiposActividades as $tipo)
                                                            <option value="{{ $tipo->id }}"
                                                                {{ $actividad->tipo_actividad_id == $tipo->id ? 'selected' : '' }}>
                                                                {{ $tipo->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Tipos de Evaluación -->
                                                <div class="mb-3">
                                                    <label for="tipos_evaluacion" class="form-label">Tipos de
                                                        Evaluación</label>
                                                    <div id="tipos-evaluacion-container-{{ $actividad->id }}">


                                                        @foreach (optional($actividad->tiposEvaluacion) as $index => $tipoEvaluacion)
                                                            <div class="tipo-evaluacion mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <select
                                                                            name="tipos_evaluacion[{{ $index }}][tipo_evaluacion_id]"
                                                                            class="form-select" required>
                                                                            @foreach ($tiposEvaluaciones as $tipo)
                                                                                <option value="{{ $tipo->id }}"
                                                                                    {{ $tipoEvaluacion->pivot->tipo_evaluacion_id == $tipo->id ? 'selected' : '' }}>
                                                                                    {{ $tipo->nombre }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input type="number"
                                                                            name="tipos_evaluacion[{{ $index }}][puntaje_maximo]"
                                                                            class="form-control"
                                                                            placeholder="Puntaje Máximo"
                                                                            value="{{ $tipoEvaluacion->pivot->puntaje_maximo }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <select
                                                                            name="tipos_evaluacion[{{ $index }}][es_obligatorio]"
                                                                            class="form-select" required>
                                                                            <option value="1"
                                                                                {{ $tipoEvaluacion->pivot->es_obligatorio ? 'selected' : '' }}>
                                                                                Obligatorio</option>
                                                                            <option value="0"
                                                                                {{ !$tipoEvaluacion->pivot->es_obligatorio ? 'selected' : '' }}>
                                                                                Opcional</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary add-tipo-evaluacion"
                                                        data-actividad-id="{{ $actividad->id }}">
                                                        <i class="fas fa-plus me-1"></i> Agregar Tipo de Evaluación
                                                    </button>
                                                </div>

                                                <!-- Archivo (opcional) -->
                                                <div class="mb-3">
                                                    <label for="archivo" class="form-label">Archivo
                                                        (opcional)
                                                    </label>
                                                    @if ($actividad->archivo)
                                                        <a href="{{ asset('storage/' . $actividad->archivo) }}"
                                                            target="_blank" class="d-block mb-2">
                                                            <i class="fas fa-download me-1"></i> Descargar Archivo
                                                            Actual
                                                        </a>
                                                    @endif
                                                    <input type="file" name="archivo" class="form-control">
                                                </div>

                                                <button type="submit" class="btn btn-success">Guardar
                                                    Cambios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta actividad?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No hay actividades disponibles para este subtema.
            </div>
        @endforelse




        <script>
            document.querySelectorAll('.add-tipo-evaluacion').forEach(button => {
                button.addEventListener('click', function() {
                    const actividadId = this.dataset.actividadId;
                    const container = document.getElementById(`tipos-evaluacion-container-${actividadId}`);
                    const index = container.children.length;

                    const template = `
                        <div class="tipo-evaluacion mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="tipos_evaluacion[${index}][tipo_evaluacion_id]" class="form-select" required>
                                        <option value="" disabled selected>Selecciona un tipo de evaluación</option>
                                        @foreach ($tiposEvaluaciones as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="tipos_evaluacion[${index}][puntaje_maximo]" class="form-control"
                                        placeholder="Puntaje Máximo" required>
                                </div>
                                <div class="col-md-3">
                                    <select name="tipos_evaluacion[${index}][es_obligatorio]" class="form-select" required>
                                        <option value="1">Obligatorio</option>
                                        <option value="0">Opcional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;

                    container.insertAdjacentHTML('beforeend', template);
                });
            });
        </script>

        <!-- Tareas -->
        {{-- @forelse($subtema->tareas as $tarea)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">
                                <i class="fas fa-pencil-alt me-2"></i>{{ $tarea->titulo_tarea }}
                            </h5>
                            <p class="text-muted small mb-1">
                                <i class="far fa-calendar-alt me-1"></i>
                                Publicado: {{ $tarea->created_at }}
                            </p>
                            <p class="text-muted small">
                                <i class="far fa-clock me-1"></i>
                                Vence: {{ $tarea->fecha_vencimiento }}
                            </p>
                        </div>
                        <span class="badge bg-primary">Tarea</span>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('VerTarea', $tarea->id) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-eye me-1"></i> Ver Actividad
                        </a>

                        @if (auth()->user()->hasRole('Estudiante'))
                            @if ($inscritos2->id && $tarea->isCompletedByInscrito($inscritos2->id))
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i> Completada
                                </span>
                            @else
                                <form method="POST" action="{{ route('tarea.completar', $tarea->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="inscritos_id" value="{{ $inscritos2->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check-circle me-1"></i> Marcar como completada
                                    </button>
                                </form>
                            @endif
                        @endif

                        @if (auth()->user()->hasRole('Docente'))
                            <a href="{{ route('calificarT', $tarea->id) }}" class="btn btn-sm btn-outline-info me-2">
                                <i class="fas fa-calculator"></i> Calificar Tarea
                            </a>
                            <a href="{{ route('editarTarea', $tarea->id) }}"
                                class="btn btn-sm btn-outline-info me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('quitarTarea', $tarea->id) }}" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
        @endforelse --}}

        {{-- <!-- Cuestionarios -->
        @forelse($subtema->cuestionarios as $cuestionario)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">
                                <i class="fas fa-question-circle me-2"></i>{{ $cuestionario->titulo_cuestionario }}
                            </h5>
                            <p class="text-muted small mb-1">
                                <i class="far fa-calendar-alt me-1"></i>
                                Publicado: {{ $cuestionario->fecha_habilitacion }}
                            </p>
                            <p class="text-muted small">
                                <i class="far fa-clock me-1"></i>
                                Vence: {{ $cuestionario->fecha_vencimiento }}
                            </p>
                        </div>
                        <span class="badge bg-info text-dark">Cuestionario</span>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('cuestionario.mostrar', $cuestionario->id) }}"
                            class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-play me-1"></i> Responder
                        </a>
                        @if (auth()->user()->hasRole('Docente'))
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#modalEditarCuestionario-{{ $cuestionario->id }}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <!-- Modal para editar Cuestionario -->
                            <div class="modal fade" id="modalEditarCuestionario-{{ $cuestionario->id }}"
                                tabindex="-1" aria-labelledby="modalEditarCuestionarioLabel-{{ $cuestionario->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="modalEditarCuestionarioLabel-{{ $cuestionario->id }}">
                                                Editar Cuestionario
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST"
                                                action="{{ route('cuestionarios.update', $cuestionario->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="titulo" class="form-label">Título del
                                                        Cuestionario</label>
                                                    <input type="text" name="titulo" class="form-control"
                                                        value="{{ $cuestionario->titulo_cuestionario }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control" required>{{ $cuestionario->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fecha_habilitacion" class="form-label">Fecha de
                                                        Habilitación</label>
                                                    <input type="date" name="fecha_habilitacion"
                                                        class="form-control"
                                                        value="{{ $cuestionario->fecha_habilitacion }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fecha_vencimiento" class="form-label">Fecha de
                                                        Vencimiento</label>
                                                    <input type="date" name="fecha_vencimiento"
                                                        class="form-control"
                                                        value="{{ $cuestionario->fecha_vencimiento }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="puntos" class="form-label">Puntos</label>
                                                    <input type="number" name="puntos" class="form-control"
                                                        value="{{ $cuestionario->puntos }}" required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Guardar
                                                    Cambios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->hasRole('Estudiante'))
                            @if ($inscritos2->id && $cuestionario->isCompletedByInscrito($inscritos2->id))
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i> Completado
                                </span>
                            @else
                                <form method="POST"
                                    action="{{ route('cuestionario.completar', $cuestionario->id) }}"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="inscritos_id" value="{{ $inscritos2->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-check-circle me-1"></i> Marcar como completado
                                    </button>

                                </form>
                            @endif
                        @endif

                        @if (auth()->user()->hasRole('Docente'))
                            <a href="{{ route('cuestionarios.index', $cuestionario->id) }}"
                                class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-cog me-1"></i> Administrar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            @if ($subtema->tareas->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No hay actividades disponibles para este subtema.
                </div>
            @endif
        @endforelse --}}
    </div>
</div>

<div class="modal fade" id="modalActividad-{{ $subtema->id }}" tabindex="-1"
    aria-labelledby="modalActividadLabel-{{ $subtema->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActividadLabel-{{ $subtema->id }}">
                    Agregar Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('actividades.store', $cursos->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="subtema_id" value="{{ $subtema->id }}">

                    <!-- Título de la Actividad -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la Actividad</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" required></textarea>
                    </div>

                    <!-- Fecha de Habilitación -->
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Habilitación</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>

                    <!-- Fecha de Vencimiento -->
                    <div class="mb-3">
                        <label for="fecha_limite" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_limite" class="form-control" required>
                    </div>

                    <!-- Tipo de Actividad -->
                    <div class="mb-3">
                        <label for="tipo_actividad_id" class="form-label">Tipo de Actividad</label>
                        <select name="tipo_actividad_id" class="form-select" required>
                            <option value="" disabled selected>Selecciona un tipo</option>
                            @foreach ($tiposActividades as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipos de Evaluación -->
                    <div class="mb-3">
                        <label for="tipos_evaluacion" class="form-label">Tipos de Evaluación</label>
                        <div id="tipos-evaluacion-container">
                            <div class="tipo-evaluacion mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="tipos_evaluacion[0][tipo_evaluacion_id]" class="form-select"
                                            required>
                                            <option value="" disabled selected>Selecciona un tipo de evaluación
                                            </option>
                                            @foreach ($tiposEvaluaciones as $tipoEvaluacion)
                                                <option value="{{ $tipoEvaluacion->id }}">
                                                    {{ $tipoEvaluacion->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="tipos_evaluacion[0][puntaje_maximo]"
                                            class="form-control" placeholder="Puntaje Máximo" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="tipos_evaluacion[0][es_obligatorio]" class="form-select"
                                            required>
                                            <option value="1">Obligatorio</option>
                                            <option value="0">Opcional</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-tipo-evaluacion">
                            <i class="fas fa-plus me-1"></i> Agregar Tipo de Evaluación
                        </button>
                    </div>

                    <!-- Archivo (opcional) -->
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo (opcional)</label>
                        <input type="file" name="archivo" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">Agregar Actividad</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecurso-{{ $subtema->id }}" tabindex="-1"
    aria-labelledby="modalCuestionarioLabel-{{ $subtema->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCuestionarioLabel-{{ $subtema->id }}">
                    Agregar Recurso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('CrearRecursosSubtemaPost', $subtema->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del
                            Recurso</label>
                        <input type="text" name="tituloRecurso" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea placeholder="Puedes agregar un link de youtube para previsualizar el video en curso"
                            name="descripcionRecurso" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fileUpload">Seleccionar Archivo:</label>
                        <input type="file" id="fileUpload" name="archivo" class="form-input">
                    </div>

                    <div class="mb-3">
                        <label for="puntos" class="form-label">Elige el tipo de
                            Recurso</label>
                        <select class="form-select" id="resourceSelect" name="tipoRecurso">
                            <option value="" disabled selected>Selecciona un
                                recurso</option>
                            <option value="word">Word</option>
                            <option value="excel">Excel</option>
                            <option value="powerpoint">PowerPoint</option>
                            <option value="pdf">PDF</option>
                            <option value="archivos-adjuntos">Archivos Adjuntos
                            </option>
                            <option value="docs">Docs</option>
                            <option value="forms">Forms</option>
                            <option value="drive">Drive</option>
                            <option value="youtube">YouTube</option>
                            <option value="kahoot">Kahoot</option>
                            <option value="canva">Canva</option>
                            <option value="zoom">Zoom</option>
                            <option value="meet">Meet</option>
                            <option value="teams">Teams</option>
                            <option value="enlace">Enlace</option>
                            <option value="imagen">Imagen</option>
                            <option value="video">Video</option>
                            <option value="audio">Audio</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Agregar
                        Recurso</button>
                </form>
            </div>
        </div>
    </div>
</div>
