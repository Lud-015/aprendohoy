@section('titulo')
    {{ $cursos->nombreCurso }}
@endsection


@php
    use BaconQrCode\Encoder\QrCode;
@endphp


@section('contentup')
    <div class="container-fluid my-4">
        <!-- Collapsible Section Toggle -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">{{ $cursos->nombreCurso }}</h1>
            <button class="btn btn-outline-primary collapse-toggle" type="button" data-bs-toggle="collapse"
                data-bs-target="#course-info" aria-expanded="true" aria-controls="course-info">
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

                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('editarCurso', [$cursos->id]) }}">
                                                <i class="fas fa-edit text-info me-2"></i> Editar Curso
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Certificate Options -->
                                    @if ($cursos->tipo === 'congreso')
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
                {{-- <div class="modal-body text-center">
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
                </div> --}}
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
    @if((auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id) ||
        (auth()->user()->hasRole('Estudiante') && $inscritos))

        @section('nav')
            <!-- Nav común para ambos roles -->
            @forelse ($temas as $index => $tema)
                @php
                    $estaDesbloqueado = auth()->user()->hasRole('Docente') ||
                                      (auth()->user()->hasRole('Estudiante') && $tema->estaDesbloqueado($inscritos2->id));
                @endphp

                <li class="nav-link">
                    @if($estaDesbloqueado)
                        <!-- Tema desbloqueado -->
                        <a class="nav-link dropdown-toggle" href="#" id="tema-{{ $tema->id }}-dropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $tema->titulo_tema }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tema-{{ $tema->id }}-dropdown">
                            @foreach($tema->subtemas as $subtema)
                                @php
                                    $desbloqueado = auth()->user()->hasRole('Docente') ||
                                                   (auth()->user()->hasRole('Estudiante') && $subtema->estaDesbloqueado($inscritos2->id));
                                @endphp

                                @if($desbloqueado)
                                    <li>
                                        <a class="dropdown-item" href="#subtema-{{ $subtema->id }}"
                                           data-bs-toggle="tab" data-bs-auto-close="false">
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
            @empty
            @endforelse
        @endsection

        <div class="container-fluid py-4">
            <!-- Barra de progreso solo para estudiantes -->
            @if(auth()->user()->hasRole('Estudiante'))
            @if ($cursos->tipo == 'curso')
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold m-0">PROGRESO DEL CURSO</h5>
                                    <span class="badge bg-primary rounded-pill fs-6">{{ $cursos->calcularProgreso($inscritos2->id) }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{ $cursos->calcularProgreso($inscritos2->id) }}%;"
                                         aria-valuenow="{{ $cursos->calcularProgreso($inscritos2->id) }}"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif

            <!-- Contenido principal -->
            <div class="card shadow border-0 rounded-3 overflow-hidden">
                <!-- Pestañas de navegación -->
                <div class="card-header bg-white p-0 border-bottom">
                    <ul class="nav nav-tabs nav-fill" id="course-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-4 py-3" id="temario-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-actividades" type="button" role="tab"
                                    aria-controls="tab-actividades" aria-selected="true">
                                <i class="fas fa-list me-2"></i>Temario
                            </button>
                        </li>
                        @if($cursos->tipo == 'curso')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-4 py-3" id="evaluaciones-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab-evaluaciones" type="button" role="tab"
                                        aria-controls="tab-evaluaciones" aria-selected="false">
                                    <i class="fas fa-tasks me-2"></i>Evaluaciones
                                </button>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" id="foros-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-foros" type="button" role="tab" aria-controls="tab-foros"
                                    aria-selected="false">
                                <i class="fas fa-comments me-2"></i>Foros
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-4 py-3" id="recursos-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-recursos" type="button" role="tab"
                                    aria-controls="tab-recursos" aria-selected="false">
                                <i class="fas fa-book me-2"></i>Recursos Globales
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content" id="course-tab-content">
                        <!-- Contenido de las pestañas (común para ambos roles) -->
                        @include('partials.cursos.temario_tab')
                        @include('partials.cursos.evaluaciones_tab')
                        @include('partials.cursos.foros_tab')
                        @include('partials.cursos.recursos_tab')
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales (extraer a archivos parciales si son muchos) -->
        @include('partials.cursos.modals.agregar_tema')
        @include('partials.cursos.modals.agregar_subtema')
         <!-- ... otros modales ... -->

    @else
        <!-- Acceso denegado -->
        <div class="card shadow">
            <div class="card-body text-center">
                <h3>No tienes acceso a este curso.</h3>
                <a href="{{ route('Inicio') }}" class="btn btn-primary">Volver a Inicio</a>
            </div>
        </div>
    @endif

    @if($errors->any())
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
    document.addEventListener("DOMContentLoaded", function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
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
