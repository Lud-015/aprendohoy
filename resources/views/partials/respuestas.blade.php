<div class="mb-3">
    <h4 class="border-bottom pb-2">
        <i class="fas fa-reply me-2"></i> Respuestas por Pregunta
    </h4>
</div>

<!-- Navegación de Pestañas -->
<ul class="nav nav-tabs" id="preguntasTabs" role="tablist">
    @foreach ($preguntas as $index => $pregunta)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $pregunta->id }}" data-bs-toggle="tab"
                data-bs-target="#contenido-{{ $pregunta->id }}" type="button" role="tab"
                aria-controls="contenido-{{ $pregunta->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                Pregunta {{ $loop->iteration }}
            </button>
        </li>
    @endforeach
</ul>

<!-- Contenido de las Pestañas -->
<div class="tab-content" id="preguntasTabsContent">
    @foreach ($preguntas as $index => $pregunta)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="contenido-{{ $pregunta->id }}"
            role="tabpanel" aria-labelledby="tab-{{ $pregunta->id }}">
            <h5 class="mt-4">
                <i class="fas fa-question-circle me-2"></i> {{ $pregunta->enunciado }}
                ({{ ucfirst(str_replace('_', ' ', $pregunta->tipo)) }})
            </h5>

            <!-- Botón para Crear Respuesta -->
            @if ($pregunta->tipo === 'opcion_multiple')
                <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#crearRespuestaModal-{{ $pregunta->id }}">
                    <i class="fas fa-plus"></i> Crear Respuesta
                </button>
            @elseif ($pregunta->tipo === 'abierta')
                <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#crearRespuestaClaveModal-{{ $pregunta->id }}">
                    <i class="fas fa-plus"></i> Crear Respuesta Clave
                </button>
            @elseif ($pregunta->tipo === 'boolean')
                <form method="POST" action="{{ route('respuestas.storeVerdaderoFalso', $pregunta->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary mb-3">
                        <i class="fas fa-plus"></i> Generar Respuestas Verdadero/Falso
                    </button>
                </form>
            @endif

            <!-- Tabla de Respuestas -->
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Respuesta</th>
                        <th>¿Es Correcta?</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pregunta->respuestas as $respuesta)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $respuesta->contenido }}</td>
                            <td>{{ $respuesta->es_correcta ? 'Sí' : 'No' }}</td>
                            <td>
                                <!-- Botón para Editar Respuesta -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editarRespuestaModal-{{ $respuesta->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                <!-- Botón para Eliminar Respuesta -->
                                <form method="POST" action="{{ route('respuestas.delete', $respuesta->id) }}"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay respuestas para esta pregunta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($preguntas as $pregunta)
            @if ($pregunta->tipo === 'opcion_multiple')
                const container{{ $pregunta->id }} = document.getElementById('respuestas-container-{{ $pregunta->id }}');
                const addButton{{ $pregunta->id }} = document.getElementById('addRespuestaButton-{{ $pregunta->id }}');
                let respuestaIndex{{ $pregunta->id }} = 1;

                addButton{{ $pregunta->id }}.addEventListener('click', function() {
                    const nuevaRespuesta = `
                        <div class="respuesta-item mb-3">
                            <div class="mb-3">
                                <label for="contenido" class="form-label">Contenido</label>
                                <input type="text" class="form-control" name="respuestas[${respuestaIndex{{ $pregunta->id }} }][contenido]" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">¿Es Correcta?</label>
                                <select class="form-select" name="respuestas[${respuestaIndex{{ $pregunta->id }} }][es_correcta]" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <hr>
                        </div>
                    `;
                    container{{ $pregunta->id }}.insertAdjacentHTML('beforeend', nuevaRespuesta);
                    respuestaIndex{{ $pregunta->id }}++;
                });
            @endif
        @endforeach
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($preguntas as $pregunta)
            @if ($pregunta->tipo === 'abierta')
                const containerClave{{ $pregunta->id }} = document.getElementById(
                    'respuestas-clave-container-{{ $pregunta->id }}');
                const addButtonClave{{ $pregunta->id }} = document.getElementById(
                    'addRespuestaClaveButton-{{ $pregunta->id }}');
                let respuestaClaveIndex{{ $pregunta->id }} = 1;

                addButtonClave{{ $pregunta->id }}.addEventListener('click', function() {
                    const nuevaRespuestaClave = `
            <div class="respuesta-item mb-3">
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <input type="text" class="form-control" name="respuestas[${respuestaClaveIndex{{ $pregunta->id }} }][contenido]" required>
                </div>
                <hr>
            </div>
        `;
                    containerClave{{ $pregunta->id }}.insertAdjacentHTML('beforeend',
                        nuevaRespuestaClave);
                    respuestaClaveIndex{{ $pregunta->id }}++;
                });
            @endif
        @endforeach
    });
</script>
