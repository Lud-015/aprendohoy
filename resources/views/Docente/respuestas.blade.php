@section('titulo')
    Respuestas
@endsection

@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaDocentes') }}">
                    <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaEstudiantes') }}">
                    <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('pagos') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('pagos') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection


@section('content')
    <div class="border p-1">


        <div class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <a href="{{ route('cuestionario', $pregunta->tarea_id) }}" class="btn btn-sm btn-primary">
                &#9668; Volver
            </a>
            <form action="" method="POST">
                @csrf

                @if ($pregunta->tipo_preg == 'multiple')
                    <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#crearRespuesta">Crear
                        Respuesta</a>


                    <div class="modal fade" id="crearRespuesta" tabindex="-1" role="dialog" aria-labelledby="miModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">Crear Respuesta</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('crearRespuesta', $pregunta->tarea_id) }}">
                                        <p for="">Texto Respuesta</p>
                                        <div class="form-group">
                                            <input type="text" name="pregunta_id" value="{{ $pregunta->id }}" hidden>
                                            <input type="text" name="respuesta">
                                        </div>
                                        <br>
                                        <p for="">Es correcta</p>

                                        <input type="radio" name="vf" value="1">Verdadero
                                        <input type="radio" name="vf" value="0">Falso
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <input type="submit" class="btn btn-primary" value="Añadir"></input>
                                    <br>
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
            </form>
        </div>
    </div>
    </div>
    @endif
    <div class="input-group input-group-alternative">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>

        <input class="form-control" placeholder="Buscar" type="text">
    </div>
    </form>
    </div>
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nro</th>
                <th scope="col">Respuesta</th>
                <th scope="col">Es Correcta</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>



            <tr>
                @forelse ($respuesta as $respuesta)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $respuesta->texto_respuesta }}</td>


                @switch($respuesta->es_correcta)
                    @case('1')
                        <td>Si</td>
                    @break

                    @case('0')
                        <td>No</td>
                    @break

                    @default
                        <!-- Acción por defecto -->
                @endswitch
                <td>
                    <!-- Botón de Eliminar con Modal -->
                    <a class="btn-sm btn-danger" href="#" data-toggle="modal"
                        data-target="#eliminarRespuesta{{ $respuesta->id }}">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                    <!-- Modal -->
                    <div class="modal fade" id="eliminarRespuesta{{ $respuesta->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="eliminarRespuestaLabel{{ $respuesta->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eliminarRespuestaLabel{{ $respuesta->id }}">Confirmar
                                        Eliminación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar esta respuesta?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('eliminar.respuesta', $respuesta->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Editar y Confirmar -->
                    <a class="btn-sm btn-info" href="#" data-toggle="modal" data-target="#editarRespuesta{{ $respuesta->id }}">
                        <i class="fa fa-edit"></i>
                    </a>



                    <div class="modal fade" id="editarRespuesta{{ $respuesta->id }}" tabindex="-1" role="dialog" aria-labelledby="editarRespuestaLabel{{ $respuesta->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('actualizar.respuesta', $respuesta->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarRespuestaLabel{{ $respuesta->id }}">Editar Respuesta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="texto_respuesta">Texto de la Respuesta</label>
                                            <textarea class="form-control" id="texto_respuesta" name="texto_respuesta" rows="3">{{ $respuesta->texto_respuesta }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="es_correcta">¿Es Correcta?</label>
                                            <select class="form-control" id="es_correcta" name="es_correcta">
                                                <option value="1" {{ $respuesta->es_correcta == 1 ? 'selected' : '' }}>Si</option>
                                                <option value="0" {{ $respuesta->es_correcta == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    {{-- <a class="btn-sm btn-default" href="{{ route('confirmar.respuesta', $respuesta->id) }}">
                        <i class="fa fa-check"></i>
                    </a> --}}
                </td>

                <!-- Modal -->


            </tr>
            @empty


                <td>

                    <h4>No hay preguntas creadas</h4>

                </td>
                @endforelse

                </tr>

            </tbody>
        </table>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif



        <script>
            // Get the current date in the format "YYYY-MM-DD"
            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();

                // Add leading zeros if needed
                month = month < 10 ? `0${month}` : month;
                day = day < 10 ? `0${day}` : day;

                return `${year}-${month}-${day}`;
            }

            // Set the initial value of the date input to the current date
            document.getElementById('fecha').value = getCurrentDate();
        </script>
    @endsection

    @include('layout')
