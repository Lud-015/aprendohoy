@section('titulo')
    Respuestas
@endsection




@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('Inicio') }}" class="btn btn-sm btn-primary">
                &#9668; Volver
            </a>

            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#crearPreguntaModal">
                Crear Pregunta
            </button>

        </div>


        <!-- Modal para Crear Pregunta -->
        <div class="modal fade" id="crearPreguntaModal" tabindex="-1" aria-labelledby="crearPreguntaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('pregunta.store', $cuestionario->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearPreguntaLabel">Crear Pregunta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"> <!-- Cambiado de form-group a mb-3 -->
                                <label for="preguntaTexto" class="form-label">Texto de la Pregunta</label>
                                <input type="text" class="form-control" id="preguntaTexto" name="pregunta" required>
                            </div>
                            <div class="mb-3">
                                <label for="preguntaTipo" class="form-label">Tipo de Pregunta</label>
                                <select class="form-select" id="preguntaTipo" name="tipo_preg" required>
                                    <option value="multiple">Opción Múltiple</option>
                                    <option value="abierta">Respuesta Abierta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="puntosPregunta" class="form-label">Puntos</label>
                                <input type="number" class="form-control" id="puntosPregunta" name="puntos" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Crear Respuesta -->
        <div class="modal fade" id="crearRespuestaModal" tabindex="-1" aria-labelledby="crearRespuestaLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('opcion.store', $cuestionario->id) }}">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="crearRespuestaLabel">Crear Respuesta</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="pregunta_id" id="pregunta_id" value="">

                            <div class="mb-3">
                                <label for="respuestaTexto" class="form-label">Texto de la Respuesta</label>
                                <input type="text" class="form-control" id="respuestaTexto" name="respuesta" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">¿Es correcta?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="es_correcta" id="verdadero"
                                        value="1" required>
                                    <label class="form-check-label" for="verdadero">Verdadero</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="es_correcta" id="falso"
                                        value="0">
                                    <label class="form-check-label" for="falso">Falso</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="puntosRespuesta" class="form-label">Puntos (opcional)</label>
                                <input type="number" class="form-control" id="puntosRespuesta" name="puntos"
                                    min="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Respuesta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Buscador -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Buscar preguntas o respuestas">
        </div>

        <!-- Tabla de Preguntas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pregunta</th>
                    <th>Tipo</th>
                    <th>Puntos</th>
                    <th>Acciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuestionario->preguntas as $pregunta)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Número de la pregunta -->
                        <td>{{ $pregunta->pregunta }}</td>
                        <td>{{ $pregunta->tipo }}</td>
                        <td>{{ $pregunta->puntos }}</td>
                        <td>
                            @if ($pregunta->tipo === 'multiple' || $pregunta->tipo === 'verdadero_falso')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#crearRespuestaModal{{ $pregunta->id }}"
                                    onclick="setPreguntaId({{ $pregunta->id }})">
                                    <i class="fas fa-plus-circle me-1"></i> Añadir Respuesta
                                </button>
                            @else
                                <span class="text-muted">No aplica</span>
                            @endif
                        </td>
                        <td colspan="2">
                            <!-- Botón para abrir el modal de edición -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editarPreguntaModal{{ $pregunta->id }}" title="Editar pregunta">
                                <i class="fas fa-edit me-1"></i> Editar
                            </button>

                            @if ($pregunta->trashed())
                                <!-- Si la pregunta está eliminada, mostrar el botón de Restaurar -->
                                <form action="{{ route('pregunta.restore', $pregunta->id) }}" method="POST"
                                    class="form-restaurar" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                                </form>
                            @else
                                <!-- Si la pregunta no está eliminada, mostrar el botón de Eliminar -->
                                <form action="{{ route('pregunta.delete', $pregunta->id) }}" method="POST"
                                    class="form-eliminar" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>

                    <div class="modal fade" id="editarPreguntaModal{{ $pregunta->id }}" tabindex="-1"
                        aria-labelledby="editarPreguntaLabel{{ $pregunta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('pregunta.update', $pregunta->id) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarRespuestaLabel{{ $pregunta->id }}">Editar
                                            Pregunta</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
                                        <div class="form-group">
                                            <label for="respuestaTexto{{ $pregunta->id }}">Texto de la Pregunta</label>
                                            <input type="text" class="form-control"
                                                id="respuestaTexto{{ $pregunta->id }}" name="pregunta"
                                                value="{{ $pregunta->pregunta }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="preguntaTipo">Tipo de Pregunta</label>
                                            <select class="form-control" id="preguntaTipo" name="tipo_preg" required>
                                                <option value="multiple"
                                                    {{ $pregunta->tipo === 'multiple' ? 'selected' : '' }}>Opción Múltiple
                                                </option>
                                                <option value="verdadero_falso"
                                                    {{ $pregunta->tipo === 'multiple' ? 'selected' : '' }}>Verdadero Falso
                                                </option>
                                                <option value="abierta"
                                                    {{ $pregunta->tipo === 'abierta' ? 'selected' : '' }}>Respuesta Abierta
                                                </option>
                                            </select>
                                        </div>

                                        <label for="preguntaTipo">Puntos</label>

                                        <div class="form-group">
                                            <input type="number" name="puntos"
                                                id="respuestaTexto{{ $pregunta->id }} value="{{ $pregunta->puntos }}">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mostrar las opciones de la pregunta -->
                    @if ($pregunta->tipo === 'multiple' || $pregunta->tipo === 'verdadero_falso')
                        @foreach ($pregunta->opciones as $opcion)
                            <tr>
                                <td colspan="2">{{ $opcion->texto }}</td>
                                <td>{{ $opcion->es_correcta ? 'Correcta' : 'Incorrecta' }}</td>
                                <td colspan="2">
                                    <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editarRespuestaModal{{ $opcion->id }}"
                                    title="Editar esta respuesta">
                                <i class="fas fa-edit me-1"></i> Editar
                            </button>
                                    @if ($opcion->trashed())
                                        <!-- Si la pregunta está eliminada, mostrar el botón de Restaurar -->
                                        <form action="{{ route('opcion.restore', $opcion->id) }}" method="POST"
                                            class="form-restaurar" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                                        </form>
                                    @else
                                        <!-- Si la pregunta no está eliminada, mostrar el botón de Eliminar -->
                                        <form action="{{ route('pregunta.delete', $opcion->id) }}" method="POST"
                                            class="form-eliminar" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                                </td>
                            </tr>
                            <div class="modal fade" id="editarRespuestaModal{{ $opcion->id }}" tabindex="-1"
                                aria-labelledby="editarRespuestaLabel{{ $opcion->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('opcion.update', $opcion->id) }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editarRespuestaLabel{{ $opcion->id }}">
                                                    Editar Respuesta</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
                                                <div class="form-group">
                                                    <label for="respuestaTexto{{ $opcion->id }}">Texto de la
                                                        Respuesta</label>
                                                    <input type="text" class="form-control"
                                                        id="respuestaTexto{{ $opcion->id }}" name="respuesta"
                                                        value="{{ $opcion->texto }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>¿Es correcta?</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="es_correcta" id="verdadero{{ $opcion->id }}"
                                                                value="1" {{ $opcion->es_correcta ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="verdadero{{ $opcion->id }}">Verdadero</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="es_correcta" id="falso{{ $opcion->id }}"
                                                                value="0"
                                                                {{ !$opcion->es_correcta ? 'checked' : '' }} required>
                                                            <label class="form-check-label"
                                                                for="falso{{ $opcion->id }}">Falso</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Modal para añadir respuestas -->
                    @if ($pregunta->tipo === 'multiple' || $pregunta->tipo === 'verdadero_falso')
                        <div class="modal fade" id="crearRespuestaModal{{ $pregunta->id }}" tabindex="-1"
                            aria-labelledby="crearRespuestaLabel{{ $pregunta->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('opcion.store', $pregunta->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="crearRespuestaLabel{{ $pregunta->id }}">Crear
                                                Respuesta</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
                                            <div class="form-group">
                                                <label for="respuestaTexto{{ $pregunta->id }}">Texto de la
                                                    Respuesta</label>
                                                <input type="text" class="form-control"
                                                    id="respuestaTexto{{ $pregunta->id }}" name="respuesta" required>
                                            </div>
                                            @if ($pregunta->tipo === 'multiple')
                                                <div class="form-group">
                                                    <label>¿Es correcta?</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="es_correcta" id="verdadero{{ $pregunta->id }}"
                                                                value="1" required>
                                                            <label class="form-check-label"
                                                                for="verdadero{{ $pregunta->id }}">Verdadero</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="es_correcta" id="falso{{ $pregunta->id }}"
                                                                value="0" required>
                                                            <label class="form-check-label"
                                                                for="falso{{ $pregunta->id }}">Falso</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Añadir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona todos los formularios con la clase 'form-eliminar'
        const formsEliminar = document.querySelectorAll('.form-eliminar');
        // Selecciona todos los formularios con la clase 'form-restaurar'
        const formsRestaurar = document.querySelectorAll('.form-restaurar');

        // Función para manejar la confirmación de eliminación
        formsEliminar.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío automático del formulario

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, envía el formulario
                        form.submit();
                    }
                });
            });
        });

        // Función para manejar la confirmación de restauración
        formsRestaurar.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita el envío automático del formulario

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres restaurar esta pregunta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745', // Verde para restaurar
                    cancelButtonColor: '#6c757d', // Gris para cancelar
                    confirmButtonText: 'Sí, restaurar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, envía el formulario
                        form.submit();
                    }
                });
            });
        });
    });
</script>



@include('layout')
