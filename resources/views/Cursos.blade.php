@section('titulo')
    {{ $cursos->nombreCurso }}
@endsection






<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle con JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



@section('contentup')
    <div class="container-fluid">
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#course-info"
            aria-expanded="true" aria-controls="course-info">
            <i class="fa fa-chevron-up"></i>
            Ocultar
        </button>

        <div id="course-info" class="collapse show">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <h1 class="mb-3">CURSO {{ $cursos->nombreCurso }}</h1>
                            <h2 class="card-title text-muted mb-3">
                                Docente:
                                <a href="{{ route('perfil', ['id' => $cursos->docente->id]) }}"
                                    class="text-decoration-none">
                                    {{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}
                                </a>
                            </h2>

                            <!-- Información del curso -->
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title text-muted mb-2">Estado: {{ $cursos->estado }}</h4>
                                    <h4 class="card-title text-muted mb-2">Tipo: {{ $cursos->tipo }}</h4>

                                    <h2 class="mt-3">Descripción</h2>
                                    <p class="card-title text-muted mb-4">{{ $cursos->descripcionC }}</p>

                                    <!-- Botones de acción -->
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <a class="btn btn-info btn-sm" href="{{ route('listacurso', [$cursos->id]) }}">
                                            <i class="fas fa-user"></i> Ver Participantes
                                        </a>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalHorario">
                                            <i class="fa fa-calendar"></i> Ver Horarios
                                        </button>

                                        <!-- Dropdown para acciones adicionales -->
                                        @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                            <div class="dropdown">
                                                <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Más Acciones
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modalCrearHorario">
                                                            <i class="fas fa-calendar-plus"></i> Crear Horarios
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('asistencias', [$cursos->id]) }}">
                                                            <i class="fas fa-check"></i> Dar Asistencia
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#qrModal">
                                                            <i class="fas fa-qrcode"></i> Generar Código QR
                                                        </a>
                                                    </li>
                                                    @if ($cursos->docente_id == auth()->user()->id)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('repF', [$cursos->id]) }}"
                                                                onclick="mostrarAdvertencia2(event)">
                                                                <i class="fas fa-list"></i> Calificaciones
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('editarCurso', [$cursos->id]) }}">
                                                                <i class="fas fa-edit"></i> Editar Curso
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()->hasRole('Administrador') && !empty($cursos->archivoContenidodelCurso))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}">
                                                                <i class="fas fa-file"></i> Ver Plan Del Curso
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif

                                        <a href="{{ route('historialAsistencias', [$cursos->id]) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-list"></i> Ver Asistencias
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Horarios -->
    <div class="modal fade" id="modalHorario" tabindex="-1" aria-labelledby="modalHorarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHorarioLabel">Lista de Horarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
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
                                    <td>{{ Carbon\Carbon::parse($horario->horario->hora_inicio)->format('h:i A') }}</td>
                                    <td>{{ Carbon\Carbon::parse($horario->horario->hora_fin)->format('h:i A') }}</td>
                                    @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                        <td class="flex">
                                            <button class="btn btn-sm btn-warning  btn-editar-horario"
                                                data-id="{{ $horario->id }}" data-dia="{{ $horario->horario->dia }}"
                                                data-hora-inicio="{{ $horario->horario->hora_inicio }}"
                                                data-hora-fin="{{ $horario->horario->hora_fin }}" data-bs-toggle="modal"
                                                data-bs-target="#modalEditarHorario">
                                                Editar
                                            </button>
                                            @if ($horario->trashed())
                                                <form action="{{ route('horarios.restore', ['id' => $horario->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas restaurar este horario?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                                                </form>
                                            @else
                                                <form action="{{ route('horarios.delete', ['id' => $horario->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este horario?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de QR -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Código QR para Inscribirte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $qrCode }}" alt="QR Code" class="img-fluid mb-3">
                    <a href="{{ $qrCode }}" download="codigo_qr_curso.png" class="btn btn-success">
                        Descargar Código QR
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCrearHorario" tabindex="-1" aria-labelledby="modalCrearHorarioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('horarios.store') }}" id="formCrearHorario" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCrearHorarioLabel">Agregar
                            Horario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="curso_id" id="curso_id" value="{{ $cursos->id }}">
                        <div class="form-group">
                            <label for="dia">Día</label>
                            <select name="dia" id="dia" class="form-control">
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
                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Edición (fuera del bucle) -->
    <div class="modal fade" id="modalEditarHorario" tabindex="-1" aria-labelledby="modalEditarHorarioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarHorarioLabel">Editar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarHorario" action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="edit_dia" class="form-label">Día</label>
                            <select name="dia" id="edit_dia" class="form-control" required>
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miércoles">Miércoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sábado">Sábado</option>
                                <option value="domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" id="edit_hora_inicio" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="edit_hora_fin" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para cambiar el ícono del botón de collapse -->
    <script>
        document.getElementById('course-info').addEventListener('show.bs.collapse', function() {
            document.querySelector('[data-bs-target="#course-info"] i').className = 'fa fa-chevron-up';
        });

        document.getElementById('course-info').addEventListener('hide.bs.collapse', function() {
            document.querySelector('[data-bs-target="#course-info"] i').className = 'fa fa-chevron-down';
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Captura el evento de clic en los botones de editar
            document.querySelectorAll('.btn-editar-horario').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtén los datos del horario desde los atributos data-*
                    const id = button.getAttribute('data-id');
                    const dia = button.getAttribute('data-dia');
                    const horaInicio = button.getAttribute('data-hora-inicio');
                    const horaFin = button.getAttribute('data-hora-fin');

                    // Asigna los valores al modal
                    document.getElementById('edit_dia').value = dia;
                    document.getElementById('edit_hora_inicio').value = horaInicio;
                    document.getElementById('edit_hora_fin').value = horaFin;

                    // Actualiza el action del formulario con la ruta correcta
                    const form = document.getElementById('formEditarHorario');
                    form.action = "{{ route('horarios.update', '') }}/" + id;
                });
            });
        });
    </script>

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
@if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
    @include('cursos.cursos_docente')
@elseif (auth()->user()->hasRole('Estudiante') && $inscritos[0] == auth()->user()->id)
    @section('nav')
    <ul class="navbar-nav">
        @foreach ($temas as $index => $tema)
            @php
                // Verificar si el tema está desbloqueado
                $estaDesbloqueado = true;

                // Verificamos todos los temas previos
                for ($i = 0; $i < $index; $i++) {
                    $prevTema = $temas[$i];
                    if (!$prevTema->estaDesbloqueado($inscritos2)) {
                        $estaDesbloqueado = false;
                        break;
                    }
                }
            @endphp

            <li class="nav-item dropdown">
                @if ($estaDesbloqueado || auth()->user()->hasRole('Docente'))
                    <!-- Tema desbloqueado -->
                    <a class="nav-link dropdown-toggle" href="#" id="tema-{{ $tema->id }}-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $tema->titulo_tema }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="tema-{{ $tema->id }}-dropdown">
                        @foreach ($tema->subtemas as $subtema)
                            @php
                                $desbloqueado = $subtema->estaDesbloqueado($inscritos2->id);
                            @endphp

                            @if ($desbloqueado || auth()->user()->hasRole('Docente'))
                                <li>
                                    <a class="dropdown-item" href="#subtema-{{ $subtema->id }}">
                                        {{ $subtema->titulo_subtema }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item disabled" href="#" aria-disabled="true">
                                        {{ $subtema->titulo_subtema }} <i class="fas fa-lock"></i>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <!-- Tema bloqueado -->
                    <a class="nav-link disabled" href="#" aria-disabled="true">
                        {{ $tema->titulo_tema }} <i class="fas fa-lock"></i>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
    @endsection
    @include('cursos.cursos_estudiante')
@else
    <div class="card shadow">
        <div class="card-body text-center">
            <h3>No tienes acceso a este curso.</h3>
            <a href="{{ route('Inicio') }}" class="btn btn-primary">Volver a Inicio</a>
        </div>
    </div>
@endif



    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                html: `
                <ul style='text-align: left;'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            });
        </script>
    @endif





@endsection

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
@include('layout')
