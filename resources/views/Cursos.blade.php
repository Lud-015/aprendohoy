@section('titulo')
    {{ $cursos->nombreCurso }}
@endsection






<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle con JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



@section('contentup')
    <div class="container-fluid my-4">
        <!-- Collapsible Section Toggle -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">CURSO {{ $cursos->nombreCurso }}</h1>
            <button class="btn btn-outline-primary collapse-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#course-info" aria-expanded="true" aria-controls="course-info">
                <i class="fa fa-chevron-up me-1"></i>
                <span class="d-none d-sm-inline toggle-text">Ocultar</span>
            </button>
        </div>

        <!-- Main Course Content -->
        <div id="course-info" class="collapse show">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <!-- Teacher Information -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded-circle p-3 me-3">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0">Docente</p>
                            <h4 class="mb-0">
                                <a href="{{ route('perfil', ['id' => $cursos->docente->id]) }}"
                                    class="text-decoration-none">
                                    {{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}
                                </a>
                            </h4>
                        </div>
                    </div>

                    <!-- Course Status & Info -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Estado
                                    </h5>
                                    <p class="card-text">
                                        <span
                                            class="badge bg-{{ $cursos->estado === 'Activo' ? 'success' : ($cursos->estado === 'Certificado Disponible' ? 'primary' : 'secondary') }} px-3 py-2">
                                            {{ $cursos->estado }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-tags text-primary me-2"></i>Tipo
                                    </h5>
                                    <p class="card-text">
                                        <span class="badge bg-info px-3 py-2">{{ $cursos->tipo }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="card border-0 bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-align-left text-primary me-2"></i>Descripción
                            </h5>
                            <p class="card-text">{{ $cursos->descripcionC }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <a class="btn btn-primary" href="{{ route('listacurso', [$cursos->id]) }}">
                            <i class="fas fa-users me-2"></i> Participantes
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHorario">
                            <i class="fa fa-calendar me-2"></i> Horarios
                        </button>

                        <a href="{{ route('historialAsistencias', [$cursos->id]) }}" class="btn btn-primary">
                            <i class="fas fa-clipboard-list me-2"></i> Asistencias
                        </a>

                        <!-- Admin/Teacher Actions -->
                        @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog me-2"></i> Gestionar Curso
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modalCrearHorario">
                                            <i class="fas fa-calendar-plus text-primary me-2"></i> Crear Horarios
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('asistencias', [$cursos->id]) }}">
                                            <i class="fas fa-check text-success me-2"></i> Dar Asistencia
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#qrModal">
                                            <i class="fas fa-qrcode text-dark me-2"></i> Generar Código QR
                                        </a>
                                    </li>

                                    @if ($cursos->docente_id == auth()->user()->id)
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('repF', [$cursos->id]) }}"
                                                onclick="mostrarAdvertencia2(event)">
                                                <i class="fas fa-star text-warning me-2"></i> Calificaciones
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('editarCurso', [$cursos->id]) }}">
                                                <i class="fas fa-edit text-info me-2"></i> Editar Curso
                                            </a>
                                        </li>
                                    @endif

                                    @if (auth()->user()->hasRole('Administrador') && !empty($cursos->archivoContenidodelCurso))
                                        <li>
                                            <a class="dropdown-item py-2"
                                                href="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}">
                                                <i class="fas fa-file-pdf text-danger me-2"></i> Ver Plan Del Curso
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Certificate Options -->
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    @if ($cursos->estado === 'Certificado Disponible')
                                        <li>
                                            <button type="button" class="dropdown-item py-2" data-bs-toggle="modal"
                                                data-bs-target="#certificadoModal">
                                                <i class="fas fa-certificate text-warning me-2"></i> Obtener Certificado
                                            </button>
                                        </li>
                                    @endif

                                    @if ($cursos->estado === 'Activo')
                                        <li>
                                            <form action="{{ route('cursos.activarCertificados', ['id' => $cursos->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item py-2">
                                                    <i class="fas fa-certificate text-success me-2"></i> Activar
                                                    Certificados
                                                </button>
                                            </form>
                                        </li>
                                    @endif

                                    <!-- Admin-only Certificate Template Options -->
                                    @if (auth()->user()->hasRole('Administrador'))
                                        @if (!isset($template))
                                            <li>
                                                <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modalCertificado">
                                                    <i class="fas fa-file-upload text-primary me-2"></i> Subir Plantilla de
                                                    Certificado
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarCertificado">
                                                    <i class="fas fa-edit text-primary me-2"></i> Actualizar Plantilla de
                                                    Certificado
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="certificadoModal" tabindex="-1" aria-labelledby="certificadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificadoModalLabel">
                        Descarga tu Certificado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    @if ($cursos->estado === 'Certificado Disponible')
                        <h3>¡Descarga tu certificado antes de la medianoche!
                        </h3>
                        <div class="text-center mt-4 mb-4">
                            {{ QrCode::size(150)->generate(route('certificados.obtener', ['id' => encrypt($cursos->id)])) }}
                            <p class="mt-3">
                                <a href="#"
                                    onclick="copiarAlPortapapeles('{{ route('certificados.obtener', ['id' => encrypt($cursos->id)]) }}')"
                                    class="btn btn-success">
                                    Copiar enlace del certificado
                                </a>
                            </p>
                        </div>
                        <script>
                            async function copiarAlPortapapeles(url) {
                                try {
                                    await navigator.clipboard.writeText(url);
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Enlace copiado!',
                                        text: 'El enlace del certificado se ha copiado al portapapeles.',
                                        confirmButtonText: 'Aceptar',
                                        timer: 3000,
                                        timerProgressBar: true,
                                    });
                                } catch (err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'No se pudo copiar el enlace. Inténtalo de nuevo.',
                                        confirmButtonText: 'Aceptar',
                                    });
                                }
                            }
                        </script>
                    @elseif($cursos->estado === 'Expirado')
                        <p>El tiempo para obtener el certificado ha
                            expirado.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para editar plantilla -->

    <div class="modal fade" id="modalCertificado" tabindex="-1" aria-labelledby="modalCertificadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCertificadoLabel">Subir Plantilla Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('certificates.store', $cursos->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <label class="block text-sm font-medium mt-2">Seleccionar Imagen Para La Parte Frontal del
                            Certificado</label>
                        <input type="file" name="template_front" class="w-full border rounded px-3 py-2" required>
                        <label class="block text-sm font-medium mt-2">Seleccionar Imagen Para La Parte Trasera del
                            Certificado</label>
                        <input type="file" name="template_back" class="w-full border rounded px-3 py-2" required>
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                Subir
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCertificado" tabindex="-1" aria-labelledby="modalEditarCertificadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarCertificadoLabel">Actualizar Plantilla de Certificado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('certificates.update', $cursos->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Mostrar imagen actual si existe -->
                        <label class="block text-sm font-medium mt-2">Seleccionar Imagen Para La Parte Frontal del
                            Certificado</label>
                        <input type="file" name="template_front" class="w-full border rounded px-3 py-2" required>

                        <label class="block text-sm font-medium mt-2">Seleccionar Imagen Para La Parte Trasera del
                            Certificado</label>
                        <input type="file" name="template_back" class="w-full border rounded px-3 py-2" required>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success">Restaurar</button>
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
    @elseif (auth()->user()->hasRole('Estudiante') && $inscritos[0] == auth()->user()->id)
        @section('nav')
            <ul class="navbar-nav">
                @foreach ($temas as $index => $tema)
                    @php
                        // Verificar si el tema está desbloqueado para el estudiante
                        $estaDesbloqueado =
                            auth()->user()->hasRole('Docente') || $tema->estaDesbloqueado($inscritos2->id);
                    @endphp

                    <li class="nav-item dropdown">
                        @if ($estaDesbloqueado)
                            <!-- Tema desbloqueado -->
                            <a class="nav-link dropdown-toggle" href="#" id="tema-{{ $tema->id }}-dropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $tema->titulo_tema }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tema-{{ $tema->id }}-dropdown">
                                @foreach ($tema->subtemas as $subtema)
                                    @php
                                        // Verificar si el subtema está desbloqueado para el estudiante
                                        $desbloqueado =
                                            auth()->user()->hasRole('Docente') ||
                                            $subtema->estaDesbloqueado($inscritos2->id);
                                    @endphp

                                    @if ($desbloqueado)
                                        <!-- Subtema desbloqueado -->
                                        <li>
                                            <a class="dropdown-item" href="#subtema-{{ $subtema->id }}"
                                                data-bs-toggle="tab">
                                                {{ $subtema->titulo_subtema }}
                                            </a>
                                        </li>
                                    @else
                                        <!-- Subtema bloqueado -->
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
                                            $estaDesbloqueado =
                                                auth()->user()->hasRole('Docente') ||
                                                $tema->estaDesbloqueado($inscritos2->id);

                                        @endphp


                                        <li class="nav-item" role="presentation">
                                            @if ($estaDesbloqueado || auth()->user()->hasRole('Docente'))
                                                <!-- Tema desbloqueado -->
                                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                    id="tema-{{ $tema->id }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#tema-{{ $tema->id }}" type="button"
                                                    role="tab" aria-controls="tema-{{ $tema->id }}"
                                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                    {{ $tema->titulo_tema }}
                                                </button>
                                            @else
                                                <button class="nav-link disabled" id="tema-{{ $tema->id }}-tab"
                                                    type="button" role="tab" aria-disabled="true"
                                                    data-bs-toggle="popover" data-bs-trigger="hover focus"
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
                                                        <img class="img-fluid" src="{{ $tema->imagen }}"
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
                                                        <div class="collapse"
                                                            id="descripcionTema-{{ $tema->id }}">
                                                            <div class="card card-body">
                                                                {{ $tema->descripcion }}
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="accordion" id="subtemasAccordion-{{ $tema->id }}">
                                                        @foreach ($tema->subtemas as $subtemaIndex => $subtema)
                                                            @php
                                                                $desbloqueado = $subtema->estaDesbloqueado(
                                                                    $inscritos2->id,
                                                                );
                                                            @endphp

                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="subtemaHeading-{{ $subtema->id }} {{ $subtema->estaDesbloqueado($inscritos2->id) }}">
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
                                                                                <button class="btn btn-link"
                                                                                    type="button"
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
                                                                                                    <h5>NO HAY RECURSOS
                                                                                                        CREADOS
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
                                                                                    <button
                                                                                        class="accordion-button collapsed"
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
                                                                                                <p class="text-light">
                                                                                                    Entrega
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
                                                                                                                inscrito en
                                                                                                                este
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
                                                                                                                inscrito en
                                                                                                                este
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
                                                                                                    <div
                                                                                                        class="card-body">
                                                                                                        <h5>NO HAY
                                                                                                            ACTIVIDADES
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
                                            class="btn btn-danger btn-sm"
                                            onclick="mostrarAdvertencia(event)">Eliminar</a>
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
                                            class="btn btn-danger btn-sm"
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
<!-- Bootstrap JS (con Popper.js incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function copiarAlPortapapeles(url) {
        // Crear un input temporal
        const inputTemp = document.createElement('input');
        inputTemp.value = url;
        document.body.appendChild(inputTemp);

        // Seleccionar el texto del input
        inputTemp.select();
        inputTemp.setSelectionRange(0, 99999); // Para dispositivos móviles

        // Copiar el texto al portapapeles
        document.execCommand('copy');

        // Eliminar el input temporal
        document.body.removeChild(inputTemp);

        // Mostrar mensaje con SweetAlert
        Swal.fire({
            icon: 'success',
            title: '¡Enlace copiado!',
            text: 'El enlace del certificado se ha copiado al portapapeles.',
            confirmButtonText: 'Aceptar',
            timer: 3000, // Cerrar automáticamente después de 3 segundos
            timerProgressBar: true, // Mostrar barra de progreso
        });
    }
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
    document.addEventListener('DOMContentLoaded', function() {
        const collapseButton = document.querySelector('.collapse-toggle');
        const toggleText = document.querySelector('.toggle-text');
        const collapseIcon = document.querySelector('.collapse-toggle i');

        collapseButton.addEventListener('click', function() {
            if (toggleText.textContent === 'Ocultar') {
                toggleText.textContent = 'Mostrar';
                collapseIcon.classList.remove('fa-chevron-up');
                collapseIcon.classList.add('fa-chevron-down');
            } else {
                toggleText.textContent = 'Ocultar';
                collapseIcon.classList.remove('fa-chevron-down');
                collapseIcon.classList.add('fa-chevron-up');
            }
        });
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('.collapse-toggle');
        const toggleText = document.querySelector('.toggle-text');
        const toggleIcon = toggleButton.querySelector('i');

        // Initialize Bootstrap collapse events
        const courseInfo = document.getElementById('course-info');
        courseInfo.addEventListener('hide.bs.collapse', function() {
            toggleText.textContent = 'Mostrar';
            toggleIcon.classList.remove('fa-chevron-up');
            toggleIcon.classList.add('fa-chevron-down');
        });

        courseInfo.addEventListener('show.bs.collapse', function() {
            toggleText.textContent = 'Ocultar';
            toggleIcon.classList.remove('fa-chevron-down');
            toggleIcon.classList.add('fa-chevron-up');
        });
    });
</script>
@include('layout')
