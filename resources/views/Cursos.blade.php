@section('titulo')
    {{ $cursos->nombreCurso }}
@endsection



<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle con JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



@section('contentup')
    <!-- Estilos CSS -->
    <style>
        /* Estilo del botón */
        .btn-icon {
            background: linear-gradient(to right, #1A73E8, #33BFFF);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 0 15px 15px 0;
            /* Redondea solo la esquina derecha */
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: initial;
            right: 0;
            top: 20px;
            /* Ajusta según sea necesario */
            z-index: 1000;
            /* Asegura que esté por encima de otros elementos */
        }

        /* Tamaño del icono dentro del botón */
        .btn-icon i {
            font-size: 18px;
        }

        /* Estilo del contenedor de información del curso */
        .course-info {
            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            overflow: hidden;
        }

        /* Estado minimizado */
        .minimized {
            max-height: 0;
            opacity: 0;
        }

        /* Estado maximizado */
        .maximized {
            max-height: 1000px;
            /* Ajusta según la altura del contenido */
            opacity: 1;
        }
    </style>

    <div class="container-fluid">
        <!-- Botón para minimizar/maximizar -->
        <button class="btn-icon" id="toggle-button">
            <i class="fa fa-chevron-up"></i>
            Ocultar
        </button>

        <!-- Contenido del div -->
        <div id="course-info" class="course-info maximized">
            <div class="row">
                <div class="col-xl-12 ">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <h1 class="mb-0">CURSO {{ $cursos->nombreCurso }}</h1>
                            <h2 class="mb-0">INFORMACIÓN DEL CURSO</h2>
                            <h2 class="card-title text-muted mb-0">Docente:
                                <a href="{{ route('perfil', ['id' => $cursos->docente->id]) }}">
                                    {{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}
                                </a>
                            </h2>
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title text-muted mb-0">Estado: {{ $cursos->estado }}</h4>

                                    <br>
                                    <h2>Descripcion</h2>
                                    <h4 class="card-title text-muted mb-0">{{ $cursos->descripcionC }}</h4>
                                    <p></p>
                                    <br><br>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalHorario">
                                        <i class="fa fa-calendar"></i>
                                        Ver Horarios
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalHorario" tabindex="-1"
                                        aria-labelledby="modalHorarioLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHorarioLabel">Lista de Horarios</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Día</th>
                                                                <th>Hora Inicio</th>
                                                                <th>Hora Fin</th>
                                                                @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                                                    <th>Acciones</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($horarios as $horario)
                                                                <tr>
                                                                    <td>{{ $horario->horario->dia }}</td>
                                                                    <td>{{ Carbon\Carbon::parse($horario->horario->hora_inicio)->format('h:i A') }}
                                                                    </td>
                                                                    <td>{{ Carbon\Carbon::parse($horario->horario->hora_fin)->format('h:i A') }}
                                                                    </td>
                                                                    @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                                                        <td>
                                                                            <button
                                                                                class="btn btn-warning btn-editar-horario"
                                                                                data-id="{{ $horario->horario->id }}"
                                                                                data-dia="{{ $horario->horario->dia }}"
                                                                                data-hora-inicio="{{ $horario->horario->hora_inicio }}"
                                                                                data-hora-fin="{{ $horario->horario->hora_fin }}"
                                                                                type="button">
                                                                                Editar
                                                                            </button>
                                                                        </td>
                                                                        <td>

                                                                            @if ($horario->trashed())
                                                                                <form
                                                                                    action="{{ route('horarios.restore', ['id' => $horario->id]) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('¿Estás seguro de que deseas restaurar este horario?');">
                                                                                    @csrf
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">Restaurar</button>
                                                                                </form>
                                                                            @else
                                                                                <form
                                                                                    action="{{ route('horarios.delete', ['id' => $horario->id]) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este horario?');">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Eliminar</button>
                                                                                </form>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="modalEditarHorario" tabindex="-1"
                                        aria-labelledby="modalEditarHorarioLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="formEditarHorario" method="POST"
                                                action="{{ route('horarios.update') }}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditarHorarioLabel">Editar Horario
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="horario_id" id="horario_id">
                                                        <div class="form-group">
                                                            <label for="edit_dia">Día</label>
                                                            <select name="dia" id="edit_dia" class="form-control"
                                                                required>
                                                                <option value="Lunes">Lunes</option>
                                                                <option value="Martes">Martes</option>
                                                                <option value="Miércoles">Miércoles</option>
                                                                <option value="Jueves">Jueves</option>
                                                                <option value="Viernes">Viernes</option>
                                                                <option value="Sábado">Sábado</option>
                                                                <option value="Domingo">Domingo</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit_hora_inicio">Hora de Inicio</label>
                                                            <input type="time" name="hora_inicio" id="edit_hora_inicio"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit_hora_fin">Hora de Fin</label>
                                                            <input type="time" name="hora_fin" id="edit_hora_fin"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar
                                                            Cambios</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>











                                    @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                        <!-- Botón para abrir el modal -->
                                        <button id="add-horario" class="mr-2 btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalCrearHorario">
                                            <i class="fas fa-calendar"></i>
                                            Crear Horarios
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalCrearHorario" tabindex="-1"
                                            aria-labelledby="modalCrearHorarioLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('horarios.store') }}" id="formCrearHorario"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalCrearHorarioLabel">Agregar
                                                                Horario</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="curso_id" id="curso_id"
                                                                value="{{ $cursos->id }}">
                                                            <div class="form-group">
                                                                <label for="dia">Día</label>
                                                                <select name="dia" id="dia"
                                                                    class="form-control">
                                                                    <option value="Lunes">Lunes</option>
                                                                    <option value="Martes">Martes</option>
                                                                    <option value="Miércoles">Miércoles</option>
                                                                    <option value="Jueves">Jueves</option>
                                                                    <option value="Viernes">Viernes</option>
                                                                    <option value="Sábado">Sábado</option>
                                                                    <option value="Domingo">Domingo</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="hora_inicio">Hora de Inicio</label>
                                                                <input type="time" name="hora_inicio" id="hora_inicio"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="hora_fin">Hora de Fin</label>
                                                                <input type="time" name="hora_fin" id="hora_fin"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($cursos->docente_id == auth()->user()->id)
                                            <a class="mr-2 btn btn-sm btn-info" href="{{ route('repF', [$cursos->id]) }}"
                                                onclick="mostrarAdvertencia2(event)"> <i class="fas fa-list"></i>
                                                Calificaciones</a>
                                            <a class="mr-2 btn btn-sm btn-info"
                                                href="{{ route('editarCurso', [$cursos->id]) }}"><i
                                                    class="fas fa-edit"></i> Editar Curso</a>
                                            <a class="mr-2 btn btn-sm btn-info"
                                                href="{{ route('asistencias', [$cursos->id]) }}"> <i
                                                    class="fas fa-check"></i> Dar Asistencia</a>
                                        @endif

                                        @if (auth()->user()->hasRole('Administrador') && !empty($cursos->archivoContenidodelCurso))
                                            <a class="mr-1 btn btn-sm btn-info"
                                                href="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}"> <i
                                                    class="fas fa-file"></i> Ver Plan Del Curso</a>
                                        @endif
                                    @endif
                                    <a class="mr-2 btn btn-sm btn-info" href="{{ route('listacurso', [$cursos->id]) }}">
                                        <i class="fas fa-user"></i>
                                        VerParticipantes</a>

                                    <a href="{{ route('historialAsistencias', [$cursos->id]) }}"
                                        class="btn btn-sm btn-info"> <i class="fas fa-list"></i> Ver asistencias</a>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Script JS -->
    <script>
        document.getElementById('toggle-button').addEventListener('click', function() {
            var courseInfo = document.getElementById('course-info');
            var icon = this.querySelector('i');

            if (courseInfo.classList.contains('minimized')) {
                courseInfo.classList.remove('minimized');
                courseInfo.classList.add('maximized');
                icon.className = 'fa fa-chevron-up';
                this.textContent = " Ocultar";
                this.prepend(icon);
            } else {
                courseInfo.classList.remove('maximized');
                courseInfo.classList.add('minimized');
                icon.className = 'fa fa-chevron-down';
                this.textContent = " Mostrar";
                this.prepend(icon);
            }
        });
    </script>
@endsection





@section('content')


    @if (
        (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id) ||
            auth()->user()->hasRole('Administrador') ||
            $inscritos[0] == auth()->user()->id)
        <div class="card shadow">
            <div class="card-body">
                <!-- Navegación simplificada -->
                <ul class="nav nav-tabs" id="course-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-actividades">Actividades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-evaluaciones">Evaluaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-foros">Foros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-recursos">Recursos</a>
                    </li>
                </ul>

                <div class="tab-content mt-4">
                    <!-- Actividades -->
                    <div class="tab-pane fade show active" id="tab-actividades">
                        <h3>Actividades</h3>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @if (auth()->user()->hasRole('Docente'))
                                @if (!$cursos->fecha_fin || \Carbon\Carbon::now() <= \Carbon\Carbon::parse($cursos->fecha_fin))
                                    <div>
                                        <a href="{{ route('CrearTareas', [$cursos->id]) }}"
                                            class="btn btn-success btn-sm">Nueva Tarea</a>
                                        <a href="{{ route('tareasEliminadas', [$cursos->id]) }}"
                                            class="btn btn-warning btn-sm">Tareas Eliminadas</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                        @forelse ($tareas as $tarea)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5>{{ $tarea->titulo_tarea }}</h5>
                                    <p>Creado: {{ $tarea->fecha_habilitacion }} | Vence: {{ $tarea->fecha_vencimiento }}
                                    </p>
                                    <div>
                                        @if ($tarea->tipo_tarea == 'cuestionario')
                                            <a href="{{ route('cuestionario', $tarea->id) }}"
                                                class="btn btn-primary btn-sm">Resolver Cuestionario</a>
                                        @else
                                            <a href="{{ route('VerTarea', [$tarea->id]) }}"
                                                class="btn btn-primary btn-sm">Ver Actividad</a>
                                        @endif
                                        @if (auth()->user()->hasRole('Docente'))
                                            <a href="{{ route('editarTarea', $tarea->id) }}"
                                                class="btn btn-info btn-sm">Editar</a>
                                            <a href="{{ route('quitarTarea', $tarea->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="mostrarAdvertencia(event)">Eliminar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No hay tareas asignadas.</p>
                        @endforelse
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
                        <h3>Recursos</h3>
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
    @else
        <div class="card shadow">
            <div class="card-body text-center">
                <h3>No tienes acceso a este curso.</h3>
                <a href="{{ route('Inicio') }}" class="btn btn-primary">Volver a Inicio</a>
            </div>
        </div>
    @endif





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-editar-horario').forEach(button => {
                button.addEventListener('click', function() {
                    // Obtener los datos del horario
                    const id = this.getAttribute('data-id');
                    const dia = this.getAttribute('data-dia');
                    const horaInicio = this.getAttribute('data-hora-inicio');
                    const horaFin = this.getAttribute('data-hora-fin');

                    // Establecer los valores en el formulario
                    document.getElementById('horario_id').value = id;
                    document.getElementById('edit_dia').value = dia;
                    document.getElementById('edit_hora_inicio').value = horaInicio;
                    document.getElementById('edit_hora_fin').value = horaFin;

                    // Cerrar el modal de lista usando jQuery
                    $('#modalHorario').modal('hide');

                    // Abrir el modal de edición
                    $('#modalEditarHorario').modal('show');
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addHorarioButton = document.getElementById('add-horario');
            if (addHorarioButton) {
                addHorarioButton.addEventListener('click', function() {
                    const template = document.getElementById('horario-template').innerHTML;
                    const container = document.getElementById('horarios-container');
                    container.insertAdjacentHTML('beforeend', template);
                });
            }

            const container = document.getElementById('horarios-container');
            if (container) {
                container.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-horario')) {
                        const horario = e.target.closest('.horario');
                        horario.remove();
                    }
                });
            }
        });
    </script>

    <script>
        function mostrarAdvertencia(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Quieres Eliminar Esta Actividad. ¿Estás seguro de que deseas continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige al usuario al enlace original
                    window.location.href = event.target.getAttribute('href');
                }
            });
        }

        function mostrarAdvertencia2(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Quieres Descargar Los Reportes actuales del cursos. ¿Estás seguro de que deseas continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige al usuario al enlace original
                    window.location.href = event.target.getAttribute('href');
                }
            });
        }
    </script>

@endsection
@include('layout')
