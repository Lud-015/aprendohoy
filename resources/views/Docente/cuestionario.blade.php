@section('titulo')
    Cuestionario {{ $tarea->titulo_tarea }}
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
            <a href="{{ route('Curso', $tarea->cursos_id) }}" class="btn btn-sm btn-primary">
                &#9668; Volver
            </a>
            <form action="" method="POST">
                @csrf

                <a href="{{ route('crearPregunta', $tarea->id) }}" class="btn btn-sm btn-success">Crear Pregunta</a>
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
                    <th scope="col">Pregunta</th>
                    <th scope="col">Tipo de Respuesta</th>
                    <th scope="col">Puntaje</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>



                <tr>
                    @forelse ($pregunta as $pregunta)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pregunta->texto_pregunta }}</td>


                    @switch($pregunta->tipo_preg)
                        @case('short')
                            <td>Corta</td>
                        @break

                        @case('vf')
                            <td>Verdadero y Falso</td>
                        @break

                        @case('multiple')
                            <td>Selección Múltiple</td>
                        @break

                        @default
                            <!-- Acción por defecto -->
                    @endswitch
                    <td>{{ $pregunta->puntos }}</td>
                    <td>

                        <a class="btn-sm btn-danger"  onclick="mostrarAdvertencia(event)" href="{{ route('deletePreguntaT', $pregunta->id) }}"><i class="fa fa-trash-alt"></i></a>

                        <a class="btn-sm btn-info" href="{{ route('editarPreguntaT', $pregunta->id) }}"><i
                                class="fa fa-edit"></i></a>
                        <a class="btn-sm btn-default" href="{{ route('respuestas', $pregunta->id) }}}}"><i
                                class="fa fa-check"></i></a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function mostrarAdvertencia(event) {
        event.preventDefault();

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción borrara esta pregunta. ¿Estás seguro de que deseas continuar?',
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
