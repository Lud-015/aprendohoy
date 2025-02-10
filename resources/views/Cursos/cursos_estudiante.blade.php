<div class="col-11 my-2 progress-wrapper">
    <div class="progress-info">
        <div class="progress-percentage">
            <span class="text-sm font-weight-bold"> PROGRESO DEL CURSO-
                {{ $cursos->calcularProgreso($inscritos2->id) }}%</span>
        </div>
    </div>
    <div class="progress">
        <div class="progress-bar bg-primary" role="progressbar"
            aria-valuenow="{{ $cursos->calcularProgreso($inscritos2->id) }}
"
            aria-valuemin="{{ $cursos->calcularProgreso($inscritos2->id) }}" aria-valuemax="100"></div>
    </div>
</div>


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
            <div class="tab-pane fade show active" id="tab-actividades">
                <div class="tab-pane fade show active" id="tab-actividades">
                    <div class="container">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="temasTabs" role="tablist">
                            @foreach ($temas as $index => $tema)
                                @php
                                    // Si es el primer tema, debe estar desbloqueado
                                    if ($index === 0) {
                                        $estaDesbloqueado = true;
                                    } else {
                                        $estaDesbloqueado = false;

                                        // Revisamos que todos los temas previos estén completados
                                        foreach (range(0, $index - 1) as $i) {
                                            $prevTema = $temas[$i];
                                            if (!$prevTema->estaDesbloqueado($inscritos2->id)) {
                                                $estaDesbloqueado = false;
                                                break;
                                            }
                                        }
                                    }
                                @endphp


                                <li class="nav-item" role="presentation">
                                    @if ($estaDesbloqueado || auth()->user()->hasRole('Docente'))
                                        <!-- Tema desbloqueado -->
                                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                            id="tema-{{ $tema->id }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#tema-{{ $tema->id }}" type="button" role="tab"
                                            aria-controls="tema-{{ $tema->id }}"
                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                            {{ $tema->titulo_tema }}
                                        </button>
                                    @else
                                        <button class="nav-link disabled" id="tema-{{ $tema->id }}-tab"
                                            type="button" role="tab" aria-disabled="true" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus"
                                            data-bs-content="Debes completar el tema anterior para desbloquear este."
                                            data-bs-placement="top">
                                            {{ $tema->titulo_tema }} <i class="fas fa-lock"></i>
                                            <!-- Ícono de bloqueo -->
                                        </button>
                                    @endif
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
                                                <img class="img-fluid" src="{{ asset('storage/' . $tema->imagen) }}"
                                                    alt="Imagen del tema">
                                            @endif

                                            <div class="my-3">
                                                <button class="btn btn-link" type="button" data-bs-toggle="collapse"
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


                                            <div class="accordion" id="subtemasAccordion-{{ $tema->id }}">
                                                @foreach ($tema->subtemas as $subtemaIndex => $subtema)
                                                    @php
                                                        $desbloqueado = $subtema->estaDesbloqueado($inscritos2->id);
                                                    @endphp

                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"
                                                            id="subtemaHeading-{{ $subtema->id }}">
                                                            @if (!$desbloqueado && auth()->user()->hasRole('Estudiante'))
                                                                <!-- Subtema bloqueado -->
                                                                <button class="accordion-button collapsed"
                                                                    type="button" disabled>
                                                                    {{ $subtema->titulo_subtema }} (Bloqueado)
                                                                </button>
                                                            @else
                                                                <!-- Subtema desbloqueado -->
                                                                <button
                                                                    class="accordion-button {{ $subtemaIndex === 0 ? '' : 'collapsed' }}"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#subtemaCollapse-{{ $subtema->id }}"
                                                                    aria-expanded="{{ $subtemaIndex === 0 ? 'true' : 'false' }}"
                                                                    aria-controls="subtemaCollapse-{{ $subtema->id }}">
                                                                    {{ $subtema->titulo_subtema }}
                                                                </button>
                                                            @endif
                                                        </h2>
                                                        @if ($desbloqueado || auth()->user()->hasRole('Docente'))
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


                                                                    <div class="my-4">
                                                                        <h2>Recursos</h4>
                                                                    </div>

                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header"
                                                                            id="headingRecursos-{{ $subtema->id }}">
                                                                            <button class="accordion-button"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseRecursos-{{ $subtema->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapseRecursos-{{ $subtema->id }}">
                                                                                Recursos
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseRecursos-{{ $subtema->id }}"
                                                                            class="accordion-collapse collapse show"
                                                                            aria-labelledby="headingRecursos-{{ $subtema->id }}"
                                                                            data-bs-parent="#accordionSubtema-{{ $subtema->id }}">
                                                                            <div class="accordion-body">
                                                                                @forelse ($subtema->recursos as $recursosSubtemas)
                                                                                    <div class="card mb-3">
                                                                                        <div class="card-body">
                                                                                            <h5>{{ $recursosSubtemas->nombreRecurso }}
                                                                                            </h5>
                                                                                            @if (Str::contains($recursosSubtemas->descripcionRecursos, ['<iframe', '<video', '<img']))
                                                                                                <div
                                                                                                    class="ratio ratio-16x9">
                                                                                                    {!! $recursosSubtemas->descripcionRecursos !!}
                                                                                                </div>
                                                                                            @else
                                                                                                <p>{!! nl2br(e($recursosSubtemas->descripcionRecursos)) !!}
                                                                                                </p>
                                                                                            @endif
                                                                                            @if ($recursosSubtemas->archivoRecurso)
                                                                                                <a href="{{ asset('storage/' . $recursosSubtemas->archivoRecurso) }}"
                                                                                                    class="btn btn-primary btn-sm">Ver
                                                                                                    Recurso</a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @empty
                                                                                    <div class="card mb-3">
                                                                                        <div class="card-body">
                                                                                            <h5>NO HAY RECURSOS CREADOS
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforelse
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Sección de Actividades -->
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header"
                                                                            id="headingActividades-{{ $subtema->id }}">
                                                                            <button class="accordion-button collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseActividades-{{ $subtema->id }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseActividades-{{ $subtema->id }}">
                                                                                Actividades
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseActividades-{{ $subtema->id }}"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingActividades-{{ $subtema->id }}"
                                                                            data-bs-parent="#accordionSubtema-{{ $subtema->id }}">
                                                                            <div class="accordion-body">
                                                                                <!-- Tareas del subtema -->
                                                                                @forelse ($subtema->tareas as $tarea)
                                                                                    <div class="my-4 mb-3">
                                                                                        <h2>{{ $tarea->titulo_tarea }}
                                                                                        </h2>
                                                                                        <p class="text-light">Entrega
                                                                                            Digital</p>
                                                                                        <p>Creado:
                                                                                            {{ $tarea->fecha_habilitacion }}
                                                                                            | Vence:
                                                                                            {{ $tarea->fecha_vencimiento }}
                                                                                        </p>
                                                                                        <div>
                                                                                            <a href="{{ route('VerTarea', $tarea->id) }}"
                                                                                                class="btn btn-primary btn-sm">Ver
                                                                                                Actividad</a>
                                                                                            @if (auth()->user()->hasRole('Estudiante'))
                                                                                                @if ($inscritos2->id != null)
                                                                                                    @if ($tarea->isCompletedByInscrito($inscritos2->id))
                                                                                                        <button
                                                                                                            class="btn btn-success btn-sm"
                                                                                                            disabled>
                                                                                                            <i
                                                                                                                class="fas fa-check"></i>
                                                                                                            Completado
                                                                                                        </button>
                                                                                                    @else
                                                                                                        <form
                                                                                                            method="POST"
                                                                                                            action="{{ route('tarea.completar', $tarea->id) }}">
                                                                                                            @csrf
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="inscritos_id"
                                                                                                                value="{{ $inscritos[0] }}">
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn btn-outline-success btn-sm">
                                                                                                                Marcar
                                                                                                                como
                                                                                                                completada
                                                                                                            </button>
                                                                                                        </form>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <p
                                                                                                        class="text-danger">
                                                                                                        No estás
                                                                                                        inscrito en este
                                                                                                        curso.</p>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @empty
                                                                                @endforelse

                                                                                <!-- Cuestionarios del subtema -->
                                                                                @forelse($subtema->cuestionarios as $cuestionario)
                                                                                    <div class="my-4 mb-3">
                                                                                        <h2>{{ $cuestionario->titulo_cuestionario }}
                                                                                        </h2>
                                                                                        <p class="text-light">
                                                                                            Cuestionario</p>
                                                                                        <p>Creado:
                                                                                            {{ $cuestionario->fecha_habilitacion }}
                                                                                            | Vence:
                                                                                            {{ $cuestionario->fecha_vencimiento }}
                                                                                        </p>
                                                                                        <div>
                                                                                            @if (auth()->user()->hasRole('Estudiante'))
                                                                                                @if ($inscritos2->id != null)
                                                                                                    @if ($cuestionario->isCompletedByInscrito($inscritos2->id))
                                                                                                        <button
                                                                                                            class="btn btn-success btn-sm"
                                                                                                            disabled>
                                                                                                            <i
                                                                                                                class="fas fa-check"></i>
                                                                                                            Completado
                                                                                                        </button>
                                                                                                    @else
                                                                                                        <form
                                                                                                            method="POST"
                                                                                                            action="{{ route('cuestionario.completar', $cuestionario->id) }}">
                                                                                                            @csrf
                                                                                                            <input
                                                                                                                type="hidden"
                                                                                                                name="inscritos_id"
                                                                                                                value="{{ $inscritos2->id }}">
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn btn-outline-success btn-sm">
                                                                                                                Marcar
                                                                                                                como
                                                                                                                completado
                                                                                                            </button>
                                                                                                        </form>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <p
                                                                                                        class="text-danger">
                                                                                                        No estás
                                                                                                        inscrito en este
                                                                                                        curso.</p>
                                                                                                @endif
                                                                                                <a href="{{ route('cuestionario.mostrar', $cuestionario->id) }}"
                                                                                                    class="btn btn-primary btn-sm">Responder</a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @empty
                                                                                    @if ($subtema->tareas = !null)
                                                                                    @else
                                                                                        <div class="card mb-3">
                                                                                            <div class="card-body">
                                                                                                <h5>NO HAY ACTIVIDADES
                                                                                                    CREADOS</h5>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforelse
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            @endforeach




                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluaciones -->
            <div class="tab-pane fade" id="tab-evaluaciones">
                <h3>Evaluaciones</h3>
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
                @forelse ($foros as $foro)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>{{ $foro->nombreForo }}</h5>
                            <p>Finaliza: {{ $foro->fechaFin }}</p>
                            <a href="{{ route('foro', [$foro->id]) }}" class="btn btn-primary btn-sm">Ir a
                                Foro</a>
                            @if (auth()->user()->hasRole('Docente'))
                                <a href="{{ route('EditarForo', $foro->id) }}" class="btn btn-info btn-sm">Editar</a>
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
                                <a href="{{ route('quitarRecurso', $recurso->id) }}" class="btn btn-danger btn-sm"
                                    onclick="mostrarAdvertencia(event)">Eliminar</a>
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
