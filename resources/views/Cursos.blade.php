@section('titulo')
    {{ $cursos->nombreCurso }}
@endsection







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
                                {{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}
                            </h2>
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title text-muted mb-0">Estado: {{ $cursos->estado }}</h4>
                                    <h4 class="card-title text-muted mb-0">
                                        @foreach (json_decode($cursos->horarios->dias) as $dia)
                                            {{ $dia }}, DE {{ $cursos->horarios->hora_ini }} A
                                            {{ $cursos->horarios->hora_fin }}
                                            <br>
                                        @endforeach
                                    </h4>
                                    <br>
                                    <h2>Descripcion</h2>
                                    <h4 class="card-title text-muted mb-0">{{ $cursos->descripcionC }}</h4>
                                    <p></p>
                                    <br><br>
                                    @if ($cursos->docente_id == auth()->user()->id)
                                        <i class="fas fa-user"></i>
                                        <a class="mr-2" href="{{ route('listacurso', [$cursos->id]) }}"> Ver Participantes
                                        </a>
                                        <i class="fas fa-list"></i>
                                        <a class="mr-2" href="{{ route('repF', [$cursos->id]) }}"
                                            onclick="mostrarAdvertencia2(event)"> Calificaciones</a>
                                        <i class="fas fa-edit"></i>
                                        <a class="mr-2" href="{{ route('editarCurso', [$cursos->id]) }}"> Editar
                                            Curso</a>
                                        <i class="fas fa-check"></i>
                                        <a class="mr-2" href="{{ route('asistencias', [$cursos->id]) }}"> Dar
                                            Asistencia</a>
                                    @endif
                                    @if (auth()->user()->hasRole('Administrador'))
                                        <i class="fas fa-user"></i>
                                        <a class="mr-1" href="{{ route('listacurso', [$cursos->id]) }}"> Ver
                                            Participantes </a>
                                        <i class="fas fa-file"></i>
                                        <a class="mr-1"
                                            href="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}">Ver Plan Del
                                            Curso</a>
                                    @endif
                                    <i class="fas fa-list"></i>
                                    <a href="{{ route('historialAsistencias', [$cursos->id]) }}"> Ver asistencias</a>
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
    @if ((auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id) || auth()->user()->hasRole('Administrador') || $inscritos[0] == auth()->user()->id)
        <div class="card shadow">
            <div class="nav-wrapper ml-4 mr-4">
                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <!-- Actividades -->
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                            href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                            aria-selected="true"><i class="ni ni-archive-2"></i> Actividades</a>
                    </li>
                    <!-- Evaluaciones -->
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                            href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                            aria-selected="true"><i class="ni ni-trophy"></i> Evaluaciones</a>
                    </li>
                    <!-- Foros -->
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                            href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                            aria-selected="false"><i class="ni ni-chat-round"></i> Foros</a>
                    </li>
                    <!-- Recursos -->
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                            href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                            aria-selected="false"><i class="ni ni-collection"></i> Recursos</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <!-- Tareas Tab -->
                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                        aria-labelledby="tabs-icons-text-1-tab">
                        <div class="col-xl-12">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-2">Tareas</h3>
                                </div>
                                <div class="col text-right">
                                    @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                        @if ($cursos->fecha_fin && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($cursos->fecha_fin)))
                                            {{-- <p>El curso ha finalizado.</p> --}}
                                        @else
                                            <a href="{{ route('CrearTareas', [$cursos->id]) }}"
                                                class="btn btn-sm btn-success">Crear Tarea</a>
                                            <a href="{{ route('tareasEliminadas', [$cursos->id]) }}"
                                                class="btn btn-sm btn-warning">Tareas Eliminadas</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- Projects table -->

                                @forelse ($tareas->chunk(10) as $chunk)
                                    <!-- Dividir en chunks de 10 elementos -->
                                    @foreach ($chunk as $tarea)
                                        <div class="card pb-3 pt-3 col-xl-12">
                                            <br>
                                            <div class="row">
                                                <h3 class="col-8">{{ $tarea->titulo_tarea }}</h3>

                                                @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                                    @if ($tarea->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tarea->cursos->fecha_fin))
                                                    @else
                                                        @if ($tarea->tipo_tarea == 'cuestionario')
                                                            <a href="{{ route('cuestionario', $tarea->id) }}"
                                                                class="btn btn-sm btn-dribbble">Preguntas</a>
                                                        @endif
                                                        <a href="{{ route('quitarTarea', $tarea->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="mostrarAdvertencia(event)">Eliminar</a>
                                                        <a href="{{ route('editarTarea', $tarea->id) }}"
                                                            class="btn btn-sm btn-darker">Editar</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <br>
                                            <p>Creado el: {{ $tarea->fecha_habilitacion }}</p>
                                            <p>Vence el: {{ $tarea->fecha_vencimiento }}</p>

                                            @if (auth()->user()->hasRole('Estudiante'))
                                                @if ($tarea->tipo_tarea == 'cuestionario')
                                                    <a href="{{ route('resolvercuestionario', $tarea->id) }}"
                                                        class="btn btn-sm btn-dribbble">Responder Preguntas</a>
                                                @else
                                                    <p><a href="{{ route('VerTarea', [$tarea->id]) }}">IR A ACTIVIDAD</a>
                                                    </p>
                                                @endif
                                            @endif

                                            @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                                @if ($tarea->tipo_tarea == 'cuestionario')
                                                    <p><a href="{{ route('cuestionario', $tarea->id) }}"
                                                            class="btn btn-info">Ver Resultados</a></p>
                                                @else
                                                    <p><a class="btn btn-info"
                                                            href="{{ route('listaEntregas', [$tarea->id]) }}">Ver
                                                            Tarea</a></p>
                                                    <p><a class="btn btn-sm btn-facebook"
                                                            href="{{ route('VerTarea', [$tarea->id]) }}">Vista Previa</a>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                @empty
                                    <div class="card pb-3 pt-3 col-xl-12">
                                        <h4>Aún no hay tareas asignadas</h4>
                                    </div>
                                @endforelse







                            </div>
                        </div>

                    </div>
                    <!-- Evaluaciones Tab -->

                    <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                        aria-labelledby="tabs-icons-text-4-tab">
                        <!-- Contenido de Evaluaciones -->

                        <div class="card-header border-0">

                            <div class="row ">
                                <div class="col">
                                    <h3 class="mb-0">Evaluaciones</h3>
                                </div>
                                @if (auth()->user()->hasRole('Docente'))
                                    @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                                    @else
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('CrearEvaluacion', [$cursos->id]) }}">Crear
                                            Evaluaciones</a>

                                        <a class="btn btn-sm btn-warning"
                                            href="{{ route('evaluacionesEliminadas', [$cursos->id]) }}">Evaluaciones
                                            Eliminadas</a>
                                    @endif
                                @endif
                            </div>

                            <br>
                            @forelse ($evaluaciones as $evaluaciones)
                                <div class="card pb-3 pt-3  col-xl-12">

                                    <div class="row">
                                        <div class="ml-3">
                                            <h2>{{ $evaluaciones->titulo_evaluacion }}</h2>
                                        </div>
                                        <div class="ml-xl-5">
                                            @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                                @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin))
                                                @else
                                                    <a href="{{ route('quitarEvaluacion', $evaluaciones->id) }}"
                                                        class="btn btn-sm btn-danger mr-2"
                                                        onclick="mostrarAdvertencia(event)"><i
                                                            class="fa fa-trash"></i></a>
                                                    <a href="{{ route('editarEvaluacion', $evaluaciones->id) }}"
                                                        class="btn btn-sm btn-darker"><i class="fa fa-edit"></i></a>
                                                @endif
                                            @endif
                                        </div>

                                    </div>




                                    <br>


                                    <p>Creado el: {{ $evaluaciones->fecha_habilitacion }}</p>
                                    <p>Vence el: {{ $evaluaciones->fecha_vencimiento }}</p>


                                    @if (auth()->user()->hasRole('Estudiante'))
                                        <p> <a href="{{ route('VerEvaluacion', [$evaluaciones->id]) }}">IR
                                                A
                                                ACTIVIDAD</a> </p>
                                    @endif
                                    @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                        <p> <a class="btn btn-info"
                                                href="{{ route('listaEntregasE', [$evaluaciones->id]) }}">Ver
                                                Evaluación</a></p>
                                        <p> <a href="{{ route('VerEvaluacion', [$evaluaciones->id]) }}">Vista Previa
                                    @endif



                                </div>
                            @empty

                                <div class="card pb-3 pt-3  col-xl-12">
                                    <h4 class="mb-0"> Aún no hay evaluaciones asignadas</h4>
                                </div>
                            @endforelse








                        </div>



                        <!-- Aquí va tu contenido de evaluaciones -->
                    </div>

                    <!-- Foros Tab -->
                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                        aria-labelledby="tabs-icons-text-2-tab">
                        <!-- Contenido de Foros -->

                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Foros</h3>

                                </div>
                                <div class="col text-right">
                                    {{-- <a href="#!" class="btn btn-sm btn-success">Ver Todos</a> --}}

                                    @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                        @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                                        @else
                                            <a href="{{ route('CrearForo', [$cursos->id]) }}"
                                                class="btn btn-sm btn-success">Crear Foro</a>


                                            <a href="{{ route('forosE', [$cursos->id]) }}"
                                                class="btn btn-sm btn-warning">Lista Foros Borrados</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Projects table -->

                            @forelse ($foros as $foros)
                                <div class="table-responsive">
                                    <!-- Projects table -->


                                    <div class="card pb-2 pt-3  col-xl-12">

                                        <div class="row">
                                            <h3 class="col-7">{{ $foros->nombreForo }}</h3>
                                            @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                                @if ($foros->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($foros->cursos->fecha_fin))
                                                @else
                                                    <a href="{{ route('quitarForo', $foros->id) }}"
                                                        class="btn btn-sm btn-danger col-2"
                                                        onclick="mostrarAdvertencia(event)">Eliminar </a>
                                                    <a href="{{ route('EditarForo', $foros->id) }}"
                                                        class="btn btn-sm btn-info col-2">Editar </a>
                                                @endif
                                            @endif


                                        </div>
                                        <br>
                                        <p>Fecha de Finalización: {{ $foros->fechaFin }}</p>
                                        <p> <a href="{{ route('foro', [$foros->id]) }}">IR A FORO</a> </p>
                                    </div>
                                </div>
                            @empty

                                <div class="table-responsive">
                                    <div class="card pb-3 pt-3  col-xl-12">

                                        <h4 class="mb-0"> Aún no hay foros asignados</h4>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <!-- Aquí va tu contenido de foros -->
                    </div>
                    <!-- Recursos Tab -->
                    <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                        aria-labelledby="tabs-icons-text-3-tab">
                        <!-- Contenido de Recursos -->
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Recursos</h3>
                                </div>
                                @if (auth()->user()->hasRole('Docente'))
                                    @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                                    @else
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('CrearRecursos', [$cursos->id]) }}">Crear
                                            Recursos</a>


                                        <a class="btn btn-sm btn-warning"
                                            href="{{ route('ListaRecursosEliminados', [$cursos->id]) }}"> Recursos
                                            Eliminados</a>
                                    @endif
                                @endif
                            </div>
                            <br>
                            @forelse ($recursos as $recursos)
                                <div class="table-responsive">
                                    <!-- Projects table -->

                                    <div class="card pb-3 pt-3  col-xl-12">
                                        <br>

                                        <img src="{{ asset('/resources/icons/' . $recursos->tipoRecurso . '.png') }}"
                                            width="75px">
                                        <div class="row align-content-end">

                                            <h3 class="col-7">{{ $recursos->nombreRecurso }}</h3>

                                            @if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id)
                                                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                                                @else
                                                    <a href="{{ route('quitarRecurso', $recursos->id) }}"
                                                        class="btn btn-sm btn-danger col-2"
                                                        onclick="mostrarAdvertencia(event)">Eliminar </a>
                                                    <a href="{{ route('editarRecursos', $recursos->id) }}"
                                                        class="btn btn-sm btn-info col-2">Editar </a>
                                                @endif
                                            @endif

                                        </div>
                                        <br>
                                        <p>Descripción Recursos</p>

                                        <p>{!! $recursos->descripcionRecursos !!}</p>

                                        <a href=""></a>
                                        @if ($recursos->archivoRecurso != '')
                                            <td> <a href="{{ asset('storage/' . $recursos->archivoRecurso) }}" "> VER RECURSO </a></td>
    @endif

                                    </div>
                                </div>
                            @empty
                                <div class="table-responsive">
                                    <div class="card pb-3 pt-3  col-xl-12">
                                        <h4 class="mb-0"> Aún no hay recursos creados</h4>
                                    </div>
                                </div>
                            @endforelse


                        </div>

                    </div>
                </div>
                <!-- Aquí va tu contenido de recursos -->
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        </div>



        </div>
    @else
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="col text-right">
                            <h3>Usted no esta asignado a esta materia</h3>
                            <a href="{{ route('Inicio') }}" class="btn btn-sm btn-info">Volver a Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




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



@include('Layout')
