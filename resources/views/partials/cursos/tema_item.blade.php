<div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tema-{{ $tema->id }}" role="tabpanel" aria-labelledby="tema-{{ $tema->id }}-tab">
    <div class="card my-3">
        <div class="card-body">
            <h1>{{ $tema->titulo_tema }}</h1>

            @if($tema->imagen)
                <img class="img-fluid" src="{{ asset('storage/' . $tema->imagen) }}" alt="Imagen del tema" style="max-width: 500px; height: auto;">
            @endif

            <div class="my-3">
                <button class="btn btn-link" type="button" data-bs-toggle="collapse"
                        data-bs-target="#descripcionTema-{{ $tema->id }}" aria-expanded="false"
                        aria-controls="descripcionTema-{{ $tema->id }}">
                    Ver Descripción del Tema
                </button>
                <div class="collapse" id="descripcionTema-{{ $tema->id }}">
                    <div class="card card-body">
                        {!! nl2br(e($tema->descripcion)) !!}
                    </div>
                </div>
            </div>

            @if(auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                <div class="mb-3">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#modalSubtema-{{ $tema->id }}">
                        <i class="fas fa-plus me-1"></i> Agregar Subtema
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalEditarTema-{{ $tema->id }}">
                        <i class="fas fa-edit me-1"></i> Editar Tema
                    </button>
                </div>
            @endif
            <div class="modal fade" id="modalEditarTema-{{ $tema->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-edit me-2"></i>Editar Tema: {{ $tema->titulo_tema }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('temas.update', $tema->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título*</label>
                                    <input type="text" class="form-control" name="titulo" value="{{ $tema->titulo_tema }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" rows="3">{{ $tema->descripcion }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Imagen Actual</label>
                                    @if($tema->imagen)
                                        <img src="{{ asset('storage/'.$tema->imagen) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                    @else
                                        <p class="text-muted">No hay imagen cargada</p>
                                    @endif
                                    <input type="file" class="form-control" name="imagen" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="accordion" id="subtemasAccordion-{{ $tema->id }}">
                @foreach($tema->subtemas as $subtemaIndex => $subtema)
                    @php
                        $desbloqueado = auth()->user()->hasRole('Docente') ||
                                      (auth()->user()->hasRole('Estudiante') && $subtema->estaDesbloqueado($inscritos2->id ?? null));
                    @endphp

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="subtemaHeading-{{ $subtema->id }}">
                            @if(!$desbloqueado && auth()->user()->hasRole('Estudiante'))
                                <button class="accordion-button collapsed" type="button" disabled>
                                    {{ $subtema->titulo_subtema }} <i class="fas fa-lock ms-2"></i>
                                </button>
                            @else
                                <button class="accordion-button {{ $subtemaIndex === 0 ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#subtemaCollapse-{{ $subtema->id }}"
                                        aria-expanded="{{ $subtemaIndex === 0 ? 'true' : 'false' }}"
                                        aria-controls="subtemaCollapse-{{ $subtema->id }}">
                                    {{ $subtema->titulo_subtema }}
                                </button>
                            @endif
                        </h2>

                        @if($desbloqueado || auth()->user()->hasRole('Docente'))
                            <div id="subtemaCollapse-{{ $subtema->id }}"
                                 class="accordion-collapse collapse {{ $subtemaIndex === 0 ? 'show' : '' }}"
                                 aria-labelledby="subtemaHeading-{{ $subtema->id }}"
                                 data-bs-parent="#subtemasAccordion-{{ $tema->id }}">
                                <div class="accordion-body">
                                    @include('partials.cursos.subtema_item', [
                                        'subtema' => $subtema,
                                        'tema' => $tema
                                    ])
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="my-4">
        <h5>Evaluaciones</h5>
        @if($tema->evaluaciones->isNotEmpty())
            <ul class="list-group">
                @foreach($tema->evaluaciones as $evaluacion)
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <div>
                            <h6 class="mb-1">{{ $evaluacion->titulo_evaluacion }}</h6>
                            <p class="mb-1 text-muted">{{ $evaluacion->descripcionEvaluacion }}</p>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $evaluacion->fecha_habilitacion }} - {{ $evaluacion->fecha_vencimiento}}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-check-circle me-1"></i>
                                Puntos: {{ $evaluacion->puntos }}
                            </small>
                            @if($evaluacion->archivoEvaluacion)
                                <br>
                                <a href="{{ asset('storage/' . $evaluacion->archivoEvaluacion) }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-download me-1"></i> Descargar Archivo
                                </a>
                            @endif

                        </div>

                        <div>
                            @if(auth()->user()->hasRole('Docente'))
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalEditarEvaluacion-{{ $evaluacion->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form method="GET" action="{{ route('quitarEvaluacion', $evaluacion->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta evaluación?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No hay evaluaciones asociadas a este tema.</p>
        @endif

        @if(auth()->user()->hasRole('Docente'))
            <button class="btn btn-sm btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalAgregarEvaluacion-{{ $tema->id }}">
                <i class="fas fa-plus"></i> Agregar Evaluación
            </button>
        @endif
        <!-- Modal para Crear Evaluación -->
<div class="modal fade" id="modalAgregarEvaluacion-{{ $tema->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Crear Evaluación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('CrearEvaluacionPost', $cursos->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tema_id" value="{{ $tema->id }}">
                    <input type="hidden" name="cursos_id" value="{{ $cursos->id }}">
                    <div class="mb-3">
                        <label for="tituloEvaluacion" class="form-label">Título de la Evaluación</label>
                        <input type="text" class="form-control" name="tituloEvaluacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="evaluacionDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="evaluacionDescripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fechaHabilitacion" class="form-label">Fecha de Habilitación</label>
                        <input type="date" class="form-control" name="fechaHabilitacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" name="fechaVencimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="puntos" class="form-label">Puntos</label>
                        <input type="number" class="form-control" name="puntos" required>
                    </div>
                    <div class="mb-3">
                        <label for="evaluacionArchivo" class="form-label">Archivo (opcional)</label>
                        <input type="file" class="form-control" name="evaluacionArchivo">
                    </div>
                </div>

                <div class="m-3">
                    <label for="esCuestionario" class="form-label">¿Es un Cuestionario?</label>
                    <select class="form-select" name="esCuestionario" required>
                        <option value="0" selected>No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>
                <div class="m-3" id="intentosPermitidosContainer" style="display: none;">
                    <label for="intentosPermitidos" class="form-label">Intentos Permitidos</label>
                    <input type="number" class="form-control" name="intentosPermitidos" min="1">
                </div>
                <script>
                    document.querySelector('[name="esCuestionario"]').addEventListener('change', function() {
                        const container = document.getElementById('intentosPermitidosContainer');
                        container.style.display = this.value == '1' ? 'block' : 'none';
                    });
                </script>



                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($tema->evaluaciones as $evaluacion)
<!-- Modal para Editar Evaluación -->
<div class="modal fade" id="modalEditarEvaluacion-{{ $evaluacion->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Editar Evaluación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('editarEvaluacionPost', $evaluacion->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="cursos_id" value="{{ $cursos->id }}">
                    <input type="hidden" name="tema_id" value="{{ $evaluacion->temas_id }}">
                    <div class="mb-3">
                        <label for="tituloEvaluacion" class="form-label">Título de la Evaluación</label>
                        <input type="text" class="form-control" name="tituloEvaluacion" value="{{ $evaluacion->titulo_evaluacion }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="evaluacionDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="evaluacionDescripcion" rows="3" required>{{ $evaluacion->descripcionEvaluacion }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fechaHabilitacion" class="form-label">Fecha de Habilitación</label>
                        <input type="date" class="form-control" name="fechaHabilitacion" value="{{ $evaluacion->fecha_habilitacion }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" name="fechaVencimiento" value="{{ $evaluacion->fecha_vencimiento }}" required>
                    </div>
                    <div class="m-3">
                        <label for="puntos" class="form-label">Puntos</label>
                        <input type="number" class="form-control" name="puntos" value="{{ $evaluacion->puntos }}" required>
                    </div>
                    <div class="m-3">
                        <label for="evaluacionArchivo" class="form-label">Archivo (opcional)</label>
                        @if($evaluacion->archivoEvaluacion)
                            <a href="{{ asset('storage/' . $evaluacion->archivoEvaluacion) }}" target="_blank" class="d-block mb-2">
                                <i class="fas fa-download me-1"></i> Descargar Archivo
                            </a>
                        @endif
                        <input type="file" class="form-control" name="evaluacionArchivo">
                    </div>
                </div>

                <div class="m-3">
                    <label for="esCuestionario" class="form-label">¿Es un Cuestionario?</label>
                    <select class="form-select" name="esCuestionario" required>
                        <option value="0" {{ $evaluacion->es_cuestionario ? '' : 'selected' }}>No</option>
                        <option value="1" {{ $evaluacion->es_cuestionario ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
                <div class="m-3" id="intentosPermitidosContainer" style="{{ $evaluacion->es_cuestionario ? '' : 'display: none;' }}">
                    <label for="intentosPermitidos" class="form-label">Intentos Permitidos</label>
                    <input type="number" class="form-control" name="intentosPermitidos" value="{{ $evaluacion->intentos_permitidos }}" min="1">
                </div>
                <script>
                    document.querySelector('[name="esCuestionario"]').addEventListener('change', function() {
                        const container = document.getElementById('intentosPermitidosContainer');
                        container.style.display = this.value == '1' ? 'block' : 'none';
                    });
                </script>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
{{-- <form method="POST" action="{{ route('quitarEvaluacion', $evaluacion->id) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta evaluación?')">
        <i class="fas fa-trash"></i> Eliminar
    </button>
</form> --}}


    </div>

</div>

