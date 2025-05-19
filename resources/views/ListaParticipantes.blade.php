@section('titulo')
    Lista de Paticipantes {{ $cursos->nombreCurso }}
@endsection




@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('Curso', ['id' => $cursos->id]) }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div class="btn-group">
                    @if (auth()->user()->id == $cursos->docente_id || auth()->user()->hasRole('Administrador'))
                    <a class="btn btn-instagram" href="{{ route('listaretirados', $cursos->id) }}">Lista Retirados</a>
                    @if ($cursos->tipo == 'congreso')

                    <a class="btn btn-info" href="{{ route('certificadosCongreso.generar', $cursos->id) }}">Generar
                        Certificado</a>
                    @endif
                    <a class="btn btn-success" href="{{ route('lista', $cursos->id) }}">Descargar Lista</a>
                    @endif
                </div>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar alumno...">
            </div>
        </div>

        <!-- Tabla de alumnos -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Nro</th>
                        <th scope="col">Nombre y Apellidos</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inscritos as $inscrito)
                        @if ($inscrito->cursos_id == $cursos->id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $inscrito->estudiantes->name ?? 'Estudiante Eliminado' }}
                                    {{ $inscrito->estudiantes->lastname1 ?? '' }}
                                    {{ $inscrito->estudiantes->lastname2 ?? '' }}
                                    @role('Administrador')
                                    @if ($cursos->tipo == 'curso')


                                    @if ($inscrito->pago_completado == true)
                                    @else
                                        (Pago en Revision)
                                    @endif
                                    @endif

                                    @endrole
                                </td>
                                <td>{{ $inscrito->estudiantes->Celular ?? '' }}</td>
                                <td>
                                    <div class="btn-group">
                                         <a class="btn  btn-info"
                                            href="{{ route('perfil', [$inscrito->estudiantes->id]) }}"><i class="fa fa-eye"></i></a>


                                        @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Administrador'))
                                            <a class="btn btn-sm btn-danger" href="{{ route('quitar', [$inscrito->id]) }}"
                                                onclick="mostrarAdvertencia(event)">
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                            @if ($cursos->tipo == 'congreso')
                                            <a class="btn btn-sm btn-success" href="{{ route('certificadosCongreso.generar.admin', [encrypt($inscrito->id)]) }}"
                                                >
                                                <i class="bi bi-bi-card-heading"></i>
                                                @if (!isset($inscrito->certificado))
                                                Generar Certificado
                                                @else
                                                Reenviar Correo de Certificado
                                                @endif
                                            </a>
                                            @endif
                                            @if ($cursos->tipo = 'curso')
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('boletin', [$inscrito->id]) }}">
                                                    <i class="bi bi-file-earmark-text"></i> Ver Boletín
                                                </a>
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('verBoletin2', [$inscrito->id]) }}">
                                                    <i class="bi bi-file-earmark-check"></i> Ver Calificaciones Finales
                                                </a>
                                            @endif

                                        @endif


                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <h4>No hay alumnos inscritos</h4>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // Búsqueda en tiempo real
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('tbody tr').each(function() {
                    $(this).toggle($(this).text().toLowerCase().includes(searchText));
                });
            });

            // Alternar estado de pago
            $('.updateButton').click(function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                var pagoCompletadoInput = $('#pago_completado' + id);
                pagoCompletadoInput.val(pagoCompletadoInput.val() === 'true' ? 'false' : 'true');
                $('#paymentForm' + id).submit();
            });
        });

        // Advertencia antes de eliminar inscripción
        function mostrarAdvertencia(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción retirará al estudiante. ¿Deseas continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.getAttribute('href');
                }
            });
        }
    </script>
@endsection



@include('layout')
