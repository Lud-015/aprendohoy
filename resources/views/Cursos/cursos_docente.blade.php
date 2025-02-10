

    <div class="card shadow">
        <div class="card-body">
            <!-- Navegación simplificada -->
            <ul class="nav nav-tabs" id="course-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-actividades">Temario</a>
                </li>
                @if ($cursos->tipo == 'curso')
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-evaluaciones">Evaluaciones</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-foros">Foros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-recursos">Recursos Globales</a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- Actividades -->
                <div class="tab-pane fade show active" id="tab-actividades">

                    <div class="tab-pane fade show active" id="tab-actividades">
                        @if ($cursos->docente_id == auth()->user()->id)
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalTema">Agregar Tema</button>
                        @endif
                        <!-- Modal para agregar Tema -->
                        <div class="modal fade" id="modalTema" tabindex="-1" aria-labelledby="modalTemaLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTemaLabel">Agregar Tema</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('temas.store', $cursos->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="titulo" class="form-label">Título del Tema</label>
                                                <input type="text" name="titulo" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea name="descripcion" class="form-control"></textarea>
                                            </div>

                                            <input type="file" name="imagen" accept="image/*">

                                            <button type="submit" class="btn btn-primary">Agregar Tema</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="temasTabs" role="tablist">
                                @foreach ($temas as $index => $tema)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                            id="tema-{{ $tema->id }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#tema-{{ $tema->id }}" type="button" role="tab"
                                            aria-controls="tema-{{ $tema->id }}"
                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                            {{ $tema->titulo_tema }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" id="temasContent">
                                @foreach ($temas as $index => $tema)
                                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                        id="tema-{{ $tema->id }}" role="tabpanel"
                                        aria-labelledby="tema-{{ $tema->id }}-tab">
                                        <div class="card my-3">
                                            <div class="card-body">
                                                <h1>{{ $tema->titulo_tema }}</h1>
                                                @if ($tema->imagen)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/' . $tema->imagen) }}"
                                                        alt="Imagen del tema">
                                                @endif

                                                <div class="my-3">
                                                    <button class="btn btn-link" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#descripcionTema-{{ $tema->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="descripcionTema-{{ $tema->id }}">
                                                        Ver Descripción del Tema
                                                    </button>
                                                    <div class="collapse" id="descripcionTema-{{ $tema->id }}">
                                                        <div class="card card-body">
                                                            {{ $tema->descripcion }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Botón para agregar subtema -->
                                                @if ($cursos->docente_id == auth()->user()->id)
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalSubtema-{{ $tema->id }}">Agregar
                                                        Subtema</button>
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditarTema-{{ $tema->id }}">Editar
                                                        Tema</button>
                                                @endif

                                                <div class="accordion" id="subtemasAccordion-{{ $tema->id }}">
                                                    @foreach ($tema->subtemas as $subtemaIndex => $subtema)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header"
                                                                id="subtemaHeading-{{ $subtema->id }}">
                                                                <button
                                                                    class="accordion-button {{ $subtemaIndex === 0 ? '' : 'collapsed' }}"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#subtemaCollapse-{{ $subtema->id }}"
                                                                    aria-expanded="{{ $subtemaIndex === 0 ? 'true' : 'false' }}"
                                                                    aria-controls="subtemaCollapse-{{ $subtema->id }}">
                                                                    {{ $subtema->titulo_subtema }}
                                                                </button>
                                                            </h2>
                                                            <div id="subtemaCollapse-{{ $subtema->id }}"
                                                                class="accordion-collapse collapse {{ $subtemaIndex === 0 ? 'show' : '' }}"
                                                                aria-labelledby="subtemaHeading-{{ $subtema->id }}"
                                                                data-bs-parent="#subtemasAccordion-{{ $tema->id }}">
                                                                <div class="accordion-body">
                                                                    <h2>{{ $subtema->titulo_subtema }}</h2>
                                                                    @if ($subtema->imagen)
                                                                        <img class="img-fluid "
                                                                            src="{{ asset('storage/' . $subtema->imagen) }}"
                                                                            alt="Imagen del subtema">
                                                                    @endif
                                                                    <div class="my-3">
                                                                        <button class="btn btn-link" type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#descripcionSubtema-{{ $subtema->id }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="descripcionSubtema-{{ $subtema->id }}">
                                                                            Ver Descripción del SubTema
                                                                        </button>
                                                                        <div class="collapse"
                                                                            id="descripcionSubtema-{{ $subtema->id }}">
                                                                            <div class="card card-body">
                                                                                {{ $subtema->descripcion }}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Botón para agregar tarea -->
                                                                    @if ($cursos->docente_id == auth()->user()->id)
                                                                        <button class="btn btn-sm btn-outline-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalTarea-{{ $subtema->id }}">Agregar
                                                                            Tarea</button>
                                                                        <button class="btn btn-sm btn-outline-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalCuestionario-{{ $subtema->id }}">Agregar
                                                                            Cuestionario</button>
                                                                        <button class="btn btn-sm btn-outline-success"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalRecurso-{{ $subtema->id }}">Agregar
                                                                            Recurso</button>
                                                                        <button
                                                                            class="btn btn-sm btn-outline-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalEditarSubtema-{{ $subtema->id }}">Editar
                                                                            Subtema</button>
                                                                    @endif

                                                                    <div class="my-4">
                                                                        <h2>Recursos</h4>
                                                                    </div>

                                                                    @foreach ($subtema->recursos as $recursosSubtemas)
                                                                        <div class=" ">
                                                                            <div class="card-body">
                                                                                <h5>{{ $recursosSubtemas->nombreRecurso }}
                                                                                </h5>


                                                                                @if (Str::contains($recursosSubtemas->descripcionRecursos, ['<iframe', '<video', '<img']))
                                                                                    <div class="ratio ratio-16x9">
                                                                                            {!! $recursosSubtemas->descripcionRecursos !!}
                                                                                    </div>
                                                                                @else
                                                                                    <p>{!! nl2br(e($recursosSubtemas->descripcionRecursos)) !!}</p>
                                                                                @endif





                                                                                @if ($recursosSubtemas->archivoRecurso)
                                                                                    <a href="{{ asset('storage/' . $recursosSubtemas->archivoRecurso) }}"
                                                                                        class="btn btn-primary btn-sm">Ver
                                                                                        Recurso</a>
                                                                                @endif
                                                                                @if (auth()->user()->hasRole('Docente'))
                                                                                    <div class="my-1">
                                                                                        <!-- Botón para abrir el modal de edición -->
                                                                                        <button
                                                                                            class="btn btn-info btn-sm"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#modalEditarRecurso-{{ $recursosSubtemas->id }}">
                                                                                            Editar
                                                                                        </button>

                                                                                        <!-- Modal para editar recurso -->
                                                                                        <div class="modal fade"
                                                                                            id="modalEditarRecurso-{{ $recursosSubtemas->id }}"
                                                                                            tabindex="-1"
                                                                                            aria-labelledby="editarRecursoLabel-{{ $recursosSubtemas->id }}"
                                                                                            aria-hidden="true">
                                                                                            <div class="modal-dialog">
                                                                                                <div
                                                                                                    class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-header">
                                                                                                        <h5 class="modal-title"
                                                                                                            id="editarRecursoLabel-{{ $recursosSubtemas->id }}">
                                                                                                            Editar
                                                                                                            Recurso</h5>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn-close"
                                                                                                            data-bs-dismiss="modal"
                                                                                                            aria-label="Cerrar"></button>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="modal-body">
                                                                                                        <form
                                                                                                            method="POST"
                                                                                                            action="{{ route('editarRecursosSubtemaPost', $recursosSubtemas->id) }}"
                                                                                                            enctype="multipart/form-data">
                                                                                                            @csrf
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="tituloRecurso"
                                                                                                                    class="form-label">Título
                                                                                                                    del
                                                                                                                    Recurso</label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    name="tituloRecurso"
                                                                                                                    class="form-control"
                                                                                                                    value="{{ $recursosSubtemas->nombreRecurso }}"
                                                                                                                    required>
                                                                                                            </div>

                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="descripcionRecurso"
                                                                                                                    class="form-label">Descripción</label>
                                                                                                                <textarea name="descripcionRecurso" class="form-control" required></textarea>
                                                                                                            </div>

                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="archivo"
                                                                                                                    class="form-label">Actualizar
                                                                                                                    Archivo
                                                                                                                    (Opcional)
                                                                                                                </label>
                                                                                                                <input
                                                                                                                    type="file"
                                                                                                                    name="archivo"
                                                                                                                    class="form-control">
                                                                                                                <small
                                                                                                                    class="text-muted">Deja
                                                                                                                    vacío
                                                                                                                    si
                                                                                                                    no
                                                                                                                    deseas
                                                                                                                    cambiar
                                                                                                                    el
                                                                                                                    archivo.</small>
                                                                                                            </div>

                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="tipoRecurso"
                                                                                                                    class="form-label">Tipo
                                                                                                                    de
                                                                                                                    Recurso</label>
                                                                                                                <select
                                                                                                                    class="form-select"
                                                                                                                    name="tipoRecurso">
                                                                                                                    <option
                                                                                                                        value=""
                                                                                                                        disabled>
                                                                                                                        Selecciona
                                                                                                                        un
                                                                                                                        recurso
                                                                                                                    </option>
                                                                                                                    <option
                                                                                                                        value="word"
                                                                                                                        {{ $recursosSubtemas->tipoRecurso == 'word' ? 'selected' : '' }}>
                                                                                                                        Word
                                                                                                                    </option>
                                                                                                                    <option
                                                                                                                        value="pdf"
                                                                                                                        {{ $recursosSubtemas->tipoRecurso == 'pdf' ? 'selected' : '' }}>
                                                                                                                        PDF
                                                                                                                    </option>
                                                                                                                    <option
                                                                                                                        value="youtube"
                                                                                                                        {{ $recursosSubtemas->tipoRecurso == 'youtube' ? 'selected' : '' }}>
                                                                                                                        YouTube
                                                                                                                    </option>
                                                                                                                    <option
                                                                                                                        value="imagen"
                                                                                                                        {{ $recursosSubtemas->tipoRecurso == 'imagen' ? 'selected' : '' }}>
                                                                                                                        Imagen
                                                                                                                    </option>
                                                                                                                    <option
                                                                                                                        value="video"
                                                                                                                        {{ $recursosSubtemas->tipoRecurso == 'video' ? 'selected' : '' }}>
                                                                                                                        Video
                                                                                                                    </option>
                                                                                                                </select>
                                                                                                            </div>

                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn btn-success">Actualizar
                                                                                                                Recurso</button>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <a href="{{ route('quitarRecursoSubtema', $recursosSubtemas->id) }}"
                                                                                            class="btn btn-danger btn-sm"
                                                                                            onclick="mostrarAdvertencia(event)">Eliminar</a>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach




                                                                    <div class="my-4">
                                                                        <h2>Actividades</h4>
                                                                    </div>
                                                                    <!-- Tareas del subtema -->
                                                                    @foreach ($subtema->tareas as $tarea)
                                                                        <div class="my-4 mb-3">
                                                                            <h2>{{ $tarea->titulo_tarea }}</h2>
                                                                            <p class="text-light">Entrega Digital</p>
                                                                            <p>Creado: {{ $tarea->fecha_habilitacion }}
                                                                                | Vence:
                                                                                {{ $tarea->fecha_vencimiento }}</p>
                                                                            <div>
                                                                                @if (auth()->user()->hasRole('Docente'))
                                                                                    <a href="{{ route('editarTarea', $tarea->id) }}"
                                                                                        class="btn btn-info btn-sm">Editar</a>
                                                                                    <a href="{{ route('quitarTarea', $tarea->id) }}"
                                                                                        class="btn btn-danger btn-sm"
                                                                                        onclick="mostrarAdvertencia(event)">Eliminar</a>
                                                                                    <a href="{{ route('calificarT', $tarea->id) }}"
                                                                                        class="btn btn-primary btn-sm">Calificar</a>
                                                                                @endif
                                                                                <a href="{{ route('VerTarea', $tarea->id) }}"
                                                                                    class="btn btn-primary btn-sm">Ver
                                                                                    Actividad</a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                    @foreach ($subtema->cuestionarios as $cuestionario)
                                                                        <div class="my-4 mb-3">
                                                                            <h2>{{ $cuestionario->titulo_cuestionario }}
                                                                            </h2>
                                                                            <p class="text-light">Cuestionario</p>
                                                                            <p>Creado:
                                                                                {{ $cuestionario->fecha_habilitacion }}
                                                                                | Vence:
                                                                                {{ $cuestionario->fecha_vencimiento }}
                                                                            </p>
                                                                            <div>
                                                                                @if ($cursos->docente_id == auth()->user()->id)
                                                                                    <a href=""
                                                                                        class="btn btn-info btn-sm">Editar</a>
                                                                                    <a href=""
                                                                                        class="btn btn-danger btn-sm"
                                                                                        onclick="mostrarAdvertencia(event)">Eliminar</a>
                                                                                    <a href="{{ route('cuestionarios.index', $cuestionario->id) }}"
                                                                                        class="btn btn-primary btn-sm">Administrar
                                                                                        Cuestionario</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Modales (Agregar Subtema, Editar Tema, Agregar Tarea, Editar Subtema, etc.) -->
                        @foreach ($temas as $tema)
                            <!-- Modal para agregar Subtema -->
                            <div class="modal fade" id="modalSubtema-{{ $tema->id }}" tabindex="-1"
                                aria-labelledby="modalSubtemaLabel-{{ $tema->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalSubtemaLabel-{{ $tema->id }}">
                                                Agregar Subtema</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('subtemas.store', $tema->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="titulo" class="form-label">Título del
                                                        Subtema</label>
                                                    <input type="text" name="titulo" class="form-control"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control"></textarea>
                                                </div>
                                                <input type="file" name="imagen" accept="image/*">
                                                <button type="submit" class="btn btn-success">Agregar
                                                    Subtema</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para editar Tema -->
                            <div class="modal fade" id="modalEditarTema-{{ $tema->id }}" tabindex="-1"
                                aria-labelledby="modalEditarTemaLabel-{{ $tema->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditarTemaLabel-{{ $tema->id }}">
                                                Editar Tema</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('temas.update', $tema->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="titulo" class="form-label">Título del Tema</label>
                                                    <input type="text" name="titulo" class="form-control"
                                                        value="{{ $tema->titulo_tema }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control">{{ $tema->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="imagen" class="form-label">Imagen</label>
                                                    <input type="file" name="imagen" accept="image/*"
                                                        class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar
                                                    Cambios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($temas as $tema)
                            @foreach ($tema->subtemas as $subtema)
                                <!-- Modal para agregar Tarea -->
                                <div class="modal fade" id="modalTarea-{{ $subtema->id }}" tabindex="-1"
                                    aria-labelledby="modalTareaLabel-{{ $subtema->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTareaLabel-{{ $subtema->id }}">
                                                    Agregar Tarea</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('CrearTareasPost', $subtema->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="titulo" class="form-label">Título de la
                                                            Tarea</label>
                                                        <input type="text" name="tituloTarea" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion"
                                                            class="form-label">Descripción</label>
                                                        <textarea name="tareaDescripcion" class="form-control" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_habilitacion" class="form-label">Fecha de
                                                            Habilitación</label>
                                                        <input type="date" name="fechaHabilitacion"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_vencimiento" class="form-label">Fecha de
                                                            Vencimiento</label>
                                                        <input type="date" name="fechaVencimiento"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="archivo" class="form-label">Archivo
                                                            (opcional)
                                                        </label>
                                                        <input type="file" name="tareaArchivo"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="puntos" class="form-label">Puntos</label>
                                                        <input type="number" name="puntos" class="form-control"
                                                            required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Agregar
                                                        Tarea</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal para agregar Recurso -->
                                <div class="modal fade" id="modalRecurso-{{ $subtema->id }}" tabindex="-1"
                                    aria-labelledby="modalCuestionarioLabel-{{ $subtema->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalCuestionarioLabel-{{ $subtema->id }}">
                                                    Agregar Recurso</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('CrearRecursosSubtemaPost', $subtema->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="titulo" class="form-label">Título del
                                                            Recurso</label>
                                                        <input type="text" name="tituloRecurso"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion"
                                                            class="form-label">Descripción</label>
                                                        <textarea placeholder="Puedes agregar un link de youtube para previsualizar el video en curso"
                                                            name="descripcionRecurso" class="form-control" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fileUpload">Seleccionar Archivo:</label>
                                                        <input type="file" id="fileUpload" name="archivo"
                                                            class="form-input">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="puntos" class="form-label">Elige el tipo de
                                                            Recurso</label>
                                                        <select class="form-select" id="resourceSelect"
                                                            name="tipoRecurso">
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
                                <!-- Modal para agregar Cuestionario -->
                                <div class="modal fade" id="modalCuestionario-{{ $subtema->id }}" tabindex="-1"
                                    aria-labelledby="modalCuestionarioLabel-{{ $subtema->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalCuestionarioLabel-{{ $subtema->id }}">
                                                    Agregar Cuestionario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('cuestionarios.store', $subtema->id) }}">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label for="titulo" class="form-label">Título del
                                                            Cuestionario</label>
                                                        <input type="text" name="titulo" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion"
                                                            class="form-label">Descripción</label>
                                                        <textarea name="descripcion" class="form-control" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_habilitacion" class="form-label">Fecha de
                                                            Habilitación</label>
                                                        <input type="date" name="fecha_habilitacion"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fecha_vencimiento" class="form-label">Fecha de
                                                            Vencimiento</label>
                                                        <input type="date" name="fecha_vencimiento"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="puntos" class="form-label">Puntos</label>
                                                        <input type="number" name="puntos" class="form-control"
                                                            required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Agregar
                                                        Cuestionario</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para editar Subtema -->
                                <div class="modal fade" id="modalEditarSubtema-{{ $subtema->id }}" tabindex="-1"
                                    aria-labelledby="modalEditarSubtemaLabel-{{ $subtema->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalEditarSubtemaLabel-{{ $subtema->id }}">Editar Subtema
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('subtemas.update', $subtema->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="titulo" class="form-label">Título del
                                                            Subtema</label>
                                                        <input type="text" name="titulo" class="form-control"
                                                            value="{{ $subtema->titulo_subtema }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion"
                                                            class="form-label">Descripción</label>
                                                        <textarea name="descripcion" class="form-control">{{ $subtema->descripcion }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="imagen" class="form-label">Imagen</label>
                                                        <input type="file" name="imagen" accept="image/*"
                                                            class="form-control">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Guardar
                                                        Cambios</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <!-- Evaluaciones -->
                <div class="tab-pane fade" id="tab-evaluaciones">
                    <h3>Evaluaciones</h3>
                    @if (auth()->user()->hasRole('Docente'))
                        <div class="mb-3">
                            <a href="{{ route('CrearEvaluacion', [$cursos->id]) }}"
                                class="btn btn-success btn-sm">Nueva Evaluación</a>
                            <a href="{{ route('evaluacionesEliminadas', [$cursos->id]) }}"
                                class="btn btn-warning btn-sm">Evaluaciones Eliminadas</a>
                        </div>
                    @endif
                    @forelse ($evaluaciones as $evaluacion)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>{{ $evaluacion->titulo_evaluacion }}</h5>
                                <p>Creado: {{ $evaluacion->fecha_habilitacion }} | Vence:
                                    {{ $evaluacion->fecha_vencimiento }}</p>
                                <a href="{{ route('VerEvaluacion', [$evaluacion->id]) }}"
                                    class="btn btn-primary btn-sm">Ir a Evaluación</a>
                                @if (auth()->user()->hasRole('Docente'))
                                    <a href="{{ route('editarEvaluacion', $evaluacion->id) }}"
                                        class="btn btn-info btn-sm">Editar</a>
                                    <a href="{{ route('quitarEvaluacion', $evaluacion->id) }}"
                                        class="btn btn-danger btn-sm" onclick="mostrarAdvertencia(event)">Eliminar</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>No hay evaluaciones asignadas.</p>
                    @endforelse
                </div>

                <!-- Foros -->
                <div class="tab-pane fade" id="tab-foros">
                    <h3>Foros</h3>
                    @if (auth()->user()->hasRole('Docente'))
                        <div class="mb-3">
                            <a href="{{ route('CrearForo', [$cursos->id]) }}" class="btn btn-success btn-sm">Nuevo
                                Foro</a>
                            <a href="{{ route('forosE', [$cursos->id]) }}" class="btn btn-warning btn-sm">Foros
                                Eliminados</a>
                        </div>
                    @endif
                    @forelse ($foros as $foro)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>{{ $foro->nombreForo }}</h5>
                                <p>Finaliza: {{ $foro->fechaFin }}</p>
                                <a href="{{ route('foro', [$foro->id]) }}" class="btn btn-primary btn-sm">Ir a
                                    Foro</a>
                                @if (auth()->user()->hasRole('Docente'))
                                    <a href="{{ route('EditarForo', $foro->id) }}"
                                        class="btn btn-info btn-sm">Editar</a>
                                    <a href="{{ route('quitarForo', $foro->id) }}" class="btn btn-danger btn-sm"
                                        onclick="mostrarAdvertencia(event)">Eliminar</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>No hay foros creados.</p>
                    @endforelse
                </div>

                <!-- Recursos -->
                <div class="tab-pane fade" id="tab-recursos">
                    <h3>Recursos Globales</h3>
                    @if (auth()->user()->hasRole('Docente'))
                        <div class="mb-3">
                            <a href="{{ route('CrearRecursos', [$cursos->id]) }}"
                                class="btn btn-success btn-sm">Nuevo Recurso</a>
                            <a href="{{ route('ListaRecursosEliminados', [$cursos->id]) }}"
                                class="btn btn-warning btn-sm">Recursos Eliminados</a>
                        </div>
                    @endif
                    @forelse ($recursos as $recurso)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>{{ $recurso->nombreRecurso }}</h5>
                                <p>{!! $recurso->descripcionRecursos !!}</p>
                                @if ($recurso->archivoRecurso)
                                    <a href="{{ asset('storage/' . $recurso->archivoRecurso) }}"
                                        class="btn btn-primary btn-sm">Ver Recurso</a>
                                @endif
                                @if (auth()->user()->hasRole('Docente'))
                                    <a href="{{ route('editarRecursos', $recurso->id) }}"
                                        class="btn btn-info btn-sm">Editar</a>
                                    <a href="{{ route('quitarRecurso', $recurso->id) }}"
                                        class="btn btn-danger btn-sm" onclick="mostrarAdvertencia(event)">Eliminar</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p>No hay recursos creados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

